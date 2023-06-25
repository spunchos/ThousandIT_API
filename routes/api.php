<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\RubricController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/news',   NewsController::class);
Route::resource('/author', AuthorController::class);
Route::resource('/rubric', RubricController::class);
Route::get('/news/search/{title}', [NewsController::class, 'search']);
Route::get('/author/news/{id}', [AuthorController::class, 'newsByAuthor']);
Route::get('/rubric/news/{id}', [RubricController::class, 'newsByRubric']);
