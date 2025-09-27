<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManageAdminsController extends Controller
{
    public function index() {
        if (Auth::user()->level !== 'superadmin') {
            abort(403, 'Unauthorized');
        }
        $users = User::get();
        $admin = Auth::user();
        return view('manageAdmins.index', compact('users', 'admin'));
    }
}
