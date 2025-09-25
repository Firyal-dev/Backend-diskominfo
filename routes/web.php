<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ContentController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Agenda Routes
    Route::resource('agenda', AgendaController::class);

    // Content Page Routes
    // Galeri Routes
    Route::get('/content', [ContentController::class, 'index'])->name('content.index');
    Route::post('/content/upload', [ContentController::class, 'uploadGaleri'])->name('content.uploadGaleri');
    Route::delete('/content/delete', [ContentController::class, 'deleteGaleri'])->name('content.deleteGaleri');

    // Album Routes
    Route::get('/content/album', [ContentController::class, 'index'])->name('content.album.index');
    Route::post('/content/album/create', [ContentController::class, 'createAlbum'])->name('content.createAlbum');
    Route::delete('/content/album/delete', [ContentController::class, 'deleteAlbum'])->name('content.deleteAlbum');
    Route::post('/content/album/upload', [ContentController::class, 'uploadAlbumPhotos'])->name('content.uploadAlbumPhotos');

    // Delete photos in album
    Route::delete('/content/album/photos/delete', [ContentController::class, 'deleteAlbumPhotos'])->name('content.deleteAlbumPhotos');
    // Edit Album
    Route::post('/content/album/edit/{id}', [ContentController::class, 'editAlbum'])->name('content.editAlbum');
});

require __DIR__ . '/auth.php';
