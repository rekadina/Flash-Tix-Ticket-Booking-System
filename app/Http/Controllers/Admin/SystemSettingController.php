<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function index()
    {
        // Ambil semua setting dan kelompokkan berdasarkan group (concert, payment, dll)
        $settings = SystemSetting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'settings' => 'required|array',
        ]);

        // Update setiap setting di MongoDB
        foreach ($request->settings as $key => $value) {
            SystemSetting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Konfigurasi Sistem Berhasil Diperbarui!');
    }
}