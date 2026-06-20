<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'address', 
        'first_name', 
        'phone', 
        'email', 
        'status', 
        'risk_score', 
        'dot_tickets_count', 
        'dob_complaints_count', 
        'risk_details', 
        'api_raw_data', 
        'is_contacted'
    ];

    // Automatically cast JSON fields to/from arrays
    protected $casts = [
        'risk_details' => 'array',
        'api_raw_data' => 'array',
        'is_contacted' => 'boolean',
    ];
}