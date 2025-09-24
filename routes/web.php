<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ContentPage\GaleriController;
use App\Http\Controllers\ContentPage\AlbumController;
use App\Http\Controllers\ContentPage\ContentController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Content Page Routes
    Route::get('/content', [ContentController::class, 'index'])->name('content.index');
    
    // Agenda Routes
    Route::resource('agenda', AgendaController::class);

    // Galeri Routes
    Route::resource('galeri', GaleriController::class);

    // Album Routes
    Route::resource('album', AlbumController::class);
});

require __DIR__ . '/auth.php';
