<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// Rute untuk menerima laporan pembayaran dari Midtrans
Route::post('/payment/callback', [PaymentController::class, 'handleCallback']);