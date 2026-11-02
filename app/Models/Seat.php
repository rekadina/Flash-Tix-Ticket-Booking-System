<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // Pastikan pakai provider MongoDB

class Seat extends Model
{
    protected $connection = 'concert';
    protected $collection = 'seats';
    
    protected $fillable = ['concert_id', 'seat_number', 'status', 'category'];
}