@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Review Scraped Job') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Review Scraped Job') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Review Scraped Job') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-product-card mg-top-30">
                                <div class="create_new_btn_inline_box mb-4">
                                    <h4 class="crancy-product-card__title">{{ __('translate.Review Staging Details') }}</h4>
                                    <a href="{{ route('admin.scraper.staging.index') }}" class="crancy-btn"><i class="fa fa-arrow-left"></i> {{ __('translate.Back') }}</a>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 250px;">{{ __('translate.Job Title') }}</th>
                                                <td><strong>{{ $job->title }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('translate.Scraped Organization') }}</th>
                                                <td>{{ $job->organization_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('translate.Scraped Category') }}</th>
                                                <td>{{ $job->category_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('translate.Location') }}</th>
                                                <td>{{ $job->location ?? 'Remote' }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('translate.Job Type') }}</th>
                                                <td class="text-capitalize">{{ str_replace('-', ' ', $job->job_type ?? 'full-time') }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('translate.Salary') }}</th>
                                                <td>
                                                    @if($job->salary_min || $job->salary_max)
                                                        {{ $job->salary_min }} - {{ $job->salary_max }}
                                                    @else
                                                        {{ __('translate.Negotiable') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('translate.Experience Level') }}</th>
                                                <td>{{ $job->experience_level ?? 'Fresh Graduate' }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('translate.Source URL') }}</th>
                                                <td><a href="{{ $job->source_url }}" target="_blank" class="text-primary">{{ $job->source_url }}</a></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('translate.Deadline / Expires At') }}</th>
                                                <td>{{ $job->expires_at ? $job->expires_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                            </tr>
                                        </table>

                                        <div class="mt-4">
                                            <h5>{{ __('translate.Description') }}</h5>
                                            <div class="p-3 bg-light rounded" style="max-height: 300px; overflow-y: auto;">
                                                {!! nl2br(e($job->description)) !!}
                                            </div>
                                        </div>

                                        @if($job->requirements)
                                            <div class="mt-4">
                                                <h5>{{ __('translate.Requirements') }}</h5>
                                                <div class="p-3 bg-light rounded" style="max-height: 200px; overflow-y: auto;">
                                                    {!! nl2br(e($job->requirements)) !!}
                                                </div>
                                            </div>
                                        @endif

                                        @if($job->responsibilities)
                                            <div class="mt-4">
                                                <h5>{{ __('translate.Responsibilities') }}</h5>
                                                <div class="p-3 bg-light rounded" style="max-height: 200px; overflow-y: auto;">
                                                    {!! nl2br(e($job->responsibilities)) !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approval Panel (Side Panel) -->
                <div class="col-lg-4 col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-product-card mg-top-30">
                                <h4 class="crancy-product-card__title">{{ __('translate.Approval Workflow') }}</h4>
                                <hr>

                                @if($job->status === 'pending')
                                    <div class="alert alert-warning">
                                        <i class="fas fa-info-circle"></i> {{ __('translate.This job is currently pending approval. You can approve it to publish it immediately on the Jobs Portal.') }}
                                    </div>

                                    <form action="{{ route('admin.scraper.staging.approve', $job->id) }}" method="POST" class="mg-top-20">
                                        @csrf
                                        <div class="crancy__item-form--group mg-top-form-20">
                                            <label class="crancy__item-label">{{ __('translate.Map/Confirm Organization') }}</label>
                                            <input class="crancy__item-input" type="text" name="organization_name" value="{{ $job->organization_name }}">
                                        </div>

                                        <div class="crancy__item-form--group mg-top-form-20">
                                            <label class="crancy__item-label">{{ __('translate.Map/Confirm Category') }}</label>
                                            <input class="crancy__item-input" type="text" name="category_name" value="{{ $job->category_name }}">
                                        </div>

                                        <div class="crancy__item-form--group mg-top-form-20">
                                            <label class="crancy__item-label">{{ __('translate.Job Type') }}</label>
                                            <select class="crancy__item-input form-select" name="job_type" style="height: 50px;">
                                                <option value="full-time" {{ $job->job_type == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                                <option value="part-time" {{ $job->job_type == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                                <option value="contract" {{ $job->job_type == 'contract' ? 'selected' : '' }}>Contract</option>
                                                <option value="internship" {{ $job->job_type == 'internship' ? 'selected' : '' }}>Internship</option>
                                                <option value="remote" {{ $job->job_type == 'remote' ? 'selected' : '' }}>Remote</option>
                                            </select>
                                        </div>

                                        <button type="submit" class="crancy-btn bg-success text-white w-100 border-0 mg-top-20"><i class="fas fa-check"></i> {{ __('translate.Approve & Publish') }}</button>
                                    </form>

                                    <form action="{{ route('admin.scraper.staging.reject', $job->id) }}" method="POST" class="mg-top-10">
                                        @csrf
                                        <button type="submit" class="crancy-btn delete_danger_btn w-100 border-0"><i class="fas fa-times"></i> {{ __('translate.Reject Job') }}</button>
                                    </form>
                                @elseif($job->status === 'approved')
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i> {{ __('translate.Approved & Published') }}
                                    </div>
                                    <p class="text-muted">
                                        {{ __('translate.This job was approved and is now live on the public site.') }}
                                    </p>
                                    @if($job->approved_job_post_id)
                                        <a href="{{ route('jobs.show', $job->approvedJobPost->slug ?? '') }}" target="_blank" class="btn btn-outline-primary btn-sm w-100 mt-2">
                                            <i class="fas fa-external-link-alt"></i> {{ __('translate.View Live Posting') }}
                                        </a>
                                    @endif
                                @else
                                    <div class="alert alert-danger">
                                        <i class="fas fa-times-circle"></i> {{ __('translate.Rejected') }}
                                    </div>
                                    <p class="text-muted">
                                        {{ __('translate.This job was rejected by an administrator.') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
