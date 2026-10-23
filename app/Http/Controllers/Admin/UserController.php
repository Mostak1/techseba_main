<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\AccountDeleteRequest;
use App\Models\ProfileDomain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Ecommerce\Entities\Order;
use File;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function user_list(){

        $users = User::where('status', 'enable')->latest()->get();

        $title = trans('translate.Users List');

        return view('admin.user.user_list', ['users' => $users, 'title' => $title]);
    }

    public function pending_user(){

        $users = User::where('status', 'disable')->latest()->get();

        $title = trans('translate.Pending Users');

        return view('admin.user.user_list', ['users' => $users, 'title' => $title]);
    }

    public function user_show($id){

        $user = User::findOrFail($id);

        $total_order = Order::where('user_id', $user->id)->count();

        $success_order = Order::where('order_status', 'complete')->where('user_id', $user->id)->count();


        $orders = Order::with('order_detail')->where('user_id', $user->id)->latest()->get();

        return view('admin.user.user_show', [
            'user' => $user,
            'total_order' => $total_order,
            'success_order' => $success_order,
            'orders' => $orders,
        ]);

    }

    public function update(Request $request ,$id){

        $user = User::findOrFail($id);

        $rules = [
            'name'=>'required',
            'phone'=>'required',
            'address'=>'required|max:220',
        ];

        $customMessages = [
            'name.required' => trans('translate.Name is required'),
            'phone.required' => trans('translate.Phone is required'),
            'address.required' => trans('translate.Address is required')
        ];

        $this->validate($request, $rules,$customMessages);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->status = $request->status ? 'enable' : 'disable';
        $user->save();

        $notify_message= trans('translate.User updated successful');
        $notify_message=array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->back()->with($notify_message);
    }

    public function user_destroy($id){


        $user = User::find($id);
        $user_image = $user->image;

        if($user_image){
            if(File::exists(public_path().'/'.$user_image))unlink(public_path().'/'.$user_image);
        }

        $user->delete();

        $notify_message = trans('translate.Delete Successfully');
        $notify_message = array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->route('admin.user-list')->with($notify_message);
    }

    public function user_status($id){
        $user = User::findOrFail($id);
        if($user->status == 'enable'){
            $user->status = 'disable';
            $user->save();
            $message = trans('translate.Status Changed Successfully');
        }else{
            $user->status = 'enable';
            $user->save();
            $message = trans('translate.Status Changed Successfully');
        }
        return response()->json($message);
    }


    public function user_feez($id){
        $user = User::findOrFail($id);

        if($user->feez_status == 1){
            $user->feez_status = 0;
            $user->save();
            $notify_message = trans('translate.Unfreeze This Profile Successfully');
        }else{
            $user->feez_status = 1;
            $user->save();

            $notify_message = trans('translate.Freeze This Profile Successfully');
        }
        $notify_message = array('message'=>$notify_message,'alert-type'=>'success');
        return redirect()->back()->with($notify_message);
    }

    public function account_delete_requests()
    {
        $requests = AccountDeleteRequest::with(['user' => function ($q) {
            $q->withTrashed();
        }])->latest()->get();

        $title = trans('translate.Account Deletion Requests');

        return view('admin.user.account_delete_requests', [
            'requests' => $requests,
            'title' => $title,
        ]);
    }

    public function confirm_delete_request($id)
    {
        $deleteRequest = AccountDeleteRequest::findOrFail($id);
        $user = User::find($deleteRequest->user_id);

        if ($user) {
            $user->delete(); // Soft delete
        }

        $deleteRequest->status = 'confirmed';
        $deleteRequest->action_type = 'soft_delete';
        $deleteRequest->save();

        $notify_message = ['message' => 'User account soft deleted successfully.', 'alert-type' => 'success'];
        return redirect()->back()->with($notify_message);
    }

    public function hard_delete_user($id)
    {
        $deleteRequest = AccountDeleteRequest::findOrFail($id);
        $user = User::withTrashed()->find($deleteRequest->user_id);

        if ($user) {
            if ($user->image && File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }
            DB::table('product_reviews')->where('user_id', $user->id)->delete();
            DB::table('orders')->where('user_id', $user->id)->delete();
            DB::table('wishlists')->where('user_id', $user->id)->delete();
            DB::table('carts')->where('user_id', $user->id)->delete();

            $user->forceDelete();
        }

        $deleteRequest->status = 'confirmed';
        $deleteRequest->action_type = 'hard_delete';
        $deleteRequest->save();

        $notify_message = ['message' => 'User account permanently (hard) deleted successfully.', 'alert-type' => 'success'];
        return redirect()->back()->with($notify_message);
    }

    public function reject_delete_request($id)
    {
        $deleteRequest = AccountDeleteRequest::findOrFail($id);
        $deleteRequest->status = 'rejected';
        $deleteRequest->action_type = 'rejected';
        $deleteRequest->save();

        $notify_message = ['message' => 'Account deletion request rejected successfully.', 'alert-type' => 'success'];
        return redirect()->back()->with($notify_message);
    }

    public function deleted_users()
    {
        $users = User::onlyTrashed()->latest()->get();
        $title = trans('translate.Soft Deleted Users');

        return view('admin.user.deleted_users', [
            'users' => $users,
            'title' => $title,
        ]);
    }

    public function restore_user($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        $notify_message = ['message' => 'User restored successfully.', 'alert-type' => 'success'];
        return redirect()->back()->with($notify_message);
    }

    public function force_delete_user($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if ($user->image && File::exists(public_path($user->image))) {
            File::delete(public_path($user->image));
        }
        DB::table('product_reviews')->where('user_id', $user->id)->delete();
        DB::table('orders')->where('user_id', $user->id)->delete();
        DB::table('wishlists')->where('user_id', $user->id)->delete();
        DB::table('carts')->where('user_id', $user->id)->delete();

        $user->forceDelete();

        $notify_message = ['message' => 'User permanently deleted.', 'alert-type' => 'success'];
        return redirect()->back()->with($notify_message);
    }

    public function user_domains()
    {
        $domains = ProfileDomain::with('user')->latest()->get();
        $title = trans('translate.User Domains & Subdomains');

        return view('admin.user.user_domains', [
            'domains' => $domains,
            'title' => $title,
        ]);
    }

    public function toggle_domain_status($id)
    {
        $domain = ProfileDomain::findOrFail($id);
        $domain->is_active = !$domain->is_active;
        if ($domain->is_active && !$domain->verified_at) {
            $domain->verified_at = now();
        }
        $domain->save();

        $status = $domain->is_active ? 'activated' : 'deactivated';
        $notify_message = ['message' => "Domain '{$domain->host}' has been {$status}.", 'alert-type' => 'success'];
        return redirect()->back()->with($notify_message);
    }

    public function delete_domain($id)
    {
        $domain = ProfileDomain::findOrFail($id);
        $host = $domain->host;
        $domain->delete();

        $notify_message = ['message' => "Domain '{$host}' removed successfully.", 'alert-type' => 'success'];
        return redirect()->back()->with($notify_message);
    }
}
