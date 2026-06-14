<?php

namespace Modules\Jobs\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Jobs\Entities\JobCategory;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = JobCategory::latest()->paginate(10);
        return view('jobs::admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('jobs::admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:job_categories,slug|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $category = new JobCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        $category->icon = $request->icon;
        $category->status = $request->status ? 'active' : 'inactive';
        $category->save();

        $notification = [
            'message' => trans('translate.Created successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.categories.index')->with($notification);
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit($id)
    {
        $category = JobCategory::findOrFail($id);
        return view('jobs::admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, $id)
    {
        $category = JobCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:job_categories,slug,' . $category->id,
            'icon' => 'nullable|string|max:255',
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        $category->icon = $request->icon;
        $category->status = $request->status ? 'active' : 'inactive';
        $category->save();

        $notification = [
            'message' => trans('translate.Updated successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.categories.index')->with($notification);
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy($id)
    {
        $category = JobCategory::findOrFail($id);

        if ($category->jobPosts()->count() > 0) {
            $notification = [
                'message' => trans('translate.Cannot delete category with active job posts'),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $category->delete();

        $notification = [
            'message' => trans('translate.Deleted successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.categories.index')->with($notification);
    }
}
