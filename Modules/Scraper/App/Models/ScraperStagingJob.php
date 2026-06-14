<?php

namespace Modules\Scraper\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Jobs\Entities\JobPost;

class ScraperStagingJob extends Model
{
    protected $fillable = [
        'scraper_source_id',
        'title',
        'organization_name',
        'category_name',
        'location',
        'job_type',
        'salary_min',
        'salary_max',
        'experience_level',
        'description',
        'requirements',
        'responsibilities',
        'source_url',
        'expires_at',
        'status',
        'approved_job_post_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function source()
    {
        return $this->belongsTo(ScraperSource::class, 'scraper_source_id');
    }

    public function approvedJobPost()
    {
        return $this->belongsTo(JobPost::class, 'approved_job_post_id');
    }
}
