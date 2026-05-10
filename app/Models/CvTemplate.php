<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvTemplate extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'preview_image',
        'view_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function cvs()
    {
        return $this->hasMany(UserCv::class, 'template_id');
    }
}
