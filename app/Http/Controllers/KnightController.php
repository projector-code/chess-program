<?php

namespace App\Http\Controllers;

class KnightController extends Controller
{

    public function __construct()
    {
    }
    
    /* 
    * Function to validate move status Knight piece data.
    */
    public function KnightMoveValidation($input){
        $piece_name = $input['piece_name'];
        $piece_color = $input['piece_color'];

        $from_x = $input['from_coordinate_x'];
        $from_y = $input['from_coordinate_y'];
        $to_x = $input['to_coordinate_x'];
        $to_y = $input['to_coordinate_y'];

        $x_coordinate_diff = $to_x - $from_x;
        $y_coordinate_diff = $to_y - $from_y;

        // Check whether Knight move pattern.
        if (
            $x_coordinate_diff == 0 || $y_coordinate_diff == 0 ||
            (abs($x_coordinate_diff) + abs($y_coordinate_diff) != 3)
        ) {
            $move_status = [
                'message' => 'invalid [' . $piece_name . '] move pattern',
                'code' => 400
            ];
            return $move_status;
        }

        $to_piece_id = $input['to_piece_id'];
        $to_piece_color = $input['to_piece_color'];

        // Check whether is there any same piece color or not on the destination square. 
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
