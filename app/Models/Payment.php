<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Payment extends Model
{
    /**
     * Menghubungkan model ini ke database 'payment' 
     * sesuai pengaturan di config/database.php
     */
    protected $connection = 'payment';

    /**
     * Nama koleksi (tabel) di dalam MongoDB
     */
    protected $collection = 'payments';

    /**
     * Field yang boleh diisi (mass assignable)
     */
    protected $fillable = [
        'booking_id',
        'user_id',
        'amount',
        'payment_method',
        'status', // misal: pending, success, failed
        'transaction_id', // ID dari Midtrans
        'payment_date',
    ];

    /**
     * Cast data agar formatnya sesuai
     */
    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'integer',
    ];
}