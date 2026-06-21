<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    // Add to your existing $fillable array
    protected $fillable = [
        'type', 'title', 'subtitle', 'sort_order', 'status', 'video_link', 
        'file_path', 'thumbnail', 
        'category', 'before_image', 'after_image', 'location', 'year' // New fields
    ];

    // Fixed Categories (You can add more here anytime)
    const CATEGORIES = [
        'dot-violations'        => 'DOT Violations',
        'sidewalk-repair'       => 'Sidewalk Repair',
        'concrete-replacement'  => 'Concrete Replacement',
        'driveway'              => 'Driveway',
        'ada-ramps'             => 'ADA Ramps',
        'curb'                  => 'Curb',
        'excavation'            => 'Excavation',
        'landmark-sidewalks'    => 'Landmark Sidewalks',
    ];

    public static function getCategoryOptions()
    {
        return self::CATEGORIES;
    }

    // Helper accessor for the frontend image fallback
    public function getPreviewImageAttribute()
    {
        return $this->before_image ?? $this->thumbnail ?? $this->file_path;
    }
}