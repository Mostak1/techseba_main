<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'section_name',
        'section_identifier',
        'status',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('status', 'enable');
    }

    public function getIsEnabledAttribute(): bool
    {
        return $this->status === 'enable';
    }
}
