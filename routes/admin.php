<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Middleware\hasAdmin;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(hasAdmin::class)->group(function () {
    Route::get('', [AdminController::class, 'index'])->name('admin.index');

    Route::prefix('/users')->name('admin.users.')->group(function () {
        Route::get('', [AdminUserController::class, 'index'])->name('index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('', [AdminUserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/restore', [AdminUserController::class, 'restore'])->withTrashed()->name('restore');
        Route::delete('/{user}/force-delete', [AdminUserController::class, 'forceDelete'])->withTrashed()->name('force-delete');
    });
});
