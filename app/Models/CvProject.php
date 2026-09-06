<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvProject extends Model
{
    protected $fillable = [
        'user_cv_id',
        'title',
        'link',
        'github_url',
        'technologies',
        'role',
        'problem',
        'solution',
        'image',
        'demo_user',
        'demo_password',
        'description',
        'sort_order',
    ];

    public function userCv()
    {
        return $this->belongsTo(UserCv::class);
    }
}
