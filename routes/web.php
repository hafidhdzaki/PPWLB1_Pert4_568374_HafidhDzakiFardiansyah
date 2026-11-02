<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController; // Import ProjectController
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about'); 
})->name('about');

Route::get('/education', function () {
    return view('education'); 
})->name('education');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('projects', ProjectController::class)->except(['index', 'show']);

    Route::get('/trash', [ProjectController::class, 'trash'])->name('projects.trash');
    Route::post('/projects/{id}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::delete('/projects/{id}/force-delete', [ProjectController::class, 'forceDelete'])->name('projects.forceDelete');
});

Route::middleware('auth')->group(function () {
    Route::resource('projects', ProjectController::class)->only(['index', 'show']);

    Route::get('/profile-saya', function () {
        return view('profile-saya', ['user' => Auth::user()]);
    })->name('profile.show');
});

require __DIR__.'/auth.php';
