<?php

namespace App\Http\Controllers;

use App\Models\ChessPiece;

class RookController extends Controller
{
    public function __construct()
    {
    }

    /* 
    * Function to validate move status Rook piece data.
    */
    public function RookMoveValidation($input){
        $piece_name = $input['piece_name'];
        $piece_color = $input['piece_color'];

        $from_x = $input['from_coordinate_x'];
        $from_y = $input['from_coordinate_y'];
        $to_x = $input['to_coordinate_x'];
        $to_y = $input['to_coordinate_y'];

        $x_coordinate_diff = $to_x - $from_x;
        $y_coordinate_diff = $to_y - $from_y;

        // Check Rook move pattern.
        if (abs($x_coordinate_diff) > 1 && abs($y_coordinate_diff) > 1) {
            $move_status = [
                'message' => 'invalid [' . $piece_name . '] move pattern',
                'code' => 400
            ];
            return $move_status;
        }

        $is_valid_path = 1;

        // If Rook move vertically.
        if ($x_coordinate_diff == 0) {
            // If Rook move to the top.
            if ($y_coordinate_diff > 0) {
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
            // If Rook move to the down.
            else if ($y_coordinate_diff < 0) {
                for ($curr_y = ($from_y-1); $curr_y > $to_y; $curr_y--) {
                    $next_piece = ChessPiece::where([
                        ['coordinate_x', $from_x],
                        ['coordinate_y', $curr_y],
                        ['is_captured', 0]
                    ])->first();

                    // If is there any piece to the destination. 
                    if ($next_piece && ($curr_y > $to_y)) {
                        $is_valid_path = 0;
                        break;
                    }
                }
            }
        }
        // If Rook move horizontally.
        else if ($y_coordinate_diff == 0) {
            // If Rook move to the right.
            if ($x_coordinate_diff > 0) {
                for ($curr_x = ($from_x+1); $curr_x < $to_x; $curr_x++) {
                    $next_piece = ChessPiece::where([
                        ['coordinate_x', $curr_x],
                        ['coordinate_y', $from_y],
                        ['is_captured', 0]
                    ])->first();

                    // If is there any piece to the destination. 
                    if ($next_piece && ($curr_x < $to_x)) {
                        $is_valid_path = 0;
                        break;
                    }
                }
            }
            // If Rook move to the left.
            else if ($x_coordinate_diff < 0) {
                for ($curr_x = ($from_x-1); $curr_x > $to_x; $curr_x--) {
                    $next_piece = ChessPiece::where([
                        ['coordinate_x', $curr_x],
                        ['coordinate_y', $from_y],
                        ['is_captured', 0]
                    ])->first();

                    // If is there any piece to the destination. 
                    if ($next_piece && ($curr_x > $to_x)) {
                        $is_valid_path = 0;
                        break;
                    }
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

        $to_piece_id = $input['to_piece_id'];
        $to_piece_color = $input['to_piece_color'];

        // Check whether is there any same piece color or not on the destination. 
        if (($to_piece_id > 0) && ($to_piece_color == $piece_color)) {
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