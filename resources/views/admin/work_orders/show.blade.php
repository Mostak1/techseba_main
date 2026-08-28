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
                                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px; margin-top: 20px;">
                                    <div style="text-align: center; border-right: 1px solid #e2e8f0;">
                                        <p style="margin: 0 0 5px 0; color: #64748b; font-size: 13px;">Total Budget</p>
                                        <strong style="font-size: 18px; color: #1e293b;">{{ currency($workOrder->total_budget, 2) }}</strong>
                                    </div>
                                    <div style="text-align: center; border-right: 1px solid #e2e8f0;">
                                        <p style="margin: 0 0 5px 0; color: #64748b; font-size: 13px;">Discount</p>
                                        <strong style="font-size: 18px; color: #7628d8;">{{ currency($workOrder->discount, 2) }}</strong>
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

                            <!-- Billing & Invoices list -->
                            <div class="crancy-product-card mg-top-30" style="padding: 25px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #edf2f7; padding-bottom: 10px;">
                                    <h4 class="crancy-product-card__title" style="margin: 0;">Recurring & Extra Bills</h4>
                                    <button type="button" class="crancy-btn" data-bs-toggle="modal" data-bs-target="#addBillModal" style="background-color: #4f46e5; color: white; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; border: none; cursor: pointer;">
                                        + Generate Bill
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                        <tr style="border-bottom: 2px solid #edf2f7; text-align: left;">
                                            <th style="padding: 10px;">Bill Number</th>
                                            <th style="padding: 10px;">Title / Type</th>
                                            <th style="padding: 10px;">Amount</th>
                                            <th style="padding: 10px;">Due Date</th>
                                            <th style="padding: 10px;">Status</th>
                                            <th style="padding: 10px;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($workOrder->bills as $bill)
                                            <tr style="border-bottom: 1px solid #edf2f7;">
                                                <td style="padding: 10px;">
                                                    <a href="{{ route('admin.work-orders.bills.print', $bill->id) }}" target="_blank" style="color: #4f46e5; font-weight: 600;">
                                                        {{ $bill->bill_number }}
                                                    </a>
                                                </td>
                                                <td style="padding: 10px;">
                                                    <strong>{{ $bill->title }}</strong><br>
                                                    <small class="text-muted" style="text-transform: capitalize;">{{ str_replace('_', ' ', $bill->bill_type) }}</small>
                                                </td>
                                                <td style="padding: 10px; font-weight: 600;">{{ currency($bill->amount, 2) }}</td>
                                                <td style="padding: 10px;">{{ $bill->due_date->format('M d, Y') }}</td>
                                                <td style="padding: 10px;">
                                                    @if($bill->status == 'paid')
                                                        <span class="badge bg-success" style="background-color: #10b981; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Paid</span>
                                                    @else
                                                        <span class="badge bg-danger" style="background-color: #ef4444; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Unpaid</span>
                                                    @endif
                                                </td>
                                                <td style="padding: 10px;">
                                                    <div style="display: flex; gap: 8px; align-items: center;">
                                                        @if($bill->status == 'unpaid')
                                                            <button type="button" class="btn btn-sm btn-success pay-bill-btn" data-id="{{ $bill->id }}" data-bs-toggle="modal" data-bs-target="#payBillModal" style="background-color: #10b981; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 12px;">Mark Paid</button>
                                                        @endif
                                                        <a href="{{ route('admin.work-orders.bills.print', $bill->id) }}" target="_blank" class="btn btn-sm btn-info" style="background-color: #0ea5e9; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 12px; text-decoration: none;">Print</a>
                                                        <form action="{{ route('admin.work-orders.bills.destroy', $bill->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this bill invoice?')" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" style="background-color: #ef4444; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 12px;">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center" style="padding: 20px; color: #64748b;">No bills generated yet.</td>
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
            <div style="margin-top: 25px; display: flex; gap: 10px;">
                <a href="{{ route('admin.work-orders.index') }}" class="btn btn-secondary" style="padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px;">Back to Work Orders</a>
                <a href="{{ route('admin.work-orders.print', $workOrder->id) }}" target="_blank" class="btn btn-primary" style="background-color: #4f46e5; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 17H19C20.1 17 21 16.1 21 15V11C21 9.9 20.1 9 19 9H5C3.9 9 3 9.9 3 11V15C3 16.1 3.9 17 5 17H7M17 9V5C17 3.9 16.1 3 15 3H9C7.9 3 7 3.9 7 5V9M7 13H17V21H7V13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Print / Save PDF
                </a>
            </div>
        </div>
    </section>

    <!-- Add Bill Modal -->
    <div class="modal fade" id="addBillModal" tabindex="-1" aria-labelledby="addBillModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 8px;">
                <div class="modal-header" style="border-bottom: 1px solid #edf2f7; padding: 15px 20px;">
                    <h5 class="modal-title" id="addBillModalLabel" style="font-weight: 600; color: #1e293b;">Generate New Bill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: transparent; font-size: 20px;">&times;</button>
                </div>
                <form action="{{ route('admin.work-orders.bills.store', $workOrder->id) }}" method="POST">
                    @csrf
                    <div class="modal-body" style="padding: 20px;">
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Bill Type</label>
                            <select name="bill_type" class="crancy__item-input" style="height: 45px; padding: 8px;" required>
                                <option value="monthly">Monthly Bill</option>
                                <option value="half_yearly">Half-Yearly Bill</option>
                                <option value="yearly">Yearly Bill</option>
                                <option value="setup">Setup Cost</option>
                                <option value="custom">Custom Invoice</option>
                            </select>
                        </div>
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Bill Title</label>
                            <input type="text" name="title" class="crancy__item-input" placeholder="e.g. Hosting & Support Renewal 2026" required>
                        </div>
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Amount (BDT)</label>
                            <input type="number" step="0.01" name="amount" class="crancy__item-input" placeholder="e.g. 5000.00" required>
                        </div>
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Due Date</label>
                            <input type="date" name="due_date" class="crancy__item-input" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Notes (Optional)</label>
                            <textarea name="notes" class="crancy__item-input" rows="2" style="height: auto; padding: 8px;" placeholder="Optional details for the invoice..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #edf2f7; padding: 15px 20px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 8px 16px; border-radius: 6px;">Close</button>
                        <button type="submit" class="crancy-btn" style="background-color: #4f46e5; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">Generate Bill</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Pay Bill Modal -->
    <div class="modal fade" id="payBillModal" tabindex="-1" aria-labelledby="payBillModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 8px;">
                <div class="modal-header" style="border-bottom: 1px solid #edf2f7; padding: 15px 20px;">
                    <h5 class="modal-title" id="payBillModalLabel" style="font-weight: 600; color: #1e293b;">Record Bill Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: transparent; font-size: 20px;">&times;</button>
                </div>
                <form id="payBillForm" method="POST">
                    @csrf
                    <div class="modal-body" style="padding: 20px;">
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Payment Method</label>
                            <select name="payment_method" class="crancy__item-input" style="height: 45px; padding: 8px;" required>
                                <option value="bKash">bKash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Rocket">Rocket</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </div>
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Transaction ID (Optional)</label>
                            <input type="text" name="transaction_id" class="crancy__item-input" placeholder="e.g. TRX12345678">
                        </div>
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Payment Date</label>
                            <input type="date" name="payment_date" class="crancy__item-input" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Notes (Optional)</label>
                            <textarea name="notes" class="crancy__item-input" rows="2" style="height: auto; padding: 8px;" placeholder="Optional payment remarks..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #edf2f7; padding: 15px 20px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 8px 16px; border-radius: 6px;">Close</button>
                        <button type="submit" class="crancy-btn" style="background-color: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">Record Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js_section')
<script>
    $(document).ready(function() {
        $('.pay-bill-btn').on('click', function() {
            let billId = $(this).data('id');
            let actionUrl = "/admin/work-orders/bills/" + billId + "/pay";
            $('#payBillForm').attr('action', actionUrl);
        });
    });
</script>
@endpush
