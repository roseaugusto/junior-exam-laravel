<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/', [ArticleController::class, 'index']);
Route::get('articles/search/{name}', [ArticleController::class, 'search']);

Route::post('register/', [UserController::class, 'register']);
Route::post('login/', [UserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
  Route::get('articles/', [ArticleController::class, 'userArticle']);
  Route::get('articles/{id}', [ArticleController::class, 'show']);
  Route::post('articles/create', [ArticleController::class, 'store']);
  Route::patch('articles/{id}', [ArticleController::class, 'update']);
  Route::delete('articles/{id}', [ArticleController::class, 'destroy']);
  Route::patch('articles/{id}/voting', [ArticleController::class, 'voting']);
  Route::delete('articles/{id}/voting-delete', [ArticleController::class, 'deleteVoting']);

  Route::post('logout/', [UserController::class, 'logout']);
});
