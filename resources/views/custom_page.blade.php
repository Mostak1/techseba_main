@extends('master_layout')

@section('title')
<title>{{ $custom_page->page_name }}</title>
@endsection

@section('new-layout')
<!-- Main Start -->
<main class="bg-offWhite">
    <!-- Breadcrumb -->
        <!-- Breadcrumb -->
        <div class="optech-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
          <div class="container">
              <h1 class="post__title">{{ $custom_page->page_name }}</h1>
              <nav class="breadcrumbs">
                  <ul>
                      <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>

                      <li aria-current="page">{{ $custom_page->page_name }}</li>
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
              <div class="content-details optech-service-details-item">
                {!! clean($custom_page->description) !!}
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
