@extends('user.dashboard_layout')
@section('title')
    <title>{{ __('translate.User WishList Dashboard') }}</title>
@endsection
@section('breadcrumb')
    <h1 class="post__title">{{ __('translate.WishList') }}</h1>
    <nav class="breadcrumbs">
        <ul>
            <li><a href="{{ route('user.dashboard') }}">{{ __('translate.Home') }}</a></li>
            <li aria-current="page"> {{ __('translate.WishList') }}</li>
        </ul>
    </nav>
@endsection

@section('dashboard-content')
        @if($wishlists->isNotEmpty())
            <div class="row">
                @foreach($wishlists as $product)
                    <div class="col-xl-4 col-lg-6 col-md-6 mt-5 mt-md-0" data-aos="fade-up" data-aos-duration="400">
                        @include('_product')
                    </div>
                @endforeach
            </div>
        @else
            @include('wishlist::not_found')
        @endif

@endsection
@push('style_section')
    <link href="{{ asset('frontend/assets/css/nouislider.min.css') }}" rel="stylesheet"/>
@endpush
@push('js_section')
    <script src="{{ asset('frontend/assets/js/nouislider.min.js') }}"></script>
@endpush
