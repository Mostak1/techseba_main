<?php

namespace Modules\Jobs\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Jobs\Entities\JobPost;
use Modules\Jobs\Entities\JobDetail;
use Modules\Jobs\Entities\JobCategory;
use Modules\Jobs\Entities\Organization;
use Illuminate\Support\Str;

class JobController extends Controller
{
    /**
     * Display a listing of jobs.
     */
    public function index()
    {
        $jobs = JobPost::with(['organization', 'category'])->latest()->paginate(10);
        return view('jobs::admin.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new job.
     */
    public function create()
    {
        $categories = JobCategory::active()->get();
        $organizations = Organization::active()->get();
        return view('jobs::admin.jobs.create', compact('categories', 'organizations'));
    }

    /**
     * Store a newly created job in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:job_posts,slug|max:255',
            'organization_id' => 'required|exists:organizations,id',
            'job_category_id' => 'required|exists:job_categories,id',
            'job_type' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_type' => 'required|string',
            'experience_level' => 'nullable|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
            'expires_at' => 'nullable|date',
        ]);

        $job = new JobPost();
        $job->title = $request->title;
        $job->slug = Str::slug($request->slug);
        $job->organization_id = $request->organization_id;
        $job->job_category_id = $request->job_category_id;
        $job->job_type = $request->job_type;
        $job->location = $request->location;
        $job->salary_min = $request->salary_min;
        $job->salary_max = $request->salary_max;
        $job->salary_type = $request->salary_type;
        $job->experience_level = $request->experience_level;
        $job->status = $request->status ? 'active' : 'draft';
        $job->featured = $request->featured ? true : false;
        $job->expires_at = $request->expires_at;
        $job->save();

        $detail = new JobDetail();
        $detail->job_post_id = $job->id;
        $detail->description = $request->description;
        $detail->requirements = $request->requirements;
        $detail->responsibilities = $request->responsibilities;
        $detail->benefits = $request->benefits;
        $detail->save();

        $notification = [
            'message' => trans('translate.Created successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.jobs.index')->with($notification);
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit($id)
    {
        $job = JobPost::with('detail')->findOrFail($id);
        $categories = JobCategory::active()->get();
        $organizations = Organization::active()->get();
        return view('jobs::admin.jobs.edit', compact('job', 'categories', 'organizations'));
    }

    /**
     * Update the specified job in storage.
     */
    public function update(Request $request, $id)
    {
        $job = JobPost::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:job_posts,slug,' . $job->id,
            'organization_id' => 'required|exists:organizations,id',
            'job_category_id' => 'required|exists:job_categories,id',
            'job_type' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_type' => 'required|string',
            'experience_level' => 'nullable|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
            'expires_at' => 'nullable|date',
        ]);

        $job->title = $request->title;
        $job->slug = Str::slug($request->slug);
        $job->organization_id = $request->organization_id;
        $job->job_category_id = $request->job_category_id;
        $job->job_type = $request->job_type;
        $job->location = $request->location;
        $job->salary_min = $request->salary_min;
        $job->salary_max = $request->salary_max;
        $job->salary_type = $request->salary_type;
        $job->experience_level = $request->experience_level;
        $job->status = $request->status ? 'active' : 'draft';
        $job->featured = $request->featured ? true : false;
        $job->expires_at = $request->expires_at;
        $job->save();

        JobDetail::updateOrCreate(
            ['job_post_id' => $job->id],
            [
                'description' => $request->description,
                'requirements' => $request->requirements,
                'responsibilities' => $request->responsibilities,
                'benefits' => $request->benefits,
            ]
        );

        $notification = [
            'message' => trans('translate.Updated successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.jobs.index')->with($notification);
    }

    /**
     * Remove the specified job from storage.
     */
    public function destroy($id)
    {
        $job = JobPost::findOrFail($id);
        $job->delete();

        $notification = [
            'message' => trans('translate.Deleted successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.jobs.index')->with($notification);
    }
}
