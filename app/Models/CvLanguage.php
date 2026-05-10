<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvLanguage extends Model
{
    protected $fillable = [
        'user_cv_id',
        'language_name',
        'reading_level',
        'writing_level',
        'speaking_level',
        'sort_order',
    ];

    public function userCv()
    {
        return $this->belongsTo(UserCv::class);
    }
}
