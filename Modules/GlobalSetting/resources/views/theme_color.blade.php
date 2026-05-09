@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Theme Colors') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Theme Colors') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Website Setup') }} >> {{ __('translate.Theme Colors') }}</p>
@endsection

@section('body-content')
    <!-- crancy Dashboard -->
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <!-- Dashboard Inner -->
                        <div class="crancy-dsinner">
                            <form action="{{ route('admin.update-theme-color') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <!-- Product Card -->
                                        <div class="crancy-product-card">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Theme Colors') }}</h4>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Heading Color') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_heading_color" value="{{ $general_setting->theme_heading_color }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Body Color') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_body_color" value="{{ $general_setting->theme_body_color }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Accent Color') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_accent_color" value="{{ $general_setting->theme_accent_color }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.White Color') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_white_color" value="{{ $general_setting->theme_white_color }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Light Color 1') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_light_color1" value="{{ $general_setting->theme_light_color1 }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Light Color 2') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_light_color2" value="{{ $general_setting->theme_light_color2 }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Dark Background 1') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_dark_bg" value="{{ $general_setting->theme_dark_bg }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Dark Background 2') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_dark_bg2" value="{{ $general_setting->theme_dark_bg2 }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Dark Background 3') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_dark_bg3" value="{{ $general_setting->theme_dark_bg3 }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.White Background') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_white_bg" value="{{ $general_setting->theme_white_bg }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Accent Background') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_accent_bg" value="{{ $general_setting->theme_accent_bg }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Light Background 1') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_light_bg1" value="{{ $general_setting->theme_light_bg1 }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Light Background 2') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_light_bg2" value="{{ $general_setting->theme_light_bg2 }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25">
                                                        <label class="crancy__item-label">{{ __('translate.Light Background 3') }}</label>
                                                        <input class="crancy__item-input" type="color" name="theme_light_bg3" value="{{ $general_setting->theme_light_bg3 }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="crancy-btn mg-top-25" type="submit">{{ __('translate.Update') }}</button>

                                        </div>
                                        <!-- End Product Card -->
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End Dashboard Inner -->
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End crancy Dashboard -->
@endsection
