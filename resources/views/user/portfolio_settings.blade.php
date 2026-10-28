@extends('user.dashboard_layout')

@section('title')
    <title>{{ __('translate.User || Portfolio Settings') }}</title>
@endsection

@section('breadcrumb')
    <h1 class="post__title">{{ __('translate.Portfolio Settings') }}</h1>
    <nav class="breadcrumbs">
        <ul>
            <li><a href="{{ route('user.dashboard') }}">{{ __('translate.Home') }}</a></li>
            <li>{{ __('translate.Portfolio Settings') }}</li>
        </ul>
    </nav>
@endsection

@push('style_section')
<style>
    :root {
        --pf-bg-card: rgba(14, 22, 48, 0.85);
        --pf-border: rgba(0, 212, 255, 0.18);
        --pf-border-hover: rgba(0, 212, 255, 0.5);
        --pf-cyan: #00D4FF;
        --pf-accent: #6366F1;
        --pf-green: #10B981;
        --pf-text: #F1F5F9;
        --pf-muted: #8B9DC3;
    }

    .pf-card {
        background: var(--pf-bg-card);
        border: 1px solid var(--pf-border);
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 28px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.28);
        backdrop-filter: blur(10px);
    }

    .pf-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        flex-wrap: wrap;
        gap: 12px;
    }

    .pf-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .pf-card-title i {
        color: var(--pf-cyan);
        font-size: 22px;
    }

    /* URL Showcase Grid */
    .pf-url-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .pf-url-item {
        background: rgba(9, 15, 33, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.09);
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: all 0.25s ease;
    }

    .pf-url-item:hover {
        border-color: var(--pf-cyan);
        box-shadow: 0 4px 16px rgba(0, 212, 255, 0.15);
    }

    .pf-url-item-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--pf-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pf-url-item-label i {
        color: var(--pf-cyan);
    }

    .pf-url-item-val {
        font-family: monospace;
        font-size: 13.5px;
        color: #fff;
        word-break: break-all;
        font-weight: 600;
    }

    .pf-url-item-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 4px;
    }

    .pf-url-btn {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #fff;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .pf-url-btn:hover {
        background: rgba(0, 212, 255, 0.15);
        border-color: var(--pf-cyan);
        color: var(--pf-cyan);
    }

    .pf-url-btn-primary {
        background: var(--pf-cyan);
        border-color: var(--pf-cyan);
        color: #000;
        font-weight: 700;
    }

    .pf-url-btn-primary:hover {
        background: #38bdf8;
        color: #000;
    }

    /* Active Banner */
    .pf-active-banner {
        background: linear-gradient(135deg, rgba(0, 212, 255, 0.12) 0%, rgba(99, 102, 241, 0.12) 100%);
        border: 1px solid rgba(0, 212, 255, 0.28);
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 24px;
    }

    .pf-active-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .pf-active-badge-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: rgba(0, 212, 255, 0.18);
        color: var(--pf-cyan);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .pf-active-text h6 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        color: #fff;
    }

    .pf-active-text p {
        margin: 2px 0 0;
        font-size: 12.5px;
        color: var(--pf-muted);
    }

    /* Template Cards Grid */
    .pf-templates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
        gap: 22px;
        margin-top: 20px;
    }

    .pf-template-card {
        background: rgba(9, 15, 33, 0.9);
        border: 2px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .pf-template-card:hover {
        transform: translateY(-4px);
        border-color: rgba(0, 212, 255, 0.45);
        box-shadow: 0 14px 34px rgba(0, 212, 255, 0.14);
    }

    .pf-template-card.is-active {
        border-color: var(--pf-cyan);
        box-shadow: 0 0 25px rgba(0, 212, 255, 0.28);
    }

    .pf-thumb-wrapper {
        position: relative;
        width: 100%;
        padding-top: 68%;
        background: #0d1530;
        overflow: hidden;
    }

    .pf-thumb-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        transition: transform 0.4s ease;
    }

    .pf-template-card:hover .pf-thumb-wrapper img {
        transform: scale(1.04);
    }

    .pf-card-selected-tag {
        position: absolute;
        top: 12px;
        right: 12px;
        background: var(--pf-green);
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.45);
        z-index: 2;
    }

    .pf-card-free-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(14, 22, 48, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        backdrop-filter: blur(6px);
        z-index: 2;
    }

    .pf-card-body {
        padding: 18px 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 10px;
    }

    .pf-card-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .pf-template-name {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #fff;
    }

    .pf-template-style-pill {
        background: rgba(0, 212, 255, 0.12);
        color: var(--pf-cyan);
        border: 1px solid rgba(0, 212, 255, 0.25);
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .pf-template-desc {
        margin: 0;
        font-size: 13px;
        color: var(--pf-muted);
        line-height: 1.5;
        flex: 1;
    }

    .pf-card-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .pf-btn-preview {
        flex: 1;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.14);
        color: #fff;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }

    .pf-btn-preview:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.25);
    }

    .pf-btn-select {
        flex: 1.3;
        background: var(--pf-cyan);
        border: 1px solid var(--pf-cyan);
        color: #000;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pf-btn-select:hover:not(:disabled) {
        background: #38bdf8;
        box-shadow: 0 4px 14px rgba(0, 212, 255, 0.35);
    }

    .pf-btn-select:disabled {
        background: rgba(16, 185, 129, 0.2);
        border-color: rgba(16, 185, 129, 0.4);
        color: #10B981;
        cursor: default;
    }

    /* Live Preview Section */
    .pf-preview-section {
        margin-top: 32px;
    }

    .pf-preview-box {
        background: rgba(9, 15, 33, 0.95);
        border: 1px solid rgba(0, 212, 255, 0.2);
        border-radius: 14px;
        overflow: hidden;
    }

    .pf-preview-toolbar {
        background: rgba(14, 22, 48, 0.95);
        padding: 12px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pf-device-btns {
        display: flex;
        background: rgba(0, 0, 0, 0.4);
        border-radius: 8px;
        padding: 3px;
        gap: 3px;
    }

    .pf-device-btn {
        background: transparent;
        border: none;
        color: var(--pf-muted);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .pf-device-btn.is-active {
        background: var(--pf-cyan);
        color: #000;
    }

    .pf-iframe-wrap {
        width: 100%;
        height: 650px;
        background: #fff;
        display: flex;
        justify-content: center;
        transition: width 0.3s ease;
        margin: 0 auto;
    }

    .pf-iframe-wrap iframe {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }

    .pf-pulse-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pfPulse 1.8s infinite;
    }

    @keyframes pfPulse {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>
@endpush

@section('dashboard-content')
    <div class="dashbord_titel d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h4>{{ __('translate.Portfolio Settings & Design') }}</h4>
            <p class="text-muted small m-0">Set and customize the public portfolio UI that visitors see on your domain.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ profile_route('user.cv.edit') }}" class="btn btn-sm btn-outline-info">
                <i class="ri-edit-line"></i> {{ __('translate.Edit CV & Portfolio Content') }}
            </a>
            <a href="{{ $mainPortfolioUrl }}" target="_blank" class="btn btn-sm btn-primary" style="background: var(--pf-cyan); border-color: var(--pf-cyan); color: #000; font-weight: 700;">
                <i class="ri-external-link-line"></i> {{ __('translate.View Live Portfolio') }}
            </a>
        </div>
    </div>

    <!-- Section 1: Public URLs & Domain Showcase -->
    <div class="pf-card">
        <div class="pf-card-header">
            <h5 class="pf-card-title">
                <i class="ri-global-line"></i> {{ __('translate.Public Portfolio & Domain URLs') }}
            </h5>
            <span class="badge bg-info text-dark font-weight-bold" style="background: var(--pf-cyan) !important;">
                <span class="pf-pulse-dot me-1"></span> Live on Web
            </span>
        </div>

        <p class="text-muted small mb-3">
            Visitors accessing any of the links below will immediately see your selected <strong>Portfolio Design</strong>. You can change your active design at any time with 1-click.
        </p>

        <div class="pf-url-grid">
            <!-- 1. Main Username URL -->
            <div class="pf-url-item">
                <div class="pf-url-item-label">
                    <i class="ri-user-line"></i> {{ __('translate.Direct Portfolio Link') }}
                </div>
                <div class="pf-url-item-val">{{ $mainPortfolioUrl }}</div>
                <div class="pf-url-item-actions">
                    <button type="button" class="pf-url-btn" onclick="copyPortfolioUrl('{{ $mainPortfolioUrl }}')">
                        <i class="ri-file-copy-line"></i> Copy
                    </button>
                    <a href="{{ $mainPortfolioUrl }}" target="_blank" class="pf-url-btn pf-url-btn-primary">
                        <i class="ri-external-link-line"></i> Visit
                    </a>
                </div>
            </div>

            <!-- 2. Subdomain URL -->
            <div class="pf-url-item">
                <div class="pf-url-item-label">
                    <i class="ri-shield-flash-line"></i> {{ __('translate.Free Subdomain') }}
                </div>
                <div class="pf-url-item-val">
                    {{ $subdomainUrl ?: 'https://' . ($user->username ?: 'yourname') . '.' . $baseDomain }}
                </div>
                <div class="pf-url-item-actions">
                    @if($subdomainUrl)
                        <button type="button" class="pf-url-btn" onclick="copyPortfolioUrl('{{ $subdomainUrl }}')">
                            <i class="ri-file-copy-line"></i> Copy
                        </button>
                        <a href="{{ $subdomainUrl }}" target="_blank" class="pf-url-btn pf-url-btn-primary">
                            <i class="ri-external-link-line"></i> Visit
                        </a>
                    @else
                        <a href="{{ route('user.domain-settings.index') }}" class="pf-url-btn pf-url-btn-primary">
                            <i class="ri-settings-line"></i> Configure Subdomain
                        </a>
                    @endif
                </div>
            </div>

            <!-- 3. Custom Domain URL -->
            <div class="pf-url-item">
                <div class="pf-url-item-label">
                    <i class="ri-links-line"></i> {{ __('translate.Custom Domain') }}
                </div>
                <div class="pf-url-item-val">
                    @php
                        $activeCustom = $customDomains->where('is_active', true)->first();
                    @endphp
                    {{ $activeCustom ? $activeCustom->url : 'Not connected yet' }}
                </div>
                <div class="pf-url-item-actions">
                    @if($activeCustom)
                        <button type="button" class="pf-url-btn" onclick="copyPortfolioUrl('{{ $activeCustom->url }}')">
                            <i class="ri-file-copy-line"></i> Copy
                        </button>
                        <a href="{{ $activeCustom->url }}" target="_blank" class="pf-url-btn pf-url-btn-primary">
                            <i class="ri-external-link-line"></i> Visit
                        </a>
                    @else
                        <a href="{{ route('user.domain-settings.index') }}" class="pf-url-btn">
                            <i class="ri-add-line"></i> Connect Domain
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Active Design Summary Banner -->
        <div class="pf-active-banner">
            <div class="pf-active-info">
                <div class="pf-active-badge-icon">
                    <i class="ri-layout-masonry-line"></i>
                </div>
                <div class="pf-active-text">
                    <h6>
                        Active Portfolio Design:
                        <span id="activeDesignName" style="color: var(--pf-cyan);">{{ $selectedPortfolioTemplate?->name ?? 'Modern Portfolio' }}</span>
                    </h6>
                    <p>
                        Layout Style: <strong id="activeDesignStyle" class="text-white">{{ $selectedPortfolioTemplate?->style ?? 'Interactive Showcase' }}</strong> · Category: <span id="activeDesignCategory" class="text-info">{{ $selectedPortfolioTemplate?->category ?? 'Modern' }}</span>
                    </p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success" style="padding: 7px 12px; font-size: 12px;">
                    <i class="ri-check-line"></i> Currently Active on your Domain
                </span>
            </div>
        </div>
    </div>

    <!-- Section 2: Choose Portfolio Design (Template Cards) -->
    <div class="pf-card">
        <div class="pf-card-header">
            <div>
                <h5 class="pf-card-title">
                    <i class="ri-palette-line"></i> {{ __('translate.Choose Portfolio Design') }}
                </h5>
                <p class="text-muted small m-0 mt-1">Select any portfolio design below to set it as your website layout.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-light" onclick="scrollToPreview()">
                    <i class="ri-eye-line"></i> {{ __('translate.Live Preview Sandbox') }}
                </button>
            </div>
        </div>

        <div class="pf-templates-grid">
            @foreach($portfolioTemplates as $tpl)
                @php
                    $isSelected = ($selectedPortfolioTemplate?->id ?? 1) == $tpl->id;
                    $thumb = $tpl->thumbnail_url ?: asset('uploads/website-images/templates/' . $tpl->slug . '.webp');
                    $previewUrl = profile_route('user.cv.portfolio-templates.preview', ['slug' => $tpl->slug]);
                    $renderUrl = profile_route('user.cv.portfolio-templates.render', ['slug' => $tpl->slug]);
                @endphp
                <div class="pf-template-card {{ $isSelected ? 'is-active' : '' }}" id="tpl-card-{{ $tpl->id }}">
                    <div class="pf-thumb-wrapper">
                        <img src="{{ $thumb }}" alt="{{ $tpl->name }}" loading="lazy">
                        <span class="pf-card-free-tag">
                            <i class="ri-sparkling-fill text-warning"></i> Ready to use
                        </span>
                        <div class="pf-card-selected-tag" id="selected-badge-{{ $tpl->id }}" style="{{ $isSelected ? '' : 'display: none;' }}">
                            <i class="ri-checkbox-circle-fill"></i> Active
                        </div>
                    </div>

                    <div class="pf-card-body">
                        <div class="pf-card-title-row">
                            <h5 class="pf-template-name">{{ $tpl->name }}</h5>
                            <span class="pf-template-style-pill">{{ $tpl->style ?: $tpl->category }}</span>
                        </div>

                        <p class="pf-template-desc">
                            {{ $tpl->description ?: 'Modern, responsive portfolio design crafted to highlight your technical projects, experience, and contact info.' }}
                        </p>

                        <div class="pf-card-actions">
                            <button type="button"
                                    class="pf-btn-preview"
                                    onclick="previewTemplateInline('{{ $tpl->slug }}', '{{ addslashes($tpl->name) }}')">
                                <i class="ri-eye-line"></i> Preview
                            </button>
                            <button type="button"
                                    class="pf-btn-select js-btn-select"
                                    id="btn-select-{{ $tpl->id }}"
                                    onclick="selectPortfolioTemplate({{ $tpl->id }}, '{{ addslashes($tpl->name) }}', '{{ addslashes($tpl->style) }}', '{{ addslashes($tpl->category) }}', '{{ $tpl->slug }}', this)"
                                    @disabled($isSelected)>
                                @if($isSelected)
                                    <i class="ri-checkbox-circle-line"></i> Selected
                                @else
                                    <i class="ri-magic-line"></i> Use Design
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Section 3: Live Preview Sandbox -->
    <div class="pf-card pf-preview-section" id="livePreviewSection">
        <div class="pf-card-header">
            <div>
                <h5 class="pf-card-title">
                    <i class="ri-macbook-line"></i> {{ __('translate.Live Portfolio Preview Sandbox') }}
                </h5>
                <p class="text-muted small m-0 mt-1">
                    Previewing: <strong id="previewingTemplateName" class="text-info">{{ $selectedPortfolioTemplate?->name ?? 'Modern Portfolio' }}</strong> with your real portfolio data.
                </p>
            </div>

            <!-- Toolbar Controls -->
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <!-- Data Mode Switch -->
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-info active" id="btnModeReal" onclick="switchPreviewMode('user')">
                        <i class="ri-user-line"></i> My Real Data
                    </button>
                    <button type="button" class="btn btn-outline-secondary text-white" id="btnModeDemo" onclick="switchPreviewMode('dummy')">
                        <i class="ri-magic-line"></i> Sample Demo Data
                    </button>
                </div>

                <!-- Device Width Switch -->
                <div class="pf-device-btns">
                    <button type="button" class="pf-device-btn is-active" id="dev-desktop" onclick="setDevice('desktop')">
                        <i class="ri-computer-line"></i> Desktop
                    </button>
                    <button type="button" class="pf-device-btn" id="dev-tablet" onclick="setDevice('tablet')">
                        <i class="ri-tablet-line"></i> Tablet
                    </button>
                    <button type="button" class="pf-device-btn" id="dev-mobile" onclick="setDevice('mobile')">
                        <i class="ri-smartphone-line"></i> Mobile
                    </button>
                </div>

                <!-- Fullscreen button -->
                <a id="btnOpenFullscreen"
                   href="{{ profile_route('user.cv.portfolio-templates.preview', ['slug' => $selectedPortfolioTemplate?->slug ?? 'modern']) }}"
                   target="_blank"
                   class="btn btn-sm btn-outline-light">
                    <i class="ri-fullscreen-line"></i> Fullscreen
                </a>
            </div>
        </div>

        <div class="pf-preview-box">
            <div class="pf-iframe-wrap" id="previewIframeWrap">
                <iframe id="portfolioPreviewIframe"
                        src="{{ profile_route('user.cv.portfolio-templates.render', ['slug' => $selectedPortfolioTemplate?->slug ?? 'modern']) }}?user_data=1"
                        title="Live Portfolio Preview">
                </iframe>
            </div>
        </div>
    </div>
@endsection

@push('js_section')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    const selectTemplateUrl = "{{ profile_route('user.portfolio-settings.select-template') }}";
    const renderBaseUrl = "{{ profile_route('user.cv.portfolio-templates.render', ['slug' => '__SLUG__']) }}";
    const previewBaseUrl = "{{ profile_route('user.cv.portfolio-templates.preview', ['slug' => '__SLUG__']) }}";

    let currentSlug = "{{ $selectedPortfolioTemplate?->slug ?? 'modern' }}";
    let currentDataMode = 'user';

    function copyPortfolioUrl(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('success', 'URL copied to clipboard!');
            }).catch(() => fallbackCopy(text));
        } else {
            fallbackCopy(text);
        }
    }

    function fallbackCopy(text) {
        const temp = document.createElement('input');
        temp.value = text;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
        showToast('success', 'URL copied to clipboard!');
    }

    function showToast(type, msg) {
        if (window.toastr && typeof window.toastr[type] === 'function') {
            window.toastr[type](msg);
        } else {
            alert(msg);
        }
    }

    function selectPortfolioTemplate(templateId, name, style, category, slug, btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="ri-loader-4-line ri-spin"></i> Applying...';

        fetch(selectTemplateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ template_id: templateId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update active tags and buttons
                document.querySelectorAll('.pf-template-card').forEach(card => card.classList.remove('is-active'));
                document.querySelectorAll('.pf-card-selected-tag').forEach(tag => tag.style.display = 'none');
                document.querySelectorAll('.js-btn-select').forEach(b => {
                    b.disabled = false;
                    b.innerHTML = '<i class="ri-magic-line"></i> Use Design';
                });

                const activeCard = document.getElementById('tpl-card-' + templateId);
                if (activeCard) activeCard.classList.add('is-active');

                const activeBadge = document.getElementById('selected-badge-' + templateId);
                if (activeBadge) activeBadge.style.display = 'flex';

                btn.disabled = true;
                btn.innerHTML = '<i class="ri-checkbox-circle-line"></i> Selected';

                // Update summary banner
                document.getElementById('activeDesignName').textContent = name;
                document.getElementById('activeDesignStyle').textContent = style;
                document.getElementById('activeDesignCategory').textContent = category;

                // Update preview
                previewTemplateInline(slug, name);

                showToast('success', data.message || 'Portfolio design updated successfully!');
            } else {
                btn.disabled = false;
                btn.innerHTML = '<i class="ri-magic-line"></i> Use Design';
                showToast('error', data.message || 'Could not select template.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="ri-magic-line"></i> Use Design';
            showToast('error', 'An error occurred while updating design.');
        });
    }

    function previewTemplateInline(slug, name) {
        currentSlug = slug;
        document.getElementById('previewingTemplateName').textContent = name;

        const iframe = document.getElementById('portfolioPreviewIframe');
        const url = renderBaseUrl.replace('__SLUG__', slug) + (currentDataMode === 'user' ? '?user_data=1' : '?dummy=1');
        iframe.src = url;

        const fsBtn = document.getElementById('btnOpenFullscreen');
        fsBtn.href = previewBaseUrl.replace('__SLUG__', slug);

        scrollToPreview();
    }

    function switchPreviewMode(mode) {
        currentDataMode = mode;
        const btnReal = document.getElementById('btnModeReal');
        const btnDemo = document.getElementById('btnModeDemo');

        if (mode === 'user') {
            btnReal.classList.add('active', 'btn-outline-info');
            btnReal.classList.remove('btn-outline-secondary');
            btnDemo.classList.remove('active', 'btn-outline-info');
            btnDemo.classList.add('btn-outline-secondary');
        } else {
            btnDemo.classList.add('active', 'btn-outline-info');
            btnDemo.classList.remove('btn-outline-secondary');
            btnReal.classList.remove('active', 'btn-outline-info');
            btnReal.classList.add('btn-outline-secondary');
        }

        const iframe = document.getElementById('portfolioPreviewIframe');
        iframe.src = renderBaseUrl.replace('__SLUG__', currentSlug) + (mode === 'user' ? '?user_data=1' : '?dummy=1');
    }

    function setDevice(device) {
        document.querySelectorAll('.pf-device-btn').forEach(btn => btn.classList.remove('is-active'));
        document.getElementById('dev-' + device).classList.add('is-active');

        const wrap = document.getElementById('previewIframeWrap');
        if (device === 'tablet') {
            wrap.style.maxWidth = '768px';
            wrap.style.borderRadius = '14px';
        } else if (device === 'mobile') {
            wrap.style.maxWidth = '390px';
            wrap.style.borderRadius = '24px';
        } else {
            wrap.style.maxWidth = '100%';
            wrap.style.borderRadius = '0';
        }
    }

    function scrollToPreview() {
        const el = document.getElementById('livePreviewSection');
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
</script>
@endpush
