<?php

namespace Modules\Scraper\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Scraper\App\Models\ScraperStagingJob;
use Modules\Jobs\Entities\JobPost;
use Modules\Jobs\Entities\JobDetail;
use Modules\Jobs\Entities\Organization;
use Modules\Jobs\Entities\JobCategory;
use Illuminate\Support\Str;

class StagingJobController extends Controller
{
    public function index()
    {
        $stagingJobs = ScraperStagingJob::with('source')->latest()->paginate(10);
        return view('scraper::admin.staging.index', compact('stagingJobs'));
    }

    public function show($id)
    {
        $job = ScraperStagingJob::with('source')->findOrFail($id);
        return view('scraper::admin.staging.show', compact('job'));
    }

    public function edit($id)
    {
        $job = ScraperStagingJob::findOrFail($id);
        $organizations = Organization::active()->get();
        $categories = JobCategory::active()->get();
        return view('scraper::admin.staging.edit', compact('job', 'organizations', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $job = ScraperStagingJob::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'organization_name' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'job_type' => 'required|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'description' => 'required|string',
        ]);

        $job->update($request->only([
            'title', 'organization_name', 'category_name', 'location', 
            'job_type', 'salary_min', 'salary_max', 'experience_level', 
            'description', 'requirements', 'responsibilities', 'expires_at'
        ]));

        $notification = [
            'message' => trans('translate.Updated successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.scraper.staging.show', $job->id)->with($notification);
    }

    public function approve(Request $request, $id)
    {
        $stagingJob = ScraperStagingJob::findOrFail($id);

        if ($stagingJob->status === 'approved') {
            return redirect()->back()->with([
                'message' => trans('translate.This job has already been approved.'),
                'alert-type' => 'error'
            ]);
        }

        // 1. Get or create Organization
        $orgName = $request->organization_name ?? $stagingJob->organization_name ?? 'Government Organization';
        $org = Organization::where('name', $orgName)->first();
        if (!$org) {
            $org = Organization::create([
                'name' => $orgName,
                'slug' => Str::slug($orgName) . '-' . time(),
                'status' => 'active',
                'description' => $orgName . ' recruited via scraper.',
            ]);
        }

        // 2. Get or create Category
        $catName = $request->category_name ?? $stagingJob->category_name ?? 'Government';
        $category = JobCategory::where('name', $catName)->first();
        if (!$category) {
            $category = JobCategory::create([
                'name' => $catName,
                'slug' => Str::slug($catName) . '-' . time(),
                'status' => 'active',
            ]);
        }

        // 3. Create JobPost in Main Jobs module
        $title = $request->title ?? $stagingJob->title;
        $jobPost = JobPost::create([
            'organization_id' => $org->id,
            'job_category_id' => $category->id,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . time(),
            'location' => $request->location ?? $stagingJob->location,
            'job_type' => $request->job_type ?? $stagingJob->job_type ?? 'full-time',
            'salary_min' => $request->salary_min ?? $stagingJob->salary_min,
            'salary_max' => $request->salary_max ?? $stagingJob->salary_max,
            'salary_type' => 'monthly',
            'experience_level' => $request->experience_level ?? $stagingJob->experience_level ?? 'Fresh Graduate',
            'status' => 'active',
            'expires_at' => $request->expires_at ?? $stagingJob->expires_at ?? now()->addDays(30),
        ]);

        // 4. Create JobDetail in Main Jobs module
        JobDetail::create([
            'job_post_id' => $jobPost->id,
            'description' => $request->description ?? $stagingJob->description,
            'requirements' => $request->requirements ?? $stagingJob->requirements,
            'responsibilities' => $request->responsibilities ?? $stagingJob->responsibilities,
        ]);

        // 5. Update Staging Job status
        $stagingJob->update([
            'status' => 'approved',
            'approved_job_post_id' => $jobPost->id
        ]);

        $notification = [
            'message' => trans('translate.Job approved and published successfully.'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.scraper.staging.index')->with($notification);
    }

    public function reject($id)
    {
        $job = ScraperStagingJob::findOrFail($id);
        $job->update(['status' => 'rejected']);

        $notification = [
            'message' => trans('translate.Job rejected successfully.'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.scraper.staging.index')->with($notification);
    }
}
