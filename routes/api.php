<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('test', [AuthController::class, 'test']);
    Route::apiResource('profile', UserController::class )->except(['index', 'store', ]);

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'password'

], function () {

   Route::post('forget', [AuthController::class , 'forget']);
   Route::post('reset', [AuthController::class , 'reset']);

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'v1'

], function () {

    Route::apiResource('articles',  ArticleController::class );
    Route::apiResource('categories',  CategoryController::class );
    Route::apiResource('comments',  CommentController::class );
    Route::apiResource('tags',  TagController::class );

    Route::post('role/{user}/update', [UserController::class, 'updateRole'])->name('role.update');

});
