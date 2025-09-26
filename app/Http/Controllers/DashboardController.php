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
        $jumlahKonten = MenuData::count(); // <-- 4. Count all content records
        $jumlahMenu   = Menu::count();     // <-- 5. Count all menu structure records
        $jumlahAdmin  = User::count();
        $jumlahFoto   = Galeri::count();
        $admin = Auth::user();

        // Get the 5 upcoming agendas
        $agendasTerdekat = Agenda::where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->take(5)
            ->get();

        // --- Send all the data to the view ---
        return view('dashboard.index', [
            'jumlahAgenda'    => $jumlahAgenda,
            'jumlahKonten'    => $jumlahKonten,
            'jumlahMenu'      => $jumlahMenu,
            'jumlahAdmin'     => $jumlahAdmin,
            'jumlahFoto'      => $jumlahFoto,
            'agendasTerdekat' => $agendasTerdekat,
        ], compact('admin'));
    }
}
