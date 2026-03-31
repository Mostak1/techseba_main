<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Listing\Entities\Listing;
use Modules\Category\Entities\Category;
use Modules\Language\App\Models\Language;
use Modules\Category\Entities\SubCategory;
use Modules\Category\Entities\SubCategoryTranslate;
use Modules\Category\Http\Requests\SubCategoryRequest;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $SubCategories = SubCategory::latest()->get();

        return view('category::subcategory.index', ['SubCategories' => $SubCategories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Categories = Category::get();
        return view('category::subcategory.create',['categories' => $Categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {

        $subCategory = new SubCategory();
        $subCategory->category_id = $request->category_id;
        $subCategory->slug = $request->slug;
        $subCategory->status = $request->status ? 'enable' : 'disable';
        $subCategory->save();

        $languages = Language::all();
        foreach($languages as $language){
            $sub_translation = new SubCategoryTranslate();
            $sub_translation->lang_code = $language->lang_code;
            $sub_translation->subcategory_id = $subCategory->id;
            $sub_translation->name = $request->name;
            $sub_translation->save();
        }

        $Categories = Category::get();

        $notify_message= trans('translate.Created Successfully');
        $notify_message=array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->back()->with($notify_message);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('category::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $Categories = Category::get();
        $sub_category_translate = SubCategoryTranslate::where(['subcategory_id' => $id,'lang_code' => $request->lang_code])->first();

        return view('category::subcategory.edit', ['sub_category' => $subCategory, 'categories' => $Categories, 'sub_category_translate' => $sub_category_translate]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryRequest $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);

        if($request->lang_code == admin_lang()){

            $subCategory->category_id = $request->category_id;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status ? 'enable' : 'disable';
            $subCategory->save();

            $sub_translation = SubCategoryTranslate::findOrFail($request->translate_id);
            $sub_translation->name = $request->name;
            $sub_translation->save();

        }else{

            $sub_translation = SubCategoryTranslate::findOrFail($request->translate_id);
            $sub_translation->name = $request->name;
            $sub_translation->save();
        }

        $notify_message= trans('translate.Update Successfully');
        $notify_message=array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->back()->with($notify_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {


        $listing_qty = Listing::where('sub_category_id', $id)->count();

        if($listing_qty > 0 || $listing_qty > 0){
            $notify_message = trans('translate.Multiple listing and jobpost created under it, so you can not delete it');
            $notify_message = array('message'=>$notify_message,'alert-type'=>'error');
            return redirect()->back()->with($notify_message);
        }

        $sub_category = SubCategory::findOrFail($id);

        $sub_category->delete();

        SubCategoryTranslate::where('subcategory_id', $id)->delete();

        $notify_message= trans('translate.Delete Successfully');
        $notify_message=array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->route('admin.sub-category.index')->with($notify_message);
    }

    public function setup_language($lang_code){
        $cat_translates = SubCategoryTranslate::where('lang_code', admin_lang())->get();
        foreach($cat_translates as $cat_translate){
            $listing_cat_translate = new SubCategoryTranslate();
            $listing_cat_translate->lang_code = $lang_code;
            $listing_cat_translate->subcategory_id = $cat_translate->subcategory_id;
            $listing_cat_translate->name = $cat_translate->name;
            $listing_cat_translate->save();
        }
    }
}
