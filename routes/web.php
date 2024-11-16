<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::get('/login', [LoginController::class, "index"])->name("login");

Route::get('/register', [RegisterController::class, "index"])->name("register");

Route::get("/register", [RegisterController::class, "index"])->name("register");

Route::post("/register", [RegisterController::class, "register"])->name("register.post");

Route::post("/logout", [LoginController::class, "logout"])->name("logout");