@php
    $currentLang = session()->get('front_lang');
    $ctaContent = getContent('main_demo_cta_section.content', true);
@endphp

<div class="section bg-cover optech-section-padding cta-bg3  {{ Route::is('home') ? 'custom-image-two-home' : 'custom-image-two' }}">
    <div class="container">
        <div class="optech-cta-wrap">
            <div class="optech-cta-content center">
                <h2>{{ getTranslatedValue($ctaContent, 'heading', $currentLang) }}</h2>
                <p>{{ getTranslatedValue($ctaContent, 'description', $currentLang) }}</p>
                <div class="optech-extra-mt" data-aos="fade-up" data-aos-duration="600">
                    <a class="optech-default-btn optech-white-btn" href="{{ route($ctaContent->data_values['button_link']) }}" data-text="{{ getTranslatedValue($ctaContent, 'button_text', $currentLang) }}">
                        <span class="btn-wraper">{{ getTranslatedValue($ctaContent, 'button_text', $currentLang) }}</span> </a>
                </div>
            </div>
        </div>
    </div>
</div>
