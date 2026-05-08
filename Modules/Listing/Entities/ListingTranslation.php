<?php

namespace Modules\Listing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ListingTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['plans', 'listing_id', 'lang_code', 'title', 'description', 'address', 'seo_title', 'seo_description'];

    protected $casts = [
        'plans' => 'array'
    ];
}
