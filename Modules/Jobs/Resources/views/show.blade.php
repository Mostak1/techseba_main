@extends('master_layout')

@section('title')
    <title>{{ $job->title }}</title>
@endsection

@section('new-layout')
    <!-- Breadcrumb -->
    <div class="optech-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
        <div class="container">
            <h1 class="post__title">{{ $job->title }}</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                    <li><a href="{{ route('jobs.index') }}">{{ __('translate.Jobs') }}</a></li>
                    <li aria-current="page">{{ $job->title }}</li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Job Details Section -->
    <div class="section optech-section-padding-top optech-section-padding-bottom" style="background: #fdfdfd; padding-bottom: 80px;">
        <div class="container">
            <div class="row">
                <!-- Main Details -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm border-0 p-4 mb-4" style="border-radius: 12px; background: #fff;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                            <div class="d-flex align-items-center gap-3">
                                @if($job->organization->logo)
                                    <img src="{{ asset($job->organization->logo) }}" alt="{{ $job->organization->name }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 32px; color: #aaa; font-weight: bold;">
                                        {{ substr($job->organization->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="mb-1 text-dark font-weight-bold">{{ $job->title }}</h3>
                                    <p class="mb-0 text-muted">
                                        <a href="{{ route('jobs.organization', $job->organization->slug) }}" class="text-primary text-decoration-none font-weight-bold">{{ $job->organization->name }}</a>
                                        &bull; {{ $job->location ?? __('translate.Remote') }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                @auth('web')
                                    @php
                                        $isBookmarked = \Modules\Jobs\Entities\JobBookmark::where('user_id', auth()->id())->where('job_post_id', $job->id)->exists();
                                    @endphp
                                    <button class="btn btn-outline-primary px-3 py-2 d-flex align-items-center gap-2" onclick="toggleJobBookmark({{ $job->id }}, this)" style="border-radius: 8px; font-weight: bold;">
                                        <i class="{{ $isBookmarked ? 'ri-bookmark-fill' : 'ri-bookmark-line' }}"></i>
                                        <span class="bookmark-text">{{ $isBookmarked ? __('translate.Bookmarked') : __('translate.Bookmark Job') }}</span>
                                    </button>
                                @else
                                    <a href="{{ route('user.login') }}" class="btn btn-outline-secondary px-3 py-2 d-flex align-items-center gap-2" style="border-radius: 8px; font-weight: bold;">
                                        <i class="ri-bookmark-line"></i>
                                        <span>{{ __('translate.Bookmark Job') }}</span>
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Job Metadata Badges -->
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-primary px-3 py-2 text-capitalize" style="border-radius: 20px; font-size: 13px; background-color: #007bff !important;">{{ str_replace('-', ' ', $job->job_type) }}</span>
                            <span class="badge bg-secondary px-3 py-2 text-capitalize" style="border-radius: 20px; font-size: 13px;">{{ str_replace('-', ' ', $job->experience_level) }}</span>
                            <span class="badge bg-success px-3 py-2 text-capitalize" style="border-radius: 20px; font-size: 13px; background-color: #28a745 !important;">
                                @if($job->salary_min || $job->salary_max)
                                    {{ $job->salary_min ? number_format($job->salary_min, 0) : '0' }} - {{ $job->salary_max ? number_format($job->salary_max, 0) : 'Max' }} {{ $job->salary_type }}
                                @else
                                    {{ __('translate.Negotiable') }}
                                @endif
                            </span>
                            @if($job->expires_at)
                                <span class="badge bg-danger px-3 py-2" style="border-radius: 20px; font-size: 13px; background-color: #dc3545 !important;">
                                    {{ __('translate.Expires') }}: {{ $job->expires_at->format('M d, Y') }}
                                </span>
                            @endif
                        </div>

                        <hr class="my-4">

                        <!-- Job Description -->
                        <div class="mb-4">
                            <h4 class="font-weight-bold text-dark mb-3">{{ __('translate.Job Description') }}</h4>
                            <div class="text-muted leading-relaxed">
                                {!! clean($job->detail->description) !!}
                            </div>
                        </div>

                        <!-- Requirements -->
                        @if($job->detail->requirements)
                            <div class="mb-4">
                                <h4 class="font-weight-bold text-dark mb-3">{{ __('translate.Job Requirements') }}</h4>
                                <div class="text-muted leading-relaxed">
                                    {!! clean($job->detail->requirements) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Responsibilities -->
                        @if($job->detail->responsibilities)
                            <div class="mb-4">
                                <h4 class="font-weight-bold text-dark mb-3">{{ __('translate.Job Responsibilities') }}</h4>
                                <div class="text-muted leading-relaxed">
                                    {!! clean($job->detail->responsibilities) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Benefits -->
                        @if($job->detail->benefits)
                            <div class="mb-4">
                                <h4 class="font-weight-bold text-dark mb-3">{{ __('translate.Benefits') }}</h4>
                                <div class="text-muted leading-relaxed">
                                    {!! clean($job->detail->benefits) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Attachments -->
                        @if($job->attachments->isNotEmpty())
                            <div class="mb-4">
                                <h4 class="font-weight-bold text-dark mb-3">{{ __('translate.Attachments') }}</h4>
                                <div class="list-group">
                                    @foreach($job->attachments as $attachment)
                                        <a href="{{ asset($attachment->file_path) }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between rounded border mb-2" download>
                                            <span>
                                                <i class="ri-file-line mr-2"></i> {{ $attachment->file_name }}
                                            </span>
                                            <span class="badge bg-light text-dark">{{ round($attachment->file_size / 1024, 1) }} KB</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar Summary -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 p-4 mb-4" style="border-radius: 12px; background: #fff;">
                        <h4 class="mb-4 font-weight-bold text-dark">{{ __('translate.Job Summary') }}</h4>
                        <ul class="list-unstyled mb-4">
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('translate.Published') }}:</span>
                                <span class="font-weight-bold text-dark">{{ $job->created_at->format('M d, Y') }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('translate.Job Type') }}:</span>
                                <span class="font-weight-bold text-capitalize text-dark">{{ str_replace('-', ' ', $job->job_type) }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('translate.Experience') }}:</span>
                                <span class="font-weight-bold text-capitalize text-dark">{{ str_replace('-', ' ', $job->experience_level) }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('translate.Salary') }}:</span>
                                <span class="font-weight-bold text-success">
                                    @if($job->salary_min || $job->salary_max)
                                        {{ $job->salary_min ? number_format($job->salary_min, 0) : '0' }} - {{ $job->salary_max ? number_format($job->salary_max, 0) : 'Max' }}
                                    @else
                                        {{ __('translate.Negotiable') }}
                                    @endif
                                </span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('translate.Location') }}:</span>
                                <span class="font-weight-bold text-dark">{{ $job->location ?? __('translate.Remote') }}</span>
                            </li>
                        </ul>
                        <button class="btn btn-primary w-100 py-3 font-weight-bold" style="border-radius: 8px; background: #007bff; border: none;">
                            {{ __('translate.Apply For This Job') }}
                        </button>
                    </div>

                    <!-- Organization Info Card -->
                    <div class="card shadow-sm border-0 p-4" style="border-radius: 12px; background: #fff;">
                        <h4 class="mb-4 font-weight-bold text-dark">{{ __('translate.About Organization') }}</h4>
                        <div class="text-center mb-3">
                            @if($job->organization->logo)
                                <img src="{{ asset($job->organization->logo) }}" alt="{{ $job->organization->name }}" class="img-fluid rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                            @endif
                            <h5><a href="{{ route('jobs.organization', $job->organization->slug) }}" class="text-dark font-weight-bold text-decoration-none">{{ $job->organization->name }}</a></h5>
                            @if($job->organization->website)
                                <a href="{{ $job->organization->website }}" target="_blank" class="text-primary text-decoration-none" style="font-size: 14px;">{{ $job->organization->website }}</a>
                            @endif
                        </div>
                        <p class="text-muted text-center" style="font-size: 14px;">{{ Str::limit($job->organization->description, 150) }}</p>
                    </div>
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
            let icon = $(element).find('i');
            let text = $(element).find('.bookmark-text');
            if (response.status === 'saved') {
                icon.removeClass('ri-bookmark-line').addClass('ri-bookmark-fill');
                text.text("{{ __('translate.Bookmarked') }}");
            } else {
                icon.removeClass('ri-bookmark-fill').addClass('ri-bookmark-line');
                text.text("{{ __('translate.Bookmark Job') }}");
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

@push('schema')
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'JobPosting',
        'title' => $job->title,
        'description' => strip_tags($job->detail->description),
        'datePosted' => $job->created_at->toIso8601String(),
        'validThrough' => $job->expires_at ? $job->expires_at->toIso8601String() : null,
        'employmentType' => [
            'full-time' => 'FULL_TIME',
            'part-time' => 'PART_TIME',
            'contract' => 'CONTRACTOR',
            'internship' => 'INTERN',
            'remote' => 'FULL_TIME'
        ][$job->job_type] ?? 'FULL_TIME',
        'hiringOrganization' => [
            '@type' => 'Organization',
            'name' => $job->organization->name,
            'sameAs' => $job->organization->website,
            'logo' => $job->organization->logo ? asset($job->organization->logo) : null,
        ],
        'jobLocation' => [
            '@type' => 'Place',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $job->location ?? 'Remote',
                'addressCountry' => 'BD'
            ]
        ],
        'baseSalary' => ($job->salary_min || $job->salary_max) ? [
            '@type' => 'MonetaryAmount',
            'currency' => 'BDT',
            'value' => [
                '@type' => 'QuantitativeValue',
                'minValue' => $job->salary_min,
                'maxValue' => $job->salary_max,
                'unitText' => strtoupper($job->salary_type == 'monthly' ? 'MONTH' : ($job->salary_type == 'yearly' ? 'YEAR' : 'HOUR'))
            ]
        ] : null
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

