@extends('user.dashboard_layout')
@section('title')
    <title>Work Orders</title>
@endsection
@section('breadcrumb')
    <h1 class="post__title">Work Orders</h1>
    <nav class="breadcrumbs">
        <ul>
            <li><a href="{{ route('user.dashboard') }}">{{ __('translate.Home') }}</a></li>
            <li> Work Orders </li>
        </ul>
    </nav>
@endsection
@section('dashboard-content')
    <div class="dashbord_table_main">
        <table class="table">
            <thead>
            <tr>
                <th>Order Number</th>
                <th>Title</th>
                <th>Total Budget</th>
                <th>Due Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($workOrders as $workOrder)
                <tr>
                    <td>
                        <a href="{{ route('user.work_orders.show', $workOrder->id) }}">
                            <strong>{{ $workOrder->order_number }}</strong>
                        </a>
                    </td>
                    <td>{{ $workOrder->title }}</td>
                    <td>{{ currency($workOrder->total_budget, 2) }}</td>
                    <td>
                        @if($workOrder->due_amount > 0)
                            <span class="text-danger font-semibold">{{ currency($workOrder->due_amount, 2) }}</span>
                        @else
                            <span class="badge bg-success">Paid</span>
                        @endif
                    </td>
                    <td>
                        @if($workOrder->status == 'completed')
                            <span class="badge bg-success" style="background-color: #10b981; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Completed</span>
                        @elseif($workOrder->status == 'ongoing')
                            <span class="badge bg-primary" style="background-color: #3b82f6; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Ongoing</span>
                        @elseif($workOrder->status == 'cancelled')
                            <span class="badge bg-danger" style="background-color: #ef4444; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Cancelled</span>
                        @else
                            <span class="badge bg-warning text-dark" style="background-color: #f59e0b; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Pending</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('user.work_orders.show', $workOrder->id) }}" class="action_btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.1303 9.8531C22.2899 11.0732 22.2899 12.9268 21.1303 14.1469C19.1745 16.2047 15.8155 19 12 19C8.18448 19 4.82549 16.2047 2.86971 14.1469C1.7101 12.9268 1.7101 11.0732 2.86971 9.8531C4.82549 7.79533 8.18448 5 12 5C15.8155 5 19.1745 7.79533 21.1303 9.8531Z" stroke="white" stroke-width="1.5"/>
                                <circle cx="12" cy="12" r="3" stroke="white" stroke-width="1.5"/>
                            </svg>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 25px;">No Work Orders found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
