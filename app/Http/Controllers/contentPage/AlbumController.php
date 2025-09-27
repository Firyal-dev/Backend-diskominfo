<?php

namespace App\Http\Controllers\contentPage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = Album::withCount('galeri')->orderBy('created_at', 'desc')->get();

        return view('content.album.album', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.album.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'cover_album_url' => 'required|image|mimes:jpeg,png,jpg|max:5048'
        ]);

        try {

            $file = $request->file('cover_album_url');
            $path = $file->store('album_covers', 'public');

            Album::create([
                'nama' => $request->nama,
                'cover_album_url' => $path,
                'tgl_buat' => now()
            ]);

            return redirect()->route('album.index')->with('success', 'Album berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat album: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Album berhasil dibuat.');
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
        $request->validate([
            'nama' => 'required|string|max:255',
            'cover_album_url' => 'nullable|image|mimes:jpeg,png,jpg|max:5048'
        ]);

        $album = Album::findOrFail($id);
        $album->nama = $request->nama;

        // Jika ada file cover baru, upload dan ganti cover lama
        if ($request->hasFile('cover_album_url')) {
            // Hapus cover lama jika ada
            if ($album->cover_album_url && Storage::disk('public')->exists($album->cover_album_url)) {
                Storage::disk('public')->delete($album->cover_album_url);
            }
            $file = $request->file('cover_album_url');
            $path = $file->store('album_covers', 'public');
            $album->cover_album_url = $path;
        }

        $album->save();

        return redirect()->back()->with('success', 'Album berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ids = $request->input('selected_album', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada album yang dipilih.');
        }

        foreach ($ids as $albumId) {
            // Set album_id pada galeri yang terkait ke null
            Galeri::where('album_id', $albumId)->update(['album_id' => null]);
            // Hapus album dari tabel album
            Album::where('id', $albumId)->delete();
        }

        return redirect()->back()->with('success', 'Album berhasil dihapus tanpa menghapus foto di dalamnya.');
    }
}
