<?php

namespace App\Http\Controllers;

use App\Models\ChessPiece;

class BishopController extends Controller
{
    public function __construct()
    {
    }

    /* 
    * Function to validate move status Bishop piece data.
    */
    public function BishopMoveValidation($input){
        // $input = [
        //     'square_id' => 'c1',
        //     'piece_id' => 9,
        //     'piece_name' => 'B',
        //     'piece_color' => 'light',
        //     'from_coordinate_x' => 3,
        //     'from_coordinate_y' => 1,
        //     'to_coordinate_x' => 4,
        //     'to_coordinate_y' => 2,
        //     'to_square_id' => 'd2',
        //     'to_piece_id' => 14,
        //     'to_piece_name' => 'P',
        //     'to_piece_color' => 'light',
        //     'custom' => 'value'
        // ];

        $piece_name = $input['piece_name'];
        $piece_color = $input['piece_color'];

        $from_x = $input['from_coordinate_x'];
        $from_y = $input['from_coordinate_y'];
        $to_x = $input['to_coordinate_x'];
        $to_y = $input['to_coordinate_y'];

        $x_coordinate_diff = $to_x - $from_x;
        $y_coordinate_diff = $to_y - $from_y;

        // Check Bishop move pattern.
        if ($x_coordinate_diff == 0 || 
            $y_coordinate_diff == 0 ||
            abs($x_coordinate_diff) != abs($y_coordinate_diff)) {
            $move_status = [
                'message' => 'invalid [' . $piece_name . '] move pattern',
                'code' => 400
            ];
            return $move_status;
        }

        $is_valid_path = 1;

        // If Bishop move to the top.
        if ($y_coordinate_diff > 0) {
            // If Bishop move to the top-right.
            if ($x_coordinate_diff > 0) {
                $curr_x = $from_x + 1;
                for ($curr_y = ($from_y+1); $curr_y < $to_y; $curr_y++) {
                    $next_piece = ChessPiece::where([
                        ['coordinate_x', $curr_x],
                        ['coordinate_y', $curr_y],
                        ['is_captured', 0]
                    ])->first();

                    // If is there any piece to the destination. 
                    if ($next_piece && ($curr_y < $to_y)) {
                        $is_valid_path = 0;
                        break;
                    }
                    
                    $curr_x++;
                }
            }
            // If Bishop move to the top-left.
            else if ($x_coordinate_diff < 0) {
                $curr_x = $from_x - 1;
                for ($curr_y = ($from_y+1); $curr_y < $to_y; $curr_y++) {
                    $next_piece = ChessPiece::where([
                        ['coordinate_x', $curr_x],
                        ['coordinate_y', $curr_y],
                        ['is_captured', 0]
                    ])->first();

                    // If is there any piece to the destination. 
                    if ($next_piece && ($curr_y < $to_y)) {
                        $is_valid_path = 0;
                        break;
                    }
                    
                    $curr_x--;
                }
            }
        }
        // If Bishop move to the down.
        else if ($y_coordinate_diff < 0) {
            // If Bishop move to the down-right.
            if ($x_coordinate_diff > 0) {
                $curr_x = $from_x + 1;
                for ($curr_y = ($from_y-1); $curr_y > $to_y; $curr_y--) {
                    $next_piece = ChessPiece::where([
                        ['coordinate_x', $curr_x],
                        ['coordinate_y', $curr_y],
                        ['is_captured', 0]
                    ])->first();

                    // If is there any piece to the destination. 
                    if ($next_piece && ($curr_y > $to_y)) {
                        $is_valid_path = 0;
                        break;
                    }

                    $curr_x++;
                }
            }
            // If Bishop move to the down-left.
            else if ($x_coordinate_diff < 0) {
                $curr_x = $from_x - 1;
                for ($curr_y = ($from_y-1); $curr_y > $to_y; $curr_y--) {
                    $next_piece = ChessPiece::where([
                        ['coordinate_x', $curr_x],
                        ['coordinate_y', $curr_y],
                        ['is_captured', 0]
                    ])->first();

                    // If is there any piece to the destination. 
                    if ($next_piece && ($curr_y > $to_y)) {
                        $is_valid_path = 0;
                        break;
                    }

                    $curr_x--;
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
