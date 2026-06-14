@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Scraper Sources') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Scraper Sources') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Scraper Sources') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-table crancy-table--v3 mg-top-30">
                                <div class="crancy-customer-filter">
                                    <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch d-flex items-center justify-between create_new_btn_box">
                                        <div class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Scraper Sources') }}</h4>
                                            <a href="{{ route('admin.scraper.sources.create') }}" class="crancy-btn">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                        <path d="M8 1V15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M1 8H15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </span> {{ __('translate.Create Source') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="crancy-table__main_wrapper" class="dt-bootstrap5 no-footer">
                                    <table class="crancy-table__main crancy-table__main-v3 no-footer" id="dataTable">
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Serial') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Name') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.URL') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Type') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Status') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Last Scraped') }}</th>
                                                <th class="crancy-table__column-3 crancy-table__h3">{{ __('translate.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @foreach ($sources as $index => $source)
                                                <tr class="odd">
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ ++$index }}</h4>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ $source->name }}</h4>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <a href="{{ $source->url }}" target="_blank" class="text-primary">{{ Str::limit($source->url, 40) }}</a>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2 text-uppercase">
                                                        <span class="badge bg-info text-white">{{ $source->type }}</span>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if ($source->status)
                                                            <span class="badge bg-success text-white">{{ __('translate.Active') }}</span>
                                                        @else
                                                            <span class="badge bg-danger text-white">{{ __('translate.Inactive') }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <span>{{ $source->last_scraped_at ? $source->last_scraped_at->format('Y-m-d H:i') : __('translate.Never') }}</span>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <form action="{{ route('admin.scraper.sources.run', $source->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="crancy-btn bg-success text-white border-0"><i class="fas fa-play"></i> {{ __('translate.Run') }}</button>
                                                        </form>
                                                        <a href="{{ route('admin.scraper.sources.edit', $source->id) }}" class="crancy-btn"><i class="fas fa-edit"></i> {{ __('translate.Edit') }}</a>
                                                        <a onclick="itemDeleteConfirmation({{ $source->id }})" href="javascript:;" data-bs-toggle="modal" data-bs-target="#deleteModal" class="crancy-btn delete_danger_btn"><i class="fas fa-trash"></i> {{ __('translate.Delete') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    {{ $sources->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ __('translate.Delete Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('translate.Are you sure you want to delete this source?') }}</p>
                </div>
                <div class="modal-footer">
                    <form action="" id="item_delete_form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                        <button type="submit" class="btn btn-danger text-white">{{ __('translate.Yes, Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_section')
    <script>
        "use strict";
        function itemDeleteConfirmation(id) {
            $("#item_delete_form").attr("action", '{{ url("admin/scraper/sources") }}/' + id);
        }
    </script>
@endpush
