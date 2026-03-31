@extends('master_layout')
@section('title')
    <title>{{ __($project->translate->seo_title) }} || {{ __($project->translate->title) }}</title>
    <meta name="title" content="{{ __($project->translate->seo_title) }}">
    <meta name="description" content="{{ __($project->translate->seo_description) }}">
@endsection

@section('new-layout')
    @php
        $currentLang = session()->get('front_lang');
        $getSidebarCTAData = getContent('main_demo_sidebar_cta_section.content', true);
    @endphp
    <div class="optech-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image)}})">
        <div class="container">
            <h1 class="post__title">{{ __($project->translate->title) }}</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                    <li><a href="{{ route('portfolio') }}">{{ __('translate.Portfolio') }}</a></li>
                    <li aria-current="page"> {{ __($project->translate->title) }}</li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="section optech-section-padding">
        <div class="container">

            <div class="optech-pd-wrap">
                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <div class="optech-pd-thumb" data-aos="fade-up" data-aos-duration="800">
                <img src="{{ asset($project->thumb_image) }}" alt="Dardnak Image">
            </div>
                        <div class="optech-pd-content-wrap">
                            <div class="optech-service-details-item">
                                {!! clean($project->translate->description) !!}
                            </div>

                            <div class="optech-pd-content-item">
                                <div class="row">
                                    @foreach($project->gallery as $gallery)
                                    <div class="col-md-6" data-aos="fade-up" data-aos-duration="600">
                                        <img src="{{ asset($gallery->image) }}" alt="Gallery Image">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="optech-pd-sidebar-wrap">
                            <div class="optech-pd-sidebar">
                                <h5>{{ __('translate.Project Details') }}</h5>
                                <div class="optech-pd-sidebar-item">
                                    <span>{{ __('translate.Client:') }}</span>
                                    <p>{{ __($project->translate?->client_name) }}</p>
                                </div>
                                <div class="optech-pd-sidebar-item">
                                    <span>{{ __('translate.Category:') }}</span>
                                    <p>{{ $project->category?->translate->name }}</p>
                                </div>
                                <div class="optech-pd-sidebar-item">
                                    <span>{{ __('translate.Date:') }}</span>
                                    <p>{{ $project->project_date }}</p>
                                </div>
                                <div class="optech-pd-sidebar-item">
                                    <span>{{ __('translate.Website:') }}</span>
                                    <a href="{{ $project->website_url }}" target="_blank">{{ $project->website_url }}</a>
                                </div>
                                <div class="optech-social-icon-box">
                                    <ul>
                                        @if($project->project_fb)
                                            <li>
                                                <a href="{{ $project->project_fb }}">
                                                    <i class="ri-facebook-fill"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if($project->project_linkedin)
                                            <li>
                                                <a href="{{ $project->project_linkedin }}">
                                                    <i class="ri-linkedin-fill"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if($project->project_x)
                                            <li>
                                                <a href="{{ $project->project_x }}">
                                                    <i class="ri-twitter-fill"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if($project->project_instagram)
                                            <li>
                                                <a href="{{ $project->project_instagram }}">
                                                    <i class="ri-instagram-fill"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                            </div>
                            <div class="optech-service-contact" data-aos="fade-up" data-aos-duration="800">

                                <div class="optech-service-contact-icon">
                                    <span>
                                        <svg width="49" height="49" viewBox="0 0 49 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_541_338)">
                                            <mask id="mask0_541_338" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="49" height="49">
                                            <path d="M0.333984 0.3335H48.334V48.3335H0.333984V0.3335Z" fill="white"/>
                                            </mask>
                                            <g mask="url(#mask0_541_338)">
                                            <path d="M9.70898 31.8335H7.83398C4.72739 31.8335 2.20898 29.3151 2.20898 26.2085C2.20898 23.1019 4.72739 20.5835 7.83398 20.5835H9.70898V31.8335Z" stroke="white" stroke-width="2.6" stroke-miterlimit="10"/>
                                            <path d="M38.959 31.8335H40.834C43.9406 31.8335 46.459 29.3151 46.459 26.2085C46.459 23.1019 43.9406 20.5835 40.834 20.5835H38.959V31.8335Z" stroke="white" stroke-width="2.6" stroke-miterlimit="10"/>
                                            <path d="M5.95898 20.9036V20.5835C5.95898 10.2282 13.9786 2.2085 24.334 2.2085C34.6893 2.2085 42.709 10.2282 42.709 20.5835V20.9036" stroke="white" stroke-width="2.6" stroke-miterlimit="10"/>
                                            <path d="M28.084 42.7085C28.084 44.7795 26.4051 46.4585 24.334 46.4585C22.263 46.4585 20.584 44.7795 20.584 42.7085C20.584 40.6375 22.263 38.9585 24.334 38.9585C26.4051 38.9585 28.084 40.6375 28.084 42.7085Z" stroke="white" stroke-width="2.6" stroke-miterlimit="10"/>
                                            <path d="M28.084 42.7085H35.209C39.3511 42.7085 42.709 39.3507 42.709 35.2085V31.5134" stroke="white" stroke-width="2.6" stroke-miterlimit="10"/>
                                            <path d="M16.834 16.8335V28.0835H20.584L24.334 31.8335L28.084 28.0835H31.834V16.8335H16.834Z" stroke="white" stroke-width="2.6" stroke-miterlimit="10"/>
                                            </g>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_541_338">
                                            <rect width="48" height="48" fill="white" transform="translate(0.333984 0.333496)"/>
                                            </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                </div>
                                <h3>{{ getTranslatedValue($getSidebarCTAData, 'heading', $currentLang) }}</h3>
                                <p>{{ getTranslatedValue($getSidebarCTAData,'description', $currentLang) }}</p>
                                <a class="optech-default-btn" href="{{ route('contact-us') }}" data-text="{{ getTranslatedValue($getSidebarCTAData,'button_text', $currentLang) }}"><span
                                        class="btn-wraper">{{ getTranslatedValue($getSidebarCTAData,'button_text', $currentLang) }}</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="optech-post-navigation2">
                @if($previousProject)
                    <a href="{{ route('portfolio.show', $previousProject->slug) }}" class="p-nav-previous">
                        <div class="optech-post-icon">
                            <i class="ri-arrow-left-s-line"></i>
                        </div>
                        <div class="optech-post-data">
                            <p>{{ __('translate.Prev Project') }}</p>
                            <h5>{{ __($previousProject->translate->title) }}</h5>
                        </div>
                    </a>
                @endif

                @if($nextProject)
                    <a href="{{ route('portfolio.show', $nextProject->slug) }}" class="p-nav-next">
                        <div class="optech-post-data">
                            <p>{{ __('translate.Next Project') }}</p>
                            <h5>{{ __($nextProject->translate->title) }}</h5>
                        </div>
                        <div class="optech-post-icon">
                            <i class="ri-arrow-right-s-line"></i>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <!-- End section -->
@endsection
