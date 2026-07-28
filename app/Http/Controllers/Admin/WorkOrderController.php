<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderPayment;
use App\Helper\EmailHelper;
use App\Mail\PaymentConfirmedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WorkOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $workOrders = WorkOrder::with('user')->latest()->get();
        $title = "Work Orders";

        return view('admin.work_orders.index', compact('workOrders', 'title'));
    }

    public function create()
    {
        $users = User::where('status', 'enable')->get();
        $title = "Create Work Order";
        $workOrder = new WorkOrder();

        return view('admin.work_orders.create', compact('users', 'title', 'workOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_budget' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|string|in:pending,ongoing,completed,cancelled',
        ]);

        $discount = $request->discount ?? 0;

        // Generate unique order number
        $orderNumber = 'WO-' . strtoupper(uniqid());

        $workOrder = WorkOrder::create([
            'user_id' => $request->user_id,
            'order_number' => $orderNumber,
            'title' => $request->title,
            'description' => $request->description,
            'total_budget' => $request->total_budget,
            'discount' => $discount,
            'due_amount' => $request->total_budget - $discount, // initially due is budget - discount
            'status' => $request->status,
        ]);

        $notify = ['message' => 'Work order created successfully', 'alert-type' => 'success'];
        return redirect()->route('admin.work-orders.index')->with($notify);
    }

    public function show($id)
    {
        $workOrder = WorkOrder::with(['user', 'payments'])->findOrFail($id);
        $title = "Work Order Details - " . $workOrder->order_number;

        return view('admin.work_orders.show', compact('workOrder', 'title'));
    }

    public function edit($id)
    {
        $workOrder = WorkOrder::findOrFail($id);
        $users = User::where('status', 'enable')->get();
        $title = "Edit Work Order";

        return view('admin.work_orders.create', compact('workOrder', 'users', 'title'));
    }

    public function update(Request $request, $id)
    {
        $workOrder = WorkOrder::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_budget' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|string|in:pending,ongoing,completed,cancelled',
        ]);

        $discount = $request->discount ?? 0;

        $workOrder->update([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'total_budget' => $request->total_budget,
            'discount' => $discount,
            'status' => $request->status,
        ]);

        // Recalculate due amount based on new budget
        $workOrder->updateDueAmount();

        $notify = ['message' => 'Work order updated successfully', 'alert-type' => 'success'];
        return redirect()->route('admin.work-orders.index')->with($notify);
    }

    public function destroy($id)
    {
        $workOrder = WorkOrder::findOrFail($id);
        $workOrder->delete();

        $notify = ['message' => 'Work order deleted successfully', 'alert-type' => 'success'];
        return redirect()->route('admin.work-orders.index')->with($notify);
    }

    // Add Payment to Work Order
    public function storePayment(Request $request, $work_order_id)
    {
        $workOrder = WorkOrder::findOrFail($work_order_id);

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'status' => 'required|string|in:pending,confirmed',
            'notes' => 'nullable|string',
        ]);

        $payment = WorkOrderPayment::create([
            'work_order_id' => $workOrder->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'payment_date' => $request->payment_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        $workOrder->updateDueAmount();

        // Send email if confirmed
        if ($payment->status === 'confirmed') {
            try {
                EmailHelper::mail_setup();
                $subject = "Payment Confirmed - " . $workOrder->order_number;
                Mail::to($workOrder->user->email)->send(new PaymentConfirmedMail($payment, $subject));
            } catch (\Exception $e) {
                // Log or handle email exception silently or let admin know
            }
        }

        $notify = ['message' => 'Payment recorded successfully', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }

    // Confirm a Pending Payment
    public function confirmPayment($id)
    {
        $payment = WorkOrderPayment::with('workOrder.user')->findOrFail($id);
        $payment->status = 'confirmed';
        $payment->save();

        $payment->workOrder->updateDueAmount();

        // Send confirmation email
        try {
            EmailHelper::mail_setup();
            $subject = "Payment Confirmed - " . $payment->workOrder->order_number;
            Mail::to($payment->workOrder->user->email)->send(new PaymentConfirmedMail($payment, $subject));
        } catch (\Exception $e) {
            // Log or handle email exception silently
        }

        $notify = ['message' => 'Payment confirmed successfully and email sent', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }

    // Delete a Payment
    public function destroyPayment($id)
    {
        $payment = WorkOrderPayment::findOrFail($id);
        $workOrder = $payment->workOrder;
        $payment->delete();

        $workOrder->updateDueAmount();

        $notify = ['message' => 'Payment record deleted successfully', 'alert-type' => 'success'];
        return redirect()->back()->with($notify);
    }

    public function quickCreateUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:4',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => \Illuminate\Support\Str::slug($request->name).'-'.date('Ymdhis'),
            'status' => 'enable',
            'is_banned' => 'no',
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    public function print($id)
    {
        $workOrder = WorkOrder::with(['user', 'payments'])->findOrFail($id);
        return view('admin.work_orders.print', compact('workOrder'));
    }
}
