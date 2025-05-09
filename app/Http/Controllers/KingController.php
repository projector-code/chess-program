<?php

namespace App\Http\Controllers;

class KingController extends Controller
{
    public function __construct()
    {
    }

    /* 
    * Function to validate move status King piece data.
    */
    public function KingMoveValidation($input){
        $piece_name = $input['piece_name'];
        $piece_color = $input['piece_color'];

        $from_x = $input['from_coordinate_x'];
        $from_y = $input['from_coordinate_y'];
        $to_x = $input['to_coordinate_x'];
        $to_y = $input['to_coordinate_y'];

        $x_coordinate_diff = $to_x - $from_x;
        $y_coordinate_diff = $to_y - $from_y;

        // Check whether King move more than 1 square.
        if (abs($x_coordinate_diff) > 1 || abs($y_coordinate_diff) > 1) {
            $move_status = [
                'message' => 'invalid [' . $piece_name . '] move pattern',
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