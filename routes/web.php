<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\SubjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\Web\DashboardController::class, 'index'])->name('home');
//Quiz
Route::get('/create/quiz', [App\Http\Controllers\Web\QuizController::class, 'create'])->name('create.quiz');
Route::get('/quizzes', [App\Http\Controllers\Web\QuizController::class, 'index'])->name('quiz.view');
Route::get('/quiz/{quiz}', [App\Http\Controllers\Web\QuizController::class, 'edit'])->name('quiz.edit');
Route::post('/quiz/{quiz}', [App\Http\Controllers\Web\QuizController::class, 'update']);
Route::post('/create/quiz', [App\Http\Controllers\Web\QuizController::class, 'store']);
Route::get('/quiz/delete/{quiz}', [App\Http\Controllers\Web\QuizController::class, 'destroy'])->name('quiz.delete');


//Questions
Route::get('/create/questions/{quiz?}', [App\Http\Controllers\Web\QuestionController::class, 'create'])->name('create.question');
Route::get('/questions', [App\Http\Controllers\Web\QuestionController::class, 'index'])->name('question.view');
Route::get('/get/questions/{quiz?}', [App\Http\Controllers\Web\QuestionController::class, 'getQuestion'])->name('question.get');

// Route::get('/quiz/{quiz}', [App\Http\Controllers\Web\QuizController::class, 'edit'])->name('quiz.edit');
// Route::post('/quiz/{quiz}', [App\Http\Controllers\Web\QuizController::class, 'update']);
Route::post('/create/questions/{quiz?}', [App\Http\Controllers\Web\QuestionController::class, 'store']);
Route::get('/question/delete/{question}/{quiz}', [App\Http\Controllers\Web\QuestionController::class, 'destroy'])->name('question.delete');

//Subject
Route::get('/subject/list', [SubjectController::class, 'index'])->name('subject.list');
Route::post('/create/subject', [SubjectController::class, 'store']);
Route::get('/create/subject', [SubjectController::class, 'create'])->name('teacher.create.subject');
Route::post('/edit/{subject}/subject', [SubjectController::class, 'update']);
Route::get('/edit/{subject}/subject', [SubjectController::class, 'show'])->name('teacher.edit.subject');
Route::get('/subject/{subject}/destroy', [SubjectController::class, 'destroy'])->name('subject.delete');

//User
Route::get('/user/list', [App\Http\Controllers\Web\UserController::class, 'index'])->name('user.list');
Route::post('/user/create', [App\Http\Controllers\Web\UserController::class, 'store']);
Route::post('/user/approve', [App\Http\Controllers\Web\UserController::class, 'statusUpdate']);
