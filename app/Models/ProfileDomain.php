<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileDomain extends Model
{
    protected $fillable = [
        'user_id',
        'host',
        'type',
        'is_primary',
        'is_active',
        'verified_at',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
