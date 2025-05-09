<?php

namespace App\Http\Controllers;

use App\Models\ChessPiece;

class ChessPieceController extends Controller
{
    public function __construct()
    {
    }

    /* 
    * Function to capture or remove chess piece data.
    */
    public function updatePiece($input) {
        $piece_id = $input['piece_id'];

        $to_x = $input['to_coordinate_x'];
        $to_y = $input['to_coordinate_y'];

        $to_square_id = $input['to_square_id'];
        $to_piece_id = $input['to_piece_id'];

        // Get and update moving piece data.
        $piece = ChessPiece::find($piece_id)
            ->update([
                'coordinate_x' => $to_x,
                'coordinate_y' => $to_y,
                'coordinate_id' => $to_square_id,
                'is_pawn_first_move' => 0
            ]);

        // Get and update destination piece data.
        if ($to_piece_id > 0) {
            $piece_destination = ChessPiece::find($to_piece_id)
                ->update([
                    'coordinate_x' => 0,
                    'coordinate_y' => 0,
                    'coordinate_id' => "",
                    'is_captured' => 1
                ]);
        }
    }
}
