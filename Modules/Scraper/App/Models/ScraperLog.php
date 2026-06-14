<?php

namespace Modules\Scraper\App\Models;

use Illuminate\Database\Eloquent\Model;

class ScraperLog extends Model
{
    protected $fillable = [
        'scraper_source_id',
        'status',
        'jobs_found',
        'jobs_imported',
        'error_message',
    ];

    public function source()
    {
        return $this->belongsTo(ScraperSource::class, 'scraper_source_id');
    }
}
