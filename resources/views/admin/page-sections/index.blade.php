@extends('admin.master_layout')

@section('title')
    <title>Page Section Management</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">Page Permission Management</h3>
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
                                <h4 class="crancy-product-card__title">Create Dynamic Page</h4>

                                <form action="{{ route('admin.page-sections.store') }}" method="POST" class="mg-top-25">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Page Name</label>
                                                <input type="text" name="name" class="crancy__item-input" value="{{ old('name') }}" placeholder="About Us">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Slug</label>
                                                <input type="text" name="slug" class="crancy__item-input" value="{{ old('slug') }}" placeholder="about-us">
                                                @error('slug')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Menu Status</label>
                                                <select name="is_enabled" class="crancy__item-input">
                                                    <option value="1" @selected(old('is_enabled', '1') == '1')>Enable</option>
                                                    <option value="0" @selected(old('is_enabled') == '0')>Disable</option>
                                                </select>
                                                @error('is_enabled')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 mg-top-25">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label">Default Sections</label>
                                                <textarea name="sections" class="crancy__item-input" rows="4" placeholder="Hero|hero&#10;About|about&#10;Services|services">{{ old('sections', "Hero|hero\nAbout|about\nServices|services") }}</textarea>
                                                <small>Use one section per line: Section Name|section_identifier</small>
                                                @error('sections')
                                                    <span class="text-danger d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="crancy-btn mg-top-25">Create Page</button>
                                </form>
                            </div>

                            <div class="crancy-table crancy-table--v3 mg-top-30">
                                <div class="crancy-customer-filter">
                                    <h4 class="crancy-product-card__title">Pages</h4>
                                </div>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th>Type</th>
                                                <th>Menu</th>
                                                <th>Sections</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pages as $page)
                                                <tr>
                                                    <td>{{ $page->name }}</td>
                                                    <td>{{ $page->slug }}</td>
                                                    <td>{{ $page->is_managed ? 'Existing Page' : 'Dynamic Page' }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.page-sections.toggle-page', $page) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm {{ $page->is_enabled ? 'btn-success' : 'btn-secondary' }}">
                                                                {{ $page->is_enabled ? 'Enabled' : 'Disabled' }}
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td>{{ $page->is_managed ? 'Existing layout' : $page->enabled_sections_count . ' / ' . $page->sections_count . ' enabled' }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.page-sections.edit', $page) }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if($page->is_enabled)
                                                            <a href="{{ $page->menu_url }}" target="_blank" class="btn btn-info btn-sm">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No pages found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mg-top-25">
                                    {{ $pages->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
