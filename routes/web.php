<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes (accessible by guests)
Route::get('/', function () {
    return view('app');
});

// Grouping Login/Logout routes with guest middleware
Route::middleware('guest')->group(function () {
    Route::get("/login", [LoginController::class, "index"])->name("login");
    Route::post("/login", [LoginController::class, "login"])->name("login.post");

    Route::get("/register", [RegisterController::class, "index"])->name("register");
    Route::post("/register", [RegisterController::class, "register"])->name("register.post");
});

// Protected Routes (only accessible when logged in)
Route::middleware('auth')->group(function () {
    // Logout route
    Route::post("/logout", [LoginController::class, "logout"])->name("logout");

    // Online users route
    Route::get("/online-users", [UsersController::class, "getOnlineUsers"]);

    // Messages routes (can be further simplified using resource controllers)
    Route::prefix('messages')->group(function() {
        Route::get("/", [MessagesController::class, "index"]);
        Route::post("/", [MessagesController::class, "store"])->name("message.store");
        Route::put("/{id}", [MessagesController::class, "update"]);
    });
});
