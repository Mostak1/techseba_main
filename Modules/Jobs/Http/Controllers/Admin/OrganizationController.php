<?php

namespace Modules\Jobs\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Jobs\Entities\Organization;
use Image, File, Str;

class OrganizationController extends Controller
{
    /**
     * Display a listing of organizations.
     */
    public function index()
    {
        $organizations = Organization::latest()->paginate(10);
        return view('jobs::admin.organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new organization.
     */
    public function create()
    {
        return view('jobs::admin.organizations.create');
    }

    /**
     * Store a newly created organization in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:organizations,slug|max:255',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]);

        $org = new Organization();
        $org->name = $request->name;
        $org->slug = Str::slug($request->slug);
        $org->website = $request->website;
        $org->description = $request->description;
        $org->status = $request->status ? 'active' : 'inactive';

        if ($request->hasFile('logo')) {
            $extension = $request->logo->getClientOriginalExtension();
            $logo_name = Str::slug($request->name) . '-' . time() . '.' . $extension;
            $logo_path = 'uploads/custom-images/' . $logo_name;
            Image::make($request->logo)->save(public_path('/' . $logo_path));
            $org->logo = $logo_path;
        }

        $org->save();

        $notification = [
            'message' => trans('translate.Created successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.organizations.index')->with($notification);
    }

    /**
     * Show the form for editing the specified organization.
     */
    public function edit($id)
    {
        $organization = Organization::findOrFail($id);
        return view('jobs::admin.organizations.edit', compact('organization'));
    }

    /**
     * Update the specified organization in storage.
     */
    public function update(Request $request, $id)
    {
        $org = Organization::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:organizations,slug,' . $org->id,
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]);

        $org->name = $request->name;
        $org->slug = Str::slug($request->slug);
        $org->website = $request->website;
        $org->description = $request->description;
        $org->status = $request->status ? 'active' : 'inactive';

        if ($request->hasFile('logo')) {
            $existing_logo = $org->logo;
            $extension = $request->logo->getClientOriginalExtension();
            $logo_name = Str::slug($request->name) . '-' . time() . '.' . $extension;
            $logo_path = 'uploads/custom-images/' . $logo_name;
            Image::make($request->logo)->save(public_path('/' . $logo_path));
            $org->logo = $logo_path;

            if ($existing_logo && File::exists(public_path('/' . $existing_logo))) {
                unlink(public_path('/' . $existing_logo));
            }
        }

        $org->save();

        $notification = [
            'message' => trans('translate.Updated successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.organizations.index')->with($notification);
    }

    /**
     * Remove the specified organization from storage.
     */
    public function destroy($id)
    {
        $org = Organization::findOrFail($id);
        $existing_logo = $org->logo;

        // Check for dependent job posts
        if ($org->jobPosts()->count() > 0) {
            $notification = [
                'message' => trans('translate.Cannot delete organization with active job posts'),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $org->delete();

        if ($existing_logo && File::exists(public_path('/' . $existing_logo))) {
            unlink(public_path('/' . $existing_logo));
        }

        $notification = [
            'message' => trans('translate.Deleted successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.organizations.index')->with($notification);
    }
}
