<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCv extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
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
        'career_summary',
        'total_experience',
        'declaration',
        'signature',
        'declaration_date',
        'is_public',
        'public_print_enabled',
        'public_pdf_enabled',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'declaration_date' => 'date',
        'total_experience' => 'decimal:2',
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
}
