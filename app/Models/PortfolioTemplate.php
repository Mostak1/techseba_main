<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioTemplate extends Model
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
        return $this->hasMany(UserCv::class, 'portfolio_template_id');
    }
}
