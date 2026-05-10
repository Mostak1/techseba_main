<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvEmployment extends Model
{
    protected $fillable = [
        'user_cv_id',
        'company_name',
        'designation',
        'department',
        'start_date',
        'end_date',
        'is_current',
        'responsibilities',
        'achievements',
        'company_location',
        'business_type',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function userCv()
    {
        return $this->belongsTo(UserCv::class);
    }
}
