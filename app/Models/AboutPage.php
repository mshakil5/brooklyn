<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_tag',
        'hero_title',
        'hero_description',
        'story_tag',
        'story_title',
        'story_content',
        'story_image',
        'badge_rating',
        'badge_label',
    ];
}