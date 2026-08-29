<?php

use Illuminate\Support\Facades\Route;

include __DIR__."/admin.php";
include __DIR__."/user.php";

Route::get('/', function () {
    return view('home');
})->name("home");
