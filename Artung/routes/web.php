<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile/settings', [ProfileController::class, 'settings'])
         ->name('profile.settings');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/banned', function (){
    return view('banned');
})->name('banned.notice');

Route::middleware(['auth', 'banned'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'banned'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});

Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::get('/profile/{user}', function (User $user) {
    return view('profile.show', ['user' => $user]);
})->middleware(['auth'])->name('profile.show');

Route::middleware('auth')->group(function () {
Route::get('/profile/{user}', [ProfileController::class, 'show'])
     ->name('profile.show')
     ->middleware('auth');

    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
         ->name('profile.photo.update');
});

require __DIR__.'/auth.php';