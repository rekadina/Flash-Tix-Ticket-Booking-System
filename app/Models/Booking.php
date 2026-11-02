<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // Pastikan menggunakan model MongoDB

class Booking extends Model
{
    protected $connection = 'mongodb'; // Sesuai config database kamu
    protected $collection = 'bookings'; // Nama koleksi di MongoDB
    
    protected $fillable = [
        'customer_name',
        'concert_title',
        'quantity',
        'total_price',
        'status',
        'created_at'
    ];
}