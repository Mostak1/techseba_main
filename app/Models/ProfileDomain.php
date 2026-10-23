<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileDomain extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_REVIEWING = 'reviewing';
    public const STATUS_COMPLETE = 'complete';
    public const STATUS_CANCELED = 'canceled';

    protected $fillable = [
        'user_id',
        'host',
        'type',
        'status',
        'user_note',
        'admin_message',
        'is_primary',
        'is_active',
        'verified_at',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_REVIEWING => 'Reviewing',
            self::STATUS_COMPLETE => 'Complete',
            self::STATUS_CANCELED => 'Canceled',
            default => 'Pending',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_REVIEWING => 'bg-info text-white',
            self::STATUS_COMPLETE => 'bg-success text-white',
            self::STATUS_CANCELED => 'bg-danger text-white',
            default => 'bg-warning text-dark',
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getBaseDomain(): string
    {
        $canonical = config('techseba_seo.canonical_host');
        if ($canonical && $canonical !== 'localhost' && $canonical !== '127.0.0.1') {
            return strtolower($canonical);
        }
        $host = parse_url(config('app.url'), PHP_URL_HOST);
        if ($host && $host !== 'localhost' && $host !== '127.0.0.1') {
            return strtolower($host);
        }
        return 'techseba.com';
    }

    public function getUrlAttribute(): string
    {
        $scheme = (request()->isSecure() || app()->environment('production')) ? 'https://' : 'http://';
        return $scheme . $this->host;
    }

    public function isSubdomain(): bool
    {
        return $this->type === 'subdomain';
    }

    public function isCustomDomain(): bool
    {
        return $this->type === 'custom_domain';
    }
}
