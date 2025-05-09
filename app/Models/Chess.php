<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chess extends Model
{
    protected $table = 'chess';

    protected $fillable = [
        'player_turn',
        'game_over',
        'game_status',
        'note'
    ];
}
