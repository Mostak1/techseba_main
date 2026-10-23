@extends('admin.master_layout')
@section('title')
    <title>{{ $title }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ $title }}</h3>
    <p class="crancy-header__text">{{ __('translate.Manage Users') }} >> {{ $title }}</p>
@endsection

@section('body-content')
    <!-- crancy Dashboard -->
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">

                            <div class="crancy-table crancy-table--v3 mg-top-30">

                                <div class="crancy-customer-filter">
                                    <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch d-flex items-center justify-between create_new_btn_box">
                                        <div class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ $title }}</h4>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.deleted-users') }}" class="crancy-btn"><i class="fas fa-user-slash"></i> {{ __('translate.View Soft Deleted Users') }}</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- crancy Table -->
                                <div id="crancy-table__main_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                                    <table class="crancy-table__main crancy-table__main-v3 dataTable no-footer" id="dataTable">
                                        <!-- crancy Table Head -->
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Serial') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.User') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Email & Phone') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Reason') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Requested At') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Status') }}
                                                </th>
                                                <th class="crancy-table__column-3 crancy-table__h3 sorting">
                                                    {{ __('translate.Action') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <!-- crancy Table Body -->
                                        <tbody class="crancy-table__body">
                                            @forelse ($requests as $index => $req)
                                                <tr class="odd">
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ ++$index }}</h4>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if($req->user)
                                                            <h4 class="crancy-table__product-title">
                                                                <a href="{{ route('admin.user-show', $req->user->id) }}">
                                                                    {{ html_decode($req->user->name) }}
                                                                </a>
                                                            </h4>
                                                            <span class="text-muted small">ID: #{{ $req->user->id }}</span>
                                                        @else
                                                            <span class="text-danger fw-semibold">User Deleted</span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <div>{{ $req->user ? html_decode($req->user->email) : 'N/A' }}</div>
                                                        <div class="text-muted small">{{ $req->user ? html_decode($req->user->phone) : 'N/A' }}</div>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <p class="m-0 text-wrap" style="max-width: 200px; font-size: 13px;">
                                                            {{ $req->reason ? html_decode($req->reason) : '-' }}
                                                        </p>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <span>{{ $req->created_at ? $req->created_at->format('d M, Y h:i A') : '-' }}</span>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if($req->status == 'pending')
                                                            <span class="badge bg-warning text-dark px-2 py-1"><i class="fas fa-clock"></i> Pending</span>
                                                        @elseif($req->status == 'confirmed')
                                                            @if($req->action_type == 'soft_delete')
                                                                <span class="badge bg-danger px-2 py-1"><i class="fas fa-user-slash"></i> Soft Deleted</span>
                                                            @elseif($req->action_type == 'hard_delete')
                                                                <span class="badge bg-dark px-2 py-1"><i class="fas fa-trash-alt"></i> Hard Deleted</span>
                                                            @else
                                                                <span class="badge bg-success px-2 py-1">Confirmed</span>
                                                            @endif
                                                        @elseif($req->status == 'cancelled')
                                                            <span class="badge bg-secondary px-2 py-1"><i class="fas fa-ban"></i> Cancelled by User</span>
                                                        @elseif($req->status == 'rejected')
                                                            <span class="badge bg-info text-dark px-2 py-1"><i class="fas fa-times-circle"></i> Rejected</span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <div class="d-flex align-items-center gap-2">
                                                            @if($req->status == 'pending')
                                                                <!-- Confirm (Soft Delete) Button -->
                                                                <button type="button" class="crancy-btn" style="background: #2563eb; color: #fff; padding: 6px 12px; font-size: 12px;" onclick="confirmSoftDelete({{ $req->id }}, '{{ $req->user ? addslashes($req->user->name) : 'User' }}')">
                                                                    <i class="fas fa-check"></i> {{ __('translate.Confirm (Soft Delete)') }}
                                                                </button>

                                                                <!-- Hard Delete Button -->
                                                                <button type="button" class="crancy-btn delete_danger_btn" style="padding: 6px 12px; font-size: 12px;" onclick="confirmHardDelete({{ $req->id }}, '{{ $req->user ? addslashes($req->user->name) : 'User' }}')">
                                                                    <i class="fas fa-trash-alt"></i> {{ __('translate.Hard Delete') }}
                                                                </button>

                                                                <!-- Reject Button -->
                                                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="confirmReject({{ $req->id }})">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            @elseif($req->status == 'confirmed' && $req->action_type == 'soft_delete')
                                                                <!-- Can still Hard Delete if soft deleted -->
                                                                <button type="button" class="crancy-btn delete_danger_btn" style="padding: 6px 12px; font-size: 12px;" onclick="confirmHardDelete({{ $req->id }}, '{{ $req->user ? addslashes($req->user->name) : 'User' }}')">
                                                                    <i class="fas fa-trash-alt"></i> {{ __('translate.Hard Delete') }}
                                                                </button>
                                                            @else
                                                                <span class="text-muted small">No action needed</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center py-4 text-muted">
                                                        {{ __('translate.No account deletion requests found.') }}
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                        <!-- End crancy Table Body -->
                                    </table>
                                </div>
                                <!-- End crancy Table -->
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End crancy Dashboard -->

    <!-- Soft Delete Confirmation Modal -->
    <div class="modal fade" id="softDeleteModal" tabindex="-1" aria-labelledby="softDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="softDeleteModalLabel">{{ __('translate.Confirm Soft Delete') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <strong>soft delete</strong> user <span id="soft_user_name" class="fw-bold"></span>?</p>
                    <p class="text-muted small mb-0">The user will not be able to log in and will be moved to Soft Deleted Users. You can restore them later if needed.</p>
                </div>
                <div class="modal-footer">
                    <form action="" id="soft_delete_form" method="POST">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                        <button type="submit" class="btn btn-primary" style="background: #2563eb;">{{ __('translate.Confirm (Soft Delete)') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hard Delete Confirmation Modal -->
    <div class="modal fade" id="hardDeleteModal" tabindex="-1" aria-labelledby="hardDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="hardDeleteModalLabel"><i class="fas fa-exclamation-triangle"></i> {{ __('translate.Hard Delete Confirmation') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger fw-bold">Warning: This action CANNOT be undone!</p>
                    <p>Are you sure you want to <strong>permanently (hard) delete</strong> user <span id="hard_user_name" class="fw-bold"></span> and all their associated data?</p>
                </div>
                <div class="modal-footer">
                    <form action="" id="hard_delete_form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('translate.Hard Delete Permanently') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Request Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">{{ __('translate.Reject Request') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to reject this account deletion request? The user account will remain active.</p>
                </div>
                <div class="modal-footer">
                    <form action="" id="reject_form" method="POST">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('translate.Reject Request') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_section')
    <script>
        "use strict";

        function confirmSoftDelete(id, name) {
            $("#soft_user_name").text(name);
            $("#soft_delete_form").attr("action", "{{ url('admin/account-delete-requests') }}/" + id + "/confirm");
            var modal = new bootstrap.Modal(document.getElementById('softDeleteModal'));
            modal.show();
        }

        function confirmHardDelete(id, name) {
            $("#hard_user_name").text(name);
            $("#hard_delete_form").attr("action", "{{ url('admin/account-delete-requests') }}/" + id + "/hard-delete");
            var modal = new bootstrap.Modal(document.getElementById('hardDeleteModal'));
            modal.show();
        }

        function confirmReject(id) {
            $("#reject_form").attr("action", "{{ url('admin/account-delete-requests') }}/" + id + "/reject");
            var modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }
    </script>
@endpush
