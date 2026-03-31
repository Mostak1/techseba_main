@extends('user.dashboard_layout')
@section('title')
    <title>{{ __('translate.User || Change Password') }}</title>
@endsection

@section('breadcrumb')
    <h1 class="post__title">{{ __('translate.Change Password') }}</h1>
    <nav class="breadcrumbs">
        <ul>
            <li><a href="{{ route('user.dashboard') }}">{{ __('translate.Dashboard') }}</a></li>
            <li> {{ __('translate.Change Password') }} </li>
        </ul>
    </nav>
@endsection
@section('dashboard-content')

    <div class="d_change_password_box">
        <div class="d_change_password_box_df">
            <div class="d_change_password_box_df_left">
                <div class="d_change_password_box_text">
                    <h4>{{ __('translate.Update your Password') }}</h4>
                    <p>{{ __('translate.Your email address will not be published. Required fields are marked *') }}</p>
                </div>

                    <form class="d_change_password_box_form" method="POST" action="{{ route('user.update-password') }}">
                        @csrf
                        @method('PUT')
                    <div class="d_profile_setting_from_item">
                        <div class="optech-checkout-field">
                            <label>{{ __('translate.Current Password*') }}</label>
                            <input
                                type="password"
                                placeholder="*******"
                                name="current_password"
                            />

                        </div>
                    </div>
                    <div class="d_profile_setting_from_item">
                        <div class="optech-checkout-field">
                            <label>{{ __('translate.New Password*') }}</label>
                            <input
                                type="password"
                                placeholder="*******"
                                name="password"
                            />

                        </div>
                    </div>
                    <div class="d_profile_setting_from_item">
                        <div class="optech-checkout-field">
                            <label>{{ __('translate.Confirm Password*') }}</label>
                            <input
                                type="password"
                                placeholder="*******"
                                name="password_confirmation"
                            />

                        </div>
                    </div>
                    <div class="d_profile_setting_from_btn">
                        <button class="optech-default-btn" data-text="{{ __('translate.Update Password') }}">
                            <span class="btn-wraper">{{ __('translate.Update Password') }}</span>
                        </button>

                        <a href="" class="optech-default-btn two" data-text="{{ __('translate.Cancel') }}">
                            <span class="btn-wraper">{{ __('translate.Cancel') }}</span>
                        </a>

                    </div>
                </form>
            </div>

            <div class="d_change_password_box_thumb">
                <img src="{{ asset($general_setting->login_page_bg) }}" alt="thumb">
            </div>
        </div>
    </div>
<!-- Main -->
@endsection
