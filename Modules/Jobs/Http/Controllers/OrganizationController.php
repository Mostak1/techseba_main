<?php

namespace Modules\Jobs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Jobs\Entities\Organization;
use Modules\Jobs\Entities\JobPost;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    /**
     * Display jobs of a specific organization with eager loading and pagination.
     */
    public function show(Request $request, $slug)
    {
        try {
            $organization = Organization::where('slug', $slug)->active()->firstOrFail();

            // Eager load category and organization to avoid N+1 queries
            $jobs = JobPost::with(['organization', 'category'])
                ->where('organization_id', $organization->id)
                ->active()
                ->notExpired()
                ->latest()
                ->paginate(10)
                ->withQueryString();

            // SEO Metadata
            $meta_title = $organization->name . ' - ' . trans('translate.Jobs');
            $meta_description = Str::limit(strip_tags($organization->description), 160);
            $canonicalUrl = route('jobs.organization', $organization->slug);
            $seoImage = $organization->logo ? $organization->logo : null;

            return view('jobs::organization', compact('organization', 'jobs', 'meta_title', 'meta_description', 'canonicalUrl', 'seoImage'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }
}
