<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chess_piece', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color');
            $table->tinyInteger('coordinate_x');
            $table->tinyInteger('coordinate_y');
            $table->string('coordinate_id');
            $table->boolean('is_pawn_first_move')->default(0);
            $table->boolean('is_captured')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chess_piece');
    }
};
