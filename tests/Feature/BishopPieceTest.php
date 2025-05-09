<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Controllers\BishopController;

class BishopPieceTest extends TestCase
{
    public function test_move_up_right(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'B',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 5,
            'to_coordinate_y' => 5,
            'to_square_id' => 'e5',
            'to_piece_id' => 0,
            'to_piece_name' => '',
            'to_piece_color' => '',
            'is_pawn_first_move' => 0
        ];

        $bishopController = new BishopController();
        $move_status = $bishopController->BishopMoveValidation($input);
        $this->assertTrue($move_status['code'] == 200);
    }

    public function test_move_up_left_3_square(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'K',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 2,
            'to_coordinate_y' => 6,
            'to_square_id' => 'b6',
            'to_piece_id' => 0,
            'to_piece_name' => '',
            'to_piece_color' => '',
            'is_pawn_first_move' => 0
        ];

        $bishopController = new BishopController();
        $move_status = $bishopController->BishopMoveValidation($input);
        $this->assertTrue($move_status['code'] == 200);
    }

    public function test_move_down_right_and_same_color_piece_on_destination(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'R',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 5,
            'to_coordinate_y' => 3,
            'to_square_id' => 'e3',
            'to_piece_id' => 2,
            'to_piece_name' => 'P',
            'to_piece_color' => 'light',
            'is_pawn_first_move' => 0
        ];

        $bishopController = new BishopController();
        $move_status = $bishopController->BishopMoveValidation($input);
        $this->assertFalse($move_status['code'] == 200);
    }

    public function test_move_down_left_2_square_and_diff_color_piece_on_destination(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'R',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 2,
            'to_coordinate_y' => 2,
            'to_square_id' => 'b2',
            'to_piece_id' => 2,
            'to_piece_name' => 'P',
            'to_piece_color' => 'dark',
            'is_pawn_first_move' => 0
        ];

        $bishopController = new BishopController();
        $move_status = $bishopController->BishopMoveValidation($input);
        $this->assertTrue($move_status['code'] == 200);
    }
}
