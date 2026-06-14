<?php

namespace Modules\Jobs\Entities;

use Illuminate\Database\Eloquent\Model;

class JobAttachment extends Model
{
    protected $fillable = [
        'job_post_id',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
    ];

    /**
     * Get the job post that owns the attachment.
     */
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}
