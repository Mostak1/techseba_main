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
                                                <label class="crancy__item-label">Client / Customer</label>
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

                                        <div class="col-md-6">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Total Budget</label>
                                                <input type="number" step="0.01" name="total_budget" class="crancy__item-input" value="{{ old('total_budget', $workOrder->total_budget) }}" placeholder="e.g., 5000.00" required>
                                                @error('total_budget')
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
@endsection
