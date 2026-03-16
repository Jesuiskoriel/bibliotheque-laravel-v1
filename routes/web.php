<?php
/* Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti .
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserLoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
    Route::resource('authors', AuthorController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('books', BookController::class)->except(['show']);
    Route::resource('loans', LoanController::class)->except(['show']);
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/utilisateur', UserDashboardController::class)->name('user.dashboard');
    Route::post('/utilisateur/emprunts', [UserLoanController::class, 'store'])->name('user.loans.store');
    Route::patch('/utilisateur/emprunts/{loan}/retour', [UserLoanController::class, 'markReturned'])->name('user.loans.return');
});
