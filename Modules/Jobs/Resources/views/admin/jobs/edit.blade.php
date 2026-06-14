@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Edit Job Post') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Edit Job Post') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Edit Job Post') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Edit Job Post') }}</h4>
                                                <a href="{{ route('admin.jobs.index') }}" class="crancy-btn"><i class="fa fa-list"></i> {{ __('translate.Jobs List') }}</a>
                                            </div>

                                            <div class="row mg-top-30">
                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Title') }} *</label>
                                                        <input class="crancy__item-input" type="text" name="title" id="name" value="{{ $job->title }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Slug') }} *</label>
                                                        <input class="crancy__item-input" type="text" name="slug" id="slug" value="{{ $job->slug }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Organization') }} *</label>
                                                        <select class="crancy__item-input" name="organization_id" required>
                                                            <option value="">{{ __('translate.Select Organization') }}</option>
                                                            @foreach($organizations as $org)
                                                                <option value="{{ $org->id }}" {{ $job->organization_id == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Job Category') }} *</label>
                                                        <select class="crancy__item-input" name="job_category_id" required>
                                                            <option value="">{{ __('translate.Select Category') }}</option>
                                                            @foreach($categories as $cat)
                                                                <option value="{{ $cat->id }}" {{ $job->job_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Job Type') }} *</label>
                                                        <select class="crancy__item-input" name="job_type" required>
                                                            <option value="full-time" {{ $job->job_type == 'full-time' ? 'selected' : '' }}>{{ __('translate.Full Time') }}</option>
                                                            <option value="part-time" {{ $job->job_type == 'part-time' ? 'selected' : '' }}>{{ __('translate.Part Time') }}</option>
                                                            <option value="contract" {{ $job->job_type == 'contract' ? 'selected' : '' }}>{{ __('translate.Contract') }}</option>
                                                            <option value="internship" {{ $job->job_type == 'internship' ? 'selected' : '' }}>{{ __('translate.Internship') }}</option>
                                                            <option value="remote" {{ $job->job_type == 'remote' ? 'selected' : '' }}>{{ __('translate.Remote') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Location') }}</label>
                                                        <input class="crancy__item-input" type="text" name="location" value="{{ $job->location }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Min Salary') }}</label>
                                                        <input class="crancy__item-input" type="number" step="0.01" name="salary_min" value="{{ $job->salary_min }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Max Salary') }}</label>
                                                        <input class="crancy__item-input" type="number" step="0.01" name="salary_max" value="{{ $job->salary_max }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Salary Type') }} *</label>
                                                        <select class="crancy__item-input" name="salary_type" required>
                                                            <option value="monthly" {{ $job->salary_type == 'monthly' ? 'selected' : '' }}>{{ __('translate.Monthly') }}</option>
                                                            <option value="yearly" {{ $job->salary_type == 'yearly' ? 'selected' : '' }}>{{ __('translate.Yearly') }}</option>
                                                            <option value="hourly" {{ $job->salary_type == 'hourly' ? 'selected' : '' }}>{{ __('translate.Hourly') }}</option>
                                                        </select>
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
                                                        <label class="crancy__item-label">{{ __('translate.Expiry Date') }}</label>
                                                        <input class="crancy__item-input" type="date" name="expires_at" value="{{ $job->expires_at ? $job->expires_at->format('Y-m-d') : '' }}">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Description') }} *</label>
                                                        <textarea class="crancy__item-input summernote" name="description" required>{{ $job->detail?->description }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Requirements') }}</label>
                                                        <textarea class="crancy__item-input summernote" name="requirements">{{ $job->detail?->requirements }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Responsibilities') }}</label>
                                                        <textarea class="crancy__item-input summernote" name="responsibilities">{{ $job->detail?->responsibilities }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Benefits') }}</label>
                                                        <textarea class="crancy__item-input summernote" name="benefits">{{ $job->detail?->benefits }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{__('Visibility Status')}}</label>
                                                        <div class="crancy-ptabs__notify-switch crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                                <input name="status" type="checkbox" {{ $job->status == 'active' ? 'checked' : '' }}>
                                                                <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{__('Featured')}}</label>
                                                        <div class="crancy-ptabs__notify-switch crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                                <input name="featured" type="checkbox" {{ $job->featured ? 'checked' : '' }}>
                                                                <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="crancy-btn mg-top-25" type="submit">{{ __('translate.Save') }}</button>
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

@push('js_section')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function () {
                $("#name").on("keyup", function(e) {
                    let inputValue = $(this).val();
                    let slug = inputValue.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
                    $("#slug").val(slug);
                });
            });
        })(jQuery);
    </script>
@endpush
