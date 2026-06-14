@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Upload Job Attachment') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Upload Job Attachment') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Upload Job Attachment') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <form action="{{ route('admin.attachments.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Upload Job Attachment') }}</h4>
                                                <a href="{{ route('admin.attachments.index') }}" class="crancy-btn"><i class="fa fa-list"></i> {{ __('translate.Attachments List') }}</a>
                                            </div>

                                            <div class="row mg-top-30">
                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Job Post') }} *</label>
                                                        <select class="crancy__item-input" name="job_post_id" required>
                                                            <option value="">{{ __('translate.Select Job') }}</option>
                                                            @foreach($jobs as $job)
                                                                <option value="{{ $job->id }}">{{ $job->title }} ({{ $job->organization->name }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.File') }} *</label>
                                                        <input class="crancy__item-input" type="file" name="file" required>
                                                        <span class="text-muted" style="font-size: 12px;">{{ __('translate.Allowed files: PDF, DOC, DOCX, Images. Max 5MB') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="crancy-btn mg-top-25" type="submit">{{ __('translate.Upload') }}</button>
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
