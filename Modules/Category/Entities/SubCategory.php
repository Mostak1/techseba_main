<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Database\factories\SubCategoryFactory;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategoryTranslate;
use Modules\Listing\Entities\Listing;

class SubCategory extends Model
{
    use HasFactory;

    protected $appends = ['name', 'total_service'];

    protected $hidden = ['front_translate', 'services'];

    public function translate(){
        return $this->belongsTo(SubCategoryTranslate::class, 'id', 'subcategory_id')->where('lang_code', admin_lang());
    }


    public function front_translate(){
        return $this->belongsTo(SubCategoryTranslate::class, 'id', 'subcategory_id')->where('lang_code', front_lang());
    }

    public function getNameAttribute()
    {
        return $this->front_translate->name;
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function services(){
        return $this->hasMany(Listing::class, 'sub_category_id', 'id')->where(['status' => 'enable', 'approved_by_admin' => 'approved']);
    }

    public function getTotalServiceAttribute()
    {
        return $this->services->count();
    }
}
