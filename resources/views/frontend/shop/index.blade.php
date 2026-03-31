@extends('master_layout')
@section('new-layout')

    <!-- Start breadcrumb -->
    <div class="optech-breadcrumb"
         style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
        <div class="container">
            <h1 class="post__title">{{ __('translate.Shop') }}</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                    <li aria-current="page">{{ __('translate.Shop') }}</li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- End breadcrumb -->

    <!-- Start section -->
    <div class="section optech-section-padding">
        <div class="container">
            <div class="row">
                @include('frontend.shop.sidebar_search')

                @if($products->count() > 0)
                    <div class="col-xl-9 col-lg-8 col-md-7">
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-xl-4 col-lg-6 col-md-6 mt-5 mt-md-0" data-aos="fade-up" data-aos-duration="400">
                                    @include('_product')
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                @include('frontend.shop.not_found')
                @endif
            </div>

           @include('frontend.shop.paginate')

        </div>
    </div>

@endsection




