@php
    if (auth()->check()) {
        $userId = auth()->id();
        $totalCart = Modules\Ecommerce\Entities\Cart::where('user_id', $userId)->count();
    } else {
        $sessionId = session()->get('session_id');
        $totalCart = Modules\Ecommerce\Entities\Cart::where('session_id', $sessionId)->count();
    }
@endphp
<header class="site-header optech-header-section" id="sticky-menu">
    <div class="optech-header-top bg-light1">
        <div class="container">
            <div class="optech-header-info-wrap">
                <div class="optech-header-info dark-color">
                    <ul>
                        <li><i class="ri-map-pin-2-fill"></i>{{ $footer->address }}</li>
                        <li><a href="tel:{{ $footer->phone }}"><i class="ri-phone-fill"></i>{{ $footer->phone }}</a></li>
                        <li><a href="mailto:{{ $footer->email }}"><i class="ri-mail-fill"></i> {{ $footer->email }}</a></li>
                    </ul>
                </div>

                <div class="optech-header-info-right two">
                    <div class="cur_lun_login_item">
                         <span>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM12 11.25C11.3096 11.25 10.75 10.6904 10.75 10C10.75 9.30964 11.3096 8.75 12 8.75C12.6904 8.75 13.25 9.30964 13.25 10C13.25 10.4142 13.5858 10.75 14 10.75C14.4142 10.75 14.75 10.4142 14.75 10C14.75 8.74122 13.9043 7.67998 12.75 7.35352V6.5C12.75 6.08579 12.4142 5.75 12 5.75C11.5858 5.75 11.25 6.08579 11.25 6.5V7.35352C10.0957 7.67998 9.25 8.74122 9.25 10C9.25 11.5188 10.4812 12.75 12 12.75C12.6904 12.75 13.25 13.3096 13.25 14C13.25 14.6904 12.6904 15.25 12 15.25C11.3096 15.25 10.75 14.6904 10.75 14C10.75 13.5858 10.4142 13.25 10 13.25C9.58579 13.25 9.25 13.5858 9.25 14C9.25 15.2588 10.0957 16.32 11.25 16.6465V17.5C11.25 17.9142 11.5858 18.25 12 18.25C12.4142 18.25 12.75 17.9142 12.75 17.5V16.6465C13.9043 16.32 14.75 15.2588 14.75 14C14.75 12.4812 13.5188 11.25 12 11.25Z"
                                    fill="#0a165e" />
                            </svg>
                        </span>
                        <form action="{{ route('currency-switcher') }}" id="currency_form">
                            <select id="currency_dropdown" class="js-example-basic-single" name="currency_code">
                                @foreach ($currency_list as $currency_item)
                                    <option
                                        {{ Session::get('currency_code') == $currency_item->currency_code ? 'selected' : '' }} value="{{ $currency_item->currency_code }}">{{ $currency_item->currency_name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div class="cur_lun_login_item">
                       <span>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M7.87643 2.47813C7.18954 4.3671 6.75001 7.02637 6.75001 10C6.75001 10.3796 6.75718 10.754 6.7711 11.1224C7.79627 11.2054 8.87923 11.25 10 11.25C11.1208 11.25 12.2038 11.2054 13.2289 11.1224C13.2429 10.754 13.25 10.3796 13.25 10C13.25 7.02637 12.8105 4.3671 12.1236 2.47813C11.779 1.53057 11.3865 0.816517 10.9883 0.353377C10.8696 0.215345 10.7565 0.106123 10.6496 0.0207619C10.4349 0.00699121 10.2183 0 10 0C9.78177 0 9.56516 0.00699124 9.3504 0.020762C9.24349 0.106123 9.13042 0.215345 9.01175 0.353377C8.61357 0.816517 8.221 1.53057 7.87643 2.47813ZM13.1315 12.6346C12.1291 12.71 11.0797 12.75 10 12.75C8.92028 12.75 7.87096 12.71 6.86854 12.6346C7.04293 14.5326 7.40024 16.2123 7.87643 17.5219C8.221 18.4694 8.61357 19.1835 9.01175 19.6466C9.13042 19.7847 9.24348 19.8939 9.35039 19.9792C9.56516 19.993 9.78177 20 10 20C10.2183 20 10.4349 19.993 10.6496 19.9792C10.7565 19.8939 10.8696 19.7847 10.9883 19.6466C11.3865 19.1835 11.779 18.4694 12.1236 17.5219C12.5998 16.2123 12.9571 14.5326 13.1315 12.6346ZM5.26493 10.968C5.25504 10.6486 5.25001 10.3257 5.25001 10C5.25001 6.8985 5.70592 4.05777 6.46674 1.96552C6.67341 1.39719 6.90681 0.872262 7.16688 0.407001C3.12245 1.59958 0.144576 5.28026 0.00512695 9.67717C0.882073 10.0753 2.09222 10.433 3.56698 10.7066C4.104 10.8062 4.67155 10.8938 5.26493 10.968ZM0.0879116 11.3317C1.0045 11.6736 2.09274 11.9587 3.29339 12.1814C3.94235 12.3018 4.63038 12.4051 5.3503 12.4893C5.5238 14.6072 5.91514 16.5176 6.46674 18.0345C6.67341 18.6028 6.90681 19.1277 7.16688 19.593C3.43599 18.4929 0.612705 15.2755 0.0879116 11.3317ZM14.6497 12.4893C15.3697 12.4051 16.0577 12.3018 16.7066 12.1814C17.9073 11.9587 18.9955 11.6736 19.9121 11.3317C19.3873 15.2755 16.564 18.4929 12.8332 19.593C13.0932 19.1277 13.3266 18.6028 13.5333 18.0345C14.0849 16.5176 14.4762 14.6072 14.6497 12.4893ZM19.9949 9.67717C19.118 10.0753 17.9078 10.433 16.4331 10.7066C15.896 10.8062 15.3285 10.8938 14.7351 10.968C14.745 10.6486 14.75 10.3257 14.75 10C14.75 6.8985 14.2941 4.05777 13.5333 1.96552C13.3266 1.39719 13.0932 0.872265 12.8332 0.407004C16.8776 1.59958 19.8555 5.28026 19.9949 9.67717Z"
                                fill="#0a165e" />
                        </svg>
                      </span>

                        <form action="{{ route('language-switcher') }}" id="language_form">
                            <select id="language_dropdown" class="js-example-basic-single" name="lang_code">
                                @foreach ($language_list as $language_item)
                                    <option {{ Session::get('front_lang') == $language_item->lang_code ? 'selected' : '' }} value="{{ $language_item->lang_code }}">{{ $language_item->lang_name }}</option>
                                @endforeach
                            </select>
                        </form>

                    </div>
                    <div class="cur_lun_login_item">
                       <span>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11ZM12 21C15.866 21 19 19.2091 19 17C19 14.7909 15.866 13 12 13C8.13401 13 5 14.7909 5 17C5 19.2091 8.13401 21 12 21Z"
                                    fill="#0a165e" />
                            </svg>
                        </span>
                        @auth
                            <a href="{{ route('user.dashboard') }}" class="login-btn">{{ __('translate.Dashboard') }}</a>
                        @else
                            <a href="{{ route('user.login') }}" class="login-btn">{{ __('translate.Login') }}</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="optech-header-bottom bg-white">
        <div class="container">
            <nav class="navbar site-navbar">
                <!-- Brand Logo-->
                <div class="brand-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset($general_setting->logo) }}" alt="logo" class="light-version-logo">
                    </a>
                </div>

                @include('frontend.templates.layouts._menu_nav')


                <div class="header-btn header-btn-l1 ms-auto d-none d-xs-inline-flex">
                    <div class="optech-header-icon">

                        <div class="optech-header-search">
                            <i class="ri-search-line"></i>
                        </div>

                        @include('frontend.templates.layouts._cart')

                        <a class="optech-default-btn optech-header-btn" href="{{ route('contact-us') }}"
                           data-text="{{ __('translate.Get in Touch') }}"><span
                                class="btn-wraper">{{ __('translate.Get in Touch') }}</span>
                        </a>
                    </div>
                </div>
                <div class="mobile-menu-trigger">
                    <span></span>
                </div>
            </nav>
        </div>
    </div>

    @include('frontend.templates.layouts.search_bar')

</header>
