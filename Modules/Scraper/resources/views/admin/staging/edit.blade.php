@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Edit Scraped Job') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Edit Scraped Job') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Edit Scraped Job') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <form action="{{ route('admin.scraper.staging.update', $job->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Edit Scraped Job Details') }}</h4>
                                                <a href="{{ route('admin.scraper.staging.show', $job->id) }}" class="crancy-btn"><i class="fa fa-arrow-left"></i> {{ __('translate.Back to Review') }}</a>
                                            </div>

                                            <div class="row mg-top-30">
                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Job Title') }} *</label>
                                                        <input class="crancy__item-input" type="text" name="title" value="{{ $job->title }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Scraped Organization Name') }} *</label>
                                                        <input class="crancy__item-input" type="text" name="organization_name" value="{{ $job->organization_name }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Scraped Category Name') }} *</label>
                                                        <input class="crancy__item-input" type="text" name="category_name" value="{{ $job->category_name }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Location') }}</label>
                                                        <input class="crancy__item-input" type="text" name="location" value="{{ $job->location }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Job Type') }} *</label>
                                                        <select class="crancy__item-input form-select" name="job_type" required style="height: 50px;">
                                                            <option value="full-time" {{ $job->job_type == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                                            <option value="part-time" {{ $job->job_type == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                                            <option value="contract" {{ $job->job_type == 'contract' ? 'selected' : '' }}>Contract</option>
                                                            <option value="internship" {{ $job->job_type == 'internship' ? 'selected' : '' }}>Internship</option>
                                                            <option value="remote" {{ $job->job_type == 'remote' ? 'selected' : '' }}>Remote</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Salary Min') }}</label>
                                                        <input class="crancy__item-input" type="number" name="salary_min" value="{{ $job->salary_min }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Salary Max') }}</label>
                                                        <input class="crancy__item-input" type="number" name="salary_max" value="{{ $job->salary_max }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Experience Level') }}</label>
                                                        <input class="crancy__item-input" type="text" name="experience_level" value="{{ $job->experience_level }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Deadline / Expires At') }}</label>
                                                        <input class="crancy__item-input" type="date" name="expires_at" value="{{ $job->expires_at ? $job->expires_at->format('Y-m-d') : '' }}">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Description') }} *</label>
                                                        <textarea class="crancy__item-input" name="description" rows="10" required style="height: auto; padding: 15px;">{{ $job->description }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Requirements') }}</label>
                                                        <textarea class="crancy__item-input" name="requirements" rows="6" style="height: auto; padding: 15px;">{{ $job->requirements }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Responsibilities') }}</label>
                                                        <textarea class="crancy__item-input" name="responsibilities" rows="6" style="height: auto; padding: 15px;">{{ $job->responsibilities }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="crancy-btn mg-top-25" type="submit">{{ __('translate.Update Details') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
