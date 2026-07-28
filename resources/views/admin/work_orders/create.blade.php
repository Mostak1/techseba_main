@extends('admin.master_layout')

@section('title')
    <title>{{ $title }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ $title }}</h3>
    <p class="crancy-header__text">Work Orders >> {{ $title }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-product-card mg-top-30">
                                <h4 class="crancy-product-card__title">{{ $workOrder->exists ? 'Update Work Order' : 'Create Work Order' }}</h4>

                                <form action="{{ $workOrder->exists ? route('admin.work-orders.update', $workOrder->id) : route('admin.work-orders.store') }}" method="POST" class="mg-top-25">
                                    @csrf
                                    @if($workOrder->exists)
                                        @method('PUT')
                                    @endif

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="crancy__item-form--group">
                                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                                    <label class="crancy__item-label" style="margin: 0;">Client / Customer</label>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addClientModal" style="color: #4f46e5; font-size: 13px; font-weight: 600;">+ Add New Client</a>
                                                </div>
                                                <select name="user_id" class="crancy__item-input" required>
                                                    <option value="">Select Customer</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" @selected(old('user_id', $workOrder->user_id) == $user->id)>
                                                            {{ $user->name }} ({{ $user->email }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Total Budget</label>
                                                <input type="number" step="0.01" name="total_budget" class="crancy__item-input" value="{{ old('total_budget', $workOrder->total_budget) }}" placeholder="e.g., 5000.00" required>
                                                @error('total_budget')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Discount</label>
                                                <input type="number" step="0.01" name="discount" class="crancy__item-input" value="{{ old('discount', $workOrder->discount) }}" placeholder="e.g., 500.00">
                                                @error('discount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Work Order Title</label>
                                                <input type="text" name="title" class="crancy__item-input" value="{{ old('title', $workOrder->title) }}" placeholder="e.g., Website Development Services" required>
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Status</label>
                                                <select name="status" class="crancy__item-input" required>
                                                    <option value="pending" @selected(old('status', $workOrder->status) == 'pending')>Pending</option>
                                                    <option value="ongoing" @selected(old('status', $workOrder->status) == 'ongoing')>Ongoing</option>
                                                    <option value="completed" @selected(old('status', $workOrder->status) == 'completed')>Completed</option>
                                                    <option value="cancelled" @selected(old('status', $workOrder->status) == 'cancelled')>Cancelled</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Description / Scope of Work</label>
                                                <textarea name="description" class="crancy__item-input" rows="6" style="height: auto; padding: 12px;" placeholder="Describe the details, milestones, payment terms, or requirements of the work order...">{{ old('description', $workOrder->description) }}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="crancy-btn mg-top-25" style="background-color: #4f46e5; color: white; padding: 10px 20px; border-radius: 6px; font-weight: 500; border: none; cursor: pointer;">
                                        {{ $workOrder->exists ? 'Update Work Order' : 'Create Work Order' }}
                                    </button>
                                    <a href="{{ route('admin.work-orders.index') }}" class="btn btn-secondary mg-top-25" style="padding: 10px 20px; border-radius: 6px; margin-left: 10px; text-decoration: none;">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Client Modal -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 8px;">
                <div class="modal-header" style="border-bottom: 1px solid #edf2f7; padding: 15px 20px;">
                    <h5 class="modal-title" id="addClientModalLabel" style="font-weight: 600; color: #1e293b;">Add New Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: transparent; font-size: 20px;">&times;</button>
                </div>
                <form id="quickClientForm">
                    @csrf
                    <div class="modal-body" style="padding: 20px;">
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Full Name</label>
                            <input type="text" id="modal_client_name" class="crancy__item-input" placeholder="e.g. John Doe" required>
                        </div>
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Email Address</label>
                            <input type="email" id="modal_client_email" class="crancy__item-input" placeholder="e.g. john@example.com" required>
                        </div>
                        <div class="crancy__item-form--group" style="margin-bottom: 15px;">
                            <label class="crancy__item-label">Password</label>
                            <input type="text" id="modal_client_password" class="crancy__item-input" value="techseba123" required>
                            <small style="color: #64748b;">Prefilled with default password. Client can change this later.</small>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #edf2f7; padding: 15px 20px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 8px 16px; border-radius: 6px;">Close</button>
                        <button type="submit" class="crancy-btn" style="background-color: #4f46e5; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">Add Client</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js_section')
<script>
    $(document).ready(function() {
        $('#quickClientForm').on('submit', function(e) {
            e.preventDefault();
            
            let name = $('#modal_client_name').val();
            let email = $('#modal_client_email').val();
            let password = $('#modal_client_password').val();
            let token = $('input[name="_token"]').val();
            
            $.ajax({
                url: "{{ route('admin.work-orders.quick-user') }}",
                type: "POST",
                data: {
                    _token: token,
                    name: name,
                    email: email,
                    password: password
                },
                success: function(response) {
                    if (response.success) {
                        // Append new option
                        let newOption = new Option(response.user.name + ' (' + response.user.email + ')', response.user.id, true, true);
                        $('select[name="user_id"]').append(newOption).trigger('change');
                        
                        // Reset form & close modal
                        $('#quickClientForm')[0].reset();
                        $('#modal_client_password').val('techseba123');
                        $('#addClientModal').modal('hide');
                        
                        toastr.success('New client added successfully!');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, val) {
                            toastr.error(val[0]);
                        });
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        });
    });
</script>
@endpush
