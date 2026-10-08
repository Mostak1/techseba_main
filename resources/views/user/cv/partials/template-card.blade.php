{{--
    Reusable template gallery card.
    @param \App\Models\CvTemplate|\App\Models\PortfolioTemplate $template
    @param string $type      'cv' | 'portfolio'
    @param bool   $selected
--}}
@php
    $routeBase = $type === 'cv' ? 'user.cv.templates' : 'user.cv.portfolio-templates';
    $previewUrl = profile_route($routeBase.'.preview', ['slug' => $template->slug]);
    $thumb = $template->thumbnail_url;
    $initials = collect(explode(' ', $template->name))->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
@endphp
<article class="tg-card {{ $selected ? 'is-selected' : '' }}"
         data-template-id="{{ $template->id }}"
         data-template-name="{{ $template->name }}"
         data-type="{{ $type }}"
         id="tg-{{ $type }}-{{ $template->slug }}">
    <div class="tg-thumb">
        @if($thumb)
            <img src="{{ $thumb }}" alt="{{ $template->name }} preview" loading="lazy" decoding="async">
        @else
            <div class="tg-thumb-fallback" aria-hidden="true">
                <div class="tg-doc">
                    <div class="tg-doc-head"><span class="tg-doc-avatar">{{ $initials }}</span><span class="tg-doc-lines"><i></i><i></i></span></div>
                    <i></i><i></i><i class="short"></i><i></i><i class="short"></i>
                </div>
            </div>
        @endif
        <span class="tg-check" title="Selected"><i class="fas fa-check"></i></span>
        @if($template->is_premium)
            <span class="tg-badge tg-badge-premium"><i class="fas fa-crown"></i> Premium</span>
        @else
            <span class="tg-badge tg-badge-free">Free</span>
        @endif
    </div>
    <div class="tg-body">
        <h6 class="tg-name" title="{{ $template->name }}">{{ $template->name }}</h6>
        <div class="tg-meta">
            @if($template->category)<span class="tg-chip">{{ $template->category }}</span>@endif
            @if($template->style)<span class="tg-chip tg-chip-muted">{{ $template->style }}</span>@endif
        </div>
        <div class="tg-actions">
            <a href="{{ $previewUrl }}" target="_blank" rel="noopener" class="tg-btn tg-btn-ghost js-tg-preview" id="tg-preview-{{ $type }}-{{ $template->slug }}">
                <i class="fas fa-eye"></i> Preview
            </a>
            <button type="button" class="tg-btn tg-btn-primary js-tg-select" id="tg-select-{{ $type }}-{{ $template->slug }}" @disabled($selected)>
                @if($selected)
                    <i class="fas fa-check-circle"></i> Selected
                @else
                    <i class="fas fa-magic"></i> Use Template
                @endif
            </button>
        </div>
    </div>
</article>
