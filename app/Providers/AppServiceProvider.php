<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // SUNTIK DATA NOTIFIKASI SECARA OTOMATIS KE LAYOUT UTAMA APP BLADE
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                $userId = (string) Auth::id();

                // 1. Ambil 5 notifikasi terbaru milik user dari MongoDB db_booking
                $unreadNotifications = DB::connection('booking')->table('notifications')
                    ->where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();

                // 2. Hitung jumlah notifikasi yang statusnya belum dibaca (is_read = false)
                $unreadCount = DB::connection('booking')->table('notifications')
                    ->where('user_id', $userId)
                    ->where('is_read', false)
                    ->count();

                // Kirim variabel ini ke file layouts/app.blade.php
                $view->with([
                    'appNotifications' => $unreadNotifications,
                    'appUnreadCount' => $unreadCount
                ]);
            }
        });
    }
}