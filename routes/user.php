<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\LogoutController;
use App\Http\Controllers\User\RegisterUserController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserSecurityController;
use Illuminate\Support\Facades\Route;

Route::prefix("/user")->middleware("auth")->group(function () {
    Route::get('/', [UserController::class, 'index'])->name("user.index");
    Route::get('/security', [UserSecurityController::class, 'index'])->name("user.security");
    Route::put('/security/account', [UserSecurityController::class, 'account'])->name("user.security.account");
    Route::put('/security/password', [UserSecurityController::class, 'password'])->name("user.security.password");
    Route::delete('/security', [UserSecurityController::class, 'delete'])->name("user.security.delete");

    Route::post('/logout', [LogoutController::class, 'logout'])->name("user.logout");

});

Route::middleware("guest")->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name("user.login");
    Route::post('/login', [LoginController::class, 'store'])->name("user.login.store");

    Route::get('/cadastro', [RegisterUserController::class, 'index'])->name("user.register");
    Route::post('/cadastro', [RegisterUserController::class, 'store'])->name("user.register.store");
}); 