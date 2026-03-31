@php
    $getProcessData = getContent('main_demo_process_section.content', true);
@endphp


<div class="container">
    <div class="optech-section-title center">
        <h2>{{ getTranslatedValue($getProcessData, 'heading', $currentLang) }} </h2>
    </div>
    <div class="row z-index">
        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="600">
            <div class="optech-numberbox-wrap">
                <div class="optech-numberbox-icon">
                    <img src="{{ asset(getImage($getProcessData, 'image_1')) }}" alt=""  class="full-img">
                </div>
                <div class="optech-numberbox-data">
                    <span>{{ __('translate.01') }}</span>
                    <h4>{{ getTranslatedValue($getProcessData, 'step_1', $currentLang) }}</h4>
                    <p>{{ getTranslatedValue($getProcessData, 'description_1', $currentLang) }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="800">
            <div class="optech-numberbox-wrap">
                <div class="optech-numberbox-icon">
                    <img src="{{ asset(getImage($getProcessData, 'image_2')) }}" alt=""  class="full-img">
                </div>
                <div class="optech-numberbox-data">
                    <span>{{ __('translate.02') }}</span>
                    <h4>{{ getTranslatedValue($getProcessData, 'step_2', $currentLang) }}</h4>
                    <p>{{ getTranslatedValue($getProcessData, 'description_2', $currentLang) }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1000">
            <div class="optech-numberbox-wrap">
                <div class="optech-numberbox-icon">
                    <img src="{{ asset(getImage($getProcessData, 'image_3')) }}" alt=""  class="full-img">
                </div>
                <div class="optech-numberbox-data">
                    <span>{{ __('translate.03') }}</span>
                    <h4>{{ getTranslatedValue($getProcessData, 'step_3', $currentLang) }}</h4>
                    <p>{{ getTranslatedValue($getProcessData, 'description_3', $currentLang) }}</p>
                </div>
            </div>
        </div>
        <div class="optech-line">
            <svg width="1296" height="1" viewBox="0 0 1296 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line y1="0.5" x2="1296" y2="0.5" stroke="#C6C9D8" stroke-dasharray="8 8"/>
            </svg>
        </div>
    </div>
</div>
