<?php

use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UsersController;
use App\Post;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', [UsersController::class,'login']);
Route::post('create-post', [PostController::class,'store']);
Route::delete('delete-post/{post}', [PostController::class, 'destroy']);
Route::get('get-interests', [PostController::class, 'getInterests']);
Route::get('get-link-preview', [PostController::class, 'getLinkPreview']);