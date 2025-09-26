<?php

namespace App\Http\Controllers\menuPage;

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
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // <-- TAMBAHKAN VALIDASI DOKUMEN
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke direktori 'menu/images' untuk membedakan
            $gambarPath = $request->file('gambar')->store('menu/images', 'public');
        }

        // --- LOGIKA BARU UNTUK DOKUMEN ---
        $dokumenPath = null;
        if ($request->hasFile('dokumen')) {
            // Simpan dokumen ke direktori 'menu/documents'
            $dokumenPath = $request->file('dokumen')->store('menu/documents', 'public');
        }
        // --- AKHIR LOGIKA BARU ---

        MenuData::create([
            'menu_id' => $request->menu_id,
            'judul' => $request->judul,
            'isi_konten' => $request->isi_konten,
            'gambar_file_path' => $gambarPath,
            'file_path' => $dokumenPath, // <-- SIMPAN PATH DOKUMEN
        ]);

        return redirect()->route('menu-data.index')->with('success', 'Konten berhasil dibuat.');
    }

    public function edit(MenuData $menuData)
    {
        $menus = Menu::whereIn('kategori', ['dinamis', 'dinamis-tabel'])->orderBy('nama')->get();
        // Ganti nama variabel agar konsisten dengan view
        $menuDataItem = $menuData;
        return view('menu-data.edit', compact('menuDataItem', 'menus'));
    }


    public function update(Request $request, MenuData $menuData)
    {
        $request->validate([
            'menu_id' => ['required', 'exists:menus,id', Rule::in(Menu::whereIn('kategori', ['dinamis', 'dinamis-tabel'])->pluck('id'))],
            'judul' => 'required|string|max:255',
            'isi_konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // <-- TAMBAHKAN VALIDASI DOKUMEN
        ]);

        $gambarPath = $menuData->gambar_file_path;
        if ($request->hasFile('gambar')) {
            if ($gambarPath) {
                Storage::disk('public')->delete($gambarPath);
            }
            $gambarPath = $request->file('gambar')->store('menu/images', 'public');
        }

        // --- LOGIKA BARU UNTUK UPDATE DOKUMEN ---
        $dokumenPath = $menuData->file_path;
        if ($request->hasFile('dokumen')) {
            // Hapus file lama jika ada
            if ($dokumenPath) {
                Storage::disk('public')->delete($dokumenPath);
            }
            // Simpan file baru
            $dokumenPath = $request->file('dokumen')->store('menu/documents', 'public');
        }
        // --- AKHIR LOGIKA BARU ---


        $menuData->update([
            'menu_id' => $request->menu_id,
            'judul' => $request->judul,
            'isi_konten' => $request->isi_konten,
            'gambar_file_path' => $gambarPath,
            'file_path' => $dokumenPath, // <-- UPDATE PATH DOKUMEN
        ]);

        return redirect()->route('menu-data.index')->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy(MenuData $menuData)
    {
        if ($menuData->gambar_file_path) {
            Storage::disk('public')->delete($menuData->gambar_file_path);
        }

        // --- LOGIKA BARU UNTUK HAPUS DOKUMEN ---
        if ($menuData->file_path) {
            Storage::disk('public')->delete($menuData->file_path);
        }
        // --- AKHIR LOGIKA BARU ---

        $menuData->delete();

        return redirect()->route('menu-data.index')->with('success', 'Konten berhasil dihapus.');
    }
}
