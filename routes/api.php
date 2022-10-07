<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post( '/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
// Route::get('/user', [UserController::class, 'user']);
 
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/logout', [UserController::class, 'logout']);
});
