<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Controllers\QueenController;

class QueenPieceTest extends TestCase
{
    public function test_move_up(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'Q',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 4,
            'to_coordinate_y' => 5,
            'to_square_id' => 'd5',
            'to_piece_id' => 0,
            'to_piece_name' => '',
            'to_piece_color' => '',
            'is_pawn_first_move' => 0
        ];

        $queenController = new QueenController();
        $move_status = $queenController->QueenMoveValidation($input);
        $this->assertTrue($move_status['code'] == 200);
    }

    public function test_move_up_3_square(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'K',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 4,
            'to_coordinate_y' => 7,
            'to_square_id' => 'd7',
            'to_piece_id' => 0,
            'to_piece_name' => '',
            'to_piece_color' => '',
            'is_pawn_first_move' => 0
        ];

        $queenController = new QueenController();
        $move_status = $queenController->QueenMoveValidation($input);
        $this->assertTrue($move_status['code'] == 200);
    }

    public function test_move_down_left(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'Q',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 3,
            'to_coordinate_y' => 3,
            'to_square_id' => 'c3',
            'to_piece_id' => 0,
            'to_piece_name' => '',
            'to_piece_color' => '',
            'is_pawn_first_move' => 0
        ];

        $queenController = new QueenController();
        $move_status = $queenController->QueenMoveValidation($input);
        $this->assertTrue($move_status['code'] == 200);
    }

    public function test_move_right_and_same_color_piece_on_destination(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'Q',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 5,
            'to_coordinate_y' => 4,
            'to_square_id' => 'e4',
            'to_piece_id' => 2,
            'to_piece_name' => 'P',
            'to_piece_color' => 'light',
            'is_pawn_first_move' => 0
        ];

        $queenController = new QueenController();
        $move_status = $queenController->QueenMoveValidation($input);
        $this->assertFalse($move_status['code'] == 200);
    }

    public function test_move_up_left_2_square_and_diff_color_piece_on_destination(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'Q',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 2,
            'to_coordinate_y' => 6,
            'to_square_id' => 'b6',
            'to_piece_id' => 2,
            'to_piece_name' => 'P',
            'to_piece_color' => 'dark',
            'is_pawn_first_move' => 0
        ];

        $queenController = new QueenController();
        $move_status = $queenController->QueenMoveValidation($input);
        $this->assertTrue($move_status['code'] == 200);
    }
}
