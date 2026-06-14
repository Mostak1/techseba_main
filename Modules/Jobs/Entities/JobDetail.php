<?php

namespace Modules\Jobs\Entities;

use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    protected $fillable = [
        'job_post_id',
        'description',
        'requirements',
        'responsibilities',
        'benefits',
    ];

    /**
     * Get the job post that owns the detail.
     */
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}
