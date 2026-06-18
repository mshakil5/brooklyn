<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'address', 
        'borough', 'service', 'message', 'ip_address', 'is_read'
    ];
}