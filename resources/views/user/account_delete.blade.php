@extends('seller.layout')
@section('title')
    <title>{{ __('translate.Seller || Account Delete') }}</title>
@endsection
@section('front-content')
<main class="dashboard-main min-vh-100">
    <div class="d-flex flex-column gap-4">
      <!-- Header -->
      <div>
        <h3 class="text-24 fw-bold text-dark-300 mb-2">{{ __('translate.Account Delete') }}</h3>
        <ul class="d-flex align-items-center gap-2">
          <li class="text-dark-200 fs-6">{{ __('translate.Dashboard') }}</li>
          <li>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="5"
              height="11"
              viewBox="0 0 5 11"
              fill="none"
            >
              <path
                d="M1 10L4 5.5L1 1"
                stroke="#5B5B5B"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </li>
          <li class="text-lime-300 fs-6">{{ __('translate.Account Delete') }}</li>
        </ul>
      </div>
      <!-- Content -->
      <div class="d-flex justify-content-center">
        <div class="bg-white p-4 p-md-5 rounded-4">
          <div
            class="d-flex flex-column justify-content-center align-items-center"
          >
            <span class="mb-30"
              ><svg
                xmlns="http://www.w3.org/2000/svg"
                width="136"
                height="136"
                viewBox="0 0 136 136"
                fill="none"
              >
                <circle cx="68" cy="68" r="68" fill="#FF3838" />
                <path
                  d="M93.0616 41.3534H83.258V39.9538C83.258 36.6708 80.5872 34 77.3043 34H59.4157C56.1328 34 53.462 36.6708 53.462 39.9538V41.3534H43.6584C41.0904 41.3534 39 43.4431 39 46.0111V48.2194C39 50.6234 40.8312 52.6072 43.171 52.8521L47.9677 94.9442C48.4249 98.964 51.822 101.995 55.8683 101.995H80.851C84.8972 101.995 88.2943 98.964 88.7515 94.9442L93.5483 52.8521C95.8888 52.608 97.7192 50.6234 97.7192 48.2194V46.0111C97.7192 43.4431 95.6296 41.3534 93.0616 41.3534ZM56.4857 39.9538C56.4857 38.3372 57.7999 37.023 59.4165 37.023H77.305C78.9216 37.023 80.2358 38.3372 80.2358 39.9538V41.3534H56.4857V39.9538ZM85.749 94.6018C85.4656 97.0935 83.3601 98.9723 80.8525 98.9723H55.8698C53.3622 98.9723 51.2567 97.0935 50.9733 94.6018L46.2189 52.8778H90.5041L85.749 94.6018ZM94.6978 48.2194C94.6978 49.121 93.9639 49.8548 93.0623 49.8548H43.6584C42.7568 49.8548 42.023 49.121 42.023 48.2194V46.0111C42.023 45.1102 42.7568 44.3764 43.6584 44.3764H93.0608C93.9624 44.3764 94.6962 45.1102 94.6962 46.0111V48.2194H94.6978Z"
                  fill="white"
                />
                <path
                  d="M68.3591 90.7912C69.1935 90.7912 69.8706 90.114 69.8706 89.2797V62.5701C69.8706 61.7357 69.1935 61.0586 68.3591 61.0586C67.5248 61.0586 66.8477 61.7357 66.8477 62.5701V89.2797C66.8477 90.114 67.5248 90.7912 68.3591 90.7912Z"
                  fill="white"
                />
                <path
                  d="M77.3965 90.7208C77.4464 90.7261 77.4963 90.7284 77.5447 90.7284C78.314 90.7284 78.9715 90.145 79.0471 89.3635L81.6363 62.7794C81.7172 61.9481 81.1095 61.2089 80.279 61.1281C79.4363 61.0427 78.7085 61.6548 78.6277 62.4854L76.0385 89.0695C75.9576 89.9009 76.566 90.64 77.3965 90.7208Z"
                  fill="white"
                />
                <path
                  d="M59.1777 90.7292C59.2261 90.7292 59.276 90.727 59.3258 90.7217C60.1564 90.6416 60.764 89.9017 60.6832 89.0704L58.094 62.4862C58.0131 61.6557 57.2853 61.0443 56.4427 61.1289C55.6121 61.209 55.0045 61.9489 55.0853 62.7802L57.6745 89.3644C57.7509 90.1451 58.4091 90.7292 59.1777 90.7292Z"
                  fill="white"
                /></svg></span>
            <p class="text-dark-200 mb-30 text-center">
              {{ __('translate.Notice: Remember you will not able to login this account') }}
              <br />
              {{ __('translate.after delete your account.') }}
            </p>
            <div class="d-flex gap-4 align-items-center">
              <button class="w-btn-secondary-lg" id="account_delete">{{ __('translate.Yes Delete') }}</button>
              <button class="text-danger text-decoration-underline" id="delete_cancel">
                {{ __('translate.Cancel') }}
              </button>

              <form id="delete_account" action="{{ route('user.confirm-account-delete') }}" method="POST">
                @csrf
                @method('DELETE')

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

@endsection




@push('js_section')
    <script src="{{ asset('global/sweetalert/sweetalert2@11.js') }}"></script>




    <script>
        (function($) {
            "use strict"
            $(document).ready(function () {
                $("#account_delete").on("click", function(){
                    Swal.fire({
                        title: "{{ __('translate.Are you realy want to delete your account ?') }}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "{{ __('translate.Yes, Delete It') }}",
                        cancelButtonText: "{{ __('translate.Cancel') }}",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#delete_account").submit();
                        }

                    })
                })

                $("#delete_cancel").on("click", function(){
                    window.location.reload()
                })

            });
        })(jQuery);


    </script>



@endpush
