<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ContentPage\GaleriController;
use App\Http\Controllers\ContentPage\AlbumController;
use App\Http\Controllers\ContentPage\ContentController;
use App\Http\Controllers\menuPage\MenuController;
use App\Http\Controllers\menuPage\MenuDataController;
use App\Http\Controllers\api\MenuController as ApiMenuController;




Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Rute Profil dari Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Manajemen Konten (tb_menu_data)
    Route::get('/content', [ContentController::class, 'index'])->name('content.index');

    // Rute Resource untuk Agenda
    Route::resource('agenda', AgendaController::class);

    // Rute Resource untuk Galeri
    Route::resource('galeri', GaleriController::class);

    // Rute Resource untuk Album
    Route::resource('album', AlbumController::class);

    // Rute Resource untuk Manajemen Menu
    Route::resource('menu', MenuController::class);

    // Rute Resource untuk Manajemen Data Menu
   Route::resource('menu-data', MenuDataController::class)
     ->parameters(['menu-data' => 'menuData']);

});

require __DIR__ . '/auth.php';
require __DIR__ . '/auth.php';
