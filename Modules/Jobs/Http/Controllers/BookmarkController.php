<?php

namespace Modules\Jobs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Jobs\Entities\JobBookmark;
use Modules\Jobs\Entities\JobPost;

class BookmarkController extends Controller
{
    /**
     * Display a listing of bookmarked job posts for the authenticated user.
     */
    public function index()
    {
        try {
            $user = Auth::guard('web')->user();
            
            $bookmarks = JobBookmark::where('user_id', $user->id)
                ->with(['jobPost.organization', 'jobPost.category'])
                ->latest()
                ->get();

            return view('jobs::bookmarks.index', compact('bookmarks'));
        } catch (\Exception $e) {
            return back()->with('error', trans('translate.An error occurred while loading bookmarked jobs.'));
        }
    }

    /**
     * Store a newly created bookmark in storage (Toggle bookmark).
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_post_id' => 'required|exists:job_posts,id',
        ]);

        try {
            $user = Auth::guard('web')->user();

            $existing = JobBookmark::where('user_id', $user->id)
                ->where('job_post_id', $request->job_post_id)
                ->first();

            if ($existing) {
                $existing->delete();
                return response()->json([
                    'status' => 'removed',
                    'message' => trans('translate.Job bookmark removed successfully.')
                ]);
            } else {
                JobBookmark::create([
                    'user_id' => $user->id,
                    'job_post_id' => $request->job_post_id,
                ]);

                return response()->json([
                    'status' => 'saved',
                    'message' => trans('translate.Job bookmarked successfully.')
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => trans('translate.An error occurred.')
            ], 500);
        }
    }

    /**
     * Remove the specified bookmark from storage.
     */
    public function destroy($id)
    {
        try {
            $user = Auth::guard('web')->user();
            
            $bookmark = JobBookmark::where('user_id', $user->id)
                ->where('id', $id)
                ->firstOrFail();

            $bookmark->delete();

            return back()->with('success', trans('translate.Job bookmark removed successfully.'));
        } catch (\Exception $e) {
            return back()->with('error', trans('translate.An error occurred.'));
        }
    }
}
