<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordChangeRequest;
use Modules\Ecommerce\Entities\Order;
use App\Models\AccountDeleteRequest;
use App\Models\Admin;
use App\Helper\EmailHelper;
use App\Mail\AccountDeletionRequestedMail;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Image;
use Str;

class ProfileController extends Controller
{
    public function dashboard(){

        $user = Auth::guard('web')->user();

        $orders = Order::where('user_id', $user->id)->latest()->take(5)->get();

        $pending_orders = Order::where('user_id', $user->id)->where(['order_status' => 0])->latest()->count();

        $complete_orders = Order::where('user_id', $user->id)->where(function ($query) {
            $query->where('order_status', 1);
        })->latest()->count();

        $total = Order::where('user_id', $user->id)
            ->latest()
            ->sum('total');

        $work_orders_count = \App\Models\WorkOrder::where('user_id', $user->id)->count();

        return view('user.dashboard', [
            'pending_orders' => $pending_orders,
            'complete_orders' => $complete_orders,
            'total' => $total,
            'orders' => $orders,
            'work_orders_count' => $work_orders_count,
        ]);

    }

    public function edit_profile(){

        $user = Auth::guard('web')->user();
        $pendingDeleteRequest = AccountDeleteRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        return view('user.edit_profile', [
            'user' => $user,
            'pendingDeleteRequest' => $pendingDeleteRequest,
        ]);
    }

    public function update_profile(Request $request){

        $user = Auth::guard('web')->user();
        $user->name = $request->name;
        if ($request->filled('username')) {
            $user->username = Str::slug($request->username);
        }
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        if($request->file('image')){
            $old_image = $user->image;
            $user_image = $request->image;
            $extention = $user_image->getClientOriginalExtension();
            $image_name = Str::slug($user->name).date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name = 'uploads/custom-images/'.$image_name;
            Image::make($user_image)->save(public_path().'/'.$image_name);
            $user->image = $image_name;
            $user->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $notify_message = trans('translate.Updated successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->back()->with($notify_message);

    }

    public function change_password(){
        return view('user.change_password');
    }

    public function update_password(PasswordChangeRequest $request){

        $user = Auth::guard('web')->user();

        if(Hash::check($request->current_password, $user->password)){
            $user->password = Hash::make($request->password);
            $user->save();

            $notify_message = trans('translate.Password changed successfully');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
            return redirect()->back()->with($notify_message);

        }else{
            $notify_message = trans('translate.Current password does not match');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }


    }

    public function orders(){
        $user = Auth::guard('web')->user();

        $orders = Order::with('order_detail')->where('user_id', $user->id)->latest()->paginate(10);

        return view('user.orders', ['orders' => $orders,]);
    }

    public function transactions(){
        $user = Auth::guard('web')->user();

        $orders = Order::with('order_detail')->where('user_id', $user->id)->latest()->paginate(10);

        return view('user.transactions', ['orders' => $orders,]);
    }

    public function order_show($order_id){

        $user = Auth::guard('web')->user();
        $order = Order::with('order_detail')->where('user_id', $user->id)->where('order_id', $order_id)->first();


        return view('user.order_show', [
            'order' => $order,
        ]);
    }

    public function account_delete(){
        return redirect()->route('user.edit-profile');
    }

    public function request_account_delete(Request $request)
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->back()->with([
                'message' => trans('translate.User not found'),
                'alert-type' => 'error'
            ]);
        }

        $request->validate([
            'password' => 'required',
        ], [
            'password.required' => trans('translate.Password is required'),
        ]);

        if (!Hash::check($request->password, $user->password)) {
            Log::warning('Account deletion request failed: Password mismatch for user ' . $user->id);
            return redirect()->back()->with([
                'message' => trans('translate.Password does not match. Please try again.'),
                'alert-type' => 'error'
            ]);
        }

        $existingRequest = AccountDeleteRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return redirect()->back()->with([
                'message' => 'You already have a pending account deletion request.',
                'alert-type' => 'info'
            ]);
        }

        $deleteRequest = AccountDeleteRequest::create([
            'user_id' => $user->id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Send email notification to Admin
        try {
            EmailHelper::mail_setup();

            $adminEmail = GlobalSetting::where('key', 'contact_message_mail')->value('value');
            if (!$adminEmail) {
                $adminEmail = Admin::where('status', 'enable')->first()?->email;
            }

            if ($adminEmail) {
                $subject = 'New Account Deletion Request - ' . $user->name;
                Mail::to($adminEmail)->send(new AccountDeletionRequestedMail($user, $deleteRequest, $subject));
                Log::info('Account deletion notification sent to admin: ' . $adminEmail);
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send account deletion email notification: ' . $e->getMessage());
        }

        return redirect()->back()->with([
            'message' => 'Account deletion request submitted successfully. It will be reviewed by admin.',
            'alert-type' => 'success'
        ]);
    }

    public function cancel_account_delete_request(Request $request)
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->back()->with([
                'message' => trans('translate.User not found'),
                'alert-type' => 'error'
            ]);
        }

        $deleteRequest = AccountDeleteRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($deleteRequest) {
            $deleteRequest->status = 'cancelled';
            $deleteRequest->action_type = 'cancelled';
            $deleteRequest->save();

            return redirect()->back()->with([
                'message' => 'Account deletion request has been cancelled.',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'No pending account deletion request found.',
            'alert-type' => 'error'
        ]);
    }

    public function confirm_account_delete(Request $request)
    {
        // Direct account deletion is disabled for users; redirect through request flow
        return $this->request_account_delete($request);
    }
}
