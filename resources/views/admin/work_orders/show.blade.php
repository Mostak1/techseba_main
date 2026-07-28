@extends('admin.master_layout')

@section('title')
    <title>{{ $title }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ $title }}</h3>
    <p class="crancy-header__text">Work Orders >> Detail >> {{ $workOrder->order_number }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <!-- Details Card -->
                <div class="col-lg-8 col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-product-card mg-top-30" style="padding: 25px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #edf2f7; padding-bottom: 15px; margin-bottom: 20px;">
                                    <h4 class="crancy-product-card__title" style="margin: 0;">Work Order Details</h4>
                                    <span>
                                        Status: 
                                        @if($workOrder->status == 'completed')
                                            <span class="badge bg-success" style="background-color: #10b981; color: white; padding: 4px 8px; border-radius: 4px;">Completed</span>
                                        @elseif($workOrder->status == 'ongoing')
                                            <span class="badge bg-primary" style="background-color: #3b82f6; color: white; padding: 4px 8px; border-radius: 4px;">Ongoing</span>
                                        @elseif($workOrder->status == 'cancelled')
                                            <span class="badge bg-danger" style="background-color: #ef4444; color: white; padding: 4px 8px; border-radius: 4px;">Cancelled</span>
                                        @else
                                            <span class="badge bg-warning text-dark" style="background-color: #f59e0b; color: white; padding: 4px 8px; border-radius: 4px;">Pending</span>
                                        @endif
                                    </span>
                                </div>

                                <div class="row">
                                    <div class="col-md-6" style="margin-bottom: 15px;">
                                        <p style="margin: 0; color: #64748b; font-size: 13px;">Order Number</p>
                                        <strong style="font-size: 16px; color: #1e293b;">{{ $workOrder->order_number }}</strong>
                                    </div>
                                    <div class="col-md-6" style="margin-bottom: 15px;">
                                        <p style="margin: 0; color: #64748b; font-size: 13px;">Client Name</p>
                                        <strong style="font-size: 16px; color: #1e293b;">{{ $workOrder->user->name }}</strong>
                                        <br>
                                        <small style="color: #64748b;">{{ $workOrder->user->email }}</small>
                                    </div>
                                    <div class="col-12" style="margin-bottom: 15px;">
                                        <p style="margin: 0; color: #64748b; font-size: 13px;">Title</p>
                                        <p style="margin: 0; font-size: 15px; color: #1e293b; font-weight: 500;">{{ $workOrder->title }}</p>
                                    </div>
                                    @if($workOrder->description)
                                        <div class="col-12" style="margin-bottom: 25px;">
                                            <p style="margin: 0; color: #64748b; font-size: 13px; margin-bottom: 5px;">Description / Scope of Work</p>
                                            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; font-size: 14px; color: #475569; line-height: 1.6;">
                                                {!! nl2br(e($workOrder->description)) !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Payments Summary -->
                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px; margin-top: 20px;">
                                    <div style="text-align: center; border-right: 1px solid #e2e8f0;">
                                        <p style="margin: 0 0 5px 0; color: #64748b; font-size: 13px;">Total Budget</p>
                                        <strong style="font-size: 18px; color: #1e293b;">{{ currency($workOrder->total_budget, 2) }}</strong>
                                    </div>
                                    <div style="text-align: center; border-right: 1px solid #e2e8f0;">
                                        <p style="margin: 0 0 5px 0; color: #64748b; font-size: 13px;">Total Paid</p>
                                        <strong style="font-size: 18px; color: #16a34a;">{{ currency($workOrder->paid_amount, 2) }}</strong>
                                    </div>
                                    <div style="text-align: center;">
                                        <p style="margin: 0 0 5px 0; color: #64748b; font-size: 13px;">Remaining Due</p>
                                        <strong style="font-size: 18px; color: #ef4444;">{{ currency($workOrder->due_amount, 2) }}</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Payments list -->
                            <div class="crancy-product-card mg-top-30" style="padding: 25px;">
                                <h4 class="crancy-product-card__title" style="margin-bottom: 20px; border-bottom: 1px solid #edf2f7; padding-bottom: 10px;">Payment Records</h4>
                                <div class="table-responsive">
                                    <table class="table" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                        <tr style="border-bottom: 2px solid #edf2f7; text-align: left;">
                                            <th style="padding: 10px;">Date</th>
                                            <th style="padding: 10px;">Method</th>
                                            <th style="padding: 10px;">Transaction ID</th>
                                            <th style="padding: 10px;">Amount</th>
                                            <th style="padding: 10px;">Status</th>
                                            <th style="padding: 10px;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($workOrder->payments as $payment)
                                            <tr style="border-bottom: 1px solid #edf2f7;">
                                                <td style="padding: 10px;">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                                <td style="padding: 10px;">{{ $payment->payment_method }}</td>
                                                <td style="padding: 10px;">{{ $payment->transaction_id ?? 'N/A' }}</td>
                                                <td style="padding: 10px; font-weight: 600;">{{ currency($payment->amount, 2) }}</td>
                                                <td style="padding: 10px;">
                                                    @if($payment->status == 'confirmed')
                                                        <span class="badge bg-success" style="background-color: #10b981; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Confirmed</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark" style="background-color: #f59e0b; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Pending Approval</span>
                                                    @endif
                                                </td>
                                                <td style="padding: 10px;">
                                                    <div style="display: flex; gap: 8px;">
                                                        @if($payment->status != 'confirmed')
                                                            <form action="{{ route('admin.work-order-payments.confirm', $payment->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success" style="background-color: #10b981; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 12px;">Confirm & Email</button>
                                                            </form>
                                                        @endif
                                                        <form action="{{ route('admin.work-order-payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment record?')" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" style="background-color: #ef4444; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 12px;">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center" style="padding: 20px; color: #64748b;">No payments recorded yet.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Record Payment Form -->
                <div class="col-lg-4 col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-product-card mg-top-30" style="padding: 25px;">
                                <h4 class="crancy-product-card__title" style="margin-bottom: 20px; border-bottom: 1px solid #edf2f7; padding-bottom: 10px;">Record Payment</h4>

                                <form action="{{ route('admin.work-orders.payments.store', $workOrder->id) }}" method="POST">
                                    @csrf

                                    <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                                        <label class="crancy__item-label">Amount</label>
                                        <input type="number" step="0.01" name="amount" class="crancy__item-input" placeholder="e.g. 1500.00" value="{{ old('amount', $workOrder->due_amount) }}" required>
                                        @error('amount')
                                            <span class="text-danger"><small>{{ $message }}</small></span>
                                        @enderror
                                    </div>

                                    <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                                        <label class="crancy__item-label">Payment Method</label>
                                        <select name="payment_method" class="crancy__item-input" required>
                                            <option value="Bkash">Bkash</option>
                                            <option value="Nagad">Nagad</option>
                                            <option value="Rocket">Rocket</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Stripe">Stripe</option>
                                            <option value="PayPal">PayPal</option>
                                        </select>
                                        @error('payment_method')
                                            <span class="text-danger"><small>{{ $message }}</small></span>
                                        @enderror
                                    </div>

                                    <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                                        <label class="crancy__item-label">Transaction ID</label>
                                        <input type="text" name="transaction_id" class="crancy__item-input" placeholder="e.g. TR57X9H8" value="{{ old('transaction_id') }}">
                                        @error('transaction_id')
                                            <span class="text-danger"><small>{{ $message }}</small></span>
                                        @enderror
                                    </div>

                                    <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                                        <label class="crancy__item-label">Payment Date</label>
                                        <input type="date" name="payment_date" class="crancy__item-input" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                                        @error('payment_date')
                                            <span class="text-danger"><small>{{ $message }}</small></span>
                                        @enderror
                                    </div>

                                    <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                                        <label class="crancy__item-label">Payment Status</label>
                                        <select name="status" class="crancy__item-input" required>
                                            <option value="confirmed">Confirmed (Dispatches Email)</option>
                                            <option value="pending">Pending Approval</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger"><small>{{ $message }}</small></span>
                                        @enderror
                                    </div>

                                    <div class="crancy__item-form--group" style="margin-bottom: 20px;">
                                        <label class="crancy__item-label">Notes</label>
                                        <textarea name="notes" class="crancy__item-input" rows="3" style="height: auto; padding: 8px;" placeholder="Optional payment description or comments...">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <span class="text-danger"><small>{{ $message }}</small></span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="crancy-btn" style="background-color: #4f46e5; color: white; width: 100%; padding: 12px; border-radius: 6px; font-weight: 500; border: none; cursor: pointer;">
                                        Record Payment
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 25px;">
                <a href="{{ route('admin.work-orders.index') }}" class="btn btn-secondary" style="padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px;">Back to Work Orders</a>
            </div>
        </div>
    </section>
@endsection
