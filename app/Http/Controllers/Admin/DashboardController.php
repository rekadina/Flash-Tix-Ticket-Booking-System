<?php

// INI KUNCI PERBAIKANNYA: Menambahkan \Admin agar tidak bentrok dengan Dashboard milik User
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Tarik data statistik untuk ditampilkan di dashboard admin
        $totalTickets = DB::connection('booking')->table('bookings')->count();
        $checkedIn = DB::connection('booking')->table('bookings')->where('status', 'CHECKED_IN')->count();

        // Lempar ke file tampilan admin
        return view('admin.dashboard', compact('totalTickets', 'checkedIn'));
    }
}