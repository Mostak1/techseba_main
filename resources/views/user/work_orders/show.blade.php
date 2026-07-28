@extends('user.dashboard_layout')
@section('title')
    <title>Work Order Detail - {{ $workOrder->order_number }}</title>
@endsection
@section('breadcrumb')
    <h1 class="post__title">Work Order Detail</h1>
    <nav class="breadcrumbs">
        <ul>
            <li><a href="{{ route('user.dashboard') }}">{{ __('translate.Home') }}</a></li>
            <li><a href="{{ route('user.work_orders.index') }}">Work Orders</a></li>
            <li> Detail </li>
        </ul>
    </nav>
@endsection
@section('dashboard-content')
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #edf2f7; padding-bottom: 15px; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 20px; font-weight: 600; color: #1e293b;">
                Work Order: {{ $workOrder->order_number }}
            </h3>
            <span style="font-size: 14px; font-weight: 500;">
                Status: 
                @if($workOrder->status == 'completed')
                    <span style="background-color: #10b981; color: white; padding: 4px 8px; border-radius: 4px;">Completed</span>
                @elseif($workOrder->status == 'ongoing')
                    <span style="background-color: #3b82f6; color: white; padding: 4px 8px; border-radius: 4px;">Ongoing</span>
                @elseif($workOrder->status == 'cancelled')
                    <span style="background-color: #ef4444; color: white; padding: 4px 8px; border-radius: 4px;">Cancelled</span>
                @else
                    <span style="background-color: #f59e0b; color: white; padding: 4px 8px; border-radius: 4px;">Pending</span>
                @endif
            </span>
        </div>

        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-8">
                <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 10px; color: #475569;">Title</h4>
                <p style="font-size: 15px; color: #1e293b; line-height: 1.5; margin-bottom: 20px;">{{ $workOrder->title }}</p>

                @if($workOrder->description)
                    <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 10px; color: #475569;">Description</h4>
                    <div style="font-size: 14px; color: #475569; line-height: 1.6; background-color: #f8fafc; padding: 15px; border-radius: 6px; border: 1px solid #e2e8f0;">
                        {!! nl2br(e($workOrder->description)) !!}
                    </div>
                @endif
            </div>
            
            <div class="col-md-4">
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                    <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 15px; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">Budget & Payments</h4>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                        <span style="color: #64748b;">Total Budget:</span>
                        <strong style="color: #1e293b;">{{ currency($workOrder->total_budget, 2) }}</strong>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                        <span style="color: #64748b;">Discount:</span>
                        <strong style="color: #7628d8;">{{ currency($workOrder->discount, 2) }}</strong>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                        <span style="color: #64748b;">Total Paid:</span>
                        <strong style="color: #16a34a;">{{ currency($workOrder->paid_amount, 2) }}</strong>
                    </div>

                    <div style="display: flex; justify-content: space-between; font-size: 15px; padding-top: 10px; border-top: 1px dashed #cbd5e1;">
                        <span style="color: #1e293b; font-weight: 600;">Remaining Due:</span>
                        <strong style="color: #dc2626; font-weight: bold;">{{ currency($workOrder->due_amount, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin-top: 40px; margin-bottom: 15px; border-bottom: 1px solid #edf2f7; padding-bottom: 8px;">
            Payment History
        </h3>

        <div class="dashbord_table_main" style="margin-top: 10px;">
            <table class="table">
                <thead>
                <tr>
                    <th>Payment Date</th>
                    <th>Payment Method</th>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
                </thead>
                <tbody>
                @forelse($workOrder->payments as $payment)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                        <td>{{ currency($payment->amount, 2) }}</td>
                        <td>
                            @if($payment->status == 'confirmed')
                                <span class="badge" style="background-color: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Confirmed</span>
                            @else
                                <span class="badge" style="background-color: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Pending Approval</span>
                            @endif
                        </td>
                        <td><small style="color: #64748b;">{{ $payment->notes ?? 'N/A' }}</small></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 20px;">No payments recorded yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <a href="{{ route('user.work_orders.index') }}" class="btn btn-secondary" style="background-color: #64748b; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px;">Back to Work Orders</a>
            <a href="{{ route('user.work_orders.print', $workOrder->id) }}" target="_blank" class="btn btn-primary" style="background: linear-gradient(135deg, #4f46e5, #6366f1); color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 17H19C20.1 17 21 16.1 21 15V11C21 9.9 20.1 9 19 9H5C3.9 9 3 9.9 3 11V15C3 16.1 3.9 17 5 17H7M17 9V5C17 3.9 16.1 3 15 3H9C7.9 3 7 3.9 7 5V9M7 13H17V21H7V13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Print / Save PDF
            </a>
        </div>
    </div>
@endsection
