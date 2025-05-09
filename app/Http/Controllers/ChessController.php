<?php

namespace App\Http\Controllers;

use App\Models\Chess;
use App\Models\ChessPiece;
use App\Http\Controllers\ChessPieceController;
use App\Http\Controllers\KingController;
use App\Http\Controllers\QueenController;
use App\Http\Controllers\RookController;
use App\Http\Controllers\BishopController;
use App\Http\Controllers\KnightController;
use App\Http\Controllers\PawnController;

class ChessController extends Controller
{
    private ChessPieceController $chessPieceController;
    private KingController $kingController;
    private QueenController $queenController;
    private RookController $rookController;
    private BishopController $bishopController;
    private KnightController $knightController;
    private PawnController $pawnController;

    public function __construct()
    {
        $this->chessPieceController = new ChessPieceController();
        $this->kingController = new KingController();
        $this->queenController = new QueenController();
        $this->rookController = new RookController();
        $this->bishopController = new BishopController();
        $this->knightController = new KnightController();
        $this->pawnController = new PawnController();
    }

    public function main() {
        $data['coordinate_x_char'] = ChessPiece::COORDINATE_X_CHARACTER;

        // Get previous chess data.
        $chess = Chess::first();
        $chess_pieces = ChessPiece::where('is_captured', 0)->get();

        // If there is no previous chess data.
        if (!$chess || count($chess_pieces) < 1) {
            // Create new game data.
            $new_data = $this->startNewGame();
            $data['chess'] = $new_data['chess'];
            $data['chess_pieces'] = $new_data['chess_pieces'];

            return view('main', $data);
        }

        // If there is previous chess data.
        $data['chess'] = $chess;
        $data['chess_pieces'] = $chess_pieces;

        return view('main', $data);
    }
    
    /* 
    * Function to create new chess data.
    */
    public function startNewGame() {

        // Empty the table.
        Chess::truncate();
        ChessPiece::truncate();

        $date_now = date('Y-m-d H:i:s');

        // Insert data to Chess Table.
        Chess::insert([
            'player_turn' => 'light',
            'game_over' => 0,
            'game_status' => 'Game Ongoing!',
            'note' => 'Have Fun!',
            'created_at' => $date_now
        ]);

        $curr_coordinate_x = ChessPiece::MIN_COORDINATE_X;
        $max_coordinate_x = ChessPiece::MAX_COORDINATE_X;

        $light_piece_starting_coordinate_y = ChessPiece::LIGHT_PIECE_STARTING_COORDINATE_Y;
        $light_pawn_starting_coordinate_y = ChessPiece::LIGHT_PAWN_STARTING_COORDINATE_Y;
        $dark_piece_starting_coordinate_y = ChessPiece::DARK_PIECE_STARTING_COORDINATE_Y;
        $dark_pawn_starting_coordinate_y = ChessPiece::DARK_PAWN_STARTING_COORDINATE_Y;
        
        $coordinate_x_char = ChessPiece::COORDINATE_X_CHARACTER;
        $pieces_by_coordinate_x = ChessPiece::PIECES_BY_COORDINATE_X;

        $chess_pieces = [];

        while ($curr_coordinate_x <= $max_coordinate_x) {
            // Create Light Piece.
            $coordinate_id = $coordinate_x_char[$curr_coordinate_x] . $light_piece_starting_coordinate_y;
            $light_piece = [
                'name' => $pieces_by_coordinate_x[$curr_coordinate_x],
                'color'=> ChessPiece::LIGHT,
                'coordinate_x' => $curr_coordinate_x,
                'coordinate_y' => $light_piece_starting_coordinate_y,
                'coordinate_id' => $coordinate_id,
                'is_pawn_first_move' => 1,
                'created_at' => $date_now
            ];
            array_push($chess_pieces, $light_piece);

            // Create Light Pawn.
            $coordinate_id = $coordinate_x_char[$curr_coordinate_x] . $light_pawn_starting_coordinate_y;
            $light_pawn = [
                'name' => ChessPiece::PAWN,
                'color'=> ChessPiece::LIGHT,
                'coordinate_x' => $curr_coordinate_x,
                'coordinate_y' => $light_pawn_starting_coordinate_y,
                'coordinate_id' => $coordinate_id,
                'is_pawn_first_move' => 1,
                'created_at' => $date_now
            ];
            array_push($chess_pieces, $light_pawn);

            // Create Dark Piece.
            $coordinate_id = $coordinate_x_char[$curr_coordinate_x] . $dark_piece_starting_coordinate_y;
            $dark_piece = $light_piece; 
            $dark_piece['color'] = ChessPiece::DARK;
            $dark_piece['coordinate_y'] = $dark_piece_starting_coordinate_y;
            $dark_piece['coordinate_id'] = $coordinate_id;
            array_push($chess_pieces, $dark_piece);

            // Create Dark Pawn.
            $coordinate_id = $coordinate_x_char[$curr_coordinate_x] . $dark_pawn_starting_coordinate_y;
            $dark_pawn = $light_pawn;
            $dark_pawn['color'] = ChessPiece::DARK;
            $dark_pawn['coordinate_y'] = $dark_pawn_starting_coordinate_y;
            $dark_pawn['coordinate_id'] = $coordinate_id;
            array_push($chess_pieces, $dark_pawn);

            $curr_coordinate_x++;
        }

        // Insert data to Chess_Piece Table.
        ChessPiece::insert($chess_pieces);

        $new_data = [
            'chess' => Chess::first(),
            'chess_pieces' => ChessPiece::get()
        ];

        return $new_data;
    }

    /* 
    * Function to restart chess data.
    */
    public function restartGame() {
        $new_data = $this->startNewGame();
        return response()->json($new_data, 200);
    }

    /* 
    * Function to validate move and or update chess piece data.
    */
    public function movePiece() {
        $input = request()->all();
        
        switch ($input['piece_name']) {
            case 'K':
                $move_status = $this->kingController->KingMoveValidation($input);
                break;
            case 'Q':
                $move_status = $this->queenController->QueenMoveValidation($input);
                break;
            case 'R':
                $move_status = $this->rookController->RookMoveValidation($input);
                break;
            case 'B':
                $move_status = $this->bishopController->BishopMoveValidation($input);
                break;
            case 'N':
                $move_status = $this->knightController->KnightMoveValidation($input);
                break;
            case 'P':
                $move_status = $this->pawnController->PawnMoveValidation($input);
                break;
            default:
                $move_status = [
                    'message' => 'invalid chess piece',
                    'code' => 400
                ];
        }

        if ($move_status['code'] == 200) {
            // Update pieces coordinate data.
            $this->chessPieceController->updatePiece($input);
        }

        $piece_color = $input['piece_color'];
        $to_piece_name = $input['to_piece_name'];

        $next_player_turn = '';
        
        if ($piece_color == ChessPiece::LIGHT) {
            $next_player_turn = ChessPiece::DARK;
        } else {
            $next_player_turn = ChessPiece::LIGHT;
        }

        $chess_update = [];
        
        // Check whether the captured piece is King piece.
        if ($move_status['code'] == 200 && $to_piece_name == ChessPiece::KING) {
            $move_status = [
                'game_over' => 1,
                'message' => 'Game Over! ' . $piece_color . ' player win!',
                'code' => 200
            ];

            // Updated game over chess data.
            $chess_update = [
                'game_over' => 1,
                'game_status' => 'Game Over!',
                'note' => $piece_color . ' player win!',
            ];
        }

        // Change player turn.
        $move_status['player_turn'] = $next_player_turn;
        $chess_update['player_turn'] = $next_player_turn;

        // Get and update Chess data.
        Chess::where('id', 1)->update($chess_update);

        return response()->json($move_status, $move_status['code']);
    }
}
