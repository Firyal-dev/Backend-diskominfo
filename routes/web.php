<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendaController;

// Content Controllers
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ContentPage\GaleriController;
use App\Http\Controllers\ContentPage\AlbumController;
use App\Http\Controllers\ContentPage\ContentController as ContentPageController;

// Menu Controllers
use App\Http\Controllers\menuPage\MenuController;
use App\Http\Controllers\menuPage\MenuDataController;
use App\Http\Controllers\api\MenuController as ApiMenuController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Profil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Agenda
    Route::resource('agenda', AgendaController::class);

    /**
     * Content Page (versi lama)
     */
    Route::get('/content', [ContentController::class, 'index'])->name('content.index');
    Route::post('/content/upload', [ContentController::class, 'uploadGaleri'])->name('content.uploadGaleri');
    Route::delete('/content/delete', [ContentController::class, 'deleteGaleri'])->name('content.deleteGaleri');

    // Album (versi lama)
    Route::get('/content/album', [ContentController::class, 'index'])->name('content.album.index');
    Route::post('/content/album/create', [ContentController::class, 'createAlbum'])->name('content.createAlbum');
    Route::delete('/content/album/delete', [ContentController::class, 'deleteAlbum'])->name('content.deleteAlbum');
    Route::post('/content/album/upload', [ContentController::class, 'uploadAlbumPhotos'])->name('content.uploadAlbumPhotos');
    Route::delete('/content/album/photos/delete', [ContentController::class, 'deleteAlbumPhotos'])->name('content.deleteAlbumPhotos');
    Route::post('/content/album/edit/{id}', [ContentController::class, 'editAlbum'])->name('content.editAlbum');

    /**
     * Content Page (versi baru)
     */
    Route::resource('galeri', GaleriController::class);
    Route::resource('album', AlbumController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('menu-data', MenuDataController::class)
        ->parameters(['menu-data' => 'menuData']);
});

require __DIR__ . '/auth.php';
