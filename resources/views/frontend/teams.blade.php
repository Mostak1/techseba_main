@extends('master_layout')
@section('new-layout')
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
    <div class="section optech-section-padding2">
        <div class="container">
            <div class="row">
                @foreach($teams as $team)
                    <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-duration="400">
                    <div class="optech-team-wrap border_all">
                        <div class="optech-team-thumb">
                            <img src="{{ asset($team->image) }}" alt="">
                            <div class="optech-social-icon-box style-three position">
                                <ul>
                                    <li>
                                        <a href="{{ $team->linkedin }}" target="_blank">
                                            <i class="ri-linkedin-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $team->twitter }}" target="_blank">
                                            <i class="ri-twitter-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $team->instagram }}" target="_blank">
                                            <i class="ri-instagram-fill"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="optech-team-data">
                            <a href="{{ route('teamPerson', $team->slug) }}">
                                <h5>{{ $team->translate->name }}</h5>
                            </a>
                            <p>{{ $team->translate->designation }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
