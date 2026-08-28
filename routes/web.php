<?php

use Illuminate\Support\Facades\Route;

include __DIR__."/admin.php";

Route::get('/', function () {
    return view('home');
})->name("home");

Route::get('/usuario', function () {
    return view('user.index');
})->name("user.index");



Route::get('/login', function () {
    return view('user.auth.login');
})->name("user.login");