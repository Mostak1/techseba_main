<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvTemplate extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'preview_image',
        'view_path',
        'category',
        'style',
        'is_premium',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function cvs()
    {
        return $this->hasMany(UserCv::class, 'template_id');
    }

    /**
     * Public thumbnail URL, or null when the image is missing (UI renders a styled fallback).
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->preview_image && is_file(public_path($this->preview_image))) {
            return asset($this->preview_image);
        }

        return null;
    }
}
