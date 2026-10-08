@php
    $typeLabel = $type === 'cv' ? 'CV' : 'Portfolio';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Live preview of the {{ $template->name }} {{ $typeLabel }} template with demo data.">
    <title>{{ $template->name }} — {{ $typeLabel }} Template Preview</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.css') }}">
    <style>
        :root {
            --bg: #070d22; --bar: rgba(13, 21, 48, .92); --border: rgba(148, 163, 184, .18);
            --text: #e2e8f0; --muted: #94a3b8; --accent: #38bdf8; --accent-2: #6366f1;
        }
        * { box-sizing: border-box; }
        html, body { margin: 0; height: 100%; }
        body { font-family: 'Inter', system-ui, sans-serif; background: radial-gradient(circle at 20% 0%, #13204a 0%, var(--bg) 55%); color: var(--text); display: flex; flex-direction: column; }

        .template-preview-toolbar {
            position: sticky; top: 0; z-index: 10; display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 14px;
            padding: 12px 20px; background: var(--bar); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border);
        }
        .tp-title { min-width: 0; }
        .tp-title h1 { margin: 0; font-size: 16px; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .tp-title p { margin: 2px 0 0; font-size: 12px; color: var(--muted); }
        .tp-title .tp-demo { display: inline-block; margin-left: 6px; padding: 1px 8px; border-radius: 999px; background: rgba(56, 189, 248, .12); color: var(--accent); font-size: 11px; font-weight: 600; }

        .tp-devices { display: inline-flex; background: rgba(15, 23, 42, .8); border: 1px solid var(--border); border-radius: 10px; padding: 4px; gap: 4px; }
        .tp-device { border: 0; background: transparent; color: var(--muted); padding: 7px 14px; border-radius: 7px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all .2s; font-family: inherit; }
        .tp-device:hover { color: #fff; }
        .tp-device.is-active { background: linear-gradient(135deg, var(--accent), var(--accent-2)); color: #fff; }

        .tp-actions { display: flex; justify-content: flex-end; gap: 8px; }
        .tp-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px; border-radius: 9px; font-size: 13px; font-weight: 700; cursor: pointer; border: 1px solid transparent; text-decoration: none; font-family: inherit; transition: all .2s; white-space: nowrap; }
        .tp-btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-2)); color: #fff; }
        .tp-btn-primary:hover:not(:disabled) { filter: brightness(1.1); box-shadow: 0 6px 18px rgba(56, 189, 248, .35); }
        .tp-btn-primary:disabled { background: rgba(16, 185, 129, .18); color: #34d399; cursor: default; }
        .tp-btn-ghost { background: transparent; color: var(--text); border-color: var(--border); }
        .tp-btn-ghost:hover { background: rgba(148, 163, 184, .12); }
        .tp-btn.is-loading { opacity: .7; pointer-events: none; }

        .tp-stage { flex: 1; display: flex; justify-content: center; padding: 22px; overflow: auto; }
        .tp-frame-wrap { width: 100%; max-width: 100%; height: calc(100vh - 110px); transition: width .35s ease; border-radius: 12px; overflow: hidden; background: #fff; box-shadow: 0 25px 60px rgba(0, 0, 0, .5); position: relative; }
        .tp-frame-wrap[data-device="tablet"] { width: 768px; }
        .tp-frame-wrap[data-device="mobile"] { width: 390px; border-radius: 26px; border: 8px solid #1e293b; }
        .tp-frame-wrap iframe { width: 100%; height: 100%; border: 0; display: block; background: #fff; }
        .tp-loader { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: #0d1530; color: var(--muted); font-size: 14px; gap: 10px; transition: opacity .3s; }
        .tp-loader.is-hidden { opacity: 0; pointer-events: none; }

        .tp-toast { position: fixed; right: 20px; bottom: 20px; padding: 12px 18px; border-radius: 10px; font-size: 14px; font-weight: 600; color: #fff; transform: translateY(20px); opacity: 0; transition: all .3s; z-index: 50; box-shadow: 0 10px 30px rgba(0, 0, 0, .4); }
        .tp-toast.is-visible { transform: none; opacity: 1; }
        .tp-toast.success { background: #059669; }
        .tp-toast.error { background: #dc2626; }

        @media (max-width: 900px) {
            .template-preview-toolbar { grid-template-columns: 1fr; text-align: center; }
            .tp-actions { justify-content: center; flex-wrap: wrap; }
            .tp-devices { justify-self: center; }
            .tp-frame-wrap { height: calc(100vh - 210px); }
        }

        @media print {
            .template-preview-toolbar, .tp-toast { display: none !important; }
            body { background: #fff; }
            .tp-stage { padding: 0; }
            .tp-frame-wrap { width: 100% !important; height: auto; box-shadow: none; border: 0; border-radius: 0; }
        }
    </style>
</head>
<body>
    <header class="template-preview-toolbar">
        <div class="tp-title">
            <h1>{{ $template->name }} {{ $typeLabel }} <span class="tp-demo">Demo data</span></h1>
            <p>{{ $template->category ?: 'Template' }} · Preview does not change your current selection</p>
        </div>

        <div class="tp-devices" role="group" aria-label="Preview device">
            <button type="button" class="tp-device is-active" data-device="desktop" id="tp-device-desktop"><i class="fas fa-desktop"></i> Desktop</button>
            <button type="button" class="tp-device" data-device="tablet" id="tp-device-tablet"><i class="fas fa-tablet-alt"></i> Tablet</button>
            <button type="button" class="tp-device" data-device="mobile" id="tp-device-mobile"><i class="fas fa-mobile-alt"></i> Mobile</button>
        </div>

        <div class="tp-actions">
            <button type="button" class="tp-btn tp-btn-primary" id="tp-use-template" @disabled($isSelected)>
                @if($isSelected)
                    <i class="fas fa-check-circle"></i> Current Template
                @else
                    <i class="fas fa-magic"></i> Use This Template
                @endif
            </button>
            <button type="button" class="tp-btn tp-btn-ghost" id="tp-close"><i class="fas fa-times"></i> Close Preview</button>
        </div>
    </header>

    <main class="tp-stage">
        <div class="tp-frame-wrap" id="tp-frame-wrap" data-device="desktop">
            <div class="tp-loader" id="tp-loader"><i class="fas fa-spinner fa-spin"></i> Loading preview…</div>
            <iframe src="{{ $renderUrl }}" title="{{ $template->name }} preview" id="tp-frame" loading="eager"></iframe>
        </div>
    </main>

    <div class="tp-toast" id="tp-toast" role="status" aria-live="polite"></div>

    <script>
        (function () {
            'use strict';
            const wrap = document.getElementById('tp-frame-wrap');
            const frame = document.getElementById('tp-frame');
            const loader = document.getElementById('tp-loader');
            const toast = document.getElementById('tp-toast');
            const useBtn = document.getElementById('tp-use-template');
            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            const type = @json($type);
            const templateId = @json($template->id);
            const templateName = @json($template->name);
            const selectUrl = @json($selectUrl);
            const settingsUrl = @json($settingsUrl);

            frame.addEventListener('load', () => loader.classList.add('is-hidden'));

            // Device switching only resizes the container — no reload.
            document.querySelectorAll('.tp-device').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.tp-device').forEach(b => b.classList.toggle('is-active', b === btn));
                    wrap.dataset.device = btn.dataset.device;
                });
            });

            function showToast(type, message) {
                toast.className = 'tp-toast ' + type + ' is-visible';
                toast.textContent = message;
                clearTimeout(showToast.t);
                showToast.t = setTimeout(() => toast.classList.remove('is-visible'), 2800);
            }

            useBtn.addEventListener('click', function () {
                if (useBtn.disabled) return;
                useBtn.classList.add('is-loading');
                fetch(selectUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ template_id: templateId })
                })
                    .then(r => r.json().then(json => ({ ok: r.ok, json })))
                    .then(({ ok, json }) => {
                        if (!ok || !json.success) throw new Error(json.message || 'Failed to select template.');
                        useBtn.disabled = true;
                        useBtn.innerHTML = '<i class="fas fa-check-circle"></i> Current Template';
                        showToast('success', json.message);
                        // Notify an open Settings tab so it highlights the new selection without reload.
                        try { localStorage.setItem('tg-selected-' + type, JSON.stringify({ id: templateId, name: templateName, t: Date.now() })); } catch (_) {}
                    })
                    .catch(err => showToast('error', err.message || 'Failed to select template.'))
                    .finally(() => useBtn.classList.remove('is-loading'));
            });

            document.getElementById('tp-close').addEventListener('click', function () {
                window.close();
                // If the tab wasn't opened by script, browsers block close(): go back to settings instead.
                setTimeout(() => { if (!window.closed) window.location.href = settingsUrl; }, 150);
            });
        })();
    </script>
</body>
</html>
