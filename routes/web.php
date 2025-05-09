<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChessController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ChessController::class, 'main']);

Route::get('restart-game', [ChessController::class, 'restartGame']);
Route::post('move-piece', [ChessController::class, 'movePiece']);