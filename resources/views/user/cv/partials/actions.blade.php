<div class="cv-actions">
    <a href="{{ profile_route('user.cv.preview') }}" target="_blank" class="cv-secondary-btn">
        <i class="fas fa-eye"></i> {{ __('translate.Preview') }}
    </a>
    <button type="submit" class="cv-secondary-btn" data-save-tab="{{ $tab }}">{{ __('translate.Save') }}</button>
    @if(empty($last))
        <button type="button" class="cv-small-btn" data-current-tab="{{ $tab }}" data-save-next="{{ $next }}">{{ __('translate.Save & Next') }} <i class="fas fa-arrow-right"></i></button>
    @else
        <button type="submit" class="cv-small-btn" data-save-tab="{{ $tab }}">{{ __('translate.Save CV') }}</button>
    @endif
</div>
