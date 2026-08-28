@extends('admin.master_layout')
@section('title')
    <title>{{ $title }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ $title }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ $title }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">

                            <div class="crancy-table crancy-table--v3 mg-top-30">

                                <div class="crancy-customer-filter">
                                    <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch d-flex items-center justify-between create_new_btn_box" style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
                                        <div class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ $title }}</h4>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.work-orders.create') }}" class="crancy-btn" style="background-color: #4f46e5; color: white; padding: 10px 20px; border-radius: 6px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px;">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 5V19M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Create Work Order
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div id="crancy-table__main_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                    <table class="crancy-table__main crancy-table__main-v3 dataTable no-footer" id="dataTable">
                                        <thead class="crancy-table__head">
                                        <tr>
                                            <th class="crancy-table__column-2 crancy-table__h2 sorting">Order Number</th>
                                            <th class="crancy-table__column-2 crancy-table__h2 sorting">Client Name</th>
                                            <th class="crancy-table__column-2 crancy-table__h2 sorting">Title</th>
                                            <th class="crancy-table__column-2 crancy-table__h2 sorting">Total Budget</th>
                                            <th class="crancy-table__column-2 crancy-table__h2 sorting">Due Amount</th>
                                            <th class="crancy-table__column-2 crancy-table__h2 sorting">Status</th>
                                            <th class="crancy-table__column-3 crancy-table__h3 sorting">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                        @forelse ($workOrders as $index => $workOrder)
                                            <tr class="odd">
                                                <td class="crancy-table__column-2 crancy-table__data-2">
                                                    <a href="{{ route('admin.work-orders.show', $workOrder->id) }}">
                                                        <h4 class="crancy-table__product-title" style="color: #4f46e5; font-weight: 600;">{{ $workOrder->order_number }}</h4>
                                                    </a>
                                                </td>

                                                <td class="crancy-table__column-2 crancy-table__data-2">
                                                    <h4 class="crancy-table__product-title">
                                                        {{ $workOrder->user->name }}
                                                        <br>
                                                        <small style="color: #64748b;">{{ $workOrder->user->email }}</small>
                                                    </h4>
                                                </td>

                                                <td class="crancy-table__column-2 crancy-table__data-2">
                                                    <h4 class="crancy-table__product-title">{{ Str::limit($workOrder->title, 40) }}</h4>
                                                </td>

                                                <td class="crancy-table__column-2 crancy-table__data-2">
                                                    <h4 class="crancy-table__product-title">{{ currency($workOrder->total_budget, 2) }}</h4>
                                                </td>

                                                <td class="crancy-table__column-2 crancy-table__data-2">
                                                    <h4 class="crancy-table__product-title" style="color: {{ $workOrder->due_amount > 0 ? '#ef4444' : '#10b981' }}; font-weight: 600;">
                                                        {{ currency($workOrder->due_amount, 2) }}
                                                    </h4>
                                                </td>

                                                <td class="crancy-table__column-2 crancy-table__data-2">
                                                    @if ($workOrder->status == 'completed')
                                                        <span class="badge bg-success" style="background-color: #10b981; color: white; padding: 4px 8px; border-radius: 4px;">Completed</span>
                                                    @elseif ($workOrder->status == 'ongoing')
                                                        <span class="badge bg-primary" style="background-color: #3b82f6; color: white; padding: 4px 8px; border-radius: 4px;">Ongoing</span>
                                                    @elseif ($workOrder->status == 'cancelled')
                                                        <span class="badge bg-danger" style="background-color: #ef4444; color: white; padding: 4px 8px; border-radius: 4px;">Cancelled</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark" style="background-color: #f59e0b; color: white; padding: 4px 8px; border-radius: 4px;">Pending</span>
                                                    @endif
                                                </td>

                                                <td class="crancy-table__column-3 crancy-table__data-3">
                                                    <div style="display: flex; gap: 8px;">
                                                        <a href="{{ route('admin.work-orders.show', $workOrder->id) }}" class="btn btn-sm btn-info" style="background-color: #0ea5e9; color: white; padding: 6px 12px; border-radius: 4px; font-size: 13px; text-decoration: none;">View</a>
                                                        <a href="{{ route('admin.work-orders.edit', $workOrder->id) }}" class="btn btn-sm btn-primary" style="background-color: #4f46e5; color: white; padding: 6px 12px; border-radius: 4px; font-size: 13px; text-decoration: none;">Edit</a>
                                                        <form action="{{ route('admin.work-orders.destroy', $workOrder->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this work order?')" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" style="background-color: #ef4444; color: white; padding: 6px 12px; border-radius: 4px; font-size: 13px; border: none; cursor: pointer;">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center" style="padding: 20px;">No Work Orders found.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
