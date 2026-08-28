@php
    $photoSrc = $cv->photo ? asset($cv->photo) : asset('uploads/website-images/avatar-image-2024-07-02-10-08-24-5849.png');
    $currentEmployment = $cv->employments->first();
    $primaryRole = $currentEmployment?->designation ?: 'Software Developer';
    $currentCompany = $currentEmployment?->company_name;
    $summarySource = $cv->career_summary ?: $cv->career_objective;
    $summary = $summarySource ? \Illuminate\Support\Str::limit($summarySource, 280) : 'A practical software professional focused on building reliable web applications and useful digital products.';
    $technicalSkills = $cv->skills->filter(fn ($skill) => $skill->skill_type === 'Technical Skills');
    $featuredSkills = $technicalSkills->isNotEmpty() ? $technicalSkills : $cv->skills->take(12);
    $experienceYears = $cv->total_experience ? rtrim(rtrim(number_format((float) $cv->total_experience, 1), '0'), '.') . '+ Years' : 'Experienced';
    $ratings = $cv->proficiency_ratings ?? [];
    $formatDate = function ($date) {
        return $date ? \Illuminate\Support\Carbon::parse($date)->format('M Y') : '';
    };

    $proficiencyAreas = [
        'php' => ['label' => 'PHP', 'icon' => 'fab fa-php', 'color' => '#777BB4'],
        'javascript' => ['label' => 'JavaScript', 'icon' => 'fab fa-js', 'color' => '#F7DF1E'],
        'sql' => ['label' => 'SQL', 'icon' => 'fas fa-database', 'color' => '#336791'],
        'redis' => ['label' => 'Redis & Queues', 'icon' => 'fas fa-server', 'color' => '#DC382D'],
        'css' => ['label' => 'CSS', 'icon' => 'fab fa-css3-alt', 'color' => '#1572B6'],
        'other_languages' => ['label' => 'Other Languages', 'icon' => 'fas fa-code', 'color' => '#6B7280'],
        'elasticsearch' => ['label' => 'ElasticSearch', 'icon' => 'fas fa-search', 'color' => '#005571'],
        'laravel' => ['label' => 'Laravel', 'icon' => 'fab fa-laravel', 'color' => '#FF2D20'],
    ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $cv->full_name }} — Application Portfolio</title>
    <meta name="description" content="{{ $cv->full_name }} — {{ $primaryRole }}. Application portfolio with technical skills, proficiency ratings, and project experience.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.css') }}">
    <style>
        :root {
            --bg: #0b0f1a;
            --surface: #121828;
            --surface-2: #1a2236;
            --glass: rgba(18, 24, 40, .72);
            --ink: #e8edf5;
            --muted: #8492a6;
            --line: rgba(255,255,255,.08);
            --accent: #6366f1;
            --accent-light: #818cf8;
            --accent-glow: rgba(99,102,241,.25);
            --teal: #14b8a6;
            --teal-glow: rgba(20,184,166,.2);
            --amber: #f59e0b;
            --coral: #f43f5e;
            --radius: 12px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            color: var(--ink);
            background: var(--bg);
            font-family: Inter, 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
        }

        a { color: var(--accent-light); text-decoration: none; }
        a:hover { text-decoration: underline; }

        .wrap { width: min(1140px, calc(100% - 32px)); margin: 0 auto; }
        .section-gap { padding: 72px 0; }
        .section-gap + .section-gap { border-top: 1px solid var(--line); }

        /* ===== Sticky Nav ===== */
        .site-nav {
            position: sticky; top: 0; z-index: 50;
            background: rgba(11,15,26,.88);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--line);
        }
        .nav-inner {
            display: flex; align-items: center; justify-content: space-between;
            min-height: 64px; gap: 20px;
        }
        .nav-brand {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; color: var(--ink);
        }
        .nav-brand-mark {
            width: 38px; height: 38px; display: grid; place-items: center;
            border-radius: 8px; background: linear-gradient(135deg, var(--accent), var(--teal));
            color: #fff; font-weight: 900; font-size: 16px;
        }
        .nav-brand strong { font-size: 15px; }
        .nav-links { display: flex; gap: 6px; }
        .nav-links a {
            padding: 7px 14px; border-radius: 6px;
            font-size: 13px; font-weight: 600; color: var(--muted);
            transition: all .2s;
        }
        .nav-links a:hover { color: var(--ink); background: var(--surface-2); text-decoration: none; }

        /* ===== Hero ===== */
        .hero {
            padding: 80px 0 60px;
            background: linear-gradient(170deg, var(--surface) 0%, var(--bg) 100%);
            border-bottom: 1px solid var(--line);
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; top: -180px; right: -120px;
            width: 440px; height: 440px; border-radius: 50%;
            background: radial-gradient(circle, var(--accent-glow) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-grid {
            display: grid; grid-template-columns: 1fr 300px;
            gap: 48px; align-items: center;
        }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 12px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1.5px; color: var(--teal); margin-bottom: 14px;
        }
        .hero-eyebrow::before {
            content: ''; width: 28px; height: 3px;
            background: var(--teal); border-radius: 2px;
        }
        .hero h1 {
            font-size: clamp(36px, 5vw, 60px); line-height: 1;
            font-weight: 900; margin-bottom: 18px;
        }
        .hero h1 span { color: var(--accent-light); }
        .hero-summary { color: var(--muted); font-size: 17px; max-width: 600px; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 22px; border-radius: 8px; font-weight: 700;
            font-size: 14px; border: none; cursor: pointer;
            transition: all .2s;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #4f46e5);
            color: #fff; box-shadow: 0 4px 20px var(--accent-glow);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 30px var(--accent-glow); text-decoration: none; color: #fff; }
        .btn-outline {
            background: transparent; color: var(--ink);
            border: 1px solid rgba(255,255,255,.15);
        }
        .btn-outline:hover { background: var(--surface-2); text-decoration: none; }

        .hero-photo {
            width: 280px; height: 340px; border-radius: 16px;
            object-fit: cover; border: 3px solid var(--surface-2);
            box-shadow: 0 12px 40px rgba(0,0,0,.4);
            justify-self: end;
        }

        .hero-metrics {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 16px; margin-top: 44px; max-width: 560px;
        }
        .metric-card {
            padding: 14px; border-radius: var(--radius);
            background: var(--surface-2); border: 1px solid var(--line);
        }
        .metric-card strong { display: block; font-size: 22px; color: var(--accent-light); }
        .metric-card span { font-size: 12px; color: var(--muted); }

        /* ===== Section Headings ===== */
        .sec-head { margin-bottom: 36px; }
        .sec-head h2 {
            font-size: clamp(26px, 3.5vw, 40px); font-weight: 800;
            line-height: 1.1; margin-bottom: 8px;
        }
        .sec-head p { color: var(--muted); max-width: 600px; }

        /* ===== Q&A Cards ===== */
        .qa-card {
            background: var(--surface); border: 1px solid var(--line);
            border-radius: 16px; padding: 32px; margin-bottom: 24px;
            position: relative; overflow: hidden;
        }
        .qa-card::before {
            content: ''; position: absolute; top: 0; left: 0;
            width: 4px; height: 100%;
            background: linear-gradient(to bottom, var(--accent), var(--teal));
        }
        .qa-card h3 {
            font-size: 18px; font-weight: 700; margin-bottom: 16px;
            display: flex; align-items: center; gap: 10px;
        }
        .qa-card h3 i { color: var(--accent-light); font-size: 20px; }
        .qa-card .answer {
            color: var(--muted); font-size: 15px; line-height: 1.75;
            white-space: pre-line;
        }
        .qa-card .answer strong { color: var(--ink); }

        /* ===== Proficiency Grid ===== */
        .prof-grid {
            display: grid; grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }
        .prof-card {
            background: var(--surface); border: 1px solid var(--line);
            border-radius: 16px; padding: 24px;
            transition: border-color .25s, transform .25s;
        }
        .prof-card:hover { border-color: var(--accent); transform: translateY(-3px); }
        .prof-card-head {
            display: flex; align-items: center; gap: 14px;
            margin-bottom: 14px;
        }
        .prof-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: grid; place-items: center; font-size: 20px; color: #fff;
        }
        .prof-card-head strong { font-size: 15px; }
        .prof-stars { display: flex; gap: 4px; margin-bottom: 12px; }
        .prof-stars i { font-size: 18px; color: var(--amber); }
        .prof-stars i.empty { color: rgba(255,255,255,.12); }
        .prof-card .desc { color: var(--muted); font-size: 13px; line-height: 1.6; }

        /* ===== Skills Chips ===== */
        .skill-chips {
            display: flex; flex-wrap: wrap; gap: 10px;
        }
        .skill-chip {
            padding: 10px 18px; border-radius: 999px;
            background: var(--surface-2); border: 1px solid var(--line);
            font-size: 13px; font-weight: 600;
            transition: all .2s;
        }
        .skill-chip:hover {
            border-color: var(--accent);
            background: rgba(99,102,241,.1);
        }

        /* ===== Timeline ===== */
        .timeline { display: grid; gap: 0; }
        .tl-item {
            display: grid; grid-template-columns: 200px minmax(0, 1fr);
            gap: 28px; padding: 26px 0;
            border-bottom: 1px solid var(--line);
        }
        .tl-item:first-child { border-top: 1px solid var(--line); }
        .tl-date { color: var(--accent-light); font-weight: 700; font-size: 13px; padding-top: 2px; }
        .tl-body h4 { font-size: 16px; margin-bottom: 4px; }
        .tl-body .org { color: var(--muted); font-size: 14px; margin-bottom: 8px; }
        .tl-body .detail { color: var(--muted); font-size: 13px; line-height: 1.6; }

        /* ===== Projects Grid ===== */
        .proj-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .proj-card {
            background: var(--surface); border: 1px solid var(--line);
            border-radius: 16px; padding: 24px;
            transition: border-color .25s, transform .25s;
        }
        .proj-card:hover { border-color: var(--teal); transform: translateY(-3px); }
        .proj-card h4 { font-size: 15px; margin-bottom: 8px; }
        .proj-card p { color: var(--muted); font-size: 13px; line-height: 1.6; margin-bottom: 12px; }
        .proj-card a { font-size: 13px; font-weight: 700; }

        /* ===== Sparks Joy ===== */
        .joy-card {
            background: linear-gradient(135deg, rgba(99,102,241,.08), rgba(20,184,166,.08));
            border: 1px solid var(--line); border-radius: 20px;
            padding: 40px;
        }
        .joy-card h3 { font-size: 22px; margin-bottom: 16px; }
        .joy-card .content { color: var(--muted); font-size: 15px; line-height: 1.8; white-space: pre-line; }

        /* ===== Landing Page CTA ===== */
        .lp-cta {
            text-align: center; padding: 48px 32px;
            background: linear-gradient(135deg, var(--surface), var(--surface-2));
            border: 1px solid var(--line); border-radius: 20px;
        }
        .lp-cta h3 { font-size: 24px; margin-bottom: 10px; }
        .lp-cta p { color: var(--muted); margin-bottom: 24px; }

        /* ===== Footer ===== */
        .site-footer {
            padding: 32px 0; text-align: center;
            border-top: 1px solid var(--line);
            color: var(--muted); font-size: 13px;
        }
        .footer-links { display: flex; justify-content: center; gap: 18px; margin-top: 10px; }
        .footer-links a {
            width: 36px; height: 36px; display: grid; place-items: center;
            border: 1px solid var(--line); border-radius: 8px;
            color: var(--muted); font-size: 15px;
            transition: all .2s;
        }
        .footer-links a:hover { color: var(--ink); border-color: var(--accent); background: rgba(99,102,241,.1); }

        /* ===== Responsive ===== */
        @media (max-width: 900px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            .hero-photo { justify-self: center; width: 220px; height: 280px; }
            .hero-summary { margin: 0 auto; }
            .hero-actions { justify-content: center; }
            .hero-metrics { margin: 32px auto 0; }
            .prof-grid, .proj-grid { grid-template-columns: 1fr; }
            .tl-item { grid-template-columns: 1fr; gap: 8px; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    {{-- ===== Navigation ===== --}}
    <nav class="site-nav">
        <div class="wrap nav-inner">
            <a href="#" class="nav-brand">
                <span class="nav-brand-mark">{{ strtoupper(substr($cv->full_name, 0, 1)) }}</span>
                <strong>{{ $cv->full_name }}</strong>
            </a>
            <div class="nav-links">
                <a href="#proficiency">Proficiency</a>
                <a href="#experience">Experience</a>
                <a href="#projects">Projects</a>
                <a href="#questions">Q&A</a>
                <a href="#joy">✨ Joy</a>
                @if(isset($cvUrl))
                    <a href="{{ $cvUrl }}" class="btn btn-outline" style="padding: 6px 16px;">View CV</a>
                @endif
            </div>
        </div>
    </nav>

    {{-- ===== Hero ===== --}}
    <section class="hero" id="hero">
        <div class="wrap">
            <div class="hero-grid">
                <div>
                    <div class="hero-eyebrow">Application Portfolio</div>
                    <h1>{{ $cv->full_name }} <span>{{ $primaryRole }}</span></h1>
                    <p class="hero-summary">{{ $summary }}</p>

                    <div class="hero-actions">
                        @if(isset($cvUrl))
                            <a href="{{ $cvUrl }}" class="btn btn-primary"><i class="fas fa-file-alt"></i> View Full CV</a>
                        @endif
                        @if(isset($printUrl) && ($printEnabled ?? false))
                            <a href="{{ $printUrl }}" class="btn btn-outline" target="_blank"><i class="fas fa-print"></i> Print CV</a>
                        @endif
                        @if($cv->website_url)
                            <a href="{{ $cv->website_url }}" class="btn btn-outline" target="_blank"><i class="fas fa-globe"></i> Website</a>
                        @endif
                    </div>

                    <div class="hero-metrics">
                        <div class="metric-card">
                            <strong>{{ $experienceYears }}</strong>
                            <span>Experience</span>
                        </div>
                        <div class="metric-card">
                            <strong>{{ $cv->projects->count() }}+</strong>
                            <span>Projects</span>
                        </div>
                        <div class="metric-card">
                            <strong>{{ $featuredSkills->count() }}+</strong>
                            <span>Technologies</span>
                        </div>
                    </div>
                </div>

                <img src="{{ $photoSrc }}" alt="{{ $cv->full_name }}" class="hero-photo">
            </div>
        </div>
    </section>

    {{-- ===== Proficiency Ratings ===== --}}
    @if(!empty($ratings))
    <section class="section-gap" id="proficiency">
        <div class="wrap">
            <div class="sec-head">
                <h2>Technical Proficiency</h2>
                <p>Self-assessed proficiency ratings across key technology areas, with experience descriptions.</p>
            </div>

            <div class="prof-grid">
                @foreach($proficiencyAreas as $key => $area)
                    @if(isset($ratings[$key]))
                        <div class="prof-card">
                            <div class="prof-card-head">
                                <div class="prof-icon" style="background: {{ $area['color'] }};">
                                    <i class="{{ $area['icon'] }}"></i>
                                </div>
                                <strong>{{ $area['label'] }}</strong>
                            </div>
                            <div class="prof-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $ratings[$key] ? 'fas fa-star' : 'far fa-star empty' }}"></i>
                                @endfor
                            </div>
                            @if(!empty($ratings[$key . '_description']))
                                <div class="desc">{{ $ratings[$key . '_description'] }}</div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Skills Chips ===== --}}
    @if($cv->skills->isNotEmpty())
    <section class="section-gap" id="skills">
        <div class="wrap">
            <div class="sec-head">
                <h2>Skills & Expertise</h2>
            </div>
            <div class="skill-chips">
                @foreach($cv->skills as $skill)
                    <div class="skill-chip">{{ $skill->skill_name }}</div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Application Q&A ===== --}}
    @if($cv->technical_challenge || $cv->built_from_scratch)
    <section class="section-gap" id="questions">
        <div class="wrap">
            <div class="sec-head">
                <h2>Application Questions</h2>
                <p>Detailed responses to technical and cultural interview questions.</p>
            </div>

            @if($cv->technical_challenge)
                <div class="qa-card">
                    <h3><i class="fas fa-cogs"></i> Technical Challenge — Scalable Solution</h3>
                    <div class="answer">{!! nl2br(e($cv->technical_challenge)) !!}</div>
                </div>
            @endif

            @if($cv->built_from_scratch)
                <div class="qa-card">
                    <h3><i class="fas fa-hammer"></i> Built from Scratch</h3>
                    <div class="answer">{!! nl2br(e($cv->built_from_scratch)) !!}</div>
                </div>
            @endif
        </div>
    </section>
    @endif

    {{-- ===== Experience Timeline ===== --}}
    @if($cv->employments->isNotEmpty())
    <section class="section-gap" id="experience">
        <div class="wrap">
            <div class="sec-head">
                <h2>Professional Experience</h2>
            </div>
            <div class="timeline">
                @foreach($cv->employments as $emp)
                    <div class="tl-item">
                        <div class="tl-date">
                            {{ $formatDate($emp->start_date) }} — {{ $emp->is_current ? 'Present' : $formatDate($emp->end_date) }}
                        </div>
                        <div class="tl-body">
                            <h4>{{ $emp->designation }}</h4>
                            <div class="org">{{ $emp->company_name }}@if($emp->company_location) · {{ $emp->company_location }}@endif</div>
                            @if($emp->responsibilities)
                                <div class="detail">{{ $emp->responsibilities }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Projects ===== --}}
    @if($cv->projects->isNotEmpty())
    <section class="section-gap" id="projects">
        <div class="wrap">
            <div class="sec-head">
                <h2>Projects</h2>
            </div>
            <div class="proj-grid">
                @foreach($cv->projects as $project)
                    <div class="proj-card">
                        <h4>{{ $project->title }}</h4>
                        @if($project->description)
                            <p>{{ $project->description }}</p>
                        @endif
                        @if($project->link)
                            <a href="{{ $project->link }}" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i> View Project</a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Education ===== --}}
    @if($cv->academics->isNotEmpty())
    <section class="section-gap" id="education">
        <div class="wrap">
            <div class="sec-head">
                <h2>Education</h2>
            </div>
            <div class="timeline">
                @foreach($cv->academics as $edu)
                    <div class="tl-item">
                        <div class="tl-date">{{ $edu->passing_year ?? '' }}</div>
                        <div class="tl-body">
                            <h4>{{ $edu->degree_name }}</h4>
                            <div class="org">{{ $edu->institution }}@if($edu->board_or_university) · {{ $edu->board_or_university }}@endif</div>
                            <div class="detail">
                                @if($edu->group_or_major) {{ $edu->group_or_major }} @endif
                                @if($edu->result) — {{ $edu->result }} @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Sparks Joy ===== --}}
    @if($cv->sparks_joy)
    <section class="section-gap" id="joy">
        <div class="wrap">
            <div class="sec-head">
                <h2>What Sparks Joy ✨</h2>
            </div>
            <div class="joy-card">
                <div class="content">{!! nl2br(e($cv->sparks_joy)) !!}</div>
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Landing Page CTA ===== --}}
    @if($cv->landing_page_url)
    <section class="section-gap" id="landing-page">
        <div class="wrap">
            <div class="lp-cta">
                <h3>🚀 Visit My Landing Page</h3>
                <p>Created with MailerLite — explore my creative portfolio.</p>
                <a href="{{ $cv->landing_page_url }}" class="btn btn-primary" target="_blank" rel="noopener">
                    <i class="fas fa-external-link-alt"></i> Open Landing Page
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Footer ===== --}}
    <footer class="site-footer">
        <div class="wrap">
            <div>&copy; {{ date('Y') }} {{ $cv->full_name }}. Built with passion.</div>
            <div class="footer-links">
                @if($cv->github_url)
                    <a href="{{ $cv->github_url }}" target="_blank" rel="noopener" title="GitHub"><i class="fab fa-github"></i></a>
                @endif
                @if($cv->linkedin_url)
                    <a href="{{ $cv->linkedin_url }}" target="_blank" rel="noopener" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                @endif
                @if($cv->website_url)
                    <a href="{{ $cv->website_url }}" target="_blank" rel="noopener" title="Website"><i class="fas fa-globe"></i></a>
                @endif
                @if($cv->email)
                    <a href="mailto:{{ $cv->email }}" title="Email"><i class="fas fa-envelope"></i></a>
                @endif
            </div>
        </div>
    </footer>

</body>
</html>
