<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'link',
        'image',
        'serial',
        'status',
        'highlights',
        'stats',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'highlights' => 'array',
        'stats' => 'array',
        'status' => 'integer',
        'serial' => 'integer',
    ];
}
