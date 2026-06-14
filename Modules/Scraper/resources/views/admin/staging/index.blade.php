@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Scraped Staging Jobs') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Scraped Staging Jobs') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Scraped Staging Jobs') }}</p>
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
                                            <h4 class="crancy-product-card__title">{{ __('translate.Scraped Jobs (Staging Table)') }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div id="crancy-table__main_wrapper" class="dt-bootstrap5 no-footer">
                                    <table class="crancy-table__main crancy-table__main-v3 no-footer" id="dataTable">
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Serial') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Job Title') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Source') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Organization') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Scraped Date') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Status') }}</th>
                                                <th class="crancy-table__column-3 crancy-table__h3">{{ __('translate.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @foreach ($stagingJobs as $index => $job)
                                                <tr class="odd">
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ ++$index }}</h4>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ $job->title }}</h4>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <span>{{ $job->source->name }}</span>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <span>{{ $job->organization_name ?? 'N/A' }}</span>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <span>{{ $job->created_at->format('Y-m-d H:i') }}</span>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if ($job->status == 'pending')
                                                            <span class="badge bg-warning text-dark">{{ __('translate.Pending') }}</span>
                                                        @elseif ($job->status == 'approved')
                                                            <span class="badge bg-success text-white">{{ __('translate.Approved') }}</span>
                                                        @else
                                                            <span class="badge bg-danger text-white">{{ __('translate.Rejected') }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <a href="{{ route('admin.scraper.staging.show', $job->id) }}" class="crancy-btn"><i class="fas fa-eye"></i> {{ __('translate.Review') }}</a>
                                                        @if($job->status == 'pending')
                                                            <a href="{{ route('admin.scraper.staging.edit', $job->id) }}" class="crancy-btn"><i class="fas fa-edit"></i> {{ __('translate.Edit') }}</a>
                                                            <form action="{{ route('admin.scraper.staging.reject', $job->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="crancy-btn delete_danger_btn border-0"><i class="fas fa-times"></i> {{ __('translate.Reject') }}</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    {{ $stagingJobs->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
