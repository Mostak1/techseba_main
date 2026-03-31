@extends('master_layout')
@section('new-layout')
    <div class="optech-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
        <div class="container">
            <h1 class="post__title">{{ __($pageTitle) }}</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                    <li><a href="{{ route('teams') }}">{{ __('translate.Our Teams') }}</a></li>
                    <li aria-current="page">{{ __($pageTitle) }}</li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- End breadcrumb -->


    <div class="section optech-section-padding">
        <div class="container">
            <div class="optech-team-single-wrap">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="optech-team-single-thumb" data-aos="fade-up" data-aos-duration="800">
                            <img src="{{ asset($team->image) }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-1">
                        <div class="optech-team-single-content">
                            <h2>{{ $team->translate->name }}</h2>
                            <span>{{ $team->translate->designation }}</span>
                            <p>{!! clean($team->translate->description) !!}</p>
                            <div class="optech-footer-info dark-color">
                                <ul>
                                    <li><a href="tel:{{ $team->phone_number }}"><i class="ri-phone-fill"></i>{{ $team->phone_number }}</a></li>
                                    <li><a href="mailto:{{ $team->mail }}"><i class="ri-mail-fill"></i>{{ $team->mail }}</a></li>
                                </ul>
                            </div>
                            <div class="optech-extra-mt">
                                <div class="optech-social-icon-box style-two">
                                    <ul>
                                        <li>
                                            <a href="{{ $team->facebook }}">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ $team->linkedin }}">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ $team->twitter }}">
                                                <i class="ri-twitter-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ $team->instagram }}">
                                                <i class="ri-instagram-fill"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="optech-main-form p-0">
                            @include('frontend.templates.layouts.contact_form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End section -->

@endsection
