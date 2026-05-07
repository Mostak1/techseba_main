@extends('master_layout')
@section('new-layout')
    <div class="optech-breadcrumb">
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
                                        @if(!empty($team->facebook))
                                            <li><a href="{{ $team->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                        @endif

                                        @if(!empty($team->twitter))
                                            <li><a href="{{ $team->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                        @endif

                                        @if(!empty($team->linkedin))
                                            <li><a href="{{ $team->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                        @endif

                                        @if(!empty($team->instagram))
                                            <li><a href="{{ $team->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                        @endif
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
