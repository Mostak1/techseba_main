<?php

namespace Modules\Jobs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organization_id',
        'job_category_id',
        'title',
        'slug',
        'location',
        'job_type',
        'salary_min',
        'salary_max',
        'salary_type',
        'experience_level',
        'status',
        'featured',
        'expires_at',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'expires_at' => 'datetime',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    /**
     * Get the organization that owns the job post.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the category that owns the job post.
     */
    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    /**
     * Get the details associated with the job post.
     */
    public function detail()
    {
        return $this->hasOne(JobDetail::class);
    }

    /**
     * Get the attachments for the job post.
     */
    public function attachments()
    {
        return $this->hasMany(JobAttachment::class);
    }

    /**
     * Get the bookmarks for the job post.
     */
    public function bookmarks()
    {
        return $this->hasMany(JobBookmark::class);
    }

    /**
     * Scope a query to only include active job posts.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured job posts.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include job posts that have not expired.
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Scope a query to filter job posts by type.
     */
    public function scopeFilterByType($query, $type)
    {
        return $query->where('job_type', $type);
    }
}
