@php
    $currentLang = session()->get('front_lang');
    $contactContent = getContent('contact_form_section.content', true);
@endphp
<h3>{{ getTranslatedValue($contactContent, 'heading', $currentLang) }}</h3>
<p>{{ getTranslatedValue($contactContent, 'description', $currentLang) }}</p>
<form action="{{ route('store-contact-message') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-6">
            <div class="optech-main-field">
                <input
                    type="text"
                    id="name"
                    placeholder="{{ __('translate.Name') }}"
                    name="name"
                    value="{{ old('name') }}"
                />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="optech-main-field">
                <input
                    type="text"
                    id="phone"
                    placeholder="{{ __('translate.Phone') }}"
                    name="phone"
                    value="{{ old('phone') }}"
                />
            </div>
        </div>
        <div class="col-lg-12">
            <div class="optech-main-field">
                <input
                    type="email"
                    id="email"
                    placeholder="{{ __('translate.Email') }}"
                    name="email"
                    value="{{ old('email') }}"
                />
            </div>
        </div>
        <div class="col-lg-12">
            <div class="optech-main-field">
                <textarea name="message" placeholder="{{ __('translate.Message') }}">{{ old('message') ? trim(old('message')) : '' }}</textarea>
            </div>
        </div>

    @if($general_setting->recaptcha_status==1)
            <div class="optech-main-field">
                <div class="g-recaptcha" data-sitekey="{{ $general_setting->recaptcha_site_key }}"></div>
            </div>
        @endif
        <div class="col-lg-12">
            <button id="optech-main-form-btn" type="submit" data-text="{{ getTranslatedValue($contactContent, 'button_text', $currentLang) }}">
                <span class="btn-wraper">{{ getTranslatedValue($contactContent, 'button_text', $currentLang) }}</span>
            </button>
        </div>
    </div>
</form>
