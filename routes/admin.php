<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\hasAdmin;
use Illuminate\Support\Facades\Route;

Route::prefix("/admin")->middleware(hasAdmin::class)->group(function () {
    Route::get('', [AdminController::class, 'index'])->name("admin.index");
});