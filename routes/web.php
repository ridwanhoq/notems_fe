<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/notes')->name('home');

Route::middleware('api.guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/user/{userId}', [PostController::class, 'byUser'])->name('posts.user');

Route::middleware('api.auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('notes', NoteController::class)->parameters(['notes' => 'id']);

    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('interests', [UserController::class, 'groupedByInterest'])->name('interests');

    Route::middleware('api.admin')->prefix('admin')->group(function () {
        Route::get('notes', [NoteController::class, 'all'])->name('admin.notes');
        Route::resource('users', UserController::class)->except('show')->parameters(['users' => 'id']);
    });
});
