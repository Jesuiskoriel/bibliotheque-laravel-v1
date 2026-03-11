<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::resource('authors', AuthorController::class)->except(['show']);
Route::resource('categories', CategoryController::class)->except(['show']);
Route::resource('books', BookController::class)->except(['show']);
Route::resource('members', MemberController::class)->except(['show']);
Route::resource('loans', LoanController::class)->except(['show']);
