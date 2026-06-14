<?php

namespace Modules\Jobs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'status',
    ];

    /**
     * Get the job posts for the category.
     */
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }

    /**
     * Scope a query to only include active job categories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
