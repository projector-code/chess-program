<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Controllers\PawnController;

class PawnPieceTest extends TestCase
{
    public function test_light_move_up_2_square_and_first_move(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'P',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 4,
            'to_coordinate_y' => 5,
            'to_square_id' => 'd5',
            'to_piece_id' => 0,
            'to_piece_name' => '',
            'to_piece_color' => '',
            'is_pawn_first_move' => 1
        ];

        $pawnController = new PawnController();
        $move_status = $pawnController->PawnMoveValidation($input);
        $this->assertTrue($move_status['code'] == 200);
    }

    public function test_dark_move_down_2_square_and_not_first_move(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'P',
            'piece_color' => 'dark',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 4,
            'to_coordinate_y' => 2,
            'to_square_id' => 'd6',
            'to_piece_id' => 0,
            'to_piece_name' => '',
            'to_piece_color' => '',
            'is_pawn_first_move' => 0
        ];

        $pawnController = new PawnController();
        $move_status = $pawnController->PawnMoveValidation($input);
        $this->assertFalse($move_status['code'] == 200);
    }

    public function test_light_move_down(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'P',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 4,
            'to_coordinate_y' => 3,
            'to_square_id' => 'd3',
            'to_piece_id' => 0,
            'to_piece_name' => '',
            'to_piece_color' => '',
            'is_pawn_first_move' => 0
        ];

        $pawnController = new PawnController();
        $move_status = $pawnController->PawnMoveValidation($input);
        $this->assertFalse($move_status['code'] == 200);
    }

    public function test_dark_move_down_and_a_piece_on_destination(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'P',
            'piece_color' => 'dark',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 4,
            'to_coordinate_y' => 3,
            'to_square_id' => 'd3',
            'to_piece_id' => 2,
            'to_piece_name' => 'P',
            'to_piece_color' => 'light',
            'is_pawn_first_move' => 0
        ];

        $pawnController = new PawnController();
        $move_status = $pawnController->PawnMoveValidation($input);
        $this->assertFalse($move_status['code'] == 200);
    }

    public function test_light_move_up_left_and_diff_color_piece_on_destination(): void
    {
        $input = [
            'square_id' => 'd4',
            'piece_id' => 1,
            'piece_name' => 'P',
            'piece_color' => 'light',
            'from_coordinate_x' => 4,
            'from_coordinate_y' => 4,
            'to_coordinate_x' => 3,
            'to_coordinate_y' => 5,
            'to_square_id' => 'c5',
            'to_piece_id' => 2,
            'to_piece_name' => 'P',
            'to_piece_color' => 'dark',
            'is_pawn_first_move' => 0
        ];

        $pawnController = new PawnController();
        $move_status = $pawnController->PawnMoveValidation($input);
        $this->assertTrue($move_status['code'] == 200);
    }
}
