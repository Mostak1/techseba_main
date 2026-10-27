@extends('admin.master_layout')

@section('title')
    <title>CV Templates</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">CV Templates</h3>
    <p class="crancy-header__text">Digital CV >> Templates</p>
@endsection

    <form id="syncJsonForm" action="{{ route('admin.cv-templates.sync-json') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-table crancy-table--v3 mg-top-30">
                                <div class="crancy-customer-filter d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                    <h4 class="crancy-product-card__title m-0">CV Template List</h4>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <button type="button" class="btn btn-outline-info btn-sm" onclick="if(confirm('Sync database templates from database/data/cv_templates.json?')) document.getElementById('syncJsonForm').submit();">
                                            <i class="fas fa-sync"></i> Sync with JSON File
                                        </button>

                                        <a href="{{ route('admin.cv-templates.permissions') }}" class="btn btn-outline-warning btn-sm text-dark">
                                            <i class="fas fa-user-lock"></i> User Permissions
                                            @if(($pendingRequestsCount ?? 0) > 0)
                                                <span class="badge badge-danger ml-1" style="background: #dc3545; color: #fff; padding: 2px 6px; border-radius: 999px;">{{ $pendingRequestsCount }} Pending</span>
                                            @endif
                                        </a>

                                        <a href="{{ route('admin.cv-templates.create') }}" class="crancy-btn btn-sm">
                                            <i class="fas fa-plus"></i> Create Template
                                        </a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Preview</th>
                                                <th>Name</th>
                                                <th>Pricing</th>
                                                <th>View Path</th>
                                                <th>Status</th>
                                                <th>Used</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($templates as $template)
                                                <tr>
                                                    <td><strong>#{{ $template->id }}</strong></td>
                                                    <td>
                                                        @if($template->preview_image)
                                                            <img src="{{ asset($template->preview_image) }}" alt="{{ $template->name }}" style="width: 50px; height: 65px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                                        @else
                                                            <div style="width: 50px; height: 65px; background: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #adb5bd;">
                                                                <i class="fas fa-file-alt"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $template->name }}</strong>
                                                        <br><small class="text-muted">{{ $template->slug }}</small>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('admin.cv-templates.toggle-premium', $template) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @if($template->is_premium)
                                                                <button type="submit" class="btn btn-sm btn-warning text-dark font-weight-bold" title="Click to change to Free">
                                                                    <i class="fas fa-crown"></i> Paid
                                                                </button>
                                                            @else
                                                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Click to change to Paid">
                                                                    Free
                                                                </button>
                                                            @endif
                                                        </form>
                                                    </td>
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
                                                        <a href="{{ route('admin.cv-templates.edit', $template) }}" class="btn btn-primary btn-sm" title="Edit Template">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.cv-templates.destroy', $template) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this CV template?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
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
