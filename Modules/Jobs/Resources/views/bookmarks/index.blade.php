@extends('user.dashboard_layout')
@section('title')
    <title>{{ __('translate.Bookmarked Jobs') }}</title>
@endsection
@section('breadcrumb')
    <h1 class="post__title">{{ __('translate.Bookmarked Jobs') }}</h1>
    <nav class="breadcrumbs">
        <ul>
            <li><a href="{{ route('user.dashboard') }}">{{ __('translate.Home') }}</a></li>
            <li aria-current="page"> {{ __('translate.Bookmarked Jobs') }}</li>
        </ul>
    </nav>
@endsection

@section('dashboard-content')
    <div class="row">
        <div class="col-12">
            <h4 class="mb-4 font-weight-bold" style="color: #333;">{{ __('translate.My Bookmarked Jobs') }}</h4>

            @if($bookmarks->isEmpty())
                <div class="text-center py-5 card shadow-sm border-0" style="border-radius: 12px; background: #fff;">
                    <h5 class="text-muted mb-0">{{ __('translate.You haven\'t bookmarked any jobs yet.') }}</h5>
                    <div class="mt-3">
                        <a href="{{ route('jobs.index') }}" class="btn btn-primary px-4" style="border-radius: 8px; font-weight: bold; background: #007bff; border: none;">
                            {{ __('translate.Browse Jobs') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach($bookmarks as $bookmark)
                        @php
                            $job = $bookmark->jobPost;
                        @endphp
                        @if($job)
                            <div class="col-12 mb-3">
                                <div class="card shadow-sm border-0 p-4" style="border-radius: 12px; background: #fff;">
                                    <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row gap-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($job->organization->logo)
                                                <img src="{{ asset($job->organization->logo) }}" alt="{{ $job->organization->name }}" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px; color: #aaa; font-weight: bold;">
                                                    {{ substr($job->organization->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h5 class="mb-1"><a href="{{ route('jobs.show', $job->slug) }}" class="text-dark font-weight-bold text-decoration-none">{{ $job->title }}</a></h5>
                                                <p class="mb-0 text-muted" style="font-size: 14px;">
                                                    <a href="{{ route('jobs.organization', $job->organization->slug) }}" class="text-muted text-decoration-none font-weight-bold">{{ $job->organization->name }}</a>
                                                    &bull; {{ $job->location ?? __('translate.Remote') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column align-items-md-end gap-2 w-100 w-md-auto">
                                            <div class="d-flex gap-2 align-items-center">
                                                <span class="badge bg-primary px-3 py-2 text-capitalize" style="border-radius: 20px; font-size: 12px; background-color: #007bff !important;">{{ str_replace('-', ' ', $job->job_type) }}</span>
                                                <form action="{{ route('user.jobs.bookmarks.destroy', $bookmark->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0" title="{{ __('translate.Remove Bookmark') }}" style="font-size: 20px;">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <p class="mb-0 font-weight-bold text-success" style="font-size: 14px;">
                                                @if($job->salary_min || $job->salary_max)
                                                    {{ $job->salary_min ? number_format($job->salary_min, 0) : '0' }} - {{ $job->salary_max ? number_format($job->salary_max, 0) : 'Max' }} {{ $job->salary_type }}
                                                @else
                                                    {{ __('translate.Negotiable') }}
                                                @endif
                                            </p>
                                            <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-outline-primary btn-sm px-4 py-2 mt-1" style="border-radius: 20px; font-weight: bold;">
                                                {{ __('translate.Apply Now') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
