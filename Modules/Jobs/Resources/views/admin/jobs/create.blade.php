@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Create Job Post') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Create Job Post') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Create Job Post') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <form action="{{ route('admin.jobs.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Create Job Post') }}</h4>
                                                <a href="{{ route('admin.jobs.index') }}" class="crancy-btn"><i class="fa fa-list"></i> {{ __('translate.Jobs List') }}</a>
                                            </div>

                                            <div class="row mg-top-30">
                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Title') }} *</label>
                                                        <input class="crancy__item-input" type="text" name="title" id="name" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Slug') }} *</label>
                                                        <input class="crancy__item-input" type="text" name="slug" id="slug" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Organization') }} *</label>
                                                        <select class="crancy__item-input" name="organization_id" required>
                                                            <option value="">{{ __('translate.Select Organization') }}</option>
                                                            @foreach($organizations as $org)
                                                                <option value="{{ $org->id }}">{{ $org->name }}</option>
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
                                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Job Type') }} *</label>
                                                        <select class="crancy__item-input" name="job_type" required>
                                                            <option value="full-time">{{ __('translate.Full Time') }}</option>
                                                            <option value="part-time">{{ __('translate.Part Time') }}</option>
                                                            <option value="contract">{{ __('translate.Contract') }}</option>
                                                            <option value="internship">{{ __('translate.Internship') }}</option>
                                                            <option value="remote">{{ __('translate.Remote') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Location') }}</label>
                                                        <input class="crancy__item-input" type="text" name="location">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Min Salary') }}</label>
                                                        <input class="crancy__item-input" type="number" step="0.01" name="salary_min">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Max Salary') }}</label>
                                                        <input class="crancy__item-input" type="number" step="0.01" name="salary_max">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Salary Type') }} *</label>
                                                        <select class="crancy__item-input" name="salary_type" required>
                                                            <option value="monthly">{{ __('translate.Monthly') }}</option>
                                                            <option value="yearly">{{ __('translate.Yearly') }}</option>
                                                            <option value="hourly">{{ __('translate.Hourly') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Experience Level') }}</label>
                                                        <input class="crancy__item-input" type="text" name="experience_level">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Expiry Date') }}</label>
                                                        <input class="crancy__item-input" type="date" name="expires_at">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Description') }} *</label>
                                                        <textarea class="crancy__item-input summernote" name="description" required></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Requirements') }}</label>
                                                        <textarea class="crancy__item-input summernote" name="requirements"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Responsibilities') }}</label>
                                                        <textarea class="crancy__item-input summernote" name="responsibilities"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Benefits') }}</label>
                                                        <textarea class="crancy__item-input summernote" name="benefits"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{__('Visibility Status')}}</label>
                                                        <div class="crancy-ptabs__notify-switch crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                                <input name="status" type="checkbox" checked>
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
                                                                <input name="featured" type="checkbox">
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
