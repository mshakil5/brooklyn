<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutCert extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'title',
        'license_label',
        'license_number',
        'license_class',
        'description',
        'status_text',
        'sort_order',
        'status',
    ];
}