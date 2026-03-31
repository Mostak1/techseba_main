@extends('master_layout')

@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}">
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}">
@endsection

@section('new-layout')
<!-- Main Start -->
<main class="bg-offWhite">
    <!-- Breadcrumb -->
        <!-- Breadcrumb -->
        <div class="optech-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
          <div class="container">
              <h1 class="post__title">{{ __('translate.Terms and Condition') }}</h1>
              <nav class="breadcrumbs">
                  <ul>
                      <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>

                      <li aria-current="page">{{ __('translate.Terms and Condition') }}</li>
                  </ul>
              </nav>
          </div>
        </div>
    <!-- Breadcrumb End -->

    <!-- Content -->
    <section class="py-110 legal-content my-5">
      <div class="container">
        <div>
          <div class="row">
            <div class="co-auto">
              <div class="optech-service-details-item">
                {!! clean($terms_conditions->description) !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Job Grid End -->
  </main>
  <!-- Main End -->
@endsection
