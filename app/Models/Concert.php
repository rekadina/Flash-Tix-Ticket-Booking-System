<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Concert extends Model
{
    protected $connection = 'concert'; // Pastikan koneksi ke db_concert
    protected $collection = 'concerts';

    // WAJIB: Daftar semua field yang kamu input dari Admin
    protected $fillable = [
        'name', 
        'artist', 
        'venue', 
        'city', 
        'date', 
        'time', 
        'description', 
        'poster', 
        'status', 
        'categories'
    ];
}