@extends('master_layout')

@yield('title')

@section('new-layout')
    <!-- delete account modal  -->
    <div class="modal delet_account_modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- delet_icon  -->
                    <div class="delet_icon_main">
                        <span class="delet_icon">
                            <svg width="39" height="44" viewBox="0 0 39 44" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M14.6357 19.3624C15.4943 19.2765 16.26 19.903 16.3458 20.7617L17.3875 31.1784C17.4735 32.0369 16.8468 32.8028 15.9883 32.8886C15.1296 32.9744 14.3639 32.348 14.2781 31.4892L13.2364 21.0726C13.1505 20.214 13.777 19.4482 14.6357 19.3624Z"
                                      fill="#FF9191"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M25.3633 19.3624C26.2218 19.4482 26.8483 20.214 26.7624 21.0726L25.7208 31.4892C25.6349 32.348 24.8693 32.9744 24.0105 32.8886C23.152 32.8028 22.5255 32.0369 22.6114 31.1784L23.653 20.7617C23.7389 19.903 24.5045 19.2765 25.3633 19.3624Z"
                                      fill="#FF9191"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M16.0904 0.604532H23.1352C23.5861 0.604241 23.9788 0.603991 24.3496 0.66322C25.8148 0.897178 27.0827 1.81105 27.7679 3.12707C27.9415 3.46018 28.0654 3.83284 28.2077 4.26062L28.4402 4.95832C28.4796 5.07643 28.4909 5.10987 28.5004 5.1362C28.8652 6.14476 29.8111 6.82655 30.8834 6.85374C30.9115 6.85445 30.9461 6.85457 31.0711 6.85457H37.3211C38.1842 6.85457 38.8836 7.55412 38.8836 8.41707C38.8836 9.28001 38.1842 9.97957 37.3211 9.97957H1.9043C1.04136 9.97957 0.341797 9.28001 0.341797 8.41707C0.341797 7.55412 1.04136 6.85457 1.9043 6.85457H8.15448C8.27957 6.85457 8.31409 6.85445 8.3423 6.85374C9.41448 6.82655 10.3604 6.14482 10.7252 5.13624C10.7348 5.10972 10.7458 5.07701 10.7854 4.95832L11.0179 4.26066C11.1602 3.83291 11.2842 3.46018 11.4576 3.12707C12.1429 1.81105 13.4108 0.897178 14.876 0.66322C15.2469 0.603991 15.6397 0.604241 16.0904 0.604532ZM13.3796 6.85457C13.4869 6.64412 13.582 6.42541 13.6638 6.19924C13.6887 6.13055 13.713 6.05745 13.7443 5.96353L13.9523 5.33974C14.1422 4.76993 14.1859 4.65372 14.2293 4.57041C14.4578 4.13172 14.8804 3.82712 15.3688 3.74912C15.4616 3.7343 15.5856 3.72957 16.1863 3.72957H23.0394C23.64 3.72957 23.764 3.7343 23.8569 3.74912C24.3452 3.82712 24.7679 4.13172 24.9963 4.57041C25.0396 4.65372 25.0834 4.76991 25.2734 5.33974L25.4811 5.96316L25.5619 6.19928C25.6436 6.42543 25.7388 6.64412 25.8461 6.85457H13.3796Z"
                                      fill="#FF0000"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M5.6598 14.15C6.52082 14.0926 7.26536 14.7441 7.32278 15.6051L8.28098 29.9782C8.46817 32.7863 8.60157 34.7401 8.89442 36.2101C9.17848 37.6361 9.57501 38.3909 10.1446 38.9238C10.7142 39.4565 11.4937 39.8022 12.9354 39.9907C14.4217 40.1851 16.38 40.1882 19.1942 40.1882H20.8055C23.6196 40.1882 25.578 40.1851 27.0642 39.9907C28.5059 39.8022 29.2855 39.4565 29.855 38.9238C30.4246 38.3909 30.8213 37.6361 31.1053 36.2101C31.3982 34.7401 31.5315 32.7863 31.7188 29.9782L32.6769 15.6051C32.7342 14.7441 33.4788 14.0926 34.3398 14.15C35.2009 14.2074 35.8523 14.9519 35.795 15.813L34.8294 30.2957C34.6513 32.9682 34.5075 35.1268 34.17 36.8207C33.8192 38.5818 33.2225 40.0528 31.99 41.2057C30.7575 42.3588 29.25 42.8563 27.4696 43.0893C25.7569 43.3132 23.5936 43.3132 20.9153 43.3132H19.0844C16.4061 43.3132 14.2427 43.3132 12.5301 43.0893C10.7495 42.8563 9.24215 42.3588 8.00967 41.2057C6.77717 40.0528 6.18046 38.5818 5.82965 36.8207C5.49219 35.1268 5.34832 32.9682 5.17021 30.2957L4.20469 15.813C4.14728 14.9519 4.79876 14.2074 5.6598 14.15Z"
                                      fill="#FF0000"/>
                            </svg>
                        </span>
                    </div>
                    <!-- modal body text  -->
                    <div class="modal_body_text">
                        <h4>
                            {{ __('translate.Deleting Account') }}
                        </h4>

                        <p>
                            {{ __('translate.Confirm your want to delete your account forever.') }}
                        </p>
                    </div>
                    <!-- modal form  -->
                    <form class="d_change_password_box_form" action="{{ route('user.confirm-account-delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="d_profile_setting_from_item">
                            <div class="optech-checkout-field">
                                <label>{{ __('translate.Current Password*') }}</label>
                                <input type="password" placeholder="Current Password" name="password">

                            </div>
                        </div>
                        <div class="d_profile_setting_from_btn">
                            <button class="optech-default-btn red" data-text="{{ __('translate.Delete Account') }}">
                                <span class="btn-wraper">{{ __('translate.Delete Account') }}</span>
                            </button>

                            <button class="optech-default-btn two" type="button" data-text="{{ __('translate.Cancel') }}" data-bs-dismiss="modal">
                                <span class="btn-wraper">{{ __('translate.Cancel') }}</span>
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- logout modal  -->
    <div class="modal delet_account_modal logout_modal fade" id="exampleModal2" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- delete_icon  -->
                    <div class="delet_icon_main">
                        <span class="delet_icon">
                            <svg width="49" height="42" viewBox="0 0 49 42" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M41.9899 24.4544C41.2869 25.1574 41.2869 26.2971 41.9899 27C42.6928 27.703 43.8325 27.703 44.5355 27L47.6384 23.8971C49.2787 22.2569 49.2786 19.5975 47.6384 17.9573L44.5355 14.8544C43.8325 14.1514 42.6928 14.1514 41.9899 14.8544C41.2869 15.5573 41.2869 16.697 41.9899 17.4L43.7171 19.1272H29.0383C28.0442 19.1272 27.2383 19.9331 27.2383 20.9272C27.2383 21.9213 28.0442 22.7272 29.0383 22.7272H43.7171L41.9899 24.4544Z"
                                      fill="#FF0000"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M12.2383 42.0003H29.6384C35.9345 42.0003 41.0385 36.8963 41.0385 30.6002C41.0385 29.6061 40.2326 28.8002 39.2385 28.8002C38.2444 28.8002 37.4385 29.6061 37.4385 30.6002C37.4385 34.9081 33.9463 38.4003 29.6384 38.4003H20.5522C18.4725 40.6162 15.517 42.0003 12.2383 42.0003ZM29.6384 0H12.2383C15.517 0 18.4725 1.38416 20.5522 3.60003H29.6384C33.9463 3.60003 37.4385 7.09223 37.4385 11.4001C37.4385 12.3942 38.2444 13.2001 39.2385 13.2001C40.2326 13.2001 41.0385 12.3942 41.0385 11.4001C41.0385 5.10399 35.9345 0 29.6384 0Z"
                                      fill="#FF0000"/>
                                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0.837891 11.4001C0.837891 5.10399 5.94188 0 12.238 0C18.5341 0 23.6381 5.10399 23.6381 11.4001V30.6002C23.6381 36.8963 18.5341 42.0003 12.238 42.0003C5.94189 42.0003 0.837891 36.8963 0.837891 30.6002V11.4001Z"
                                      fill="#FF0000"/>
                            </svg>
                        </span>
                    </div>
                    <!-- modal body text  -->
                    <div class="modal_body_text">
                        <h4>
                            {{ __('translate.Logout') }}
                        </h4>

                        <p>
                            {{ __('translate.Are you sure you want to log out from system ?') }}
                        </p>
                    </div>
                    <!-- logout modal button  -->
                    <div class="d_profile_setting_from_btn">
                        <form method="get" action="{{ route('user.logout') }}">
                            @csrf
                            <button class="optech-default-btn red" data-text="{{ __('translate.Logout') }}">
                                <span class="btn-wraper">{{ __('translate.Logout') }}</span>
                            </button>
                        </form>

                        <button class="optech-default-btn two" data-text="Cancel" data-bs-dismiss="modal">
                            <span class="btn-wraper">{{ __('translate.Cancel') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- progress circle -->
    <div class="paginacontainer">
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
            </svg>
            <div class="top-arrow">
                <i class="ri-arrow-up-s-line"></i>
            </div>
        </div>
    </div>

    <header class="site-header optech-header-section" id="sticky-menu">
        <div class="optech-header-top bg-light1">
            <div class="container">
                <div class="optech-header-info-wrap">
                    <div class="optech-header-info dark-color ">
                        <ul>
                            <li><i class="ri-map-pin-2-fill"></i>{{ $footer->address }}</li>
                            <li><a href="tel:{{ $footer->phone }}"><i class="ri-phone-fill"></i>{{ $footer->phone }}</a>
                            </li>
                            <li><a href="mailto:{{ $footer->email }}"><i class="ri-mail-fill"></i>{{ $footer->email }}
                                </a></li>
                        </ul>
                    </div>

                    <div class="optech-header-info-right two">
                        <div class="cur_lun_login_item ">
                            <span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM12 11.25C11.3096 11.25 10.75 10.6904 10.75 10C10.75 9.30964 11.3096 8.75 12 8.75C12.6904 8.75 13.25 9.30964 13.25 10C13.25 10.4142 13.5858 10.75 14 10.75C14.4142 10.75 14.75 10.4142 14.75 10C14.75 8.74122 13.9043 7.67998 12.75 7.35352V6.5C12.75 6.08579 12.4142 5.75 12 5.75C11.5858 5.75 11.25 6.08579 11.25 6.5V7.35352C10.0957 7.67998 9.25 8.74122 9.25 10C9.25 11.5188 10.4812 12.75 12 12.75C12.6904 12.75 13.25 13.3096 13.25 14C13.25 14.6904 12.6904 15.25 12 15.25C11.3096 15.25 10.75 14.6904 10.75 14C10.75 13.5858 10.4142 13.25 10 13.25C9.58579 13.25 9.25 13.5858 9.25 14C9.25 15.2588 10.0957 16.32 11.25 16.6465V17.5C11.25 17.9142 11.5858 18.25 12 18.25C12.4142 18.25 12.75 17.9142 12.75 17.5V16.6465C13.9043 16.32 14.75 15.2588 14.75 14C14.75 12.4812 13.5188 11.25 12 11.25Z"
                                        fill="#0a165e"/>
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
                                        fill="#0a165e"/>
                                </svg>
                            </span>
                            <form action="{{ route('language-switcher') }}" id="language_form">
                                <select id="language_dropdown" class="js-example-basic-single" name="lang_code">
                                    @foreach ($language_list as $language_item)
                                        <option
                                            {{ Session::get('front_lang') == $language_item->lang_code ? 'selected' : '' }} value="{{ $language_item->lang_code }}">{{ $language_item->lang_name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <div class="cur_lun_login_item">
                            <span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11ZM12 21C15.866 21 19 19.2091 19 17C19 14.7909 15.866 13 12 13C8.13401 13 5 14.7909 5 17C5 19.2091 8.13401 21 12 21Z"
                                        fill="#0a165e"/>
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

    </header>

    <div class="optech-header-search-section">
        <div class="container">
            <div class="optech-header-search-box">
                <input type="search" placeholder="Search here...">
                <button id="header-search" type="button"><i class="ri-search-line"></i></button>
                <p>Type above and press Enter to search. Press Close to cancel.</p>
            </div>
        </div>
        <div class="optech-header-search-close">
            <i class="ri-close-line"></i>
        </div>
    </div>

    <div class="search-overlay"></div>
    <!--End index-header-section -->
    <div class="optech-breadcrumb">
        <div class="container">
            @yield('breadcrumb')
        </div>
    </div>
    <!-- End breadcrumb -->
    <div class="section optech-section-padding">
        <div class="container">
            <div class="dashbord_bg">
                <div class="row">
                    @include('user.sidebar')
                    <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                       @yield('dashboard-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End section -->
@endsection
