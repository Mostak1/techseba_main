<div class="cv-actions">
    @if($cv)
        <a href="{{ route('user.cv.preview') }}" target="_blank" class="cv-secondary-btn">Preview</a>
    @endif
    <button type="submit" class="cv-secondary-btn" data-save-tab="{{ $tab }}">Save</button>
    @if(empty($last))
        <button type="button" class="cv-small-btn" data-current-tab="{{ $tab }}" data-save-next="{{ $next }}">Save & Next</button>
    @else
        <button type="submit" class="cv-small-btn" data-save-tab="{{ $tab }}">Save CV</button>
    @endif
</div>
