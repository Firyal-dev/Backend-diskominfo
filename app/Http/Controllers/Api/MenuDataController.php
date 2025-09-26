<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class MenuDataController extends Controller
{
    /**
     * Menampilkan daftar data konten, bisa difilter berdasarkan menu_id.
     * Contoh request: /api/pages?menu_id=1
     */
    public function index(Request $request)
    {
        // Validasi input (opsional tapi direkomendasikan)
        $request->validate([
            'menu_id' => 'nullable|integer|exists:menus,id'
        ]);

        $query = MenuData::query()->with('menu:id,nama,kategori,tipe_tampilan');

        // Filter berdasarkan menu_id jika ada di request
        if ($request->has('menu_id')) {
            $query->where('menu_id', $request->menu_id);
        }

        // Ambil data dengan paginasi
        $menuDataItems = $query->latest()->paginate(10);

        // Ubah path file menjadi URL lengkap
        $menuDataItems->getCollection()->transform(function ($item) {
            if ($item->gambar_file_path) {
                $item->gambar_url = URL::to(Storage::url($item->gambar_file_path));
            }
            if ($item->file_path) {
                $item->dokumen_url = URL::to(Storage::url($item->file_path));
            }
            return $item;
        });

        return response()->json($menuDataItems);
    }

    /**
     * Menampilkan detail satu data konten.
     * Contoh request: /api/pages/5
     */
    public function show(MenuData $menuData)
    {
        // Tambahkan URL lengkap untuk file
        if ($menuData->gambar_file_path) {
            $menuData->gambar_url = URL::to(Storage::url($menuData->gambar_file_path));
        }
        if ($menuData->file_path) {
            $menuData->dokumen_url = URL::to(Storage::url($menuData->file_path));
        }

        // Load relasi menu
        $menuData->load('menu:id,nama,kategori,tipe_tampilan');

        return response()->json($menuData);
    }
}
