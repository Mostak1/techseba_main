<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;

    public const MANAGED_ROUTES = [
        'home' => ['name' => 'Home', 'route' => 'home'],
        'about-us' => ['name' => 'About Us', 'route' => 'about-us'],
        'services' => ['name' => 'Services', 'route' => 'services'],
        'portfolio' => ['name' => 'Portfolio', 'route' => 'portfolio'],
        'blogs' => ['name' => 'Blogs', 'route' => 'blogs'],
        'pricing-plan' => ['name' => 'Pricing Plan', 'route' => 'pricing'],
        'teams' => ['name' => 'Our Teams', 'route' => 'teams'],
        'faq' => ['name' => 'FAQ', 'route' => 'faq'],
        'testimonials' => ['name' => 'Testimonials', 'route' => 'testimonials'],
        'contact-us' => ['name' => 'Contact Us', 'route' => 'contact-us'],
        'privacy-policy' => ['name' => 'Privacy Policy', 'route' => 'privacy-policy'],
        'terms-conditions' => ['name' => 'Terms & Conditions', 'route' => 'terms-conditions'],
    ];

    protected $fillable = [
        'name',
        'slug',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function enabledSections(): HasMany
    {
        return $this->sections()->where('status', 'enable');
    }

    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('is_enabled', true);
    }

    public function hasEnabledSection(string $identifier): bool
    {
        if ($this->relationLoaded('sections')) {
            return $this->sections
                ->where('section_identifier', $identifier)
                ->where('status', 'enable')
                ->isNotEmpty();
        }

        return $this->sections()
            ->where('section_identifier', $identifier)
            ->where('status', 'enable')
            ->exists();
    }

    public function getMenuUrlAttribute(): string
    {
        if ($routeName = $this->managed_route_name) {
            return route($routeName);
        }

        return route('dynamic-page.show', $this->slug);
    }

    public function getIsManagedAttribute(): bool
    {
        return array_key_exists($this->slug, self::MANAGED_ROUTES);
    }

    public function getManagedRouteNameAttribute(): ?string
    {
        return self::MANAGED_ROUTES[$this->slug]['route'] ?? null;
    }
}
