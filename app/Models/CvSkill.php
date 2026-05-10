<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvSkill extends Model
{
    protected $fillable = [
        'user_cv_id',
        'skill_type',
        'skill_name',
        'skill_level',
        'sort_order',
    ];

    public function userCv()
    {
        return $this->belongsTo(UserCv::class);
    }
}
