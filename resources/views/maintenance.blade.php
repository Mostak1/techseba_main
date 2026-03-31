

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ env('APP_NAME') }} || {{ __('translate.Maintenance') }}</title>

    <link rel="shortcut icon" href="{{ asset($general_setting->favicon) }}" type="image/x-icon">


    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <!-- End google font  -->

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('global/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">

    <!-- Code Editor  -->

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/app.min.css') }}">

  </head>
  <body>


    <main>
        <section class="bg-offWhite py-80 h-100vh">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-7 col-12">

                @php
                    $maintenance_text = Modules\GlobalSetting\App\Models\GlobalSetting::where('key', 'maintenance_text')->first();
                    $maintenance_image = Modules\GlobalSetting\App\Models\GlobalSetting::where('key', 'maintenance_image')->first();
                @endphp


                <div
                  class=" p-5 rounded-3 not-found-img d-flex flex-column flex-wrap align-items-center"
                >
                  <img
                    src="{{ asset($maintenance_image->value) }}"
                    class="img-fluid"
                    alt=""
                  />
                </div>
                <div class="text-center not-found-text">

                  <p >{!! clean(nl2br($maintenance_text->value)) !!}</p>

                </div>
              </div>
            </div>
          </div>
        </section>
      </main>


      <script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
      <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>


    </body>
  </html>
