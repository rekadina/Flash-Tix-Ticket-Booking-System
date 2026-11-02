<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman formulir edit profil akun kustom
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Mengubah data informasi profil dan memproses upload berkas foto
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // Validasi masukan data teks dan berkas gambar
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Maksimal berkas file 2MB
        ]);

        // Logika Pemeriksaan Berkas Foto Profil
        if ($request->hasFile('avatar')) {
            // Hapus gambar lama dari disk 'public' jika record terdeteksi ada di DB
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan file baru ke directory storage/app/public/avatars
            $path = $request->file('avatar')->store('avatars', 'public');
            
            // Masukkan path nama file ke property model user MongoDB
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Mengubah kata sandi akun keamanan pengguna
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Kata sandi akun Anda berhasil diperbarui!');
    }

    /**
     * Menghapus akun pengguna dari cluster MongoDB
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        // Hapus file gambar avatar dari penyimpanan lokal lokal sebelum akun di-drop
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}