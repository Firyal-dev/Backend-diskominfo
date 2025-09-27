<?php

namespace App\Http\Controllers\contentPage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Album;

class AlbumsPhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($album_id)
    {
        $album = Album::findOrFail($album_id);
        $galeris = Galeri::where('album_id', $album_id)->get();

        return view('content.album.albumsPhotos.photos', compact('album', 'galeris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($album_id)
    {
        $album = Album::findOrFail($album_id);
        $galeris = Galeri::whereNull('album_id')->get(); // foto yg belum masuk album

        return view('content.album.albumsPhotos.create', compact('galeris', 'album'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $album_id)
    {
        $request->validate([
            'selected_galeri' => 'required|array',
        ]);

        Galeri::whereIn('id', $request->selected_galeri)
            ->update(['album_id' => $album_id]);

        return redirect()->route('album.photos.index', $album_id)->with('success', 'Foto berhasil dimasukkan ke album.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $album_id)
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
    public function destroy(Request $request, $album_id)
    {
        // Validasi input
        $request->validate([
            'selected_photosAlbum' => 'required|array',
            'selected_photosAlbum.*' => 'exists:galeris,id'
        ]);

        // Update album_id menjadi null untuk foto-foto yang dipilih
        $updatedCount = Galeri::whereIn('id', $request->selected_photosAlbum)
            ->where('album_id', $album_id) // Pastikan foto memang ada di album ini
            ->update(['album_id' => null]);

        if ($updatedCount > 0) {
            return redirect()->back()->with('success', $updatedCount . ' foto berhasil dihapus dari album.');
        } else {
            return redirect()->back()->with('error', 'Tidak ada foto yang berhasil dihapus.');
        }
    }
}
