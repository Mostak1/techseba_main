<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CvTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CvTemplateController extends Controller
{
    public function index()
    {
        $templates = CvTemplate::withCount('cvs')->latest()->paginate(20);

        return view('admin.cv-templates.index', compact('templates'));
    }

    public function create()
    {
        $template = new CvTemplate([
            'view_path' => 'frontend.cv.templates.',
            'is_active' => true,
        ]);

        return view('admin.cv-templates.form', compact('template'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        if (! view()->exists($validated['view_path'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['message' => 'Template Blade view path does not exist.', 'alert-type' => 'error']);
        }

        if ($request->hasFile('preview_image')) {
            $validated['preview_image'] = $this->uploadPreview($request, $validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        CvTemplate::create($validated);

        return redirect()
            ->route('admin.cv-templates.index')
            ->with(['message' => 'CV template created successfully', 'alert-type' => 'success']);
    }

    public function edit(CvTemplate $cvTemplate)
    {
        $template = $cvTemplate;

        return view('admin.cv-templates.form', compact('template'));
    }

    public function update(Request $request, CvTemplate $cvTemplate)
    {
        $validated = $this->validated($request, $cvTemplate);

        if (! view()->exists($validated['view_path'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['message' => 'Template Blade view path does not exist.', 'alert-type' => 'error']);
        }

        if ($request->hasFile('preview_image')) {
            $this->deletePreview($cvTemplate->preview_image);
            $validated['preview_image'] = $this->uploadPreview($request, $validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $cvTemplate->update($validated);

        return redirect()
            ->route('admin.cv-templates.index')
            ->with(['message' => 'CV template updated successfully', 'alert-type' => 'success']);
    }

    public function destroy(CvTemplate $cvTemplate)
    {
        if ($cvTemplate->cvs()->exists()) {
            return redirect()
                ->back()
                ->with(['message' => 'This template is already used by one or more CVs.', 'alert-type' => 'error']);
        }

        $this->deletePreview($cvTemplate->preview_image);
        $cvTemplate->delete();

        return redirect()
            ->back()
            ->with(['message' => 'CV template deleted successfully', 'alert-type' => 'success']);
    }

    private function validated(Request $request, ?CvTemplate $template = null): array
    {
        $request->merge([
            'slug' => Str::slug($request->input('slug') ?: $request->input('name')),
        ]);

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('cv_templates', 'slug')->ignore($template?->id),
            ],
            'view_path' => ['required', 'string', 'max:255'],
            'preview_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function uploadPreview(Request $request, string $name): string
    {
        $directory = 'uploads/cv/templates';
        File::ensureDirectoryExists(public_path($directory));

        $file = $request->file('preview_image');
        $filename = Str::slug($name).'-'.time().'-'.Str::random(8).'.'.$file->getClientOriginalExtension();
        $file->move(public_path($directory), $filename);

        return $directory.'/'.$filename;
    }

    private function deletePreview(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
