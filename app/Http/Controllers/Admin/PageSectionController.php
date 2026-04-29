<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageSectionController extends Controller
{
    public function index()
    {
        $this->syncManagedPages();

        $pages = Page::withCount([
            'sections',
            'sections as enabled_sections_count' => fn ($query) => $query->where('status', 'enable'),
        ])
            ->latest()
            ->paginate(20);

        return view('admin.page-sections.index', compact('pages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'slug' => Str::slug($request->input('slug') ?: $request->input('name')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:pages,slug'],
            'is_enabled' => ['nullable', 'boolean'],
            'sections' => ['nullable', 'string'],
        ]);

        $page = Page::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'is_enabled' => $request->boolean('is_enabled'),
        ]);

        foreach ($this->parseSections($request->input('sections')) as $section) {
            $page->sections()->create($section);
        }

        $notify = ['message' => 'Page created successfully', 'alert-type' => 'success'];

        return redirect()->route('admin.page-sections.edit', $page)->with($notify);
    }

    public function togglePage(Page $page): RedirectResponse
    {
        $page->update(['is_enabled' => ! $page->is_enabled]);

        $notify = ['message' => 'Page status updated successfully', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
    }

    public function edit(Page $page)
    {
        $page->load(['sections' => fn ($query) => $query->oldest('id')]);

        return view('admin.page-sections.edit', compact('page'));
    }

    public function updatePage(Request $request, Page $page): RedirectResponse
    {
        $request->merge([
            'slug' => $page->is_managed
                ? $page->slug
                : Str::slug($request->input('slug') ?: $request->input('name')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('pages', 'slug')->ignore($page->id),
            ],
            'is_enabled' => ['nullable', 'boolean'],
        ]);

        $page->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'is_enabled' => $request->boolean('is_enabled'),
        ]);

        $notify = ['message' => 'Page updated successfully', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
    }

    public function updateSections(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'sections' => ['nullable', 'array'],
            'sections.*.section_name' => ['required_with:sections', 'string', 'max:255'],
            'sections.*.section_identifier' => ['required_with:sections', 'string', 'max:255', 'alpha_dash'],
            'sections.*.status' => ['required_with:sections', Rule::in(['enable', 'disable'])],
            'new_section_name' => ['nullable', 'string', 'max:255'],
            'new_section_identifier' => ['nullable', 'string', 'max:255', 'alpha_dash'],
            'new_section_status' => ['nullable', Rule::in(['enable', 'disable'])],
        ]);

        foreach ($validated['sections'] ?? [] as $sectionId => $sectionData) {
            $sectionData['section_identifier'] = Str::slug($sectionData['section_identifier'], '_');

            Section::where('page_id', $page->id)
                ->where('id', $sectionId)
                ->update($sectionData);
        }

        if ($request->filled('new_section_name')) {
            $identifier = $request->input('new_section_identifier')
                ?: Str::slug($request->input('new_section_name'), '_');

            $page->sections()->updateOrCreate(
                ['section_identifier' => Str::slug($identifier, '_')],
                [
                    'section_name' => $request->input('new_section_name'),
                    'status' => $request->input('new_section_status', 'enable'),
                ]
            );
        }

        $notify = ['message' => 'Sections updated successfully', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
    }

    public function destroySection(Section $section): RedirectResponse
    {
        $section->delete();

        $notify = ['message' => 'Section deleted successfully', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
    }

    private function parseSections(?string $rawSections): array
    {
        $lines = preg_split('/\r\n|\r|\n/', trim((string) $rawSections));

        return collect($lines)
            ->filter()
            ->map(function (string $line): array {
                [$name, $identifier] = array_pad(array_map('trim', explode('|', $line, 2)), 2, null);

                return [
                    'section_name' => $name,
                    'section_identifier' => Str::slug($identifier ?: $name, '_'),
                    'status' => 'enable',
                ];
            })
            ->values()
            ->all();
    }

    private function syncManagedPages(): void
    {
        foreach (Page::MANAGED_ROUTES as $slug => $pageData) {
            Page::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $pageData['name'],
                    'is_enabled' => true,
                ]
            );
        }
    }
}
