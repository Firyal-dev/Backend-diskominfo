<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Dashboard Controller
use App\Http\Controllers\DashboardController;

// Agenda Controller
use App\Http\Controllers\AgendaController;

// Galeri Controller
use App\Http\Controllers\contentPage\GaleriController;

//  Album Controller
use App\Http\Controllers\contentPage\AlbumController;

// Albums Photos Controller
use App\Http\Controllers\contentPage\AlbumsPhotosController;

// Menu Controllers
use App\Http\Controllers\menuPage\MenuController;
use App\Http\Controllers\menuPage\MenuDataController;

// Manajemen Admin Controller
use App\Http\Controllers\ManageAdminsController;
use App\Models\Album;

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

    // Content -> Galeri
    Route::resource('galeri', GaleriController::class);
    Route::delete('galeri/delete', [GaleriController::class, 'destroy'])->name('galeri.destroy');

    // Content -> Album
    Route::resource('album', AlbumController::class);
    Route::delete('/album/delete', [AlbumController::class, 'destroy'])->name('album.destroy');

    // Content -> Album -> Photos
    Route::resource('album.photos', AlbumsPhotosController::class);
    Route::delete('/album/{album}/photos', [AlbumsPhotosController::class, 'destroy'])->name('album.photos.destroy');

    // Manajemen Admins
    Route::resource('manageAdmins', ManageAdminsController::class);

    Route::resource('menu', MenuController::class);
    Route::resource('menu-data', MenuDataController::class)
        ->parameters(['menu-data' => 'menuData']);
});

require __DIR__ . '/auth.php';

