@extends('layout')

@section('title')
    <title>{{ __('translate.Reset Password  ||') }} {{ config('app.name') }}</title>
@endsection

@section('front-content')
    <header class="site-header signup_header optech-header-section" id="sticky-menu">
        <div class="optech-header-bottom bg-white">
            <div class="container">
                <nav class="navbar site-navbar">
                    <div class="brand-logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset($general_setting->logo) }}" alt="logo" class="light-version-logo">
                        </a>
                    </div>

                    @include('frontend.templates.layouts._menu_nav')

                    <div class="mobile-menu-trigger">
                        <span></span>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    @php
        $currentLang = session()->get('front_lang');
        $loginContent = getContent('login_section.content', true);
    @endphp

    <section class="sign_up">
        <div class="sign_up_df">
            <div class="sign_up_thumb">
                <img src="{{ asset($general_setting->login_page_bg) }}" alt="thumb" />
                <a href="{{ route('home') }}" class="signup_logo">
                    <img src="{{ asset($general_setting->white_logo) }}" alt="logo" />
                </a>
            </div>

            <div class="sign_up_right">
                <div class="signup_text">
                    <h3>{{ __('translate.Reset your password') }}</h3>
                    <p>{{ __('translate.Forgot password? Enter your email for reset link.') }}</p>
                </div>

                <form class="sign_up_form seller_login" method="POST" action="{{ route('user.send-forget-password') }}">
                    @csrf
                    <div class="d_profile_setting_from_item">
                        <div class="optech-checkout-field">
                            <label>{{ __('translate.Email Address*') }}</label>
                            <input type="email" placeholder="{{ __('translate.Email') }}" name="email" value="{{ old('email') }}"/>
                        </div>
                    </div>

                    @if($general_setting->recaptcha_status==1)
                        <div class="sign_up_form_item">
                            <div class="g-recaptcha" data-sitekey="{{ $general_setting->recaptcha_site_key }}"></div>
                        </div>
                    @endif

                    <div class="sign_up_form_btm">
                        <button class="optech-default-btn" data-text="{{ __('translate.Continue') }}" type="submit">
                            <span class="btn-wraper">{{ __('translate.Continue') }}</span>
                        </button>
                    </div>

                    <div class="sign_up_form_btm_text">
                        <p>
                            <span><a href="{{ route('user.login') }}">{{ __('translate.Back to login') }}</a></span>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('js_section')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
