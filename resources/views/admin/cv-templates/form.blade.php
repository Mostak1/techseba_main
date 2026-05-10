@extends('admin.master_layout')

@section('title')
    <title>{{ $template->exists ? 'Edit' : 'Create' }} CV Template</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ $template->exists ? 'Edit' : 'Create' }} CV Template</h3>
    <p class="crancy-header__text">Digital CV >> Templates</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-product-card mg-top-30">
                                <h4 class="crancy-product-card__title">{{ $template->exists ? 'Update Template' : 'Create Template' }}</h4>

                                <form action="{{ $template->exists ? route('admin.cv-templates.update', $template) : route('admin.cv-templates.store') }}" method="POST" enctype="multipart/form-data" class="mg-top-25">
                                    @csrf
                                    @if($template->exists)
                                        @method('PUT')
                                    @endif

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Template Name</label>
                                                <input type="text" name="name" class="crancy__item-input" value="{{ old('name', $template->name) }}" placeholder="BD Jobs Style">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Slug</label>
                                                <input type="text" name="slug" class="crancy__item-input" value="{{ old('slug', $template->slug) }}" placeholder="bdjobs">
                                                @error('slug')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Blade View Path</label>
                                                <input type="text" name="view_path" class="crancy__item-input" value="{{ old('view_path', $template->view_path) }}" placeholder="frontend.cv.templates.bdjobs">
                                                <small>Example file: resources/views/frontend/cv/templates/bdjobs.blade.php = frontend.cv.templates.bdjobs</small>
                                                @error('view_path')
                                                    <span class="text-danger d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Status</label>
                                                <select name="is_active" class="crancy__item-input">
                                                    <option value="1" @selected(old('is_active', (int) $template->is_active) == 1)>Active</option>
                                                    <option value="0" @selected(old('is_active', (int) $template->is_active) == 0)>Inactive</option>
                                                </select>
                                                @error('is_active')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Preview Image</label>
                                                <input type="file" name="preview_image" class="crancy__item-input" accept=".jpg,.jpeg,.png,.webp,image/*">
                                                @error('preview_image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                                @if($template->preview_image)
                                                    <div class="mg-top-25">
                                                        <img src="{{ asset($template->preview_image) }}" alt="{{ $template->name }}" style="width: 96px; height: 124px; object-fit: cover; border-radius: 4px;">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="crancy-btn mg-top-25">
                                        {{ $template->exists ? 'Update Template' : 'Create Template' }}
                                    </button>
                                    <a href="{{ route('admin.cv-templates.index') }}" class="btn btn-secondary mg-top-25">Back</a>
                                </form>
                            </div>

                            <div class="crancy-product-card mg-top-30">
                                <h4 class="crancy-product-card__title">How This Works</h4>
                                <p class="mg-top-25">
                                    The template design must exist as a Blade file. Admin creates the selectable template record here,
                                    then users can choose active templates from their Digital CV form.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
