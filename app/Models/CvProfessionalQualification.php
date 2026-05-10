<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvProfessionalQualification extends Model
{
    protected $fillable = [
        'user_cv_id',
        'title',
        'authority',
        'result_or_score',
        'year',
        'details',
        'sort_order',
    ];

    public function userCv()
    {
        return $this->belongsTo(UserCv::class);
    }
}
