<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvReference extends Model
{
    protected $fillable = [
        'user_cv_id',
        'name',
        'designation',
        'organization',
        'phone',
        'email',
        'relationship',
        'sort_order',
    ];

    public function userCv()
    {
        return $this->belongsTo(UserCv::class);
    }
}
