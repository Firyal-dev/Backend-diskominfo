<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda; // 1. PENTING: Import Model Agenda

// Jika Anda sudah membuat model lain, import juga di sini
// use App\Models\Konten;
// use App\Models\Menu;
// use App\Models\Admin;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data dinamis.
     */
    public function index()
    {
        // 2. AMBIL SEMUA DATA YANG DIBUTUHKAN

        // Mengambil data untuk kartu statistik
        $jumlahAgenda = Agenda::count();

        // Baris di bawah ini akan error jika Modelnya belum dibuat.
        // Anda bisa membukanya satu per satu setelah membuat Modelnya.
        // $jumlahKonten = Konten::count();
        // $jumlahMenu   = Menu::count();
        // $jumlahAdmin  = Admin::count();

        // Mengambil 5 agenda terdekat dari hari ini
        $agendasTerdekat = Agenda::where('tanggal', '>=', now())
                                 ->orderBy('tanggal', 'asc')
                                 ->take(5)
                                 ->get();

        // 3. KIRIM SEMUA DATA KE VIEW
        return view('dashboard.index', [
            'jumlahAgenda'    => $jumlahAgenda,
            'jumlahKonten'    => 0, // Ganti 0 dengan $jumlahKonten jika model sudah ada
            'jumlahMenu'      => 0, // Ganti 0 dengan $jumlahMenu jika model sudah ada
            'jumlahAdmin'     => 0, // Ganti 0 dengan $jumlahAdmin jika model sudah ada
            'agendasTerdekat' => $agendasTerdekat,
        ]);
    }
}
