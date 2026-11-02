<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class SystemSetting extends Model
{
    protected $connection = 'booking';
    protected $collection = 'system_settings';
    
    protected $fillable = ['key', 'value', 'group', 'label', 'type'];
}