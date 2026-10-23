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
    .domain-badge-primary {
        background: rgba(59, 130, 246, 0.15);
        border: 1px solid rgba(59, 130, 246, 0.4);
        color: #3B82F6;
    }
    .dns-table {
        width: 100%;
        border-collapse: collapse;
        margin: 15px 0;
        font-size: 13.5px;
    }
    .dns-table th, .dns-table td {
        padding: 12px 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        text-align: left;
    }
    .dns-table th {
        background: rgba(255, 255, 255, 0.04);
        color: #8b9dc3;
        font-weight: 600;
    }
    .dns-table td {
        color: #fff;
    }
    .dns-code {
        background: rgba(0, 0, 0, 0.4);
        padding: 2px 8px;
        border-radius: 4px;
        color: #00D4FF;
        font-family: monospace;
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
            Connect your own purchased domain (e.g., <code>johnsmith.com</code> or <code>portfolio.mybrand.me</code>) to point directly to your TechSeba portfolio.
        </p>

        <!-- Add Custom Domain Form -->
        <form action="{{ route('user.domain-settings.custom-domain') }}" method="POST" class="mb-4">
            @csrf
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <div class="optech-checkout-field m-0">
                        <input type="text"
                               name="custom_domain"
                               placeholder="e.g. myname.com or portfolio.mybrand.me"
                               style="height: 48px; border-radius: 10px;"
                               required>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="optech-default-btn w-100" style="padding: 12px 20px; justify-content: center;" data-text="{{ __('translate.Connect Domain') }}">
                        <span class="btn-wraper">{{ __('translate.Connect Domain') }}</span>
                    </button>
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
                                <td>
                                    <span class="fw-bold text-white">{{ $cd->host }}</span>
                                    @if($cd->is_active)
                                        <a href="{{ $cd->url }}" target="_blank" class="text-info ms-2 small">
                                            <i class="ri-external-link-line"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if($cd->is_active)
                                        <span class="domain-badge domain-badge-active"><i class="ri-checkbox-circle-line"></i> Verified & Active</span>
                                    @else
                                        <span class="domain-badge domain-badge-pending"><i class="ri-time-line"></i> DNS Pending</span>
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
                                        @if(!$cd->is_active)
                                            <form action="{{ route('user.domain-settings.verify', $cd->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-info" style="font-size: 12px;">
                                                    <i class="ri-refresh-line"></i> Verify DNS
                                                </button>
                                            </form>
                                        @endif

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
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Section 3: DNS Configuration Guide -->
    <div class="domain-card">
        <div class="domain-card-header">
            <h5 class="domain-card-title">
                <i class="ri-settings-5-line"></i> {{ __('translate.DNS Configuration Guide') }}
            </h5>
        </div>

        <p class="text-muted small">
            To connect your custom domain, go to your domain provider's DNS Manager (Cloudflare, Namecheap, GoDaddy, etc.) and add the following record:
        </p>

        <div class="table-responsive">
            <table class="dns-table">
                <thead>
                    <tr>
                        <th>Record Type</th>
                        <th>Host / Name</th>
                        <th>Target / Value</th>
                        <th>TTL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="badge bg-primary">CNAME (Recommended)</span></td>
                        <td><span class="dns-code">@</span> or your subdomain (e.g. <span class="dns-code">cv</span>)</td>
                        <td><span class="dns-code">{{ $baseDomain }}</span></td>
                        <td>Automatic or 3600</td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-secondary">A Record (Alternative)</span></td>
                        <td><span class="dns-code">@</span></td>
                        <td><span class="dns-code">{{ $serverIp }}</span></td>
                        <td>Automatic or 3600</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="alert alert-dark d-flex align-items-center gap-2 p-3 mt-3 rounded-3" style="background: rgba(0, 212, 255, 0.08); border: 1px solid rgba(0, 212, 255, 0.2); color: #8B9DC3;">
            <i class="ri-information-line text-info fs-5"></i>
            <span class="small">
                After adding the DNS records, it may take between <strong>5 minutes to a few hours</strong> to propagate worldwide. Once added, click the <strong>Verify DNS</strong> button above.
            </span>
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
