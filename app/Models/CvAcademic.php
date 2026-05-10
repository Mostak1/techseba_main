<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvAcademic extends Model
{
    protected $fillable = [
        'user_cv_id',
        'degree_name',
        'institution',
        'board_or_university',
        'group_or_major',
        'result',
        'passing_year',
        'sort_order',
    ];

    public function userCv()
    {
        return $this->belongsTo(UserCv::class);
    }
}
