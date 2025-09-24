<?php

// Pastikan namespace ini sesuai dengan lokasi file: app/Http/Controllers/menuPage
namespace App\Http\Controllers\menuPage;

use App\Http\Controllers\Controller; // <-- Penting untuk meng-extend Controller
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar semua menu dalam format pohon.
     */
    public function index()
    {
        $menus = Menu::whereNull('parent_id')->orderBy('urutan')->with('children')->get();
        return view('menu.index', compact('menus'));
    }

    /**
     * Menampilkan formulir untuk membuat menu baru.
     */
    public function create()
    {
        $parentMenus = Menu::orderBy('nama')->get();
        return view('menu.create', compact('parentMenus'));
    }

    /**
     * Menyimpan menu baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'kategori' => ['required', Rule::in(['statis', 'dinamis', 'dinamis-tabel'])],
            'parent_id' => 'nullable|exists:menus,id',
        ]);

        Menu::create($request->all());

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dibuat.');
    }

    /**
     * Menampilkan formulir untuk mengedit menu.
     */
    public function edit(Menu $menu)
    {
        $parentMenus = Menu::where('id', '!=', $menu->id)
                            ->orderBy('nama')
                            ->get();

        return view('menu.edit', compact('menu', 'parentMenus'));
    }

    /**
     * Memperbarui menu yang ada.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'kategori' => ['required', Rule::in(['statis', 'dinamis', 'dinamis-tabel'])],
            'parent_id' => ['nullable', 'exists:menus,id', Rule::notIn([$menu->id])],
        ]);

        $menu->update($request->all());

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Menghapus menu.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}
