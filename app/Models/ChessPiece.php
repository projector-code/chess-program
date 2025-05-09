<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChessPiece extends Model
{
    //
    protected $table = 'chess_piece';

    protected $fillable = [
        'coordinate_x',
        'coordinate_y',
        'coordinate_id',
        'is_pawn_first_move',
        'is_captured'
    ];

    private const
        MIN_COORDINATE = 1,
        MAX_COORDINATE = 8
    ;

    public const
        MIN_COORDINATE_X = self::MIN_COORDINATE,
        MAX_COORDINATE_X = self::MAX_COORDINATE,
        MIN_COORDINATE_Y = self::MIN_COORDINATE,
        MAX_COORDINATE_Y = self::MAX_COORDINATE
    ;

    public const
        LIGHT_PIECE_STARTING_COORDINATE_Y = self::MIN_COORDINATE_Y,
        LIGHT_PAWN_STARTING_COORDINATE_Y = 2,
        DARK_PIECE_STARTING_COORDINATE_Y = self::MAX_COORDINATE_Y,
        DARK_PAWN_STARTING_COORDINATE_Y = 7
    ;

    public const COORDINATE_X_CHARACTER = [
        1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd',
        5 => 'e', 6 => 'f', 7 => 'g', 8 => 'h'
    ];   

    public const
        PAWN = 'P',
        BISHOP = 'B',
        KNIGHT = 'N',
        ROOK = 'R',
        QUEEN = 'Q',
        KING = 'K'
    ;

    public const PIECES_BY_COORDINATE_X = [
        1 => ChessPiece::ROOK,
        2 => ChessPiece::KNIGHT,
        3 => ChessPiece::BISHOP,
        4 => ChessPiece::QUEEN,
        5 => ChessPiece::KING,
        6 => ChessPiece::BISHOP,
        7 => ChessPiece::KNIGHT,
        8 => ChessPiece::ROOK,
    ];

    public const
        LIGHT = 'light',
        DARK = 'dark'
    ;

    // public const
    //     PAWN = 'pawn',
    //     BISHOP = 'bishop',
    //     KNIGHT = 'knight',
    //     ROOK = 'rook',
    //     QUEEN = 'queen',
    //     KING = 'king'
    // ;

    // public const PIECES_LIST = [
    //     ['name' => self::PAWN, 'title' => 'Pawn', 'symbol' => 'P'],
    //     ['name' => self::BISHOP, 'title' => 'Bishop', 'symbol' => 'B'],
    //     ['name' => self::KNIGHT, 'title' => 'Knight', 'symbol' => 'N'],
    //     ['name' => self::ROOK, 'title' => 'Rook', 'symbol' => 'R'],
    //     ['name' => self::QUEEN, 'title' => 'Queen', 'symbol' => 'Q'],
    //     ['name' => self::KING, 'title' => 'King', 'symbol' => 'K'],
    // ];
}
