@extends('admin.master_layout')

@section('title')
    <title>CV Template Permissions & Paid Access</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">CV Template Permissions</h3>
    <p class="crancy-header__text">Digital CV >> Template Access Control</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <!-- Grant Permission Form Card -->
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-table crancy-table--v3 mg-top-30" style="padding: 24px; background: #fff; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="crancy-product-card__title m-0">
                                        <i class="fas fa-key text-primary"></i> Grant Paid Template Access to User
                                    </h4>
                                    <a href="{{ route('admin.cv-templates.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> Back to Templates
                                    </a>
                                </div>

                                <form action="{{ route('admin.cv-templates.permissions.grant') }}" method="POST">
                                    @csrf
                                    <div class="row align-items-end">
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label font-weight-bold">Select User *</label>
                                            <select name="user_id" class="form-control select2" required style="width: 100%;">
                                                <option value="">-- Choose User --</option>
                                                @foreach($users as $u)
                                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label font-weight-bold">Select CV Template *</label>
                                            <select name="cv_template_id" class="form-control" required>
                                                <option value="">-- Choose Template --</option>
                                                @foreach($templates as $tpl)
                                                    <option value="{{ $tpl->id }}">
                                                        {{ $tpl->name }} {{ $tpl->is_premium ? '(Paid)' : '(Free)' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label font-weight-bold">Notes / Reason (Optional)</label>
                                            <input type="text" name="notes" class="form-control" placeholder="e.g. Paid via bKash / Promotion">
                                        </div>

                                        <div class="col-md-2 mb-2">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-check"></i> Grant Access
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions List & Pending Requests Table -->
                <div class="col-12 mt-4">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-table crancy-table--v3 mg-top-30">
                                <div class="crancy-customer-filter d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                    <h4 class="crancy-product-card__title m-0">User Access Permissions & Requests</h4>

                                    <div class="btn-group">
                                        <a href="{{ route('admin.cv-templates.permissions') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                                            All Permissions
                                        </a>
                                        <a href="{{ route('admin.cv-templates.permissions', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') === 'pending' ? 'btn-warning text-dark' : 'btn-outline-warning' }}">
                                            Pending Requests ({{ $pendingCount ?? 0 }})
                                        </a>
                                        <a href="{{ route('admin.cv-templates.permissions', ['status' => 'active']) }}" class="btn btn-sm {{ request('status') === 'active' ? 'btn-success' : 'btn-outline-success' }}">
                                            Active
                                        </a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Email</th>
                                                <th>Template</th>
                                                <th>Status</th>
                                                <th>Notes</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($permissions as $perm)
                                                <tr>
                                                    <td><strong>{{ $perm->user?->name ?: 'N/A' }}</strong></td>
                                                    <td>{{ $perm->user?->email ?: 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge badge-info" style="font-size: 13px;">
                                                            {{ $perm->template?->name ?: 'Template #' . $perm->cv_template_id }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($perm->status === 'active')
                                                            <span class="btn btn-sm btn-success">Active</span>
                                                        @elseif($perm->status === 'pending')
                                                            <span class="btn btn-sm btn-warning text-dark">Pending Request</span>
                                                        @else
                                                            <span class="btn btn-sm btn-danger">Rejected</span>
                                                        @endif
                                                    </td>
                                                    <td><small class="text-muted">{{ $perm->notes ?: '—' }}</small></td>
                                                    <td>{{ $perm->created_at->format('d M Y, h:i A') }}</td>
                                                    <td>
                                                        @if($perm->status === 'pending')
                                                            <form action="{{ route('admin.cv-templates.permissions.approve', $perm->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success btn-sm" title="Approve Request">
                                                                    <i class="fas fa-check"></i> Approve
                                                                </button>
                                                            </form>

                                                            <form action="{{ route('admin.cv-templates.permissions.reject', $perm->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-secondary btn-sm" title="Reject Request">
                                                                    <i class="fas fa-times"></i> Reject
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <form action="{{ route('admin.cv-templates.permissions.revoke', $perm->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Revoke template access for this user?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Revoke Permission">
                                                                <i class="fas fa-trash"></i> Revoke
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center py-4 text-muted">
                                                        No user template permissions found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mg-top-25">
                                    {{ $permissions->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
