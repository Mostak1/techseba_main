<?php

namespace App\Http\Controllers;

use App\Models\Page;

class DynamicPageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::enabled()
            ->where('slug', $slug)
            ->with(['sections' => fn ($query) => $query->oldest('id')])
            ->firstOrFail();

        $enabledSections = $page->sections
            ->where('status', 'enable')
            ->keyBy('section_identifier');

        return view('dynamic_pages.show', compact('page', 'enabledSections'));
    }
}
