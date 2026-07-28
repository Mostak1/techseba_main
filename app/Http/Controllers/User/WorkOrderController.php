<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\WorkOrderBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index()
    {
        $user = Auth::guard('web')->user();
        $workOrders = WorkOrder::where('user_id', $user->id)->latest()->get();

        return view('user.work_orders.index', compact('workOrders'));
    }

    public function show($id)
    {
        $user = Auth::guard('web')->user();
        $workOrder = WorkOrder::where('user_id', $user->id)->with(['payments', 'bills' => function($q) {
            $q->latest();
        }])->findOrFail($id);

        return view('user.work_orders.show', compact('workOrder'));
    }

    public function print($id)
    {
        $user = Auth::guard('web')->user();
        $workOrder = WorkOrder::where('user_id', $user->id)->with('payments')->findOrFail($id);

        return view('admin.work_orders.print', compact('workOrder'));
    }

    public function printBill($bill_id)
    {
        $user = Auth::guard('web')->user();
        $bill = WorkOrderBill::with('workOrder.user')->whereHas('workOrder', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->findOrFail($bill_id);

        return view('admin.work_orders.print_bill', compact('bill'));
    }
}
