<?php

namespace Modules\Jobs\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class JobBookmark extends Model
{
    protected $fillable = [
        'user_id',
        'job_post_id',
    ];

    /**
     * Get the job post that is bookmarked.
     */
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    /**
     * Get the user that bookmarked the job post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
