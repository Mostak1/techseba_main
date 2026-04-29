@extends('admin.master_layout')

@section('title')
    <title>Edit {{ $page->name }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">Edit {{ $page->name }}</h3>
    <p class="crancy-header__text">CMS & Blogs >> Page Permission Management</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-product-card mg-top-30">
                                <h4 class="crancy-product-card__title">Page Settings</h4>

                                <form action="{{ route('admin.page-sections.update-page', $page) }}" method="POST" class="mg-top-25">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Page Name</label>
                                                <input type="text" name="name" class="crancy__item-input" value="{{ old('name', $page->name) }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Slug</label>
                                                <input type="text" name="slug" class="crancy__item-input" value="{{ old('slug', $page->slug) }}" @readonly($page->is_managed)>
                                                @if($page->is_managed)
                                                    <small>Existing page slug is fixed because it is connected to a live route.</small>
                                                @endif
                                                @error('slug')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Menu Status</label>
                                                <select name="is_enabled" class="crancy__item-input">
                                                    <option value="1" @selected(old('is_enabled', (int) $page->is_enabled) == 1)>Enable</option>
                                                    <option value="0" @selected(old('is_enabled', (int) $page->is_enabled) == 0)>Disable</option>
                                                </select>
                                                @error('is_enabled')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="crancy-btn mg-top-25">Update Page</button>
                                </form>
                            </div>

                            @if($page->is_managed)
                                <div class="crancy-product-card mg-top-30">
                                    <h4 class="crancy-product-card__title">Existing Page</h4>
                                    <p class="mg-top-25">This page uses the existing Blade layout. Only the page permission controls whether it appears in menus and whether the route is accessible.</p>
                                </div>
                            @else
                            <div class="crancy-product-card mg-top-30">
                                <h4 class="crancy-product-card__title">Sections</h4>

                                <form action="{{ route('admin.page-sections.update-sections', $page) }}" method="POST" class="mg-top-25">
                                    @csrf
                                    @method('PUT')

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Section Name</th>
                                                    <th>Identifier</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($page->sections as $section)
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="sections[{{ $section->id }}][section_name]" class="form-control" value="{{ old("sections.{$section->id}.section_name", $section->section_name) }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="sections[{{ $section->id }}][section_identifier]" class="form-control" value="{{ old("sections.{$section->id}.section_identifier", $section->section_identifier) }}">
                                                        </td>
                                                        <td>
                                                            <select name="sections[{{ $section->id }}][status]" class="form-control">
                                                                <option value="enable" @selected(old("sections.{$section->id}.status", $section->status) === 'enable')>Enable</option>
                                                                <option value="disable" @selected(old("sections.{$section->id}.status", $section->status) === 'disable')>Disable</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No sections found.</td>
                                                    </tr>
                                                @endforelse

                                                <tr>
                                                    <td>
                                                        <input type="text" name="new_section_name" class="form-control" value="{{ old('new_section_name') }}" placeholder="FAQ">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="new_section_identifier" class="form-control" value="{{ old('new_section_identifier') }}" placeholder="faq">
                                                    </td>
                                                    <td>
                                                        <select name="new_section_status" class="form-control">
                                                            <option value="enable">Enable</option>
                                                            <option value="disable">Disable</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-success btn-sm">Add</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <button type="submit" class="crancy-btn mg-top-25">Update Sections</button>
                                </form>

                                @if($page->sections->isNotEmpty())
                                    <div class="mg-top-25">
                                        @foreach($page->sections as $section)
                                            <form action="{{ route('admin.page-sections.destroy-section', $section) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this section?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mb-2">
                                                    Delete {{ $section->section_name }}
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @endif

                            <a href="{{ route('admin.page-sections.index') }}" class="crancy-btn mg-top-30">Back to Pages</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
