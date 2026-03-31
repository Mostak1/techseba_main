@extends('layout')

@section('title')
    <title>{{ config('app.name', __('Sign Up')) }}</title>
@endsection
@section('front-content')

    <!-- sign up start  -->
    <section class="sign_up">
        <div class="sign_up_df">
            <div class="sign_up_thumb">
                <img src="{{ asset($general_setting->login_page_bg) }}" alt="thumb">
                <a href="{{ route('home') }}" class="signup_logo">
                    <img src="{{ asset($general_setting->white_logo) }}" alt="logo">
                </a>
            </div>

            <div class="sign_up_right">
                <div class="signup_text">
                    <h3>{{ __('translate.Sign up for an account') }}</h3>
                    <p>
                        {{ __('translate.Welcome to ') }} {{ config('app.name') }}
                    </p>
                </div>
                <form class="sign_up_form" method="POST" action="{{ route('user.store-register') }}">
                    @csrf
                    <div class="d_profile_setting_from_item">
                        <div class="optech-checkout-field">
                            <label>{{ __('translate.Full Name') }}</label>
                            <input type="text" placeholder="{{ __('translate.Full Name') }}" name="name" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="d_profile_setting_from_item">
                        <div class="optech-checkout-field">
                            <label>{{ __('translate.Email Address*') }}</label>
                            <input type="text" placeholder="{{ __('translate.Email Address') }}" name="email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="d_profile_setting_from_item mb-0">
                        <div class="optech-checkout-field">
                            <label>{{ __('translate.Password*') }}</label>
                            <input type="password" placeholder="********" name="password">

                        </div>
                        <div class="optech-checkout-field">
                            <label>{{ __('translate.Confirm Password*') }}</label>
                            <input type="password" placeholder="*********"  name="password_confirmation">

                        </div>
                    </div>
                    @if($general_setting->recaptcha_status==1)
                        <div class="optech-checkout-field">
                            <div class="g-recaptcha" data-sitekey="{{ $general_setting->recaptcha_site_key }}"></div>
                        </div>
                    @endif
                    <div class="sign_up_form_text">
                        <p>{{ __('translate.Or with email') }}</p>
                    </div>

                    <div class="sign_up_form_df">
                        @if ($general_setting->is_facebook == 1)
                        <a href="{{ route('user.login-facebook') }}" class="sign_up_form_btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 3H15C12.2386 3 10 5.23858 10 8V10H6V14H10V21H14V14H18V10H14V8C14 7.44772 14.4477 7 15 7H18V3Z" fill="#405FF2"/>
                            </svg>
                            {{ __('translate.Sign Up with Facebook') }}
                        </a>
                        @endif

                        @if ($general_setting->is_gmail == 1)
                        <a href="{{ route('user.login-google') }}" class="sign_up_form_btn">
                            <span>
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20.6258 11.2139C20.6258 10.4225 20.5603 9.84497 20.4185 9.24609H11.1973V12.818H16.6099C16.5008 13.7057 15.9115 15.0425 14.602 15.9408L14.5836 16.0603L17.4992 18.2738L17.7012 18.2936C19.5563 16.6145 20.6258 14.1441 20.6258 11.2139Z"
                                        fill="#4285F4" />
                                    <path
                                        d="M11.1976 20.6248C13.8494 20.6248 16.0755 19.7692 17.7016 18.2934L14.6024 15.9405C13.773 16.5073 12.6599 16.903 11.1976 16.903C8.60043 16.903 6.39609 15.224 5.61031 12.9033L5.49513 12.9129L2.46347 15.2122L2.42383 15.3202C4.03888 18.4644 7.35634 20.6248 11.1976 20.6248Z"
                                        fill="#34A853" />
                                    <path
                                        d="M5.60908 12.9038C5.40174 12.305 5.28175 11.6632 5.28175 11.0002C5.28175 10.3371 5.40174 9.69549 5.59817 9.09661L5.59268 8.96906L2.52303 6.63281L2.42259 6.67963C1.75695 7.98437 1.375 9.44953 1.375 11.0002C1.375 12.5509 1.75695 14.016 2.42259 15.3207L5.60908 12.9038Z"
                                        fill="#FBBC05" />
                                    <path
                                        d="M11.1977 5.09664C13.0419 5.09664 14.2859 5.87733 14.9953 6.52974L17.7671 3.8775C16.0648 2.32681 13.8494 1.375 11.1977 1.375C7.35637 1.375 4.03889 3.53526 2.42383 6.6794L5.59942 9.09638C6.39612 6.77569 8.60047 5.09664 11.1977 5.09664Z"
                                        fill="#EB4335" />
                                </svg>
                            </span>
                           {{ __('translate.Sign Up with Google') }}
                        </a>
                          @endif


                    </div>

                    <div class="sign_up_form_btm">
                        <button class="optech-default-btn" data-text="{{ __('translate.Sign Up') }}">
                            <span class="btn-wraper">{{ __('translate.Sign Up') }}</span>
                        </button>
                    </div>

                    <div class="sign_up_form_btm_text">
                        <p>
                            {{ __('translate.Don’t have an account yet?') }}
                            <span>
                                <a href="{{ route('user.login') }}">{{ __('translate.Login') }}</a>
                            </span>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- sign up end -->
@endsection


@push('js_section')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
