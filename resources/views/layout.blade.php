<!DOCTYPE html>
<html lang="en">
    @include('frontend.head')
  <body>

    <!-- Menu Start -->
    <div class="optech-preloader-wrap">
        <div class="optech-preloader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- End preloader -->


    <!-- progress circle -->
    <div class="paginacontainer">
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
            <div class="top-arrow">
                <i class="ri-arrow-up-s-line"></i>
            </div>
        </div>
    </div>

    @yield('front-content')

    @include('frontend.script')

    @stack('js_section')

  </body>
</html>
