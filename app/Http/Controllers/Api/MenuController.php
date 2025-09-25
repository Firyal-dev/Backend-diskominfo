<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    /**
     * Mengambil dan mengembalikan data menu dalam format pohon (nested).
     */
    public function getTree()
    {
        // Ambil semua menu dari database, diurutkan berdasarkan 'urutan'
        $allMenus = Menu::orderBy('urutan')->get()->toArray();

        // Ubah data flat menjadi struktur pohon
        $menuTree = $this->buildTree($allMenus);

        // Kembalikan sebagai respons JSON
        return response()->json($menuTree);
    }

    /**
     * Fungsi rekursif untuk membangun struktur pohon dari array data menu.
     * Fungsi ini juga akan mengubah nama kolom agar sesuai dengan ekspektasi front-end.
     *
     * @param array $elements Data menu dari database
     * @param int|null $parentId ID dari parent menu yang sedang dicari anaknya
     * @return array
     */
    private function buildTree(array $elements, $parentId = null): array
    {
        $branch = [];

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                // Cari anak dari elemen saat ini
                $children = $this->buildTree($elements, $element['id']);

                // Transformasi data agar sesuai dengan front-end
                $transformedElement = [
                    'id' => $element['id'],
                    'label' => $element['nama'], // 'nama' -> 'label'
                    'href' => $this->generateHref($element), // Buat href dinamis
                    'parent_id' => $element['parent_id'],
                    'kategori' => $element['kategori'],
                    'children' => $children, // Tambahkan anak yang sudah ditemukan
                ];

                $branch[] = $transformedElement;
            }
        }
        return $branch;
    }

    /**
     * Membuat path URL (href) berdasarkan kategori menu.
     */
    private function generateHref(array $menu): string
    {
        $slug = Str::slug($menu['nama']);

        if ($menu['kategori'] === 'dinamis') {
            return "/page/{$slug}";
        }
        if ($menu['kategori'] === 'dinamis-tabel') {
            return "/table/{$slug}";
        }

        // Untuk menu statis, kita asumsikan link-nya adalah slug dari namanya.
        // Contoh: "Visi Misi" -> "/visi-misi"
        return "/{$slug}";
    }
}
