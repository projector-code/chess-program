<?php

namespace Tests\Feature;

use Tests\TestCase;

class ChessTest extends TestCase
{
    public function test_general(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_start_new_game(): void
    {
        $response = $this->get('/restart-game');

        $response->assertStatus(200);
    }
}
