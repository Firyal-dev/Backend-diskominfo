<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuData;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuDataController extends Controller
{
    /**
     * Menampilkan daftar data konten, bisa difilter berdasarkan slug menu.
     * Contoh request: /api/pages?menu=berita
     */
    public function index(Request $request)
    {
        // Validasi jika ada parameter 'menu'
        $request->validate([
            'menu' => 'nullable|string|max:255'
        ]);

        $query = MenuData::query()->with('menu');

        // Jika ada parameter 'menu' (misal: 'berita'), filter berdasarkan itu
        if ($request->has('menu')) {
            $menuSlug = $request->input('menu');
            $query->whereHas('menu', function ($q) use ($menuSlug) {
                // Mencari menu yang namanya jika di-slug sama dengan parameter
                $q->whereRaw('LOWER(REPLACE(nama, " ", "-")) = ?', [$menuSlug]);
            });
        }

        // Ambil data terbaru, paginasi 9 item per halaman
        $menuData = $query->latest()->paginate(9);

        // Transformasi data untuk menambahkan URL gambar absolut
        $menuData->getCollection()->transform(function ($item) {
            if ($item->gambar_file_path) {
                $item->gambar_url = asset('storage/' . $item->gambar_file_path);
            }
            return $item;
        });

        return response()->json($menuData);
    }

    /**
     * Menampilkan detail satu data konten.
     */
    public function show(MenuData $menuData)
    {
        // Eager load relasi menu
        $menuData->load('menu');

        // Transformasi untuk menambahkan URL gambar absolut
        if ($menuData->gambar_file_path) {
            $menuData->gambar_url = asset('storage/' . $menuData->gambar_file_path);
        }

        // Ambil 3 konten terkait dari menu yang sama (kecuali konten ini sendiri)
        $related = MenuData::where('menu_id', $menuData->menu_id)
                           ->where('id', '!=', $menuData->id)
                           ->latest()
                           ->take(3)
                           ->get()
                           ->transform(function ($item) { // Transformasi juga untuk item terkait
                                if ($item->gambar_file_path) {
                                    $item->gambar_url = asset('storage/' . $item->gambar_file_path);
                                }
                                return $item;
                            });

        return response()->json([
            'detail' => $menuData,
            'related' => $related,
        ]);
    }
}
