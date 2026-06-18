<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'icon',
        'badge',
        'badge_type',
        'badge_class',
        'heading',
        'description',
        'description_two',
        'features',
        'image',
        'urgent_tag',
        'btn_text',
        'btn_link',
        'serial',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'features' => 'array',
        'status' => 'boolean',
        'serial' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title) . '-' . Str::random(5);
            }
            $service->created_by = auth()->id();
        });

        static::updating(function ($service) {
            $service->updated_by = auth()->id();
        });

        static::deleting(function ($service) {
            $service->deleted_by = auth()->id();
            $service->save();
        });
    }
}