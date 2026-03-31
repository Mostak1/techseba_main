@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Edit Project') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Edit Project') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Manage Project') }} >> {{ __('translate.Edit Project') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show mg-top-30">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="row">
                                <div class="col-12">
                                    <div class="crancy-product-card translation_main_box">
                                        <div class="crancy-customer-filter">
                                            <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch">
                                                <div class="crancy-header__form crancy-header__form--customer">
                                                    <h4 class="crancy-product-card__title">{{ __('translate.Switch to language translation') }}</h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="translation_box">
                                            <ul>
                                                @foreach ($language_list as $language)
                                                    <li><a href="{{ route('admin.project.edit', ['project' => $project->id, 'lang_code' => $language->lang_code] ) }}">
                                                            @if (request()->get('lang_code') == $language->lang_code)
                                                                <i class="fas fa-eye"></i>
                                                            @else
                                                                <i class="fas fa-edit"></i>
                                                            @endif

                                                            {{ $language->lang_name }}</a></li>
                                                @endforeach
                                            </ul>

                                            <div class="alert alert-secondary" role="alert">
                                                @php
                                                    $edited_language = $language_list->where('lang_code', request()->get('lang_code'))->first();
                                                @endphp
                                                <p>{{ __('translate.Your editing mode') }} : <b>{{ $edited_language->lang_name }}</b></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <form action="{{ route('admin.project.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="lang_code" value="{{ $project_translate->lang_code }}">
        <input type="hidden" name="translate_id" value="{{ $project_translate->id }}">

        <section class="crancy-adashboard crancy-show">
            <div class="container container__bscreen">
                <div class="row">
                    <div class="col-12">
                        <div class="crancy-body">
                            <div class="crancy-dsinner">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Basic Information') }}</h4>
                                            </div>

                                            <div class="row">
                                                @if (admin_lang() == request()->get('lang_code'))
                                                    <div class="col-12 mg-top-form-20">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="crancy__item-form--group w-100 h-100">
                                                                    <label class="crancy__item-label">{{ __('translate.Thumbnail Image') }} </label>
                                                                    <div class="crancy-product-card__upload crancy-product-card__upload--border">
                                                                        <input type="file" class="btn-check" name="thumb_image" id="input-img1" autocomplete="off" onchange="previewImage(event)">
                                                                        <label class="crancy-image-video-upload__label" for="input-img1">
                                                                            <img id="view_img" src="{{ asset($project->thumb_image) }}">
                                                                            <h4 class="crancy-image-video-upload__title">{{ __('translate.Click here to') }} <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span> {{ __('translate.and upload') }} </h4>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="{{ admin_lang() == request()->get('lang_code') ? 'col-md-6' : 'col-12' }}">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Title') }} * </label>
                                                        <input class="crancy__item-input" type="text" name="title" id="title" value="{{ html_decode($project_translate->title) }}">
                                                    </div>
                                                </div>

                                                @if (admin_lang() == request()->get('lang_code'))
                                                    <div class="col-md-6">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.Slug') }} * </label>
                                                            <input class="crancy__item-input" type="text" name="slug" id="slug" value="{{ html_decode($project->slug) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.Category') }} * </label>
                                                            <select class="form-select crancy__item-input" name="category_id" id="category-select">
                                                                <option value="">{{ __('translate.Select Category') }}</option>
                                                                @foreach ($categories as $category)
                                                                    <option {{ $category->id == $project->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->translate->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>



                                                        <div class="col-md-6">
                                                            <div class="crancy__item-form--group mg-top-form-20">
                                                                <label class="crancy__item-label">{{ __('translate.Client Name') }} * </label>
                                                                <input class="crancy__item-input" type="text" name="client_name" id="client_name" value="{{ html_decode($project_translate->client_name) }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="crancy__item-form--group mg-top-form-20">
                                                                <label class="crancy__item-label">{{ __('translate.Website URL') }} * </label>
                                                                <input class="crancy__item-input" type="text" name="website_url" id="website_url" value="{{ html_decode($project->website_url) }}">
                                                            </div>
                                                        </div>



                                                    <div class="col-md-6">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.Project Date') }} * </label>
                                                            <input class="crancy__item-input" type="date" name="project_date" id="project_date" value="{{ html_decode($project->project_date) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.Facebook URL') }} </label>
                                                            <input class="crancy__item-input" type="text" name="project_fb" id="project_fb" value="{{ html_decode($project->project_fb) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.X URL') }} </label>
                                                            <input class="crancy__item-input" type="text" name="project_x" id="project_x" value="{{ html_decode($project->project_x) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.LinkedIn URL') }} </label>
                                                            <input class="crancy__item-input" type="text" name="project_linkedin" id="project_linkedin" value="{{ html_decode($project->project_linkedin) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.Instagram URL') }} </label>
                                                            <input class="crancy__item-input" type="text" name="project_instagram" id="project_instagram" value="{{ html_decode($project->project_instagram) }}">
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Description') }} * </label>
                                                        <textarea class="crancy__item-input crancy__item-textarea summernote" name="description" id="description">{!! html_decode($project_translate->description) !!}</textarea>
                                                    </div>
                                                </div>



                                            </div>

                                            @if (admin_lang() != request()->get('lang_code'))
                                                <button class="crancy-btn mg-top-25" type="submit">{{ __('translate.Update Data') }}</button>
                                            @endif

                                        </div>
                                        <!-- End Product Card -->
                                    </div>
                                </div>
                            </div>
                            <!-- End Dashboard Inner -->
                        </div>
                    </div>

                </div>
            </div>
        </section>

        @if (admin_lang() == request()->get('lang_code'))
            <section class="crancy-adashboard crancy-show">
                <div class="container container__bscreen">
                    <div class="row">
                        <div class="col-12">
                            <div class="crancy-body">
                                <div class="crancy-dsinner">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="crancy-product-card">
                                                <div class="create_new_btn_inline_box">
                                                    <h4 class="crancy-product-card__title">{{ __('translate.SEO Information') }}</h4>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.SEO Title') }} </label>
                                                            <input class="crancy__item-input" type="text" name="seo_title" id="seo_title" value="{{ html_decode($project->translate?->seo_title) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.SEO Description') }} </label>
                                                            <textarea class="crancy__item-input crancy__item-textarea seo_description_box" name="seo_description" id="seo_description">{{ html_decode($project->translate?->seo_description) }}</textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <button class="crancy-btn mg-top-25" type="submit">{{ __('translate.Update Data') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </form>
@endsection

@push('style_section')
    <link rel="stylesheet" href="{{ asset('global/tagify/tagify.css') }}">
    <style>
        .tox .tox-promotion,
        .tox-statusbar__branding {
            display: none !important;
        }
    </style>
@endpush

@push('js_section')

    <script src="{{ asset('global/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('global/tagify/tagify.js') }}"></script>

    <script>
        (function($) {
            "use strict"
            $(document).ready(function () {
                $("#title").on("keyup",function(e){
                    let inputValue = $(this).val();
                    let slug = inputValue.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
                    $("#slug").val(slug);
                })

                tinymce.init({
                    selector: '.summernote',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name',
                    mergetags_list: [
                        { value: 'First.Name', title: 'First Name' },
                        { value: 'Email', title: 'Email' },
                    ]
                });

                $('.tags').tagify();

            });
        })(jQuery);

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('view_img');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
@endpush
