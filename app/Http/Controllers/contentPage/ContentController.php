<?php

namespace App\Http\Controllers\contentPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $galeris = Galeri::orderBy('created_at', 'desc')->get();
        $admin = Auth::user();

        return view('content.index', compact('galeris', 'albums', 'admin'));
    }

    // Galeri Methods
    public function uploadGaleri(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_path' => 'required|image|mimes:jpeg,png,jpg|max:5048'
        ]);

        try {
            $file = $request->file('file_path');
            $path = $file->store('galeri', 'public');

            Galeri::create([
                'judul' => $request->judul,
                'file_path' => $path,
                'tgl_upload' => now()
            ]);

            return redirect()->back()->with('success', 'Foto berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan foto: ' . $e->getMessage());
        }
    }

    public function deleteGaleri(Request $request)
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

    //

    // Album Methods
    // Create Album
    public function createAlbum(Request $request)
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

            return redirect()->back()->with('success', 'Album berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat album: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Album berhasil dibuat.');
    }

    public function uploadAlbumPhotos(Request $request)
    {
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'selected_galeri' => 'required|array',
        ]);

        Galeri::whereIn('id', $request->selected_galeri)
            ->update(['album_id' => $request->album_id]);

        return redirect()->back()->with('success', 'Foto berhasil dimasukkan ke album.');
    }

    // Album delete method
    public function deleteAlbum(Request $request)
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

    // Delete photos in album
    public function deleteAlbumPhotos(Request $request)
    {
        $ids = $request->input('selected_photosAlbum', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada foto yang dipilih.');
        }

        // Set album_id ke null untuk foto yang dipilih
        Galeri::whereIn('id', $ids)->update(['album_id' => null]);

        return redirect()->back()->with('success', 'Foto berhasil dihapus dari album.');
    }

    // Edit Album
    public function editAlbum(Request $request, $id)
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

    // Upload cover album
}
