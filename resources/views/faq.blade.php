@extends('master_layout')

@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}">
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}">
@endsection

@section('new-layout')

    @php
        $currentLang = session()->get('front_lang');
        $faqContent = getContent('faq_section.content', true);
    @endphp

    <div class="optech-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
        <div class="container">
            <h1 class="post__title">{{ __($pageTitle) }}</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>

                    <li aria-current="page">{{ __($pageTitle) }}</li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="section accordion-page">
        <div class="container">
            <div class="optech-accordion-column">
                <div class="optech-accordion-wrap mt-0 init-wrap">
                    @foreach($faqs as $faq)
                    <div class="optech-accordion-item {{ $loop->first ? 'open' : '' }}">
                        <div class="optech-accordion-header init-header">
                            <h5> <span> {{ __('translate.Q') }} </span>{{ $loop->iteration }}. {{ $faq->translate?->question }}</h5>
                        </div>
                        <div class="optech-accordion-body init-body">
                            <p>{!! clean($faq->translate?->answer) !!}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- End section -->

    <div class="section optech-section-padding-bottom">
        <div class="container">
            <div class="optech-default-content sm-mw">
                <h2>{{ getTranslatedValue($faqContent, 'heading', $currentLang) }}</h2>
                <p>{{ getTranslatedValue($faqContent, 'description', $currentLang) }}</p>
                <div class="optech-extra-mt" data-aos="fade-up" data-aos-duration="800">
                    <a class="optech-default-btn optech-light-btn" href="{{ route('contact-us') }}" data-text="{{ getTranslatedValue($faqContent, 'button_text', $currentLang) }}"> <span
                            class="btn-wraper">{{ getTranslatedValue($faqContent, 'button_text', $currentLang) }}</span> </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End section -->

@endsection
