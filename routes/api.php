<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\MenuDataController; // <-- Tambahkan import ini

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rute untuk struktur menu utama
Route::get('/menus', [MenuController::class, 'getTree']);

// [BARU] Rute untuk data konten
Route::get('/pages', [MenuDataController::class, 'index']);      // Untuk daftar (misal: /api/pages?menu=berita)
Route::get('/pages/{menuData}', [MenuDataController::class, 'show']); // Untuk detail (misal: /api/pages/123)


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
