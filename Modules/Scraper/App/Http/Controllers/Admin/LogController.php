<?php

namespace Modules\Scraper\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Scraper\App\Models\ScraperLog;

class LogController extends Controller
{
    public function index()
    {
        $logs = ScraperLog::with('source')->latest()->paginate(15);
        return view('scraper::admin.logs.index', compact('logs'));
    }
}
