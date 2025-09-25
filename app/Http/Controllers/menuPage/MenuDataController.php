<?php

namespace App\Http\Controllers\menuPage ;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MenuDataController extends Controller
{
    public function index()
    {
        $menuDataItems = MenuData::with('menu')->latest()->paginate(10);
        return view('menu-data.index', compact('menuDataItems'));
    }

    public function create()
    {
        $menus = Menu::whereIn('kategori', ['dinamis', 'dinamis-tabel'])->orderBy('nama')->get();
        return view('menu-data.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => ['required', 'exists:menus,id', Rule::in(Menu::whereIn('kategori', ['dinamis', 'dinamis-tabel'])->pluck('id'))],
            'judul' => 'required|string|max:255',
            'isi_konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('gambar')) {
            $filePath = $request->file('gambar')->store('menu', 'public');
        }

        MenuData::create([
            'menu_id' => $request->menu_id,
            'judul' => $request->judul,
            'isi_konten' => $request->isi_konten,
            'gambar_file_path' => $filePath,
        ]);

        return redirect()->route('menu-data.index')->with('success', 'Konten berhasil ditambahkan.');
    }

    // [DIPERBAIKI] Menggunakan parameter $menuData sesuai konvensi Laravel
    public function edit(MenuData $menuData)
    {
        $menus = Menu::whereIn('kategori', ['dinamis', 'dinamis-tabel'])->orderBy('nama')->get();
        return view('menu-data.edit', compact('menuData', 'menus'));
    }

    // [DIPERBAIKI] Menggunakan parameter $menuData sesuai konvensi Laravel
    public function update(Request $request, MenuData $menuData)
    {
        $request->validate([
            'menu_id' => ['required', 'exists:menus,id', Rule::in(Menu::whereIn('kategori', ['dinamis', 'dinamis-tabel'])->pluck('id'))],
            'judul' => 'required|string|max:255',
            'isi_konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $filePath = $menuData->gambar_file_path;
        if ($request->hasFile('gambar')) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('gambar')->store('menu', 'public');
        }

        $menuData->update([
            'menu_id' => $request->menu_id,
            'judul' => $request->judul,
            'isi_konten' => $request->isi_konten,
            'gambar_file_path' => $filePath,
        ]);

        return redirect()->route('menu-data.index')->with('success', 'Konten berhasil diperbarui.');
    }

    // [DIPERBAIKI] Menggunakan parameter $menuData sesuai konvensi Laravel
    public function destroy(MenuData $menuData)
    {
        if ($menuData->gambar_file_path) {
            Storage::disk('public')->delete($menuData->gambar_file_path);
        }

        $menuData->delete();

        return redirect()->route('menu-data.index')->with('success', 'Konten berhasil dihapus.');
    }
}

