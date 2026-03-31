
@extends('master_layout')
@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}">
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}">
@endsection
@php
    $currentLang = session()->get('front_lang');
    $getProcessData = getContent('main_demo_process_section.content', true);
@endphp
@section('new-layout')
    <div class="optech-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
        <div class="container">
            <h1 class="post__title">{{ __('translate.Our Services') }}</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                    <li aria-current="page"> {{ __('translate.Our Services') }}</li>
                </ul>
            </nav>

        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="section optech-section-padding5">
        @include('frontend.templates.layouts.process_section')
    </div>
    @php
        $currentLang = session()->get('front_lang');
        $getServiceContent = getContent('main_demo_service_section.content', true)
    @endphp
    <!-- End section -->
    <div class="section optech-section-padding2 bg-light1">
        <div class="container">
            <div class="optech-section-title center">
                <h2></h2>
            </div>
            <div class="row">

                @foreach($services_list as $index => $service)

                <div class="col-lg-6" data-aos="fade-up" data-aos-duration="600">
                    <div class="optech-iconbox-wrap style-two">
                        <div class="optech-iconbox-icon">
                            <img src="{{ asset($service->thumb_image) }}" alt="Image">
                        </div>
                        <div class="optech-iconbox-data">
                            <h5>{{ $service->translate?->title }}</h5>
                            <p>{{ $service->translate?->short_description }}</p>
                            <a class="optech-icon-btn" href="{{ route('service', $service->slug) }}"><i class="icon-show ri-arrow-right-line"></i>
                                <span>{{ __('translate.Learn More') }}</span> <i class="icon-hide ri-arrow-right-line"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End section -->
@endsection


