<?php

namespace Modules\Jobs\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Jobs\Entities\JobAttachment;
use Modules\Jobs\Entities\JobPost;
use File, Str;

class AttachmentController extends Controller
{
    /**
     * Display a listing of attachments.
     */
    public function index()
    {
        $attachments = JobAttachment::with('jobPost')->latest()->paginate(10);
        return view('jobs::admin.attachments.index', compact('attachments'));
    }

    /**
     * Show the form for creating a new attachment.
     */
    public function create()
    {
        $jobs = JobPost::active()->get();
        return view('jobs::admin.attachments.create', compact('jobs'));
    }

    /**
     * Store a newly created attachment in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_post_id' => 'required|exists:job_posts,id',
            'file' => 'required|file|max:5120', // Max 5MB
        ]);

        $attachment = new JobAttachment();
        $attachment->job_post_id = $request->job_post_id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $safeName = Str::slug($fileName) . '-' . time() . '.' . $extension;
            $uploadPath = 'uploads/attachments/';

            if (!File::isDirectory(public_path('/' . $uploadPath))) {
                File::makeDirectory(public_path('/' . $uploadPath), 0777, true, true);
            }

            $file->move(public_path('/' . $uploadPath), $safeName);

            $attachment->file_name = $originalName;
            $attachment->file_path = $uploadPath . $safeName;
            $attachment->file_size = $file->getSize() ?? 0;
            $attachment->file_type = $file->getClientMimeType();
        }

        $attachment->save();

        $notification = [
            'message' => trans('translate.Created successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.attachments.index')->with($notification);
    }

    /**
     * Remove the specified attachment from storage.
     */
    public function destroy($id)
    {
        $attachment = JobAttachment::findOrFail($id);
        $filePath = $attachment->file_path;

        $attachment->delete();

        if ($filePath && File::exists(public_path('/' . $filePath))) {
            unlink(public_path('/' . $filePath));
        }

        $notification = [
            'message' => trans('translate.Deleted successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.attachments.index')->with($notification);
    }
}
