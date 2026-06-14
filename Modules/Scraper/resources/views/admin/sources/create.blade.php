@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Create Scraper Source') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Create Scraper Source') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Create Scraper Source') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <form action="{{ route('admin.scraper.sources.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Create Scraper Source') }}</h4>
                                                <a href="{{ route('admin.scraper.sources.index') }}" class="crancy-btn"><i class="fa fa-list"></i> {{ __('translate.Source List') }}</a>
                                            </div>

                                            <div class="row mg-top-30">
                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Name') }} *</label>
                                                        <input class="crancy__item-input" type="text" name="name" required placeholder="e.g. Bangladesh Bank Careers">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Target URL') }} *</label>
                                                        <input class="crancy__item-input" type="url" name="url" required placeholder="https://example.com/jobs">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Scraper Type') }} *</label>
                                                        <select class="crancy__item-input form-select" name="type" required style="height: 50px;">
                                                            <option value="css">HTML / CSS Selector</option>
                                                            <option value="api">API Endpoint (JSON)</option>
                                                            <option value="rss">RSS Feed</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.List Item Selector (XPath)') }}</label>
                                                        <input class="crancy__item-input" type="text" name="selectors[list]" placeholder="e.g. //div[contains(@class, 'job-post')]">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Title Selector (XPath relative)') }}</label>
                                                        <input class="crancy__item-input" type="text" name="selectors[title]" placeholder="e.g. .//h3/a">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Description Selector (XPath relative)') }}</label>
                                                        <input class="crancy__item-input" type="text" name="selectors[description]" placeholder="e.g. .//div[@class='details']">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{__('Status')}}</label>
                                                        <div class="crancy-ptabs__notify-switch crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                                 <input name="status" type="checkbox" checked value="1">
                                                                 <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="crancy-btn mg-top-25" type="submit">{{ __('translate.Save') }}</button>
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
