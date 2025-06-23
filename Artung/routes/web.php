<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserAdminController;
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

Route::delete('/posts/{post}/admin', [PostController::class, 'PostdestroyAdmin'])->name('posts.PostdestroyAdmin');

Route::get('/profile/{user}', function (User $user) {
    return view('profile.show'     , ['user' => $user]);
})->middleware(['auth'])->name('profile.show');

Route::middleware('auth')->group(function () {
Route::get('/profile/{user}'       , [ProfileController::class, 'show'])
     ->name('profile.show')
     ->middleware('auth');

    Route::post('/profile/photo'   , [ProfileController::class, 'updatePhoto'])
         ->name('profile.photo.update');
});

Route::middleware('auth')->group(function() {
    Route::get  ('/tags'           , [TagController::class, 'index'  ])->name('tags.index');
    Route::get  ('/tags/create'    , [TagController::class, 'create' ])->name('tags.create');
    Route::post ('/tags'           , [TagController::class, 'store'  ])->name('tags.store');
    Route::get  ('/tags/{tag}/edit', [TagController::class, 'edit'   ])->name('tags.edit');
    Route::put  ('/tags/{tag}'     , [TagController::class, 'update' ])->name('tags.update');
    Route::delete('/tags/{tag}'    , [TagController::class, 'destroy'])->name('tags.destroy');
});

Route::middleware('auth')->group(function(){
    Route::post('/posts/{post}/like', [App\Http\Controllers\PostController::class, 'like'])
         ->name('posts.like');
    Route::delete('/posts/{post}/like', [App\Http\Controllers\PostController::class, 'unlike'])
         ->name('posts.unlike');
});


Route::middleware(['auth'])->group(function(){
    Route::get('/admin/users',               [UserAdminController::class, 'index'])->name('users.index');
    Route::patch('/admin/users/{user}/ban',   [UserAdminController::class, 'ban'])->name('users.ban');
    Route::patch('/admin/users/{user}/unban', [UserAdminController::class, 'unban'])->name('users.unban');
    Route::delete('/admin/users/{user}',     [UserAdminController::class, 'destroy'])->name('users.destroy');
    Route::patch('/admin/users/{user}/promote', [UserAdminController::class, 'promote'])->name('users.promote');
    Route::patch('/admin/users/{user}/demote', [UserAdminController::class, 'demote'])->name('users.demote');
});


require __DIR__.'/auth.php';