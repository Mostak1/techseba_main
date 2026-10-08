{{--
    Scalable template gallery (AJAX paginated, searchable, filterable).
    Only lightweight metadata/thumbnails are loaded here — full templates render only on the preview route.

    @param string      $type          'cv' | 'portfolio'
    @param string      $title
    @param string      $inputName     hidden form field kept in sync for the main CV save flow
    @param object|null $selected      effective selected template model
    @param array       $categories
    @param string|null $myPreviewUrl  "Preview My CV / Portfolio" (real user data)
    @param string      $myPreviewLabel
--}}
@php
    $routeBase = $type === 'cv' ? 'user.cv.templates' : 'user.cv.portfolio-templates';
    $placeholder = $type === 'cv' ? 'Search CV templates...' : 'Search portfolio templates...';
@endphp

<div class="tg-gallery" id="tg-gallery-{{ $type }}"
     data-type="{{ $type }}"
     data-index-url="{{ profile_route($routeBase.'.index') }}"
     data-select-url="{{ profile_route($routeBase.'.select') }}"
     data-input="{{ $inputName }}">

    <input type="hidden" name="{{ $inputName }}" value="{{ $selected?->id }}" class="js-tg-input">

    <div class="tg-head">
        <div>
            <h6 class="tg-title">
                <i class="fas {{ $type === 'cv' ? 'fa-file-alt' : 'fa-briefcase' }}"></i> {{ $title }}
            </h6>
            <p class="tg-selected-line">
                Selected: <strong class="js-tg-selected-name">{{ $selected?->name ?? 'None' }}</strong>
            </p>
        </div>
        @if($myPreviewUrl)
            <a href="{{ $myPreviewUrl }}" target="_blank" rel="noopener" class="tg-btn tg-btn-outline" id="tg-my-preview-{{ $type }}">
                <i class="fas fa-user-check"></i> {{ $myPreviewLabel }}
            </a>
        @endif
    </div>

    <div class="tg-toolbar">
        <label class="tg-search">
            <i class="fas fa-search"></i>
            <input type="search" class="js-tg-search" id="tg-search-{{ $type }}" placeholder="{{ $placeholder }}" autocomplete="off" aria-label="{{ $placeholder }}">
        </label>
        @if(count($categories))
            <div class="tg-filters" role="tablist">
                <button type="button" class="tg-filter is-active js-tg-filter" data-category="all">All</button>
                @foreach($categories as $category)
                    <button type="button" class="tg-filter js-tg-filter" data-category="{{ $category }}">{{ $category }}</button>
                @endforeach
            </div>
        @endif
    </div>

    <div class="tg-grid js-tg-grid" aria-live="polite">
        @for($i = 0; $i < 4; $i++)
            <div class="tg-skeleton"></div>
        @endfor
    </div>

    <div class="tg-empty js-tg-empty" hidden>
        <i class="fas fa-search"></i>
        <p>No templates match your search.</p>
    </div>

    <div class="tg-footer">
        <span class="tg-count js-tg-count"></span>
        <button type="button" class="tg-btn tg-btn-outline js-tg-more" hidden>
            <i class="fas fa-chevron-down"></i> Load More
        </button>
    </div>
</div>

@once
    @push('style_section')
        <style>
            .tg-gallery {
                --tg-surface: #0d1530;
                --tg-card: #131d3d;
                --tg-border: rgba(148, 163, 184, .18);
                --tg-text: #e2e8f0;
                --tg-muted: #94a3b8;
                --tg-accent: #38bdf8;
                --tg-accent-2: #6366f1;
                background: linear-gradient(160deg, #0f1938 0%, var(--tg-surface) 100%);
                border: 1px solid var(--tg-border);
                border-radius: 14px;
                padding: 18px;
                color: var(--tg-text);
                margin-bottom: 18px;
            }
            .tg-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 14px; flex-wrap: wrap; }
            .tg-title { margin: 0; font-size: 16px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 8px; }
            .tg-title i { color: var(--tg-accent); }
            .tg-selected-line { margin: 4px 0 0; font-size: 13px; color: var(--tg-muted); }
            .tg-selected-line strong { color: var(--tg-accent); }

            .tg-toolbar { display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px; }
            .tg-search { position: relative; margin: 0; display: block; }
            .tg-search i { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--tg-muted); font-size: 13px; }
            .tg-gallery .tg-search input {
                width: 100%; min-height: 42px; padding: 10px 14px 10px 36px;
                background: rgba(15, 23, 42, .7); border: 1px solid var(--tg-border); border-radius: 10px;
                color: var(--tg-text); font-size: 14px; transition: border-color .2s, box-shadow .2s;
            }
            .tg-gallery .tg-search input::placeholder { color: #64748b; }
            .tg-gallery .tg-search input:focus { outline: none; border-color: var(--tg-accent); box-shadow: 0 0 0 3px rgba(56, 189, 248, .18); }

            .tg-filters { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 2px; scrollbar-width: thin; }
            .tg-filter {
                flex: 0 0 auto; border: 1px solid var(--tg-border); background: transparent; color: var(--tg-muted);
                padding: 6px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all .2s;
            }
            .tg-filter:hover { color: #fff; border-color: rgba(56, 189, 248, .5); }
            .tg-filter.is-active { background: linear-gradient(135deg, var(--tg-accent), var(--tg-accent-2)); color: #fff; border-color: transparent; }

            .tg-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
            @media (max-width: 1399px) { .tg-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
            @media (max-width: 991px) { .tg-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
            @media (max-width: 575px) { .tg-grid { grid-template-columns: 1fr; } }

            .tg-card {
                position: relative; display: flex; flex-direction: column; background: var(--tg-card);
                border: 1px solid var(--tg-border); border-radius: 12px; overflow: hidden;
                transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
                animation: tgFadeIn .35s ease both;
            }
            .tg-card:hover { transform: translateY(-3px); box-shadow: 0 14px 30px rgba(2, 6, 23, .45); border-color: rgba(56, 189, 248, .35); }
            .tg-card.is-selected { border-color: var(--tg-accent); box-shadow: 0 0 0 2px rgba(56, 189, 248, .35), 0 14px 30px rgba(2, 6, 23, .45); }

            .tg-thumb { position: relative; aspect-ratio: 4 / 5; background: #0b1226; overflow: hidden; }
            .tg-thumb img { width: 100%; height: 100%; object-fit: cover; object-position: top center; display: block; transition: transform .4s ease; }
            .tg-card:hover .tg-thumb img { transform: scale(1.03); }

            .tg-thumb-fallback { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle at 30% 20%, rgba(99, 102, 241, .25), transparent 60%), #0b1226; }
            .tg-doc { width: 62%; aspect-ratio: 1 / 1.35; background: #f8fafc; border-radius: 6px; padding: 10% 9%; display: flex; flex-direction: column; gap: 7%; box-shadow: 0 10px 25px rgba(0, 0, 0, .4); }
            .tg-doc > i, .tg-doc-lines i { display: block; height: 6px; border-radius: 3px; background: #cbd5e1; }
            .tg-doc > i.short { width: 60%; }
            .tg-doc-head { display: flex; gap: 8px; align-items: center; margin-bottom: 4%; }
            .tg-doc-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--tg-accent), var(--tg-accent-2)); color: #fff; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
            .tg-doc-lines { flex: 1; display: flex; flex-direction: column; gap: 5px; }
            .tg-doc-lines i:first-child { background: #334155; width: 80%; }

            .tg-check {
                position: absolute; top: 10px; right: 10px; width: 28px; height: 28px; border-radius: 50%;
                background: var(--tg-accent); color: #0b1226; display: flex; align-items: center; justify-content: center;
                font-size: 12px; transform: scale(0); transition: transform .25s cubic-bezier(.34, 1.56, .64, 1);
            }
            .tg-card.is-selected .tg-check { transform: scale(1); }

            .tg-badge { position: absolute; top: 10px; left: 10px; padding: 3px 9px; border-radius: 999px; font-size: 10px; font-weight: 700; letter-spacing: .03em; text-transform: uppercase; }
            .tg-badge-free { background: rgba(16, 185, 129, .9); color: #fff; }
            .tg-badge-premium { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; }

            .tg-body { padding: 12px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
            .tg-name { margin: 0; font-size: 14px; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .tg-meta { display: flex; gap: 6px; flex-wrap: wrap; min-height: 20px; }
            .tg-chip { font-size: 11px; padding: 2px 8px; border-radius: 6px; background: rgba(56, 189, 248, .12); color: var(--tg-accent); font-weight: 600; }
            .tg-chip-muted { background: rgba(148, 163, 184, .12); color: var(--tg-muted); }
            .tg-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: auto; }

            .tg-btn {
                display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 34px; padding: 7px 12px;
                border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; text-decoration: none; border: 1px solid transparent;
                transition: all .2s ease; white-space: nowrap;
            }
            .tg-btn-ghost { background: rgba(148, 163, 184, .1); color: var(--tg-text); border-color: var(--tg-border); }
            .tg-btn-ghost:hover { background: rgba(148, 163, 184, .2); color: #fff; }
            .tg-btn-primary { background: linear-gradient(135deg, var(--tg-accent), var(--tg-accent-2)); color: #fff; }
            .tg-btn-primary:hover:not(:disabled) { filter: brightness(1.1); box-shadow: 0 6px 16px rgba(56, 189, 248, .3); }
            .tg-btn-primary:disabled { background: rgba(56, 189, 248, .15); color: var(--tg-accent); cursor: default; }
            .tg-btn-outline { background: transparent; color: var(--tg-accent); border-color: rgba(56, 189, 248, .45); }
            .tg-btn-outline:hover { background: rgba(56, 189, 248, .1); color: #fff; }
            .tg-btn.is-loading { opacity: .7; pointer-events: none; }

            .tg-footer { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-top: 16px; flex-wrap: wrap; }
            .tg-count { font-size: 12px; color: var(--tg-muted); }
            .tg-empty { text-align: center; padding: 30px 10px; color: var(--tg-muted); }
            .tg-empty i { font-size: 22px; margin-bottom: 8px; display: block; }
            .tg-empty p { margin: 0; }

            .tg-skeleton { aspect-ratio: 4 / 6; border-radius: 12px; background: linear-gradient(90deg, #131d3d 25%, #1b2850 50%, #131d3d 75%); background-size: 200% 100%; animation: tgShimmer 1.2s infinite; }
            @keyframes tgShimmer { to { background-position: -200% 0; } }
            @keyframes tgFadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }

            .tg-settings-box { background: #f8fafc; border: 1px solid #dbe3ef; border-radius: 12px; padding: 16px; }
            .tg-settings-box h6 { margin: 0 0 12px; font-size: 14px; font-weight: 700; color: #0f172a; }
        </style>
    @endpush

    @push('js_section')
        <script>
            (function () {
                'use strict';

                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                function notify(type, message) {
                    if (window.toastr && typeof window.toastr[type] === 'function') {
                        window.toastr[type](message);
                    } else if (window.Swal) {
                        window.Swal.fire({ icon: type === 'error' ? 'error' : 'success', text: message, timer: 2000, showConfirmButton: false });
                    } else {
                        alert(message);
                    }
                }

                function debounce(fn, wait) {
                    let t;
                    return function (...args) { clearTimeout(t); t = setTimeout(() => fn.apply(this, args), wait); };
                }

                function initGallery(root) {
                    const state = { page: 1, search: '', category: 'all', loading: false, requestId: 0 };
                    const grid = root.querySelector('.js-tg-grid');
                    const moreBtn = root.querySelector('.js-tg-more');
                    const emptyEl = root.querySelector('.js-tg-empty');
                    const countEl = root.querySelector('.js-tg-count');
                    const input = root.querySelector('.js-tg-input');
                    const selectedName = root.querySelector('.js-tg-selected-name');

                    function load(append) {
                        const requestId = ++state.requestId;
                        state.loading = true;
                        moreBtn.classList.add('is-loading');

                        const url = new URL(root.dataset.indexUrl, window.location.origin);
                        url.searchParams.set('page', state.page);
                        if (state.search) url.searchParams.set('search', state.search);
                        if (state.category && state.category !== 'all') url.searchParams.set('category', state.category);

                        fetch(url.toString(), { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
                            .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
                            .then(json => {
                                if (requestId !== state.requestId) return; // stale response
                                if (append) {
                                    grid.insertAdjacentHTML('beforeend', json.html);
                                } else {
                                    grid.innerHTML = json.html;
                                }
                                const p = json.pagination || {};
                                const shown = grid.querySelectorAll('.tg-card').length;
                                emptyEl.hidden = shown > 0;
                                moreBtn.hidden = !p.has_more;
                                countEl.textContent = p.total ? `Showing ${shown} of ${p.total} templates` : '';
                            })
                            .catch(() => {
                                if (requestId !== state.requestId) return;
                                if (!append) grid.innerHTML = '';
                                notify('error', 'Could not load templates. Please try again.');
                            })
                            .finally(() => {
                                if (requestId === state.requestId) {
                                    state.loading = false;
                                    moreBtn.classList.remove('is-loading');
                                }
                            });
                    }

                    function markSelected(id, name) {
                        root.querySelectorAll('.tg-card').forEach(card => {
                            const isSel = String(card.dataset.templateId) === String(id);
                            card.classList.toggle('is-selected', isSel);
                            const btn = card.querySelector('.js-tg-select');
                            if (!btn) return;
                            btn.disabled = isSel;
                            btn.innerHTML = isSel
                                ? '<i class="fas fa-check-circle"></i> Selected'
                                : '<i class="fas fa-magic"></i> Use Template';
                        });
                        if (input) input.value = id;
                        if (selectedName) selectedName.textContent = name;
                    }

                    function select(card, btn) {
                        const id = card.dataset.templateId;
                        btn.classList.add('is-loading');
                        fetch(root.dataset.selectUrl, {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
                            body: JSON.stringify({ template_id: Number(id) })
                        })
                            .then(r => r.json().then(json => ({ ok: r.ok, json })))
                            .then(({ ok, json }) => {
                                if (!ok || !json.success) throw new Error(json.message || 'Failed to select template.');
                                markSelected(json.template.id, json.template.name);
                                notify('success', json.message);
                            })
                            .catch(err => notify('error', err.message || 'Failed to select template.'))
                            .finally(() => btn.classList.remove('is-loading'));
                    }

                    // Event delegation (works for AJAX-appended cards)
                    root.addEventListener('click', function (e) {
                        const previewLink = e.target.closest('.js-tg-preview');
                        if (previewLink) {
                            e.stopPropagation(); // never select when previewing
                            return; // native target="_blank" handles opening
                        }

                        const selectBtn = e.target.closest('.js-tg-select');
                        if (selectBtn) {
                            e.preventDefault();
                            e.stopPropagation();
                            const card = selectBtn.closest('.tg-card');
                            if (card && !selectBtn.disabled) select(card, selectBtn);
                            return;
                        }

                        const filter = e.target.closest('.js-tg-filter');
                        if (filter) {
                            root.querySelectorAll('.js-tg-filter').forEach(f => f.classList.toggle('is-active', f === filter));
                            state.category = filter.dataset.category;
                            state.page = 1;
                            load(false);
                        }
                    });

                    moreBtn.addEventListener('click', function () {
                        if (state.loading) return;
                        state.page += 1;
                        load(true);
                    });

                    const searchInput = root.querySelector('.js-tg-search');
                    searchInput.addEventListener('keydown', e => { if (e.key === 'Enter') e.preventDefault(); }); // don't submit main CV form
                    searchInput.addEventListener('input', debounce(function () {
                        state.search = this.value.trim();
                        state.page = 1;
                        load(false);
                    }, 300));

                    // Sync selection made from a preview tab ("Use This Template")
                    window.addEventListener('storage', function (e) {
                        if (e.key !== 'tg-selected-' + root.dataset.type || !e.newValue) return;
                        try {
                            const data = JSON.parse(e.newValue);
                            markSelected(data.id, data.name);
                        } catch (_) {}
                    });

                    load(false);
                }

                function boot() {
                    document.querySelectorAll('.tg-gallery').forEach(initGallery);
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', boot);
                } else {
                    boot();
                }
            })();
        </script>
    @endpush
@endonce
