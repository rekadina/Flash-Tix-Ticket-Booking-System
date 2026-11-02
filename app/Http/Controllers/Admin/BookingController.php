<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Booking; // Pastikan model Booking sudah ada

class BookingController extends Controller
{
    public function index()
    {
        // Contoh data dummy jika model belum siap
        $bookings = [
            [
                'id' => 'BK-001',
                'customer_name' => 'Wanda Thabita',
                'concert_title' => 'Tulus - Tur Manusia',
                'quantity' => 2,
                'total_price' => 705000,
                'status' => 'success',
                'created_at' => '2026-04-20'
            ],
            [
                'id' => 'BK-002',
                'customer_name' => 'Andreas',
                'concert_title' => 'Sheila On 7',
                'quantity' => 1,
                'total_price' => 255000,
                'status' => 'pending',
                'created_at' => '2026-04-21'
            ]
        ];

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Logika update status ke database nanti di sini
        return back()->with('success', 'Status pesanan ' . $id . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Logika hapus data
        return back()->with('success', 'Data booking berhasil dihapus.');
    }
}