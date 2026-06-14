<?php

namespace Modules\Scraper\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Scraper\App\Models\ScraperSource;
use Illuminate\Support\Facades\Artisan;

class SourceController extends Controller
{
    public function index()
    {
        $sources = ScraperSource::latest()->paginate(10);
        return view('scraper::admin.sources.index', compact('sources'));
    }

    public function create()
    {
        return view('scraper::admin.sources.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'type' => 'required|string|in:css,api,rss',
            'selectors' => 'nullable|array',
        ]);

        ScraperSource::create([
            'name' => $request->name,
            'url' => $request->url,
            'type' => $request->type,
            'selectors' => $request->selectors,
            'status' => $request->status ? true : false,
        ]);

        $notification = [
            'message' => trans('translate.Created successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.scraper.sources.index')->with($notification);
    }

    public function edit($id)
    {
        $source = ScraperSource::findOrFail($id);
        return view('scraper::admin.sources.edit', compact('source'));
    }

    public function update(Request $request, $id)
    {
        $source = ScraperSource::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'type' => 'required|string|in:css,api,rss',
            'selectors' => 'nullable|array',
        ]);

        $source->update([
            'name' => $request->name,
            'url' => $request->url,
            'type' => $request->type,
            'selectors' => $request->selectors,
            'status' => $request->status ? true : false,
        ]);

        $notification = [
            'message' => trans('translate.Updated successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.scraper.sources.index')->with($notification);
    }

    public function destroy($id)
    {
        $source = ScraperSource::findOrFail($id);
        $source->delete();

        $notification = [
            'message' => trans('translate.Deleted successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.scraper.sources.index')->with($notification);
    }

    public function run($id)
    {
        try {
            Artisan::call('scraper:run', ['source_id' => $id]);
            
            $notification = [
                'message' => trans('translate.Scraper run completed successfully.'),
                'alert-type' => 'success'
            ];
        } catch (\Exception $e) {
            $notification = [
                'message' => trans('translate.Scraper run failed: ') . $e->getMessage(),
                'alert-type' => 'error'
            ];
        }

        return redirect()->back()->with($notification);
    }
}
