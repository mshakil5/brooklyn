<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutHighlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'sort_order',
        'status',
    ];
}