<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
     public function getTree()
    {
        // Mengambil menu level atas (parent) dan memuat semua children-nya secara rekursif
        $menus = Menu::whereNull('parent_id')
                    ->with('children') // 'children' adalah nama relasi di Model Menu
                    ->orderBy('urutan')
                    ->get();

        // Memformat data agar sesuai dengan yang diharapkan React
        $formattedMenus = $this->formatMenusForFrontend($menus);

        return response()->json($formattedMenus);
    }

    /**
     * Fungsi rekursif untuk mengubah koleksi menu menjadi format array yang diinginkan.
     */
    private function formatMenusForFrontend($menus)
    {
        // Gunakan ->map untuk iterasi dan transformasi setiap item menu
        return $menus->map(function ($menu) {

            $path_url = null;
            $href = '#';

            // 1. Tentukan link (href) berdasarkan kategori
            if ($menu->kategori === 'statis') {
                // Untuk menu statis, kita buat link slug dari namanya (misal: /visi-misi)
                $path_url = '/' . Str::slug($menu->nama);
                $href = $path_url;
            } else { // Untuk 'dinamis' atau 'dinamis-tabel'
                // Link ke halaman generik dengan ID menu
                $href = '/page/' . $menu->id;
            }

            // Anda bisa menambahkan link khusus di sini jika perlu
            // if (strtolower($menu->nama) === 'kontak') {
            //     $path_url = '/kontak';
            //     $href = '/kontak';
            // }

            // 2. Buat struktur dasar untuk item menu
            $item = [
                'id' => $menu->id,
                'label' => $menu->nama,
                'href' => $href,
                'path_url' => $path_url,
                'children' => [], // Siapkan array kosong untuk children
            ];

            // 3. Jika ada children, format mereka juga (di sinilah rekursi terjadi)
            if ($menu->children->isNotEmpty()) {
                // Parent menu yang memiliki anak seharusnya tidak bisa diklik, hanya membuka dropdown.
                $item['href'] = '#';
                $item['children'] = $this->formatMenusForFrontend($menu->children);
            }

            return $item;

        })->values(); // ->values() untuk mereset key array menjadi 0, 1, 2, ...
    }
}
