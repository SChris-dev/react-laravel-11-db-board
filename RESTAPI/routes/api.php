<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\CardController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/v1/auth/login', [AuthController::class, 'login']);
Route::post('/v1/auth/register', [AuthController::class, 'register']);
Route::get('/v1/auth/logout', [AuthController::class, 'logout']);

Route::middleware(['bcrypt'])->group(function () {

    // boards
    Route::post('/v1/board', [BoardController::class, 'store']);
    Route::post('/v1/board/{board_id}/member', [BoardController::class, 'storeMember']);
    Route::put('/v1/board/{board_id}', [BoardController::class, 'update']);
    Route::delete('/v1/board/{board_id}', [BoardController::class, 'destroy']);
    Route::delete('/v1/board/{board_id}/member/{user_id}', [BoardController::class, 'destroyMember']);
    Route::get('/v1/board', [BoardController::class, 'index']);
    Route::get('/v1/board/{board_id}', [BoardController::class, 'show']);

    // list
    Route::post('/v1/board/{board_id}/list', [ListController::class, 'store']);
    Route::post('/v1/board/{board_id}/list/{list_id}/right', [ListController::class, 'moveRight']);
    Route::post('/v1/board/{board_id}/list/{list_id}/left', [ListController::class, 'moveLeft']);
    Route::put('/v1/board/{board_id}/list/{list_id}', [ListController::class, 'update']);
    Route::delete('/v1/board/{board_id}/list/{list_id}', [ListController::class, 'destroy']);

    // cards
    Route::post('/v1/board/{board_id}/list/{list_id}/card', [CardController::class, 'store']);
    Route::post('/v1/card/{card_id}/up', [CardController::class, 'moveUp']);
    Route::post('/v1/card/{card_id}/down', [CardController::class, 'moveDown']);
    Route::post('/v1/card/{card_id}/move/{list_id}', [CardController::class, 'moveList']);
    Route::put('/v1/board/{board_id}/list/{list_id}/card/{card_id}', [CardController::class, 'update']);
    Route::delete('/v1/board/{board_id}/list/{list_id}/card/{card_id}', [CardController::class, 'destroy']);

});