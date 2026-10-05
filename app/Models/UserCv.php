<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCv extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'portfolio_template_id',
        'full_name',
        'father_name',
        'mother_name',
        'date_of_birth',
        'gender',
        'marital_status',
        'nationality',
        'religion',
        'nid_or_passport',
        'present_address',
        'permanent_address',
        'mobile',
        'email',
        'website_url',
        'github_url',
        'linkedin_url',
        'photo',
        'career_objective',
        'technical_challenge',
        'built_from_scratch',
        'proficiency_ratings',
        'sparks_joy',
        'landing_page_url',
        'career_summary',
        'total_experience',
        'declaration',
        'signature',
        'source_file',
        'source_file_original_name',
        'source_text',
        'source_extract_status',
        'source_extracted_at',
        'declaration_date',
        'is_public',
        'public_print_enabled',
        'public_pdf_enabled',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'declaration_date' => 'date',
        'source_extracted_at' => 'datetime',
        'total_experience' => 'decimal:2',
        'proficiency_ratings' => 'array',
        'is_public' => 'boolean',
        'public_print_enabled' => 'boolean',
        'public_pdf_enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(CvTemplate::class, 'template_id');
    }

    public function portfolioTemplate()
    {
        return $this->belongsTo(PortfolioTemplate::class, 'portfolio_template_id');
    }

    public function employments()
    {
        return $this->hasMany(CvEmployment::class)->orderBy('sort_order');
    }

    public function academics()
    {
        return $this->hasMany(CvAcademic::class)->orderBy('sort_order');
    }

    public function trainings()
    {
        return $this->hasMany(CvTraining::class)->orderBy('sort_order');
    }

    public function professionalQualifications()
    {
        return $this->hasMany(CvProfessionalQualification::class)->orderBy('sort_order');
    }

    public function skills()
    {
        return $this->hasMany(CvSkill::class)->orderBy('sort_order');
    }

    public function languages()
    {
        return $this->hasMany(CvLanguage::class)->orderBy('sort_order');
    }

    public function references()
    {
        return $this->hasMany(CvReference::class)->orderBy('sort_order');
    }

    public function projects()
    {
        return $this->hasMany(CvProject::class)->orderBy('sort_order');
    }

    /**
     * Calculate total days from all employment histories.
     * Running jobs (is_current = true or null end_date) use the current date (Carbon::now()).
     */
    public function getCalculatedTotalDaysAttribute(): int
    {
        $totalDays = 0;
        foreach ($this->employments as $employment) {
            if (! $employment->start_date) {
                continue;
            }
            $start = \Illuminate\Support\Carbon::parse($employment->start_date);
            $end = ($employment->is_current || ! $employment->end_date)
                ? \Illuminate\Support\Carbon::now()
                : \Illuminate\Support\Carbon::parse($employment->end_date);

            if ($end->greaterThanOrEqualTo($start)) {
                $totalDays += $start->diffInDays($end) + 1;
            }
        }

        return (int) $totalDays;
    }

    /**
     * Calculate total experience in decimal years (e.g. 4.5)
     */
    public function getCalculatedTotalExperienceYearsAttribute(): float
    {
        $days = $this->calculated_total_days;
        if ($days <= 0) {
            return (float) ($this->attributes['total_experience'] ?? 0);
        }

        return round($days / 365.25, 1);
    }

    /**
     * Format total experience dynamically (e.g., "4 Years 5 Months" or "6 Years 6 Months")
     */
    public function getFormattedTotalExperienceAttribute(): string
    {
        $days = $this->calculated_total_days;
        if ($days <= 0) {
            $manual = (float) ($this->attributes['total_experience'] ?? 0);
            if ($manual <= 0) {
                return '0 Months';
            }
            $years = (int) floor($manual);
            $months = (int) round(($manual - $years) * 12);
            $parts = [];
            if ($years > 0) {
                $parts[] = $years.' '.($years === 1 ? 'Year' : 'Years');
            }
            if ($months > 0) {
                $parts[] = $months.' '.($months === 1 ? 'Month' : 'Months');
            }

            return ! empty($parts) ? implode(' ', $parts) : '0 Months';
        }

        $years = (int) floor($days / 365.25);
        $remDays = $days - ($years * 365.25);
        $months = (int) round($remDays / 30.4375);

        if ($months >= 12) {
            $years += 1;
            $months = 0;
        }

        $parts = [];
        if ($years > 0) {
            $parts[] = $years.' '.($years === 1 ? 'Year' : 'Years');
        }
        if ($months > 0) {
            $parts[] = $months.' '.($months === 1 ? 'Month' : 'Months');
        }

        return ! empty($parts) ? implode(' ', $parts) : 'Less than 1 Month';
    }

    /**
     * Short format for badges / headers (e.g. "6.5+ Years" or "4y 5m")
     */
    public function getFormattedTotalExperienceShortAttribute(): string
    {
        $days = $this->calculated_total_days;
        if ($days <= 0) {
            $manual = (float) ($this->attributes['total_experience'] ?? 0);

            return $manual > 0 ? rtrim(rtrim(number_format($manual, 1), '0'), '.').'+ Years' : '0 Years';
        }

        $decimal = round($days / 365.25, 1);

        return rtrim(rtrim(number_format($decimal, 1), '0'), '.').'+ Years';
    }
}
