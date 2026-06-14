<?php

namespace Modules\Jobs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Jobs\Entities\JobCategory;
use Modules\Jobs\Entities\JobPost;

class CategoryController extends Controller
{
    /**
     * Display jobs of a specific category with eager loading and pagination.
     */
    public function show(Request $request, $slug)
    {
        try {
            $category = JobCategory::where('slug', $slug)->active()->firstOrFail();

            // Eager load category and organization to avoid N+1 queries
            $jobs = JobPost::with(['organization', 'category'])
                ->where('job_category_id', $category->id)
                ->active()
                ->notExpired()
                ->latest()
                ->paginate(10)
                ->withQueryString();

            // SEO Metadata
            $meta_title = $category->name . ' - ' . trans('translate.Jobs');
            $meta_description = trans('translate.Browse job openings under category') . ' ' . $category->name;
            $canonicalUrl = route('jobs.category', $category->slug);

            return view('jobs::category', compact('category', 'jobs', 'meta_title', 'meta_description', 'canonicalUrl'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }
}
