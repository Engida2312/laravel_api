<?php

use App\Http\Controllers\API\ComponentController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AvatarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//component route
Route::post('/add-component', [ComponentController::class, 'add']);
Route::get('/component', [ComponentController::class, 'getComponent']);
Route::get('/single-component/{id}', [ComponentController::class, 'singleComponent']);
Route::put('/update-component/{id}', [ComponentController::class, 'updateComponent']);
Route::delete('/delete-component/{id}', [ComponentController::class, 'deleteComponent']);
//category route
Route::get('/category', [CategoryController::class, 'getCategory']);
Route::post('/add-category', [CategoryController::class, 'store']);
Route::get('/single-category/{id}', [CategoryController::class, 'singleCategory']);
Route::put('/update-category/{id}', [CategoryController::class, 'update']);
Route::delete('/delete-category/{id}', [CategoryController::class, 'delete']);

Route::post( '/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [UserController::class, 'user']);
    
    Route::get('/users', [UserController::class, 'users']);

    Route::post('/logout', [UserController::class, 'logout']);
});
 

Route::get('/editprofile/{id}', [UserController::class, 'edit']);
Route::put('/updateprofile/{id}', [UserController::class, 'update']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/////avatar route
Route::get('/upload/{id}', [AvatarController::class, 'view']);
Route::post('/upload/{id}', [AvatarController::class, 'store']);
Route::put('/uploadImage', [AvatarController::class, 'uploadeImage']);
