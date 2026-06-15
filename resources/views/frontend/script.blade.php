@if (($general_setting->cookie_consent_status ?? 0) == 1)
    <!-- common-modal start  -->
    <div class="common-modal cookie_consent_modal d-none bg-white">
        <button type="button" class="btn-close cookie_consent_close_btn" aria-label="Close"></button>

        <h5>{{ __('translate.Cookies') }}</h5>
        <p>{{ $general_setting->cookie_consent_message }}</p>


        <a href="javascript:;"
           class="td_btn td_style_1 td_type_3 td_radius_30 td_medium td_fs_14 report-modal-btn cookie_consent_accept_btn">
                                        <span class="td_btn_in td_accent_color">
                                        <span>{{ __('translate.Accept') }}</span>
                                        </span>
        </a>

    </div>
    <!-- common-modal end  -->
@endif


@if (($general_setting->tawk_status ?? 0) == 1)
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = '{{ $general_setting->tawk_chat_link }}';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
@endif



<!-- Jquery -->

<script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('global/select2/select2.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/menu/menu.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/slick.js') }}"></script>
<script src="{{ asset('frontend/assets/js/countdown.js') }}"></script>
<script src="{{ asset('frontend/assets/js/skillbar.js') }}"></script>
<script src="{{ asset('frontend/assets/js/slick-animation.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/faq.js') }}"></script>
<script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/tabs-slider.js') }}"></script>
<script src="{{ asset('frontend/assets/js/top-to-bottom.js') }}"></script>
<script src="{{ asset('frontend/assets/js/aos.js') }}"></script>


<script src="{{ asset('frontend/assets/js/cart.js') }}"></script>
<script src="{{ asset('frontend/assets/js/app.js') }}"></script>
<script src="{{ asset('global/toastr/toastr.min.js') }}"></script>


<script>
    (function($) {
        "use strict";
        $(document).ready(function () {

            const session_notify_message = @json(Session::get('message'));
            const demo_mode_message = @json(Session::get('demo_mode'));

            if(session_notify_message != null){
                const session_notify_type = @json(Session::get('alert-type', 'info'));
                switch (session_notify_type) {
                    case 'info':
                        toastr.info(session_notify_message);
                        break;
                    case 'success':
                        toastr.success(session_notify_message);
                        break;
                    case 'warning':
                        toastr.warning(session_notify_message);
                        break;
                    case 'error':
                        toastr.error(session_notify_message);
                        break;
                }
            }

            if(demo_mode_message != null){
                toastr.warning("{{ __('translate.All Language keywords are not implemented in the demo mode') }}");
                toastr.info("{{ __('translate.Admin can translate every word from the admin panel') }}");
            }

            const validation_errors = @json($errors->all());

            if (validation_errors.length > 0) {
                validation_errors.forEach(error => toastr.error(error));
            }


            $("#currency_dropdown").on("change", function(){
                $("#currency_form").submit();
            });

            $("#language_dropdown").on("change", function(){
                $("#language_form").submit();
            });


            $(document).on('click', '.cart-add-btn', function (e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                var quantity = $('input[name="quantity"]').val() || 1;
                var $this = $(this);

                // Create Form Data
                let formData = new FormData();
                formData.append('product_id', productId);
                formData.append('quantity', quantity);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('cart.add') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $this.attr("disabled", true);
                    },
                    complete: function () {
                        $this.attr("disabled", false);
                    },
                    success: function (response) {
                        if (response.success) {
                            $('.cart-count').text(response.totalCartItem);

                            // Push add_to_cart event to GA4 dataLayer
                            if (typeof window.dataLayer !== 'undefined' && response.product) {
                                window.dataLayer.push({
                                    event: "add_to_cart",
                                    ecommerce: {
                                        currency: "BDT",
                                        value: parseFloat(response.product.price) * parseInt(quantity),
                                        items: [
                                            {
                                                item_id: String(response.product.id),
                                                item_name: response.product.name,
                                                price: parseFloat(response.product.price),
                                                item_category: response.product.category || "",
                                                quantity: parseInt(quantity)
                                            }
                                        ]
                                    }
                                });
                            }

                            toastr.success("{{ __('translate.Cart Added Successfully') }}");
                        } else {
                            toastr.error("{{ __('translate.Something Went Wrong') }}");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX error:", xhr.responseText);
                    }
                });
            });

            let $searchForm = $("#searchForm"),
                $searchInput = $("#searchInput"),
                $searchButton = $("#header-search"),
                $closeButton = $(".optech-header-search-close"),
                $searchSection = $(".optech-header-search-section");

            // Handle search button click
            $searchButton.on("click", function() {
                if ($searchInput.val().trim()) {
                    $searchForm.submit();
                }
            });

            // Handle Enter key press
            $searchInput.on("keypress", function(e) {
                if (e.key === "Enter" && $searchInput.val().trim()) {
                    e.preventDefault();
                    $searchForm.submit();
                }
            });

            // Handle close button click
            $closeButton.on("click", function() {
                $searchSection.hide();
                $searchInput.val("");
            });


            if (localStorage.getItem('optech-cookie') != '1') {
                $('.cookie_consent_modal').removeClass('d-none');
            }

            $('.cookie_consent_close_btn').on('click', function () {
                $('.cookie_consent_modal').addClass('d-none');
            });

            $('.cookie_consent_accept_btn').on('click', function () {
                localStorage.setItem('optech-cookie', '1');
                $('.cookie_consent_modal').addClass('d-none');
            });

            // --- CUSTOM DARK FUTURE SCROLL REVEAL & CANVAS SCRIPTS ---
            const canvas = document.getElementById('heroCanvas');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                let animationFrameId;
                function resize(){
                    canvas.width=window.innerWidth;
                    canvas.height=window.innerHeight;
                }
                resize();
                window.addEventListener('resize',resize);

                const dots=[];
                for(let i=0;i<80;i++){
                  dots.push({
                      x:Math.random()*window.innerWidth,
                      y:Math.random()*window.innerHeight,
                      vx:(Math.random()-.5)*.3,
                      vy:(Math.random()-.5)*.3,
                      r:Math.random()*2+1
                  });
                }

                function draw(){
                  ctx.clearRect(0,0,canvas.width,canvas.height);
                  dots.forEach(d=>{
                    d.x+=d.vx;d.y+=d.vy;
                    if(d.x<0||d.x>canvas.width)d.vx*=-1;
                    if(d.y<0||d.y>canvas.height)d.vy*=-1;
                    ctx.beginPath();
                    ctx.arc(d.x,d.y,d.r,0,Math.PI*2);
                    ctx.fillStyle='rgba(0,212,255,0.5)';
                    ctx.fill();
                  });
                  dots.forEach((a,i)=>{
                    dots.slice(i+1).forEach(b=>{
                      const dist=Math.hypot(a.x-b.x,a.y-b.y);
                      if(dist<120){
                        ctx.beginPath();
                        ctx.moveTo(a.x,a.y);ctx.lineTo(b.x,b.y);
                        ctx.strokeStyle=`rgba(0,212,255,${.3*(1-dist/120)})`;
                        ctx.lineWidth=.6;ctx.stroke();
                      }
                    });
                  });
                  animationFrameId = requestAnimationFrame(draw);
                }
                draw();
            }

            // HAMBURGER
            $('#hamburger').click(function(){
              $('#mobileNav').toggleClass('open');
              $(this).toggleClass('active');
            });

            // SCROLL REVEAL
            function revealOnScroll(){
              $('.reveal').each(function(){
                const el = $(this);
                if (el.length && el.offset()) {
                    const top=el.offset().top;
                    const windowBottom=$(window).scrollTop()+$(window).height();
                    if(windowBottom>top+60){el.addClass('visible');}
                }
              });
            }
            $(window).on('scroll',revealOnScroll);
            revealOnScroll();

            // COUNTER ANIMATION
            function animateCounters(){
              $('.stat-num,.num').each(function(){
                const el=$(this);
                if (el.length && el.offset()) {
                    const text=el.text();
                    const num=parseInt(text.replace(/\D/g,''));
                    const suffix=text.replace(/[\d]/g,'');
                    if(el.data('animated'))return;
                    const top=el.offset().top;
                    if($(window).scrollTop()+$(window).height()>top){
                      el.data('animated',true);
                      $({n:0}).animate({n:num},{duration:1500,easing:'swing',step:function(){el.text(Math.floor(this.n)+suffix);}});
                    }
                }
              });
            }
            $(window).on('scroll',animateCounters);
            animateCounters();

        });
    })(jQuery);

</script>
