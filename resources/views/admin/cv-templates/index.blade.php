@extends('admin.master_layout')

@section('title')
    <title>CV Templates</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">CV Templates</h3>
    <p class="crancy-header__text">Digital CV >> Templates</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-table crancy-table--v3 mg-top-30">
                                <div class="crancy-customer-filter d-flex justify-content-between align-items-center">
                                    <h4 class="crancy-product-card__title">CV Template List</h4>
                                    <a href="{{ route('admin.cv-templates.create') }}" class="crancy-btn">Create Template</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Preview</th>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th>View Path</th>
                                                <th>Status</th>
                                                <th>Used</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($templates as $template)
                                                <tr>
                                                    <td>
                                                        @if($template->preview_image)
                                                            <img src="{{ asset($template->preview_image) }}" alt="{{ $template->name }}" style="width: 54px; height: 70px; object-fit: cover; border-radius: 4px;">
                                                        @else
                                                            <span class="text-muted">No image</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $template->name }}</td>
                                                    <td>{{ $template->slug }}</td>
                                                    <td><code>{{ $template->view_path }}</code></td>
                                                    <td>
                                                        <span class="btn btn-sm {{ $template->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                            {{ $template->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $template->cvs_count }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.cv-templates.preview', $template) }}" class="btn btn-info btn-sm" target="_blank" title="Preview Template">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.cv-templates.edit', $template) }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.cv-templates.destroy', $template) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this CV template?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No CV templates found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mg-top-25">
                                    {{ $templates->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
