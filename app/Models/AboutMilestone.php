<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'title',
        'description',
        'sort_order',
        'status',
    ];
}