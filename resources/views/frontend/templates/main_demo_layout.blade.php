@extends('layout')

@section('front-content')
@include('frontend.templates.layouts.white_navbar')
    <div class="search-overlay"></div>

    @yield('content')

<!-- Footer Section Start -->
    @unless(Route::is('contact-us'))
        @include('frontend.templates.layouts.main_demo_cta')
    @endunless
    @include('frontend.templates.layouts.footer')
<!-- Footer Section End -->
@endsection
