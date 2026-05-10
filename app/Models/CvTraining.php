<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvTraining extends Model
{
    protected $fillable = [
        'user_cv_id',
        'training_title',
        'institute',
        'duration',
        'year',
        'certificate_details',
        'sort_order',
    ];

    public function userCv()
    {
        return $this->belongsTo(UserCv::class);
    }
}
