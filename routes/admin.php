<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\Frontend\FrontendController::class, 'index']);
Route::get('/home', [App\Http\Controllers\Frontend\FrontendController::class, 'index']);

Route::prefix('admin/')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('custom-login', [AuthController::class, 'customLOgin'])->name('login.custom');
    

    Route::get('/register', [AuthController::class, 'registration'])->name('register-user');
    Route::post('/custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');
});

Route::get('admin/dashboard', [AuthController::class, 'dashboard'])->middleware('auth');

Route::post('admin/logout', [AuthController::class, 'signOut'])->name('signout')->middleware('auth');