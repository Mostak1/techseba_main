@extends('layout')

@section('title')
<title>{{ config('app.name', __('Sign In')) }} | {{ __('translate.Login') }}</title>
@endsection

@push('style_section')
<style>
    /* =========================================================
       SMART AUTH - TECHSEBA MODERN DARK THEME
       ========================================================= */
    :root {
        --smart-bg: #070B19;
        --smart-card: rgba(14, 22, 48, 0.82);
        --smart-card-border: rgba(0, 212, 255, 0.18);
        --smart-input-bg: rgba(9, 15, 33, 0.85);
        --smart-input-border: rgba(255, 255, 255, 0.12);
        --smart-accent-cyan: #00D4FF;
        --smart-accent-purple: #7B4FFF;
        --smart-accent-blue: #3B82F6;
        --smart-text-white: #FFFFFF;
        --smart-text-muted: #8E9EB8;
    }

    body {
        background-color: var(--smart-bg) !important;
        overflow-x: hidden;
    }

    /* Ambient Glow Canvas */
    .smart-auth-wrapper {
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 40px 20px;
        background: radial-gradient(circle at 10% 20%, rgba(0, 212, 255, 0.08) 0%, transparent 45%),
                    radial-gradient(circle at 90% 80%, rgba(123, 79, 255, 0.12) 0%, transparent 50%),
                    #070B19;
    }

    .smart-auth-orb-1 {
        position: absolute;
        top: -80px;
        left: -80px;
        width: 420px;
        height: 420px;
        background: radial-gradient(circle, rgba(0, 212, 255, 0.14) 0%, transparent 70%);
        filter: blur(80px);
        pointer-events: none;
        z-index: 0;
    }

    .smart-auth-orb-2 {
        position: absolute;
        bottom: -80px;
        right: -80px;
        width: 460px;
        height: 460px;
        background: radial-gradient(circle, rgba(123, 79, 255, 0.18) 0%, transparent 70%);
        filter: blur(90px);
        pointer-events: none;
        z-index: 0;
    }

    /* Master Card */
    .smart-auth-card {
        width: 100%;
        max-width: 1140px;
        background: var(--smart-card);
        backdrop-filter: blur(28px);
        -webkit-backdrop-filter: blur(28px);
        border: 1px solid var(--smart-card-border);
        border-radius: 28px;
        box-shadow: 0 30px 90px -15px rgba(0, 0, 0, 0.85),
                    0 0 50px rgba(0, 212, 255, 0.06),
                    inset 0 1px 0 rgba(255, 255, 255, 0.12);
        overflow: hidden;
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: row;
        transition: all 0.3s ease;
    }

    /* Left Hero Visual */
    .smart-auth-visual {
        flex: 1.05;
        position: relative;
        overflow: hidden;
        min-height: 620px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 35px;
        background: #090e21;
    }

    .smart-auth-visual-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        opacity: 0.95;
        transition: transform 6s ease;
    }

    .smart-auth-card:hover .smart-auth-visual-img {
        transform: scale(1.03);
    }

    .smart-auth-visual-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(7, 11, 25, 0.25) 0%, rgba(7, 11, 25, 0.7) 100%);
        z-index: 1;
    }

    .smart-visual-top {
        position: relative;
        z-index: 2;
    }

    .smart-brand-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        background: rgba(7, 11, 25, 0.65);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .smart-brand-link:hover {
        background: rgba(0, 212, 255, 0.15);
        border-color: rgba(0, 212, 255, 0.4);
        transform: translateY(-2px);
    }

    .smart-brand-link img {
        height: 32px;
        width: auto;
    }

    .smart-brand-link span {
        color: #fff;
        font-size: 13px;
        font-weight: 500;
    }

    .smart-visual-bottom {
        position: relative;
        z-index: 2;
    }

    .smart-visual-glass-badge {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        background: rgba(14, 22, 48, 0.75);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(0, 212, 255, 0.25);
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .smart-pulsing-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #10B981;
        box-shadow: 0 0 10px #10B981;
        animation: smartPulse 2s infinite;
    }

    @keyframes smartPulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .smart-visual-badge-text {
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    /* Right Form Area */
    .smart-auth-form-wrap {
        flex: 1.15;
        padding: 50px 55px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: rgba(14, 22, 48, 0.65);
    }

    .smart-form-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .smart-auth-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        background: rgba(0, 212, 255, 0.1);
        border: 1px solid rgba(0, 212, 255, 0.3);
        border-radius: 30px;
        color: var(--smart-accent-cyan);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .smart-home-link {
        color: var(--smart-text-muted);
        text-decoration: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
    }

    .smart-home-link:hover {
        color: var(--smart-accent-cyan);
        transform: translateX(-2px);
    }

    .smart-auth-title {
        font-size: 32px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
        font-family: 'Space Grotesk', sans-serif;
        line-height: 1.25;
    }

    .smart-auth-title .gradient-text {
        background: linear-gradient(135deg, #00D4FF, #9055FF);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .smart-auth-subtitle {
        color: var(--smart-text-muted);
        font-size: 14px;
        margin-bottom: 32px;
        line-height: 1.5;
    }

    /* Input Field Styling */
    .smart-form-group {
        margin-bottom: 22px;
    }

    .smart-form-label {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #CCD6E5;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        letter-spacing: 0.2px;
    }

    .smart-form-label i {
        color: var(--smart-accent-cyan);
        font-size: 15px;
    }

    .smart-form-label .required-star {
        color: #FF5E5E;
    }

    .smart-input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .smart-input-icon {
        position: absolute;
        left: 16px;
        color: #6C7D9C;
        font-size: 18px;
        pointer-events: none;
        transition: color 0.25s ease;
    }

    .smart-input {
        width: 100% !important;
        height: 52px !important;
        background: var(--smart-input-bg) !important;
        border: 1px solid var(--smart-input-border) !important;
        border-radius: 12px !important;
        padding: 12px 18px 12px 48px !important;
        color: #FFFFFF !important;
        font-size: 14.5px !important;
        font-family: 'Inter', sans-serif !important;
        transition: all 0.25s ease !important;
        outline: none !important;
    }

    .smart-input::placeholder {
        color: #5D6F8F !important;
        font-size: 14px !important;
    }

    .smart-input:focus {
        border-color: var(--smart-accent-cyan) !important;
        background: rgba(14, 23, 50, 0.95) !important;
        box-shadow: 0 0 16px rgba(0, 212, 255, 0.28) !important;
    }

    .smart-input:focus + .smart-input-icon,
    .smart-input-container:focus-within .smart-input-icon {
        color: var(--smart-accent-cyan);
    }

    /* Chrome/Safari Autofill Fix */
    .smart-input:-webkit-autofill,
    .smart-input:-webkit-autofill:hover, 
    .smart-input:-webkit-autofill:focus {
        -webkit-text-fill-color: #FFFFFF !important;
        -webkit-box-shadow: 0 0 0px 1000px #090F21 inset !important;
        transition: background-color 5000s ease-in-out 0s;
        border-color: rgba(0, 212, 255, 0.3) !important;
    }

    /* Password Toggle Button */
    .smart-password-toggle-btn {
        position: absolute;
        right: 14px;
        background: transparent;
        border: none;
        color: #7A8CA8;
        font-size: 18px;
        cursor: pointer;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .smart-password-toggle-btn:hover {
        color: var(--smart-accent-cyan);
        background: rgba(255, 255, 255, 0.05);
    }

    /* Remember & Forgot Flex */
    .smart-extra-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: -4px;
        margin-bottom: 26px;
    }

    .smart-checkbox-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        user-select: none;
        margin: 0;
    }

    .smart-checkbox {
        width: 17px !important;
        height: 17px !important;
        accent-color: var(--smart-accent-cyan) !important;
        border-radius: 4px;
        cursor: pointer;
        margin: 0;
    }

    .smart-checkbox-text {
        color: #A3B3CC;
        font-size: 13.5px;
    }

    .smart-forgot-link {
        color: var(--smart-accent-cyan);
        font-size: 13.5px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .smart-forgot-link:hover {
        color: #6fe5ff;
        text-decoration: underline;
        text-shadow: 0 0 8px rgba(0, 212, 255, 0.5);
    }

    /* Main Submit Button */
    .smart-submit-btn {
        width: 100%;
        height: 52px;
        background: linear-gradient(135deg, #00D4FF 0%, #3B82F6 50%, #7B4FFF 100%);
        border: none;
        border-radius: 12px;
        color: #FFFFFF;
        font-size: 16px;
        font-weight: 600;
        font-family: 'Space Grotesk', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 6px 20px rgba(0, 212, 255, 0.35);
    }

    .smart-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 212, 255, 0.55), 0 0 20px rgba(123, 79, 255, 0.35);
        color: #FFFFFF;
    }

    .smart-submit-btn:active {
        transform: translateY(1px);
    }

    .smart-submit-btn i {
        font-size: 18px;
        transition: transform 0.2s ease;
    }

    .smart-submit-btn:hover i {
        transform: translateX(4px);
    }

    /* Divider */
    .smart-divider {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 26px 0 22px 0;
    }

    .smart-divider-line {
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.12), transparent);
    }

    .smart-divider-text {
        color: #7284A3;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    /* Social Buttons */
    .smart-social-wrap {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .smart-social-btn {
        width: 100%;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 12px;
        color: #FFFFFF !important;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .smart-social-btn:hover {
        background: rgba(255, 255, 255, 0.09);
        border-color: rgba(0, 212, 255, 0.4);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
        color: #FFFFFF !important;
    }

    /* Footer Sign Up Link */
    .smart-auth-footer {
        text-align: center;
        margin-top: 26px;
    }

    .smart-auth-footer p {
        color: var(--smart-text-muted);
        font-size: 14px;
        margin: 0;
    }

    .smart-auth-signup-link {
        color: var(--smart-accent-cyan);
        font-weight: 600;
        text-decoration: none;
        margin-left: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
    }

    .smart-auth-signup-link:hover {
        color: #78e5ff;
        text-decoration: underline;
        transform: translateX(2px);
    }

    /* Modal Dark Overrides */
    .smart-dark-modal .modal-content {
        background: #0D142E !important;
        border: 1px solid rgba(0, 212, 255, 0.25) !important;
        border-radius: 20px !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8) !important;
        color: #fff !important;
    }

    .smart-dark-modal .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 20px 25px !important;
    }

    .smart-dark-modal .modal-body {
        padding: 25px !important;
    }

    .smart-dark-modal .btn-close {
        filter: invert(1) brightness(200%);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .smart-auth-card {
            flex-direction: column;
            max-width: 540px;
        }

        .smart-auth-visual {
            min-height: 260px;
            padding: 25px;
        }

        .smart-auth-form-wrap {
            padding: 35px 25px;
        }

        .smart-auth-title {
            font-size: 26px;
        }
    }

    @media (max-width: 575px) {
        .smart-auth-wrapper {
            padding: 15px;
        }

        .smart-auth-card {
            border-radius: 20px;
        }

        .smart-auth-form-wrap {
            padding: 25px 20px;
        }
    }
</style>
@endpush

@section('front-content')
<!-- forget password modal -->
<div class="modal forget_pass_modal smart-dark-modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset($general_setting->white_logo ?? $general_setting->logo) }}" alt="logo" style="height: 32px;" />
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 class="text-white mb-2" style="font-family: 'Space Grotesk', sans-serif;">{{ __('translate.Reset your password') }}</h4>
                <p class="text-muted small mb-4">
                    {{ __('translate.Forgot password? Enter your email for reset link.') }}
                </p>

                <form method="POST" action="{{ route('user.send-forget-password') }}">
                    @csrf
                    <div class="smart-form-group">
                        <label class="smart-form-label">{{ __('translate.Email Address*') }}</label>
                        <div class="smart-input-container">
                            <span class="smart-input-icon"><i class="ri-mail-line"></i></span>
                            <input type="email" class="smart-input" placeholder="name@example.com" name="email" required />
                        </div>
                    </div>
                    @if($general_setting->recaptcha_status==1)
                        <div class="mb-3">
                            <div class="g-recaptcha" data-sitekey="{{ $general_setting->recaptcha_site_key }}"></div>
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="javascript:;" data-bs-dismiss="modal" class="text-muted small text-decoration-none">
                            <i class="ri-arrow-left-line"></i> {{ __('translate.Back to login') }}
                        </a>
                        <button type="submit" class="smart-submit-btn" style="width: auto; padding: 10px 24px; font-size: 14px;">
                            <span>{{ __('translate.Continue') }}</span>
                            <i class="ri-arrow-right-line"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@php
 $currentLang = session()->get('front_lang');
 $loginContent = getContent('login_section.content', true);
 $heading = getTranslatedValue($loginContent, 'heading', $currentLang);
 $description = getTranslatedValue($loginContent, 'description', $currentLang);
@endphp

<!-- Smart Auth Section Start -->
<div class="smart-auth-wrapper">
    <div class="smart-auth-orb-1"></div>
    <div class="smart-auth-orb-2"></div>

    <div class="smart-auth-card">
        <!-- Left Side: Visual & Brand Showcase -->
        <div class="smart-auth-visual">
            <img src="{{ asset($general_setting->login_page_bg) }}" alt="TechSeba Auth Visual" class="smart-auth-visual-img" />
            <div class="smart-auth-visual-overlay"></div>

            <div class="smart-visual-top">
                <a href="{{ route('home') }}" class="smart-brand-link">
                    <img src="{{ asset($general_setting->white_logo) }}" alt="{{ config('app.name') }}" />
                    <span>One Click Solution</span>
                </a>
            </div>

            <div class="smart-visual-bottom">
                <div class="smart-visual-glass-badge">
                    <div class="smart-pulsing-dot"></div>
                    <span class="smart-visual-badge-text">Secure Access • One Click Solution</span>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="smart-auth-form-wrap">
            <div class="smart-form-header-bar">
                <span class="smart-auth-badge">
                    <i class="ri-shield-keyhole-line"></i> {{ __('translate.User Login') }}
                </span>
                <a href="{{ route('home') }}" class="smart-home-link">
                    <i class="ri-home-4-line"></i> {{ __('translate.Home') }}
                </a>
            </div>

            <h2 class="smart-auth-title">
                {{ $heading ?: __('translate.Login for an account') }}
            </h2>
            <p class="smart-auth-subtitle">
                {{ $description ?: __('translate.Welcome to TechSeba. Please enter your credentials to access your dashboard.') }}
            </p>

            <form class="seller_login" action="{{ route('user.store-login') }}" method="POST">
                @csrf
                
                <!-- Email Field -->
                <div class="smart-form-group">
                    <label class="smart-form-label" for="email">
                        <i class="ri-mail-line"></i> {{ __('translate.Email Address') }} <span class="required-star">*</span>
                    </label>
                    <div class="smart-input-container">
                        <span class="smart-input-icon"><i class="ri-at-line"></i></span>
                        <input type="email" id="email" name="email" class="smart-input" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="email" />
                    </div>
                </div>

                <!-- Password Field -->
                <div class="smart-form-group">
                    <label class="smart-form-label" for="password">
                        <i class="ri-lock-2-line"></i> {{ __('translate.Password') }} <span class="required-star">*</span>
                    </label>
                    <div class="smart-input-container">
                        <span class="smart-input-icon"><i class="ri-key-2-line"></i></span>
                        <input type="password" id="password" name="password" class="smart-input" placeholder="••••••••••••" required autocomplete="current-password" />
                        <button type="button" class="smart-password-toggle-btn" id="togglePasswordBtn" title="Toggle password visibility">
                            <i class="ri-eye-line" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="smart-extra-row">
                    <label class="smart-checkbox-label" for="rememberMe">
                        <input type="checkbox" name="remember" class="smart-checkbox" id="rememberMe">
                        <span class="smart-checkbox-text">{{ __('translate.Remember me') }}</span>
                    </label>

                    <a href="{{ route('user.reset-password') }}" class="smart-forgot-link" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        {{ __('translate.Forgot Password?') }}
                    </a>
                </div>

                <!-- reCAPTCHA if enabled -->
                @if($general_setting->recaptcha_status==1)
                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="{{ $general_setting->recaptcha_site_key }}"></div>
                    </div>
                @endif

                <!-- Submit Button -->
                <button type="submit" class="smart-submit-btn">
                    <span>{{ __('translate.Login') }}</span>
                    <i class="ri-arrow-right-line"></i>
                </button>

                <!-- Social Sign In Options -->
                @if ($general_setting->is_facebook == 1 || $general_setting->is_gmail == 1)
                    <div class="smart-divider">
                        <span class="smart-divider-line"></span>
                        <span class="smart-divider-text">OR SIGN IN WITH</span>
                        <span class="smart-divider-line"></span>
                    </div>

                    <div class="smart-social-wrap">
                        @if ($general_setting->is_gmail == 1)
                        <a href="{{ route('user.login-google') }}" class="smart-social-btn">
                            <svg width="20" height="20" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.6258 11.2139C20.6258 10.4225 20.5603 9.84497 20.4185 9.24609H11.1973V12.818H16.6099C16.5008 13.7057 15.9115 15.0425 14.602 15.9408L14.5836 16.0603L17.4992 18.2738L17.7012 18.2936C19.5563 16.6145 20.6258 14.1441 20.6258 11.2139Z" fill="#4285F4" />
                                <path d="M11.1976 20.6248C13.8494 20.6248 16.0755 19.7692 17.7016 18.2934L14.6024 15.9405C13.773 16.5073 12.6599 16.903 11.1976 16.903C8.60043 16.903 6.39609 15.224 5.61031 12.9033L5.49513 12.9129L2.46347 15.2122L2.42383 15.3202C4.03888 18.4644 7.35634 20.6248 11.1976 20.6248Z" fill="#34A853" />
                                <path d="M5.60908 12.9038C5.40174 12.305 5.28175 11.6632 5.28175 11.0002C5.28175 10.3371 5.40174 9.69549 5.59817 9.09661L5.59268 8.96906L2.52303 6.63281L2.42259 6.67963C1.75695 7.98437 1.375 9.44953 1.375 11.0002C1.375 12.5509 1.75695 14.016 2.42259 15.3207L5.60908 12.9038Z" fill="#FBBC05" />
                                <path d="M11.1977 5.09664C13.0419 5.09664 14.2859 5.87733 14.9953 6.52974L17.7671 3.8775C16.0648 2.32681 13.8494 1.375 11.1977 1.375C7.35637 1.375 4.03889 3.53526 2.42383 6.6794L5.59942 9.09638C6.39612 6.77569 8.60047 5.09664 11.1977 5.09664Z" fill="#EB4335" />
                            </svg>
                            <span>{{ __('translate.Sign In with Google') }}</span>
                        </a>
                        @endif

                        @if ($general_setting->is_facebook == 1)
                        <a href="{{ route('user.login-facebook') }}" class="smart-social-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 3H15C12.2386 3 10 5.23858 10 8V10H6V14H10V21H14V14H18V10H14V8C14 7.44772 14.4477 7 15 7H18V3Z" fill="#1877F2"/>
                            </svg>
                            <span>{{ __('translate.Sign In with Facebook') }}</span>
                        </a>
                        @endif
                    </div>
                @endif

                <!-- Sign Up Footer -->
                <div class="smart-auth-footer">
                    <p>
                        {{ __('translate.Don’t have an account yet?') }}
                        <a href="{{ route('user.register') }}" class="smart-auth-signup-link">
                            {{ __('translate.Sign Up') }} <i class="ri-arrow-right-line"></i>
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Smart Auth Section End -->
@endsection

@push('js_section')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', function() {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                toggleIcon.classList.toggle('ri-eye-line', !isPassword);
                toggleIcon.classList.toggle('ri-eye-off-line', isPassword);
            });
        }
    });
</script>

@if (env('APP_MODE') == 'DEMO')
<script>
    (function($) {
        "use strict";
        $(document).ready(function() {
            $(".seller_login").on("click", function(e) {
                if ($("#email").val() === '') {
                    $("#email").val('seller@gmail.com');
                }
                if ($("#password").val() === '') {
                    $("#password").val('1234');
                }
            });
        });
    })(jQuery);
</script>
@endif
@endpush
