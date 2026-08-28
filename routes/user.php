<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix("/usuario")->group(function () {
    Route::get('', [UserController::class, 'index'])->name("user.index");
});