<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/category', [CategoryController::class, 'getCategory']);
Route::post('/add-category', [CategoryController::class, 'store']);
Route::get('/single-category/{id}', [CategoryController::class, 'singleCategory']);
Route::put('/update-category/{id}', [CategoryController::class, 'update']);


Route::post( '/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
 
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/logout', [UserController::class, 'logout']);
});
