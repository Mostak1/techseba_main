@extends('user.dashboard_layout')

@section('title')
    <title>{{ __('translate.Reviews List') }}</title>
@endsection

@section('breadcrumb')
    <h1 class="post__title">{{ __('translate.Reviews List') }}</h1>
    <nav class="breadcrumbs">
        <ul>
            <li><a href="{{ route('user.dashboard') }}">{{ __('translate.Home') }}</a></li>
            <li> {{ __('translate.Reviews List') }} </li>
        </ul>
    </nav>
@endsection

@section('dashboard-content')
    @if($reviews->isNotEmpty())
    <div class="d_review_box_main">
        <div class="d_review_box_head">
            <h4>{{ __('translate.Reviews') }}</h4>
        </div>
        <div class="d_review_box_item">
            @foreach($reviews as $review)
            <!-- single item start-->
                <div class="d_review_box">
                <div class="d_review_box_thumb">
                    <img src="{{ asset($review->product->thumbnail_image) }}" alt="thumb">
                </div>
                <div class="d_review_box_text">
                    <div class="d_review_box_tex_df">
                        <a href="{{ route('product.view', $review->product->slug) }}">
                            {{ __($review->product->translate->name) }}
                        </a>
                        <ul>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <li><i class="fa fa-star"></i></li>
                                @else
                                    <li><i class="fa-regular fa-star"></i></li>
                                @endif
                            @endfor
                        </ul>
                    </div>
                    <p>
                        {{ __($review->reviews) }}
                    </p>

                    <span>{{ $review->created_at->format('d M Y') }}</span>
                </div>
            </div>
            <!-- single item end-->
            @endforeach
        </div>
    </div>
    @else
        @include('wishlist::not_found')
    @endif

    @if ($reviews->hasPages())
        <div class="optech-navigation">
            <nav class="navigation pagination" aria-label="Posts">
                <div class="nav-links">
                    {{-- Previous Page Link --}}
                    <a class="next page-numbers" href="{{ $reviews->appends(['per_page' => request('per_page'), 'search' => request('search')])->previousPageUrl() }}">
                        <i class="ri-arrow-left-s-line"></i>
                    </a>

                    {{-- Pagination Elements --}}
                    @for ($i = 1; $i <= $reviews->lastPage(); $i++)
                        @if ($i == $reviews->currentPage())
                            <span aria-current="page" class="page-numbers current">{{ $i }}</span>
                        @else
                            <a class="page-numbers" href="{{ $reviews->appends(['per_page' => request('per_page'), 'search' => request('search')])->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    <a class="next page-numbers" href="{{ $reviews->appends(['per_page' => request('per_page'), 'search' => request('search')])->nextPageUrl() }}">
                        <i class="ri-arrow-right-s-line"></i>
                    </a>
                </div>
            </nav>
        </div>
    @endif

@endsection
