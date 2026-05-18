<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @yield('title')
    @include('frontend.seo')

    <link rel="shortcut icon" href="{{ asset($general_setting->favicon) }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <!-- End google font  -->

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('global/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">

    <!-- Code Editor  -->

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/app.min.css') }}">

    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">

    @stack('style_section')




    @if ($general_setting->google_analytic_status == 1)
        <script async
                src="https://www.googletagmanager.com/gtag/js?id={{ $general_setting->google_analytic_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', '{{ $general_setting->google_analytic_id }}');
        </script>
    @endif


    @if ($general_setting->pixel_status == 1)
        @php
            $pixel_event_id = uniqid();
        @endphp
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $general_setting->pixel_app_id }}');
            fbq('track', 'PageView', {}, {eventID: '{{ $pixel_event_id }}'});
        </script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id={{ $general_setting->pixel_app_id }}&ev=PageView&noscript=1"
            /></noscript>
        @php
            \App\Helper\FacebookCapiHelper::sendEvent('PageView', [], [], $pixel_event_id);
        @endphp
    @endif



    <style>
        :root {
            --heading-color: {{ $general_setting->theme_heading_color ?? '#07145c' }};
            --body-color: {{ $general_setting->theme_body_color ?? '#565b6e' }};
            --accent-color: {{ $general_setting->theme_accent_color ?? '#2f55f6' }};
            --white-color: {{ $general_setting->theme_white_color ?? '#ffffff' }};
            --light-color1: {{ $general_setting->theme_light_color1 ?? '#e7e8f2' }};
            --light-color2: {{ $general_setting->theme_light_color2 ?? '#c9cddc' }};
            --dark-bg: {{ $general_setting->theme_dark_bg ?? '#06104b' }};
            --dark-bg2: {{ $general_setting->theme_dark_bg2 ?? '#20295e' }};
            --dark-bg3: {{ $general_setting->theme_dark_bg3 ?? '#071e73' }};
            --white-bg: {{ $general_setting->theme_white_bg ?? '#ffffff' }};
            --accent-bg: {{ $general_setting->theme_accent_bg ?? '#2f55f6' }};
            --light-bg1: {{ $general_setting->theme_light_bg1 ?? '#f5f6fb' }};
            --light-bg2: {{ $general_setting->theme_light_bg2 ?? '#eef1ff' }};
            --light-bg3: {{ $general_setting->theme_light_bg3 ?? '#f8f9ff' }};
        }
    </style>
</head>
