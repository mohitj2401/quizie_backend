<?php

use App\Http\Controllers\AppSubjectController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResultController;
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

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/quiz/create/{api_token}', [QuizController::class, 'store']);
Route::get('/quiz/get/{subject}/{api_token}', [QuizController::class, 'getQuiz']);
Route::post('/result/get/{api_token}', [ResultController::class, 'store']);
Route::post('/quiz/delete/{api_token}/{quiz}', [QuizController::class, 'deleteQuiz']);
Route::post('/question/create/{api_token}/{quiz}', [QuestionController::class, 'store']);
Route::get('/question/get/{api_token}/{quiz}', [QuestionController::class, 'getQuestion']);
Route::get('/subjects/get/{api_token}', [AppSubjectController::class, 'getSubjects']);
Route::get('/subjects/search/{api_token}/{sub_name}', [AppSubjectController::class, 'getSearchSubjects']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
