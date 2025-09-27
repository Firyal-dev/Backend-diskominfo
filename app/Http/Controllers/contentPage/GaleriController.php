<?php

namespace App\Http\Controllers\contentPage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

use function Ramsey\Uuid\v1;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galeris = Galeri::orderBy('created_at', 'desc')->get();

        return view('content.galeri.galeri', compact('galeris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_path' => 'required|image|mimes:jpeg,png,jpg|max:7048'
        ]);

        try {
            $file = $request->file('file_path');
            $path = $file->store('galeri', 'public');

            Galeri::create([
                'judul' => $request->judul,
                'file_path' => $path,
                'tgl_upload' => now()
            ]);

            return redirect()->route('galeri.index')->with('success', 'Foto berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan foto: ' . $e->getMessage());
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ids = $request->input('selected_galeri', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada foto yang dipilih.');
        }

        $galeris = Galeri::whereIn('id', $ids)->get();

        foreach ($galeris as $galeri) {
            // Hapus file dari storage
            if ($galeri->file_path && Storage::disk('public')->exists($galeri->file_path)) {
                Storage::disk('public')->delete($galeri->file_path);
            }
            // Hapus data dari database
            $galeri->delete();
        }

        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }
}
