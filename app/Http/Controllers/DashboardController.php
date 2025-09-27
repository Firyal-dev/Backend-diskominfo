<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Menu;
use App\Models\MenuData;
use App\Models\User;
use App\Models\Galeri;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with dynamic data.
     */
    public function index()
    {
        // --- Get all the data needed for the cards ---
        $jumlahAgenda = Agenda::count();
        $jumlahKonten = MenuData::count();
        $jumlahMenu   = Menu::count();
        $jumlahAdmin  = User::count();
        $jumlahFoto   = Galeri::count();

        // --- Get the 5 upcoming agendas ---
        $agendasTerdekat = Agenda::where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->take(5)
            ->get();

        // --- Chart Data: jumlah konten per bulan (12 bulan terakhir) ---
        $kontenBulanan = MenuData::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Susun data untuk 12 bulan (jangan bolong)
        $bulanIndo = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartBulan = [];
        $chartJumlah = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartBulan[]  = $bulanIndo[$i - 1];
            $chartJumlah[] = $kontenBulanan[$i] ?? 0;
        }

        $chartData = [
            'bulan'  => $chartBulan,
            'jumlah' => $chartJumlah,
        ];

        // --- Send all the data to the view ---
        return view('dashboard.index', [
            'jumlahAgenda'    => $jumlahAgenda,
            'jumlahKonten'    => $jumlahKonten,
            'jumlahMenu'      => $jumlahMenu,
            'jumlahAdmin'     => $jumlahAdmin,
            'jumlahFoto'      => $jumlahFoto,
            'agendasTerdekat' => $agendasTerdekat,
            'chartData'       => $chartData,
        ]);
    }
}
