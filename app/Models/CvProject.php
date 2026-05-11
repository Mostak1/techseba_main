<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvProject extends Model
{
    protected $fillable = [
        'user_cv_id',
        'title',
        'link',
        'description',
        'sort_order',
    ];

    public function userCv()
    {
        return $this->belongsTo(UserCv::class);
    }
}
