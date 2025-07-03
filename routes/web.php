<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Force redirect to login page
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage.index');
    Route::resource('post', PostController::class);
    Route::post('/post/{postId}/like', [PostController::class, 'like'])->name('post.like');
    Route::post('/post/{postId}/unlike', [PostController::class, 'unlike'])->name('post.unlike');
    Route::post('/post/{postId}/comment', [PostController::class, 'storeComment'])->name('post.comment');
    Route::get('/post/{postId}/comments', [PostController::class, 'getComments'])->name('post.comments');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/{userId}', [ProfileController::class, 'show'])->name('profile.show');

    Route::get('/image/{filename}', [ImageController::class, 'showImage'])->name('image.show');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

