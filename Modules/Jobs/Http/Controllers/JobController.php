<?php

namespace Modules\Jobs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Jobs\Entities\JobPost;
use Modules\Jobs\Entities\JobCategory;
use Modules\Jobs\Entities\Organization;
use Illuminate\Support\Str;

class JobController extends Controller
{
    /**
     * Display a listing of job posts with filtering and pagination.
     */
    public function index(Request $request)
    {
        try {
            // Eager load relationships to prevent N+1 queries
            $query = JobPost::with(['organization', 'category'])->active()->notExpired();

            // Apply filters
            if ($request->filled('keyword')) {
                $keyword = trim($request->keyword);
                $words = array_filter(explode(' ', $keyword));
                $formattedTerm = '';
                foreach ($words as $word) {
                    if (strlen($word) >= 3) {
                        $formattedTerm .= '+' . $word . '* ';
                    } else {
                        $formattedTerm .= '+' . $word . ' ';
                    }
                }
                $formattedTerm = trim($formattedTerm);

                if (!empty($formattedTerm)) {
                    $query->where(function($q) use ($formattedTerm, $keyword) {
                        $q->whereRaw("MATCH(title, location) AGAINST(? IN BOOLEAN MODE)", [$formattedTerm])
                          ->orWhereHas('detail', function($subQ) use ($formattedTerm) {
                              $subQ->whereRaw("MATCH(description, requirements, responsibilities) AGAINST(? IN BOOLEAN MODE)", [$formattedTerm]);
                          })
                          ->orWhere('title', 'like', '%' . $keyword . '%')
                          ->orWhere('location', 'like', '%' . $keyword . '%');
                    });
                }
            }

            if ($request->filled('category_id')) {
                $query->where('job_category_id', $request->category_id);
            }

            if ($request->filled('organization_id')) {
                $query->where('organization_id', $request->organization_id);
            }

            if ($request->filled('job_type')) {
                $query->where('job_type', $request->job_type);
            }

            if ($request->filled('location')) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            if ($request->filled('deadline')) {
                $deadline = $request->deadline;
                if ($deadline === 'today') {
                    $query->whereDate('expires_at', now()->toDateString());
                } elseif ($deadline === '1-week') {
                    $query->whereBetween('expires_at', [now(), now()->addDays(7)]);
                } elseif ($deadline === '30-days') {
                    $query->whereBetween('expires_at', [now(), now()->addDays(30)]);
                }
            }

            // Paginated listing
            $jobs = $query->latest()->paginate(10)->withQueryString();

            // Side filters data
            $categories = JobCategory::withCount(['jobPosts' => function ($q) {
                $q->active()->notExpired();
            }])->active()->get();

            $organizations = Organization::active()->get();

            // SEO Metadata
            $meta_title = trans('translate.Jobs Portal');
            $meta_description = trans('translate.Find and apply to the latest job openings, remote jobs, internships, full-time and part-time positions.');
            $canonicalUrl = route('jobs.index');

            return view('jobs::index', compact('jobs', 'categories', 'organizations', 'meta_title', 'meta_description', 'canonicalUrl'));
        } catch (\Exception $e) {
            return back()->with('error', trans('translate.An error occurred while loading jobs.'));
        }
    }

    /**
     * Display the specified job post details with eager loaded relations.
     */
    public function show($slug)
    {
        try {
            // Eager load description, attachments, and meta information
            $job = JobPost::where('slug', $slug)
                ->with(['organization', 'category', 'detail', 'attachments'])
                ->active()
                ->notExpired()
                ->firstOrFail();

            // Eager loaded related jobs to avoid N+1 queries
            $relatedJobs = JobPost::with(['organization', 'category'])
                ->where('job_category_id', $job->job_category_id)
                ->where('id', '!=', $job->id)
                ->active()
                ->notExpired()
                ->limit(4)
                ->get();

            // SEO Metadata
            $meta_title = $job->title . ' | ' . $job->organization->name;
            $meta_description = Str::limit(strip_tags($job->detail->description), 160);
            $canonicalUrl = route('jobs.show', $job->slug);
            $seoImage = $job->organization->logo ? $job->organization->logo : null;

            return view('jobs::show', compact('job', 'relatedJobs', 'meta_title', 'meta_description', 'canonicalUrl', 'seoImage'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }
}
