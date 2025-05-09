<?php

namespace App\Http\Controllers;

use App\Models\ChessPiece;

class PawnController extends Controller
{
    public function __construct()
    {
    }

    /* 
    * Function to validate move status Pawn piece data.
    */
    public function PawnMoveValidation($input){
        $piece_name = $input['piece_name'];
        $piece_color = $input['piece_color'];

        $from_x = $input['from_coordinate_x'];
        $from_y = $input['from_coordinate_y'];
        $to_x = $input['to_coordinate_x'];
        $to_y = $input['to_coordinate_y'];

        $x_coordinate_diff = $to_x - $from_x;
        $y_coordinate_diff = $to_y - $from_y;

        $is_pawn_first_move = $input['is_pawn_first_move'];
        $to_piece_id = $input['to_piece_id'];
        $to_piece_color = $input['to_piece_color'];

        // Check whether Pawn move pattern.
        if (
            $y_coordinate_diff == 0 ||
            abs($y_coordinate_diff) > 2 ||
            abs($x_coordinate_diff) > 1 ||
            (abs($y_coordinate_diff) > 1 && $is_pawn_first_move == 0) ||
            ($piece_color == ChessPiece::LIGHT && $y_coordinate_diff < 0) ||
            ($piece_color == ChessPiece::DARK && $y_coordinate_diff > 0)
        ) {
            $move_status = [
                'message' => 'invalid [' . $piece_name . '] move pattern',
                'code' => 400
            ];
            return $move_status;
        }

        $is_valid_path = 1;

        // If Pawn move 2 square in the first moce
        if (abs($y_coordinate_diff) > 1 && $is_pawn_first_move == 1) {
            for ($curr_y = ($from_y+1); $curr_y < $to_y; $curr_y++) {
                $next_piece = ChessPiece::where([
                    ['coordinate_x', $from_x],
                    ['coordinate_y', $curr_y],
                    ['is_captured', 0]
                ])->first();

                // If is there any piece to the destination. 
                if ($next_piece && ($curr_y < $to_y)) {
                    $is_valid_path = 0;
                    break;
                }
            }
        }

        // If is there any piece while move to the destination. 
        if ($is_valid_path == 0) {
            $move_status = [
                'message' => 'invalid [' . $piece_name . '] move path',
                'code' => 400
            ];
            return $move_status;
        }

        // Check whether Pawn diagonal move destination.
        if (
            abs($x_coordinate_diff) == 1 && 
            (
                $to_piece_id == 0 ||
                $to_piece_color == $piece_color
            )
        ) {
            $move_status = [
                'message' => 'invalid [' . $piece_name . '] diagonal move destination',
                'code' => 400
            ];
            return $move_status;
        }
        

        // Check whether is there any piece or not on the destination. 
        if (abs($y_coordinate_diff) > 0 && abs($x_coordinate_diff) == 0 && $to_piece_id > 0) {
            $move_status = [
                'message' => 'invalid [' . $piece_name . '] move destination',
                'code' => 400
            ];
            return $move_status;
        }

        $move_status = [
            'message' => 'valid move pattern',
            'code' => 200
        ];
        return $move_status;
    }
}
