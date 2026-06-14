@extends('master_layout')

@section('title')
    <title>{{ __('translate.Jobs Portal') }}</title>
@endsection

@section('new-layout')
    <!-- Breadcrumb -->
    <div class="optech-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
        <div class="container">
            <h1 class="post__title">{{ __('translate.Jobs Portal') }}</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                    <li aria-current="page">{{ __('translate.Jobs') }}</li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="section optech-section-padding-top optech-section-padding-bottom" style="background: #fdfdfd; padding-bottom: 80px;">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filter -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 p-4" style="border-radius: 12px; background: #fff;">
                        <h4 class="mb-4 font-weight-bold" style="color: #333;">{{ __('translate.Filter Jobs') }}</h4>
                        <form method="GET" action="{{ route('jobs.index') }}">
                            <!-- Keyword Search -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">{{ __('translate.Search Keyword') }}</label>
                                <input type="text" name="keyword" class="form-control" placeholder="{{ __('translate.Job title, keywords...') }}" value="{{ request('keyword') }}" style="border-radius: 8px;">
                            </div>

                            <!-- Location Search -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">{{ __('translate.Location') }}</label>
                                <input type="text" name="location" class="form-control" placeholder="{{ __('translate.City, state or remote...') }}" value="{{ request('location') }}" style="border-radius: 8px;">
                            </div>

                            <!-- Job Type Filter -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">{{ __('translate.Job Type') }}</label>
                                <select name="job_type" class="form-select" style="border-radius: 8px;">
                                    <option value="">{{ __('translate.All Types') }}</option>
                                    <option value="full-time" {{ request('job_type') == 'full-time' ? 'selected' : '' }}>{{ __('translate.Full Time') }}</option>
                                    <option value="part-time" {{ request('job_type') == 'part-time' ? 'selected' : '' }}>{{ __('translate.Part Time') }}</option>
                                    <option value="contract" {{ request('job_type') == 'contract' ? 'selected' : '' }}>{{ __('translate.Contract') }}</option>
                                    <option value="internship" {{ request('job_type') == 'internship' ? 'selected' : '' }}>{{ __('translate.Internship') }}</option>
                                    <option value="remote" {{ request('job_type') == 'remote' ? 'selected' : '' }}>{{ __('translate.Remote') }}</option>
                                </select>
                            </div>

                            <!-- Category Filter -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">{{ __('translate.Category') }}</label>
                                <select name="category_id" class="form-select" style="border-radius: 8px;">
                                    <option value="">{{ __('translate.All Categories') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->job_posts_count }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Organization Filter -->
                            <div class="mb-4">
                                <label class="form-label font-weight-bold">{{ __('translate.Organization') }}</label>
                                <select name="organization_id" class="form-select" style="border-radius: 8px;">
                                    <option value="">{{ __('translate.All Organizations') }}</option>
                                    @foreach($organizations as $org)
                                        <option value="{{ $org->id }}" {{ request('organization_id') == $org->id ? 'selected' : '' }}>
                                            {{ $org->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Deadline Filter -->
                            <div class="mb-4">
                                <label class="form-label font-weight-bold">{{ __('translate.Application Deadline') }}</label>
                                <select name="deadline" class="form-select" style="border-radius: 8px;">
                                    <option value="">{{ __('translate.Anytime') }}</option>
                                    <option value="today" {{ request('deadline') == 'today' ? 'selected' : '' }}>{{ __('translate.Expiring Today') }}</option>
                                    <option value="1-week" {{ request('deadline') == '1-week' ? 'selected' : '' }}>{{ __('translate.Expiring within 7 Days') }}</option>
                                    <option value="30-days" {{ request('deadline') == '30-days' ? 'selected' : '' }}>{{ __('translate.Expiring within 30 Days') }}</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2" style="border-radius: 8px; font-weight: bold; background: #007bff; border: none;">
                                {{ __('translate.Apply Filters') }}
                            </button>
                            @if(request()->anyFilled(['keyword', 'location', 'job_type', 'category_id', 'organization_id', 'deadline']))
                                <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary w-100 mt-2 py-2" style="border-radius: 8px; font-weight: bold;">
                                    {{ __('translate.Clear Filters') }}
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Job Listings -->
                <div class="col-lg-8">
                    @if($jobs->isEmpty())
                        <div class="text-center py-5 card shadow-sm border-0" style="border-radius: 12px; background: #fff;">
                            <h4 class="text-muted mb-0">{{ __('translate.No jobs found matching your criteria.') }}</h4>
                        </div>
                    @else
                        <div class="row">
                            @foreach($jobs as $job)
                                <div class="col-12 mb-3">
                                    <div class="card shadow-sm border-0 p-4 job-hover-card" style="border-radius: 12px; transition: transform 0.2s; background: #fff;">
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
                                                    @if($job->featured)
                                                        <span class="badge bg-warning text-dark px-3 py-2" style="border-radius: 20px; font-size: 12px;">{{ __('translate.Featured') }}</span>
                                                    @endif
                                                    @auth('web')
                                                        @php
                                                            $isBookmarked = \Modules\Jobs\Entities\JobBookmark::where('user_id', auth()->id())->where('job_post_id', $job->id)->exists();
                                                        @endphp
                                                        <button class="btn btn-link p-0 text-primary bookmark-btn" onclick="toggleJobBookmark({{ $job->id }}, this)" style="font-size: 18px; line-height: 1;">
                                                            <i class="{{ $isBookmarked ? 'ri-bookmark-fill' : 'ri-bookmark-line' }}"></i>
                                                        </button>
                                                    @else
                                                        <a href="{{ route('user.login') }}" class="btn btn-link p-0 text-muted" style="font-size: 18px; line-height: 1;" title="{{ __('translate.Login to bookmark') }}">
                                                            <i class="ri-bookmark-line"></i>
                                                        </a>
                                                    @endauth
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
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $jobs->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_section')
<script>
function toggleJobBookmark(jobId, element) {
    $.ajax({
        url: "{{ route('user.jobs.bookmarks.store') }}",
        type: "POST",
        data: {
            job_post_id: jobId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status === 'saved') {
                $(element).find('i').removeClass('ri-bookmark-line').addClass('ri-bookmark-fill');
            } else {
                $(element).find('i').removeClass('ri-bookmark-fill').addClass('ri-bookmark-line');
            }
            toastr.success(response.message);
        },
        error: function (xhr) {
            toastr.error("{{ __('translate.An error occurred') }}");
        }
    });
}
</script>
@endpush
