<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Home (login)
Route::get('/', function () { return view('home'); })->name('home');

// Signup page & submission
Route::get('/signup', [AuthController::class, 'signupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');

// Login submission
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Dashboard
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('/dashboard', [AuthController::class, 'handlePost']);

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Course page
Route::get('/course', [AuthController::class, 'course'])->name('course');

Route::get('/html-course', [AuthController::class, 'htmlCourse'])->name('html.course');

Route::post('/lesson-complete', [AuthController::class, 'completeLesson'])->name('lesson.complete');

Route::post('/html-quiz', [AuthController::class, 'htmlQuiz'])->name('html.quiz');
Route::post('/html-submit', [AuthController::class, 'submitQuiz'])->name('html.submit');
