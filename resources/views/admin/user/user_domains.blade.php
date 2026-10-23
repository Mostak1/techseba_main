@extends('admin.master_layout')
@section('title')
    <title>{{ $title }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ $title }}</h3>
    <p class="crancy-header__text">{{ __('translate.Manage Users') }} >> {{ $title }}</p>
@endsection

@section('body-content')
    <!-- crancy Dashboard -->
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
                                            <h4 class="crancy-product-card__title">{{ $title }}</h4>
                                        </div>
                                        <div>
                                            <span class="badge bg-primary px-3 py-2" style="font-size: 13px;">Total Domains: {{ $domains->count() }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- crancy Table -->
                                <div id="crancy-table__main_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                                    <table class="crancy-table__main crancy-table__main-v3 dataTable no-footer" id="dataTable">
                                        <!-- crancy Table Head -->
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Serial') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.User') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Host / Domain') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Type') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Primary') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Verified At') }}
                                                </th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Status') }}
                                                </th>
                                                <th class="crancy-table__column-3 crancy-table__h3 sorting">
                                                    {{ __('translate.Action') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <!-- crancy Table Body -->
                                        <tbody class="crancy-table__body">
                                            @forelse ($domains as $index => $domain)
                                                <tr class="odd">
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ ++$index }}</h4>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if($domain->user)
                                                            <h4 class="crancy-table__product-title">
                                                                <a href="{{ route('admin.user-show', $domain->user->id) }}">
                                                                    {{ html_decode($domain->user->name) }}
                                                                </a>
                                                            </h4>
                                                            <span class="text-muted small">{{ html_decode($domain->user->email) }}</span>
                                                        @else
                                                            <span class="text-danger small">User Not Found</span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <div>
                                                            <strong class="text-primary">{{ $domain->host }}</strong>
                                                            <a href="{{ $domain->url }}" target="_blank" class="ms-1 text-info small" title="Visit">
                                                                <i class="fas fa-external-link-alt"></i>
                                                            </a>
                                                        </div>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if($domain->type == 'subdomain')
                                                            <span class="badge bg-info text-dark">Subdomain</span>
                                                        @else
                                                            <span class="badge bg-purple text-white" style="background: #7B4FFF;">Custom Domain</span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if($domain->is_primary)
                                                            <span class="badge bg-success"><i class="fas fa-star"></i> Primary</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if($domain->verified_at)
                                                            <span class="text-success small">{{ $domain->verified_at->format('d M, Y') }}</span>
                                                        @else
                                                            <span class="text-warning small"><i class="fas fa-clock"></i> Unverified</span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <form action="{{ route('admin.user-domains.toggle-status', $domain->id) }}" method="POST">
                                                            @csrf
                                                            <div class="crancy-ptabs__notify-switch crancy-ptabs__notify-switch--two">
                                                                <label class="crancy__item-switch">
                                                                    <input onchange="this.form.submit()" type="checkbox" {{ $domain->is_active ? 'checked' : '' }}>
                                                                    <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                                </label>
                                                            </div>
                                                        </form>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <form action="{{ route('admin.user-domains.delete', $domain->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this domain record?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="crancy-btn delete_danger_btn" style="padding: 6px 12px; font-size: 12px;">
                                                                <i class="fas fa-trash"></i> {{ __('translate.Delete') }}
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-4 text-muted">
                                                        {{ __('translate.No user domains or subdomains found.') }}
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                        <!-- End crancy Table Body -->
                                    </table>
                                </div>
                                <!-- End crancy Table -->
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End crancy Dashboard -->
@endsection
