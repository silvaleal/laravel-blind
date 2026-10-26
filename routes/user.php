<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\RecoverPasswordController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserSecurityController;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/security', [UserSecurityController::class, 'index'])->name('user.security');
    Route::put('/security/account', [UserSecurityController::class, 'account'])->name('user.security.account');
    Route::put('/security/password', [UserSecurityController::class, 'password'])->name('user.security.password');
    Route::delete('/security', [UserSecurityController::class, 'delete'])->name('user.security.delete');

    Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');

});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('user.login');
    Route::post('/login', [AuthController::class, 'store'])->name('user.login.store');

    Route::get('/cadastro', [AuthController::class, 'registerIndex'])->name('user.register');
    Route::post('/cadastro', [AuthController::class, 'registerStore'])->name('user.register.store');

    Route::get('/recover-password', [RecoverPasswordController::class, 'index'])->name('user.auth.recover-password');
    Route::post('/recover-password', [RecoverPasswordController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('user.auth.recover-password.store');

    Route::get('/reset-password/{token}', [RecoverPasswordController::class, 'reset'])->name('user.password.reset');
    Route::post('/reset-password', [RecoverPasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('user.password.update');
});
