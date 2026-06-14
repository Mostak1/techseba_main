<?php

namespace Modules\Scraper\App\Models;

use Illuminate\Database\Eloquent\Model;

class ScraperSource extends Model
{
    protected $fillable = [
        'name',
        'url',
        'type',
        'selectors',
        'status',
        'last_scraped_at',
    ];

    protected $casts = [
        'selectors' => 'array',
        'status' => 'boolean',
        'last_scraped_at' => 'datetime',
    ];

    public function stagingJobs()
    {
        return $this->hasMany(ScraperStagingJob::class);
    }

    public function logs()
    {
        return $this->hasMany(ScraperLog::class);
    }
}
