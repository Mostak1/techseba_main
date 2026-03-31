<?php

namespace Modules\Language\App\Http\Controllers;

use App\Models\TeamTranslation;
use DB, File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Brand\Entities\BrandTranslation;
use Modules\Brand\Http\Controllers\BrandController;
use Modules\Ecommerce\Entities\ProductTranslation;
use Modules\Ecommerce\Http\Controllers\ProductController;
use Modules\Language\App\Models\Language;
use Modules\City\Entities\CityTranslation;
use Modules\FAQ\App\Models\FaqTranslation;
use Modules\Page\App\Http\Controllers\SliderController;
use Modules\Page\App\Models\PrivacyPolicy;
use Modules\Blog\App\Models\BlogTranslation;
use Modules\Page\App\Models\SliderTranslation;
use Modules\Page\App\Models\TermAndCondition;
use Modules\Page\App\Models\FooterTranslation;
use Modules\Page\App\Models\AboutUsTranslation;
use Modules\JobPost\Entities\JobPostTranslation;
use Modules\Listing\Entities\ListingTranslation;
use Modules\Page\App\Models\HomepageTranslation;
use Modules\City\Http\Controllers\CityController;
use Modules\Page\App\Models\ContactUsTranslation;
use Modules\Category\Entities\CategoryTranslation;
use Modules\Page\App\Models\CustomPageTranslation;
use Modules\FAQ\App\Http\Controllers\FAQController;
use Modules\Blog\App\Models\BlogCategoryTranslation;
use Modules\Blog\App\Http\Controllers\BlogController;
use Modules\JobPost\Http\Controllers\JobPostController;
use Modules\Language\App\Http\Requests\LanguageRequest;
use Modules\Listing\Http\Controllers\ListingController;
use Modules\Page\App\Http\Controllers\AboutusController;
use Modules\Page\App\Http\Controllers\PrivacyController;
use Modules\Category\Http\Controllers\CategoryController;
use Modules\Page\App\Http\Controllers\HomepageController;
use Modules\Project\App\Http\Controllers\ProjectController;
use Modules\Project\App\Models\ProjectTranslation;
use Modules\Team\App\Http\Controllers\TeamController;
use Modules\Testimonial\App\Models\TestimonialTrasnlation;
use Modules\Page\App\Http\Controllers\CustomPageController;
use Modules\Page\App\Http\Controllers\ContactPageController;
use Modules\Blog\App\Http\Controllers\BlogCategoryController;
use Modules\Page\App\Http\Controllers\FooterContrllerController;
use Modules\Page\App\Http\Controllers\TermsConditiondController;
use Modules\Testimonial\App\Http\Controllers\TestimonialController;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::latest()->get();

        return view('language::index', ['languages' => $languages]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('language::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LanguageRequest $request)
    {
        if($request->is_default){
            DB::table('languages')->update(['is_default' => 'No']);
        }

        $language = new Language();
        $language->lang_code = $request->lang_code;
        $language->lang_name = $request->lang_name;
        $language->lang_direction = $request->lang_direction;
        $language->status = $request->status ? 1 : 0;
        $language->is_default = $request->is_default ? 'Yes' : 'No';
        $language->save();


        $testi_lang = new TestimonialController();
        $testi_lang->setup_language($request->lang_code);

        $blog_cat_lang = new BlogCategoryController();
        $blog_cat_lang->setup_language($request->lang_code);

        $blog_lang = new BlogController();
        $blog_lang->setup_language($request->lang_code);

        $faq_lang = new FAQController();
        $faq_lang->setup_language($request->lang_code);

        $privacy_lang = new PrivacyController();
        $privacy_lang->setup_language($request->lang_code);

        $terms_condition_lang = new TermsConditiondController();
        $terms_condition_lang->setup_language($request->lang_code);

        $city_lang = new CityController();
        $city_lang->setup_language($request->lang_code);

        $category_lang = new CategoryController();
        $category_lang->setup_language($request->lang_code);

        $listing_lang = new ListingController();
        $listing_lang->setup_language($request->lang_code);

        $project_lang = new ProjectController();
        $project_lang->setup_language($request->lang_code);

        $jobpost_lang = new JobPostController();
        $jobpost_lang->setup_language($request->lang_code);

        $about_lang = new AboutusController();
        $about_lang->setup_language($request->lang_code);

        $contact_lang = new ContactPageController();
        $contact_lang->setup_language($request->lang_code);

        $footer_lang = new FooterContrllerController();
        $footer_lang->setup_language($request->lang_code);

        $home_lang = new HomepageController();
        $home_lang->setup_language($request->lang_code);

        $page_lang = new CustomPageController();
        $page_lang->setup_language($request->lang_code);

        $slider_lang = new SliderController();
        $slider_lang->setup_language($request->lang_code);

        $team_lang = new TeamController();
        $team_lang->setup_language($request->lang_code);

        $product_lang = new ProductController();
        $product_lang->setup_language($request->lang_code);

        $brand_lang = new BrandController();
        $brand_lang->setup_language($request->lang_code);


        /** generate local language */

        $path = base_path().'/lang'.'/'.$request->lang_code;

        if (! File::exists($path)) {
            File::makeDirectory($path);

            $sourcePath = base_path().'/lang/en';
            $destinationPath = $path;

            // Get all files from the source folder
            $files = File::allFiles($sourcePath);

            foreach ($files as $file) {
                $destinationFile = $destinationPath . '/' . $file->getRelativePathname();

                // Copy the file to the destination folder
                File::copy($file->getRealPath(), $destinationFile);
            }
        }

        $notify_message = trans('translate.Created successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');

        return redirect()->route('admin.language.index')->with($notify_message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $language = Language::findOrFail($id);

        return view('language::edit', ['language' => $language]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LanguageRequest $request, $id)
    {

        $language = Language::findOrFail($id);

        if($request->is_default){
            DB::table('languages')->update(['is_default' => 'No']);
        }

        if($language->is_default == 'Yes'){
            DB::table('languages')->where('id', 1)->update(['is_default' => 'Yes']);
        }

        $language->lang_name = $request->lang_name;
        $language->lang_direction = $request->lang_direction;
        $language->status = $request->status ? 1 : 0;
        $language->is_default = $request->is_default ? 'Yes' : 'No';
        $language->save();

        $notify_message = trans('translate.Updated successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('admin.language.index')->with($notify_message);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id == 1){
            $notify_message = trans('translate.You can not delete english language');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->route('admin.language.index')->with($notify_message);
        }

        $language = Language::findOrFail($id);
        $language->delete();

        BrandTranslation::where('lang_code', $language->lang_code)->delete();
        BlogCategoryTranslation::where('lang_code' , $language->lang_code)->delete();
        BlogTranslation::where('lang_code' , $language->lang_code)->delete();
        FaqTranslation::where('lang_code' , $language->lang_code)->delete();
        PrivacyPolicy::where('lang_code' , $language->lang_code)->delete();
        TermAndCondition::where('lang_code' , $language->lang_code)->delete();
        TestimonialTrasnlation::where('lang_code' , $language->lang_code)->delete();
        CityTranslation::where('lang_code' , $language->lang_code)->delete();
        CategoryTranslation::where('lang_code' , $language->lang_code)->delete();
        ListingTranslation::where('lang_code' , $language->lang_code)->delete();
        JobPostTranslation::where('lang_code' , $language->lang_code)->delete();
        AboutUsTranslation::where('lang_code' , $language->lang_code)->delete();
        ContactUsTranslation::where('lang_code' , $language->lang_code)->delete();
        FooterTranslation::where('lang_code' , $language->lang_code)->delete();
        HomepageTranslation::where('lang_code' , $language->lang_code)->delete();
        CustomPageTranslation::where('lang_code' , $language->lang_code)->delete();
        ProjectTranslation::where('lang_code' , $language->lang_code)->delete();
        SliderTranslation::where('lang_code' , $language->lang_code)->delete();
        TeamTranslation::where('lang_code' , $language->lang_code)->delete();
        ProductTranslation::where('lang_code' , $language->lang_code)->delete();

        $path = base_path().'/lang'.'/'.$language->lang_code;

        if (File::exists($path)) {
            File::deleteDirectory($path);
        }

        $notify_message = trans('translate.Deleted successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('admin.language.index')->with($notify_message);
    }

    public function theme_language(Request $request){

        if(!File::exists('lang/'.$request->lang_code.'/translate.php')){
            $notify_message = trans('translate.Requested language does not exist');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->route('admin.language.index')->with($notify_message);
        }

        $data = include('lang/'.$request->lang_code.'/translate.php');

        return view('language::theme_language', [
            'data' => $data
        ]);
    }


    public function update_theme_language (Request $request)
    {

        if(!File::exists('lang/'.$request->lang_code.'/translate.php')){
            $notify_message = trans('translate.Requested language does not exist');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->route('admin.language.index')->with($notify_message);
        }

        $dataArray = [];
        foreach($request->values as $index => $value){
            $dataArray[$index] = $value;
        }

        file_put_contents('lang/'.$request->lang_code.'/translate.php', "");
        $dataArray = var_export($dataArray, true);
        file_put_contents('lang/'.$request->lang_code.'/translate.php', "<?php\n return {$dataArray};\n ?>");

        $notify_message = trans('translate.Updated successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');

        return redirect()->back()->with($notify_message);
    }

}
