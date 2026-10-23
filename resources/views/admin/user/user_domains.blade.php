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
                                            <span class="badge bg-primary px-3 py-2" style="font-size: 13px;">Total Domains: {{ $domains->count() }}</span>
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
                                                    {{ __('translate.Host / Domain') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Type') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Request Status') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.User Info / Note') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Admin Message') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Active') }}
                                                </th>
                                                <th class="crancy-table__column-3 crancy-table__h3 sorting text-end">
                                                    {{ __('translate.Action') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <!-- crancy Table Body -->
                                        <tbody class="crancy-table__body">
                                            @forelse ($domains as $index => $domain)
                                                <tr class="odd">
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ ++$index }}</h4>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if($domain->user)
                                                            <h4 class="crancy-table__product-title">
                                                                <a href="{{ route('admin.user-show', $domain->user->id) }}">
                                                                    {{ html_decode($domain->user->name) }}
                                                                </a>
                                                            </h4>
                                                            <span class="text-muted small">{{ html_decode($domain->user->email) }}</span>
                                                        @else
                                                            <span class="text-danger small">User Not Found</span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <div>
                                                            <strong class="text-primary">{{ $domain->host }}</strong>
                                                            <a href="{{ $domain->url }}" target="_blank" class="ms-1 text-info small" title="Visit">
                                                                <i class="fas fa-external-link-alt"></i>
                                                            </a>
                                                        </div>
                                                        @if($domain->is_primary)
                                                            <span class="badge bg-success" style="font-size: 10px;"><i class="fas fa-star"></i> Primary</span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if($domain->type == 'subdomain')
                                                            <span class="badge bg-info text-dark">Subdomain</span>
                                                        @else
                                                            <span class="badge text-white" style="background: #7B4FFF;">Custom Domain</span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if($domain->status === 'complete')
                                                            <span class="badge bg-success text-white px-2 py-1"><i class="fas fa-check-circle"></i> Complete</span>
                                                        @elseif($domain->status === 'reviewing')
                                                            <span class="badge bg-info text-white px-2 py-1"><i class="fas fa-spinner fa-spin"></i> Reviewing</span>
                                                        @elseif($domain->status === 'canceled')
                                                            <span class="badge bg-danger text-white px-2 py-1"><i class="fas fa-times-circle"></i> Canceled</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark px-2 py-1"><i class="fas fa-clock"></i> Pending</span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if(!empty($domain->user_note))
                                                            <span class="text-dark small d-inline-block text-truncate" style="max-width: 150px;" title="{{ $domain->user_note }}">
                                                                {{ $domain->user_note }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted small"><em>None</em></span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if(!empty($domain->admin_message))
                                                            <span class="text-primary small d-inline-block text-truncate" style="max-width: 150px;" title="{{ $domain->admin_message }}">
                                                                <i class="fas fa-comment-alt"></i> {{ $domain->admin_message }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted small"><em>None</em></span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <form action="{{ route('admin.user-domains.toggle-status', $domain->id) }}" method="POST">
                                                            @csrf
                                                            <div class="crancy-ptabs__notify-switch crancy-ptabs__notify-switch--two">
                                                                <label class="crancy__item-switch">
                                                                    <input onchange="this.form.submit()" type="checkbox" {{ $domain->is_active ? 'checked' : '' }}>
                                                                    <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                                </label>
                                                            </div>
                                                        </form>
                                                    </td>

                                                    <td class="crancy-table__column-3 crancy-table__data-3 text-end">
                                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editDomainModal{{ $domain->id }}" style="padding: 5px 10px; font-size: 12px; border-radius: 6px;">
                                                                <i class="fas fa-edit"></i> {{ __('translate.Review') }}
                                                            </button>

                                                            <form action="{{ route('admin.user-domains.delete', $domain->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this domain record?');" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="crancy-btn delete_danger_btn" style="padding: 5px 10px; font-size: 12px; border-radius: 6px;">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center py-4 text-muted">
                                                        {{ __('translate.No user domains or subdomains found.') }}
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

    <!-- Domain Review / Update Modals -->
    @foreach ($domains as $domain)
        <div class="modal fade" id="editDomainModal{{ $domain->id }}" tabindex="-1" aria-labelledby="editDomainModalLabel{{ $domain->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
                    <div class="modal-header bg-light py-3 px-4">
                        <h5 class="modal-title fw-bold text-dark m-0" id="editDomainModalLabel{{ $domain->id }}">
                            <i class="fas fa-globe text-primary me-2"></i> {{ __('translate.Review Domain Request') }}: <span class="text-primary">{{ $domain->host }}</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.user-domains.update-request', $domain->id) }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <!-- User Details Card -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <small class="text-muted d-block fw-semibold">{{ __('translate.User Name') }}</small>
                                        <strong class="text-dark">{{ $domain->user ? $domain->user->name : 'N/A' }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <small class="text-muted d-block fw-semibold">{{ __('translate.User Email') }}</small>
                                        <strong class="text-dark">{{ $domain->user ? $domain->user->email : 'N/A' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- User Provided Information / Note -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark d-flex align-items-center gap-1">
                                    <i class="fas fa-info-circle text-info"></i> {{ __('translate.Information / Note from User') }}:
                                </label>
                                <div class="p-3 border rounded" style="background: #f8fafc; font-size: 13.5px; line-height: 1.6; min-height: 60px; white-space: pre-wrap; color: #334155;">{{ $domain->user_note ?: __('translate.No information or note provided by the user.') }}</div>
                            </div>

                            <!-- Status Dropdown -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark d-flex align-items-center gap-1">
                                    <i class="fas fa-tasks text-warning"></i> {{ __('translate.Status') }}: <span class="text-danger">*</span>
                                </label>
                                <select name="status" class="form-select" style="height: 44px; border-radius: 8px; font-weight: 600;" required>
                                    <option value="pending" {{ $domain->status === 'pending' ? 'selected' : '' }}>⏳ Pending (Awaiting Review)</option>
                                    <option value="reviewing" {{ $domain->status === 'reviewing' ? 'selected' : '' }}>🔍 Reviewing (Work in Progress / Checking DNS)</option>
                                    <option value="complete" {{ $domain->status === 'complete' ? 'selected' : '' }}>✅ Complete (Configuration Done & Active)</option>
                                    <option value="canceled" {{ $domain->status === 'canceled' ? 'selected' : '' }}>❌ Canceled (Request Rejected or Canceled)</option>
                                </select>
                                <div class="form-text small text-muted">
                                    <i class="fas fa-info-circle"></i> Selecting <strong>Complete</strong> will mark the domain verified and activate it immediately.
                                </div>
                            </div>

                            <!-- Admin Message Box -->
                            <div class="mb-2">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-label fw-bold text-dark m-0">
                                        <i class="fas fa-comment-dots text-primary me-1"></i> {{ __('translate.Admin Message / Requirements List for User') }}:
                                    </label>
                                    <span class="badge bg-light text-primary border small">Shows on user dashboard</span>
                                </div>

                                <div class="d-flex align-items-center gap-1 flex-wrap my-2">
                                    <small class="text-muted me-1">Quick requirements:</small>
                                    <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 11px; border-radius: 4px;" onclick="insertMsg({{ $domain->id }}, 'Please configure the following DNS record in your domain manager:\n• Record Type: CNAME\n• Host/Name: @ (or root)\n• Target/Points to: {{ \App\Models\ProfileDomain::getBaseDomain() }}\n• TTL: Automatic / 3600\n\nPlease let us know once done.')">
                                        + CNAME Requirement
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-info py-0 px-2" style="font-size: 11px; border-radius: 4px;" onclick="insertMsg({{ $domain->id }}, 'Please provide your domain DNS provider access (e.g. Cloudflare, Namecheap, GoDaddy) or nameserver access so our technical team can configure it directly.')">
                                        + Request DNS Access
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success py-0 px-2" style="font-size: 11px; border-radius: 4px;" onclick="insertMsg({{ $domain->id }}, 'Your custom domain setup is complete and SSL certificate has been issued. Your website is now live on this domain!')">
                                        + Done Note
                                    </button>
                                </div>

                                <textarea id="admin_msg_{{ $domain->id }}" name="admin_message" rows="4" class="form-control" placeholder="Write any instructions, requirements or checklist for the user..." style="border-radius: 8px; font-size: 13.5px;">{{ $domain->admin_message }}</textarea>
                                <div class="form-text small text-muted">
                                    💡 <strong>Notice:</strong> This list of instructions or requirements will appear directly on the user's domain settings page.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light px-4 py-3">
                            <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                            <button type="submit" class="btn btn-primary px-4" style="background-color: #0b63e5; border-color: #0b63e5;">
                                <i class="fas fa-save me-1"></i> {{ __('translate.Update Status & Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('js_section')
<script>
    function insertMsg(id, text) {
        var el = document.getElementById('admin_msg_' + id);
        if (el) {
            el.value = text;
            el.focus();
        }
    }
</script>
@endpush
