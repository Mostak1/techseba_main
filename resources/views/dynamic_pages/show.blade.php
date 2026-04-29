@extends('master_layout')

@section('title')
    <title>{{ $page->name }}</title>
    <meta name="title" content="{{ $page->name }}">
    <meta name="description" content="{{ $page->name }}">
@endsection

@section('new-layout')
    @php
        $pageTitle = $page->name;
    @endphp

    @include('frontend.templates.layouts.breadcrumb')

    @if($enabledSections->has('hero'))
        <section class="section optech-section-padding">
            <div class="container">
                <div class="optech-section-title center">
                    <h2>{{ $enabledSections['hero']->section_name }}</h2>
                    <p>This hero block is visible because the hero section is enabled for {{ $page->name }}.</p>
                </div>
            </div>
        </section>
    @endif

    @if($enabledSections->has('about'))
        <section class="section optech-section-padding bg-light1">
            <div class="container">
                <div class="optech-section-title">
                    <h2>{{ $enabledSections['about']->section_name }}</h2>
                    <p>Put your about page content here, or include a reusable Blade partial for this section.</p>
                </div>
            </div>
        </section>
    @endif

    @if($enabledSections->has('services'))
        <section class="section optech-section-padding">
            <div class="container">
                <div class="optech-section-title center">
                    <h2>{{ $enabledSections['services']->section_name }}</h2>
                    <p>Only enabled services sections are rendered on this page.</p>
                </div>
            </div>
        </section>
    @endif

    @foreach($enabledSections->except(['hero', 'about', 'services']) as $section)
        <section class="section optech-section-padding {{ $loop->odd ? 'bg-light1' : '' }}">
            <div class="container">
                <div class="optech-section-title center">
                    <h2>{{ $section->section_name }}</h2>
                    <p>Section identifier: {{ $section->section_identifier }}</p>
                </div>
            </div>
        </section>
    @endforeach
@endsection
