@extends('user.dashboard_layout')

@section('title')
    <title>{{ __('translate.User || Domain Settings') }}</title>
@endsection

@section('breadcrumb')
    <h1 class="post__title">{{ __('translate.Domain Settings') }}</h1>
    <nav class="breadcrumbs">
        <ul>
            <li><a href="{{ route('user.dashboard') }}">{{ __('translate.Home') }}</a></li>
            <li>{{ __('translate.Domain Settings') }}</li>
        </ul>
    </nav>
@endsection

@push('style_section')
<style>
    .domain-card {
        background: rgba(14, 22, 48, 0.75);
        border: 1px solid rgba(0, 212, 255, 0.16);
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 28px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }
    .domain-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .domain-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .domain-card-title i {
        color: #00D4FF;
        font-size: 20px;
    }
    .domain-preview-box {
        background: rgba(9, 15, 33, 0.85);
        border: 1px solid rgba(0, 212, 255, 0.2);
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }
    .domain-url-text {
        font-family: monospace;
        font-size: 15px;
        color: #00D4FF;
        font-weight: 600;
        word-break: break-all;
    }
    .domain-badge {
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .domain-badge-active {
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.4);
        color: #10B981;
    }
    .domain-badge-pending {
        background: rgba(245, 158, 11, 0.15);
        border: 1px solid rgba(245, 158, 11, 0.4);
        color: #F59E0B;
    }
    .domain-badge-reviewing {
        background: rgba(0, 212, 255, 0.15);
        border: 1px solid rgba(0, 212, 255, 0.4);
        color: #00D4FF;
    }
    .domain-badge-canceled {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.4);
        color: #EF4444;
    }
    .domain-badge-primary {
        background: rgba(59, 130, 246, 0.15);
        border: 1px solid rgba(59, 130, 246, 0.4);
        color: #3B82F6;
    }
    .subdomain-input-group {
        display: flex;
        align-items: center;
        background: rgba(9, 15, 33, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.25s ease;
    }
    .subdomain-input-group:focus-within {
        border-color: #00D4FF;
        box-shadow: 0 0 14px rgba(0, 212, 255, 0.25);
    }
    .subdomain-prefix-input {
        flex: 1;
        background: transparent !important;
        border: none !important;
        color: #fff !important;
        padding: 12px 16px !important;
        font-size: 15px !important;
        outline: none !important;
    }
    .subdomain-suffix-addon {
        background: rgba(255, 255, 255, 0.05);
        color: #8B9DC3;
        padding: 12px 18px;
        font-size: 14px;
        border-left: 1px solid rgba(255, 255, 255, 0.08);
        user-select: none;
    }
</style>
@endpush

@section('dashboard-content')
    <div class="dashbord_titel">
        <h4>{{ __('translate.Domain Settings') }}</h4>
    </div>

    <!-- Active Portfolio UI Design on this Domain -->
    <div class="domain-card" style="background: linear-gradient(135deg, rgba(14, 22, 48, 0.9) 0%, rgba(19, 32, 74, 0.9) 100%); border-color: rgba(0, 212, 255, 0.35);">
        <div class="domain-card-header" style="border-bottom-color: rgba(0, 212, 255, 0.15);">
            <h5 class="domain-card-title">
                <i class="ri-palette-line"></i> {{ __('translate.Domain Portfolio UI & Design') }}
            </h5>
            <span class="badge bg-info text-dark font-weight-bold" style="background: #00D4FF !important;">
                <i class="ri-checkbox-circle-line me-1"></i> Connected to Domain
            </span>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div style="width: 54px; height: 54px; border-radius: 12px; background: rgba(0, 212, 255, 0.15); border: 1px solid rgba(0, 212, 255, 0.3); display: flex; align-items: center; justify-content: center; color: #00D4FF; font-size: 26px;">
                    <i class="ri-layout-masonry-line"></i>
                </div>
                <div>
                    <h6 class="text-white mb-1" style="font-size: 16px; font-weight: 700;">
                        {{ $portfolioTemplate?->name ?? 'Modern Portfolio' }}
                        <span class="badge bg-secondary ms-2" style="font-size: 11px;">{{ $portfolioTemplate?->style ?? 'Interactive Showcase' }}</span>
                    </h6>
                    <p class="text-muted small m-0">
                        This is the design layout displayed when visitors visit your subdomain (e.g. <code>{{ $subdomain?->url }}</code>) or custom domain.
                    </p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ profile_route('user.portfolio-settings.index') }}" class="btn btn-sm btn-primary" style="background: #00D4FF; color: #000; border: none; font-weight: 700; padding: 8px 16px;">
                    <i class="ri-brush-line me-1"></i> Change Portfolio Design
                </a>
                @if($subdomain)
                    <a href="{{ $subdomain->url }}" target="_blank" class="btn btn-sm btn-outline-info" style="padding: 8px 14px;">
                        <i class="ri-external-link-line me-1"></i> Visit Domain
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Section 1: Free Subdomain -->
    <div class="domain-card">
        <div class="domain-card-header">
            <h5 class="domain-card-title">
                <i class="ri-global-line"></i> {{ __('translate.Your Free Subdomain') }}
            </h5>
            @if($subdomain)
                <div class="d-flex align-items-center gap-2">
                    <span class="domain-badge domain-badge-active"><i class="ri-check-line"></i> Active</span>
                    @if($subdomain->is_primary)
                        <span class="domain-badge domain-badge-primary">Primary Domain</span>
                    @endif
                </div>
            @endif
        </div>

        @if($subdomain)
            <div class="domain-preview-box">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="domain-url-text">{{ $subdomain->url }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-outline-info" onclick="copyDomain('{{ $subdomain->url }}')">
                        <i class="ri-file-copy-line"></i> {{ __('translate.Copy Link') }}
                    </button>
                    <a href="{{ $subdomain->url }}" target="_blank" class="btn btn-sm btn-primary" style="background: #00D4FF; color: #000; border: none; font-weight: 600;">
                        <i class="ri-external-link-line"></i> {{ __('translate.Visit Site') }}
                    </a>
                </div>
            </div>
        @endif

        <form action="{{ route('user.domain-settings.subdomain') }}" method="POST">
            @csrf
            <label class="form-label text-muted small mb-2">
                {{ __('translate.Customize your subdomain prefix (letters, numbers and hyphens only):') }}
            </label>
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <div class="subdomain-input-group">
                        <input type="text"
                               name="subdomain_prefix"
                               class="subdomain-prefix-input"
                               placeholder="e.g. {{ $user->username ?: 'yourname' }}"
                               value="{{ $subdomain ? str_replace('.' . $baseDomain, '', $subdomain->host) : ($user->username ?: '') }}"
                               required>
                        <span class="subdomain-suffix-addon">.{{ $baseDomain }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="optech-default-btn w-100" style="padding: 12px 20px; justify-content: center;" data-text="{{ __('translate.Save Subdomain') }}">
                        <span class="btn-wraper">{{ __('translate.Save Subdomain') }}</span>
                    </button>
                </div>
            </div>
            <p class="text-muted small mt-2 mb-0">
                <i class="ri-information-line text-info"></i> Your portfolio and CV will be instantly accessible at this subdomain.
            </p>
        </form>
    </div>

    <!-- Section 2: Custom Domains -->
    <div class="domain-card">
        <div class="domain-card-header">
            <h5 class="domain-card-title">
                <i class="ri-links-line"></i> {{ __('translate.Connect Custom Domain') }}
            </h5>
            <span class="badge bg-secondary text-white small" style="font-size: 11px;">Optional</span>
        </div>

        <p class="text-muted small">
            Connect your own purchased domain (e.g., <code>johnsmith.com</code> or <code>portfolio.mybrand.me</code>). Submit your request along with any configuration information or registrar details for our admin team to review and activate.
        </p>

        <!-- Add Custom Domain Form -->
        <form action="{{ route('user.domain-settings.custom-domain') }}" method="POST" class="mb-4">
            @csrf
            <div class="row g-3">
                <div class="col-md-7">
                    <label class="form-label text-white-50 small mb-1">{{ __('translate.Custom Domain Name') }} <span class="text-danger">*</span></label>
                    <div class="optech-checkout-field m-0">
                        <input type="text"
                               name="custom_domain"
                               placeholder="e.g. myname.com or portfolio.mybrand.me"
                               style="height: 48px; border-radius: 10px;"
                               required>
                    </div>
                </div>
                <div class="col-md-5 d-flex align-items-end">
                    <button type="submit" class="optech-default-btn w-100" style="padding: 12px 20px; justify-content: center; height: 48px;" data-text="{{ __('translate.Submit Request') }}">
                        <span class="btn-wraper"><i class="ri-send-plane-fill me-1"></i> {{ __('translate.Submit Request') }}</span>
                    </button>
                </div>
                <div class="col-12 mt-2">
                    <label class="form-label text-white-50 small mb-1">
                        <i class="ri-information-line text-info"></i> {{ __('translate.Information / Instructions for Admin (Optional)') }}
                    </label>
                    <textarea name="user_note"
                              rows="2"
                              class="form-control"
                              placeholder="e.g. Domain registered on Namecheap/GoDaddy, DNS CNAME already configured, or any instructions for admin..."
                              style="background: rgba(9, 15, 33, 0.85); border: 1px solid rgba(255, 255, 255, 0.12); color: #fff; border-radius: 10px; font-size: 13.5px;"></textarea>
                </div>
            </div>
        </form>

        <!-- Custom Domains List -->
        @if($customDomains->count() > 0)
            <div class="table-responsive mt-3">
                <table class="table table-dark table-borderless align-middle mb-0" style="background: rgba(9, 15, 33, 0.6); border-radius: 12px; overflow: hidden;">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.08); color: #8B9DC3; font-size: 13px;">
                            <th>{{ __('translate.Domain') }}</th>
                            <th>{{ __('translate.Status') }}</th>
                            <th>{{ __('translate.Primary') }}</th>
                            <th class="text-end">{{ __('translate.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customDomains as $cd)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                                <td style="width: 40%;">
                                    <div>
                                        <span class="fw-bold text-white fs-6">{{ $cd->host }}</span>
                                        @if($cd->is_active)
                                            <a href="{{ $cd->url }}" target="_blank" class="text-info ms-2 small" title="Visit">
                                                <i class="ri-external-link-line"></i>
                                            </a>
                                        @endif
                                    </div>

                                    @if(!empty($cd->user_note))
                                        <div class="mt-1 small" style="color: #94a3b8; font-size: 12px;">
                                            <i class="ri-file-text-line text-info"></i> <strong>{{ __('translate.Your Note') }}:</strong>
                                            <span>{{ Str::limit($cd->user_note, 70) }}</span>
                                            <a href="javascript:void(0)" class="text-info ms-1 text-decoration-none" data-bs-toggle="modal" data-bs-target="#userNoteModal{{ $cd->id }}">
                                                <i class="ri-edit-line"></i> {{ __('translate.Edit') }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="mt-1">
                                            <a href="javascript:void(0)" class="text-info small text-decoration-none" style="font-size: 11.5px;" data-bs-toggle="modal" data-bs-target="#userNoteModal{{ $cd->id }}">
                                                <i class="ri-add-line"></i> {{ __('translate.Add Note for Admin') }}
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($cd->status === 'complete')
                                        <span class="domain-badge domain-badge-active"><i class="ri-checkbox-circle-line"></i> Complete</span>
                                    @elseif($cd->status === 'reviewing')
                                        <span class="domain-badge domain-badge-reviewing"><i class="ri-loader-4-line ri-spin"></i> Reviewing</span>
                                    @elseif($cd->status === 'canceled')
                                        <span class="domain-badge domain-badge-canceled"><i class="ri-close-circle-line"></i> Canceled</span>
                                    @else
                                        <span class="domain-badge domain-badge-pending"><i class="ri-time-line"></i> Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($cd->is_primary)
                                        <span class="domain-badge domain-badge-primary"><i class="ri-star-fill"></i> Primary</span>
                                    @elseif($cd->is_active)
                                        <form action="{{ route('user.domain-settings.primary', $cd->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;">
                                                Make Primary
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-info" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#userNoteModal{{ $cd->id }}">
                                            <i class="ri-edit-2-line"></i> {{ __('translate.Info') }}
                                        </button>

                                        <form action="{{ route('user.domain-settings.destroy', $cd->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this domain?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" style="font-size: 12px;">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            @if(!empty($cd->admin_message))
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.08); background: rgba(0, 212, 255, 0.04);">
                                    <td colspan="4" class="p-3">
                                        <div class="p-3 rounded-3" style="background: rgba(0, 212, 255, 0.08); border-left: 4px solid #00D4FF; border: 1px solid rgba(0, 212, 255, 0.25);">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="ri-chat-voice-fill fs-5" style="color: #00D4FF;"></i>
                                                    <strong style="color: #00D4FF; font-size: 13.5px;">
                                                        {{ __('translate.Message from Administrator:') }}
                                                    </strong>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-info py-0 px-2" style="font-size: 11px;" data-bs-toggle="modal" data-bs-target="#userNoteModal{{ $cd->id }}">
                                                    <i class="ri-reply-line"></i> {{ __('translate.Reply / Update Info') }}
                                                </button>
                                            </div>
                                            <div class="text-white ps-4" style="font-size: 13.5px; line-height: 1.6; white-space: pre-wrap;">{{ $cd->admin_message }}</div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Modals for User to view/reply/update information for domain -->
    @foreach($customDomains as $cd)
        <div class="modal fade" id="userNoteModal{{ $cd->id }}" tabindex="-1" aria-labelledby="userNoteModalLabel{{ $cd->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #0e1630; border: 1px solid rgba(0, 212, 255, 0.25); border-radius: 14px; color: #fff; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                    <div class="modal-header py-3 px-4" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                        <h5 class="modal-title fs-6 fw-bold m-0" id="userNoteModalLabel{{ $cd->id }}">
                            <i class="ri-links-line text-info me-2"></i> {{ __('translate.Domain Information') }}: <span style="color: #00D4FF;">{{ $cd->host }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.domain-settings.update-note', $cd->id) }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            @if(!empty($cd->admin_message))
                                <div class="p-3 mb-3 rounded-3" style="background: rgba(0, 212, 255, 0.08); border-left: 3px solid #00D4FF; border: 1px solid rgba(0, 212, 255, 0.2);">
                                    <div class="d-flex align-items-center gap-1 mb-1">
                                        <i class="ri-chat-voice-fill" style="color: #00D4FF;"></i>
                                        <span class="fw-bold small" style="color: #00D4FF;">{{ __('translate.Admin Message') }}:</span>
                                    </div>
                                    <p class="mb-0 text-white-50 small" style="white-space: pre-wrap; line-height: 1.5;">{{ $cd->admin_message }}</p>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label text-white-50 small mb-1">
                                    <i class="ri-edit-line text-info me-1"></i> {{ __('translate.Your Information / Notes for Admin:') }}
                                </label>
                                <textarea name="user_note"
                                          rows="5"
                                          class="form-control"
                                          placeholder="{{ __('translate.Provide any details required by admin, registrar info, DNS details, or status updates...') }}"
                                          style="background: rgba(9, 15, 33, 0.85); border: 1px solid rgba(255, 255, 255, 0.15); color: #fff; border-radius: 8px; font-size: 13.5px;"
                                          required>{{ $cd->user_note }}</textarea>
                                <small class="text-muted d-block mt-1">
                                    <i class="ri-information-line"></i> Admin will review this updated information and change status accordingly.
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer py-2 px-4" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                            <button type="submit" class="btn btn-sm btn-info text-dark fw-bold px-3">
                                <i class="ri-send-plane-fill me-1"></i> {{ __('translate.Save & Submit Info') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection

@push('js_section')
<script>
    function copyDomain(text) {
        navigator.clipboard.writeText(text).then(function() {
            toastr.success('Domain URL copied to clipboard!');
        }, function(err) {
            toastr.error('Could not copy URL.');
        });
    }
</script>
@endpush
