@extends('master_layout')
@section('title')
<title>{{ $seo_setting->seo_title }}</title>
<meta name="title" content="{{ $seo_setting->seo_title }}"/>
<meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}" />
@endsection
@section('new-layout')
<!-- Main Start -->
<div class="optech-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
    <div class="container">
        <h1 class="post__title">{{ __('translate.Blogs') }}</h1>
        <nav class="breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                <li aria-current="page"> {{ __('translate.Blogs') }}</li>
            </ul>
        </nav>

    </div>
</div>

@php
    $isGrid = request()->query('type') === 'grid';
@endphp
<!-- End breadcrumb -->
@if(!$isGrid)
<!-- Non Grid Blogs Start -->
<div class="section optech-section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @forelse($blogs as $blog)
                    <div data-aos="fade-up" data-aos-duration="600">
                    <div class="optech-blog-wrap">
                        <a href="{{ route('blog', $blog->slug) }}">
                            <div class="optech-blog-thumb optech-blog-thumb-big">
                                <img src="{{ asset($blog->image) }}" alt="Blog Image">
                            </div>
                        </a>
                        <div class="optech-blog-content">
                            <div class="optech-blog-meta">
                                <ul>
                                    <li><a href="{{ route('blog', $blog->slug) }}">{{ $blog->category->translate?->name }}</a></li>
                                    <li><a href="{{ route('blog', $blog->slug) }}">{{ $blog->created_at->format('d F Y') }}</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('blog', $blog->slug) }}">
                                <h2>{{ $blog->translate->title }}</h2>
                            </a>
                            <p>
                                {!! Str::limit(clean($blog->translate->description), 180, '...') !!}
                            </p>
                            <a class="optech-icon-btn" href="{{ route('blog', $blog->slug) }}"><i class="icon-show ri-arrow-right-line"></i>
                                <span>{{ __('translate.Learn More') }}</span> <i class="icon-hide ri-arrow-right-line"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                @include('blog_not_found')
                @endforelse


                @if($blogs->hasPages())
                        <div class="optech-navigation">
                            <nav class="navigation pagination" aria-label="Posts">
                                <div class="nav-links">
                                    @if($blogs->onFirstPage())
                                        <span class="next page-numbers disabled">
                                            <i class="ri-arrow-left-s-line"></i>
                                        </span>
                                    @else
                                        <a class="next page-numbers" href="{{ $blogs->previousPageUrl() }}">
                                            <i class="ri-arrow-left-s-line"></i>
                                        </a>
                                    @endif

                                    @php
                                        $start = max($blogs->currentPage() - 2, 1);
                                        $end = min($start + 4, $blogs->lastPage());
                                        $start = max(min($start, $blogs->lastPage() - 4), 1);
                                    @endphp

                                    @if($start > 1)
                                        <a class="page-numbers" href="{{ $blogs->url(1) }}">1</a>
                                        @if($start > 2)
                                            <span class="page-numbers dots">...</span>
                                        @endif
                                    @endif

                                    @for($i = $start; $i <= $end; $i++)
                                        @if($i == $blogs->currentPage())
                                            <span aria-current="page" class="page-numbers current">{{ $i }}</span>
                                        @else
                                            <a class="page-numbers" href="{{ $blogs->url($i) }}">{{ $i }}</a>
                                        @endif
                                    @endfor

                                    @if($end < $blogs->lastPage())
                                        @if($end < $blogs->lastPage() - 1)
                                            <span class="page-numbers dots">...</span>
                                        @endif
                                        <a class="page-numbers" href="{{ $blogs->url($blogs->lastPage()) }}">{{ $blogs->lastPage() }}</a>
                                    @endif

                                    @if($blogs->hasMorePages())
                                        <a class="next page-numbers" href="{{ $blogs->nextPageUrl() }}">
                                            <i class="ri-arrow-right-s-line"></i>
                                        </a>
                                    @else
                                        <span class="next page-numbers disabled">
                                            <i class="ri-arrow-right-s-line"></i>
                                        </span>
                                    @endif
                                </div>
                            </nav>
                        </div>
                    @endif
                </div>
            @include('blog_sidebar')
        </div>
    </div>
</div>
@else
<!-- Non Grid Blogs End -->

<!-- Grid Blogs Start -->
<div class="section optech-section-padding optech-blog-grid">
    <div class="container">
        <div class="row">
            @foreach($blogs as $blog)
            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="600">
                <div class="optech-blog-wrap">
                    <a href="{{ route('blog', $blog->slug) }}">
                        <div class="optech-blog-thumb ">
                            <img src="{{ asset($blog->image) }}" alt="Image Blog">
                        </div>
                    </a>
                    <div class="optech-blog-content">
                        <div class="optech-blog-meta">
                            <ul>
                                <li><a href="{{ route('blog', $blog->slug) }}">{{ $blog->category->translate?->name }}</a></li>
                                <li><a href="{{ route('blog', $blog->slug) }}">{{ $blog->created_at->format('d F Y') }}</a></li>
                            </ul>
                        </div>
                        <a href="{{ route('blog', $blog->slug) }}">
                            <h4>{{ $blog->translate->title }}</h4>
                        </a>
                        <a class="optech-icon-btn" href="{{ route('blog', $blog->slug) }}"><i class="icon-show ri-arrow-right-line"></i>
                            <span>
                                {{ __('translate.Learn More') }}
                            </span> <i class="icon-hide ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($blogs->hasPages())
            <div class="optech-navigation">
                <nav class="navigation pagination center" aria-label="Posts">
                    <div class="nav-links">
                        @if($blogs->onFirstPage())
                            <span class="next page-numbers disabled">
                        <i class="ri-arrow-left-s-line"></i>
                    </span>
                        @else
                            <a class="next page-numbers" href="{{ $blogs->previousPageUrl() }}">
                                <i class="ri-arrow-left-s-line"></i>
                            </a>
                        @endif

                        @php
                            $start = max($blogs->currentPage() - 2, 1);
                            $end = min($start + 4, $blogs->lastPage());
                            $start = max(min($start, $blogs->lastPage() - 4), 1);
                        @endphp

                        @if($start > 1)
                            <a class="page-numbers" href="{{ $blogs->url(1) }}">1</a>
                            @if($start > 2)
                                <span class="page-numbers dots">...</span>
                            @endif
                        @endif

                        @for($i = $start; $i <= $end; $i++)
                            @if($i == $blogs->currentPage())
                                <span aria-current="page" class="page-numbers current">{{ $i }}</span>
                            @else
                                <a class="page-numbers" href="{{ $blogs->url($i) }}">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($end < $blogs->lastPage())
                            @if($end < $blogs->lastPage() - 1)
                                <span class="page-numbers dots">...</span>
                            @endif
                            <a class="page-numbers" href="{{ $blogs->url($blogs->lastPage()) }}">{{ $blogs->lastPage() }}</a>
                        @endif

                        @if($blogs->hasMorePages())
                            <a class="next page-numbers" href="{{ $blogs->nextPageUrl() }}">
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                        @else
                            <span class="next page-numbers disabled">
                        <i class="ri-arrow-right-s-line"></i>
                    </span>
                        @endif
                    </div>
                </nav>
            </div>
        @endif
    </div>
</div>
@endif
<!-- Grid Blogs Start End  -->

@endsection
