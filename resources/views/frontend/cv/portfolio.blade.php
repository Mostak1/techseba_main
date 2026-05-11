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
    $formatDate = function ($date) {
        return $date ? \Illuminate\Support\Carbon::parse($date)->format('M Y') : '';
    };
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $cv->full_name }} - Portfolio</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/all.min.css') }}">
    <style>
        :root {
            --bg: #f7f6ef;
            --surface: #ffffff;
            --ink: #17202a;
            --muted: #65707c;
            --line: #ded9cc;
            --teal: #0f766e;
            --teal-dark: #104c49;
            --coral: #c8553d;
            --gold: #b7791f;
            --green-soft: #e2f2ef;
            --gold-soft: #fff1cf;
            --coral-soft: #f9e4dc;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            color: var(--ink);
            background: var(--bg);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            line-height: 1.6;
            letter-spacing: 0;
        }

        a {
            color: inherit;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(247, 246, 239, .94);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(14px);
        }

        .nav {
            width: min(1120px, calc(100% - 32px));
            margin: 0 auto;
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            min-width: 0;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: var(--teal-dark);
            color: #fff;
            font-weight: 800;
            flex: 0 0 auto;
        }

        .brand-text {
            display: grid;
            line-height: 1.2;
            min-width: 0;
        }

        .brand-name {
            font-size: 16px;
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .brand-role {
            color: var(--muted);
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 18px;
            color: #39434f;
            font-size: 14px;
        }

        .nav-links a {
            text-decoration: none;
            font-weight: 700;
        }

        .nav-links a:hover {
            color: var(--teal);
        }

        .btn {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 10px 16px;
            border: 1px solid transparent;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 800;
            line-height: 1.2;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(23, 32, 42, .12);
        }

        .btn-primary {
            background: var(--coral);
            color: #fff;
        }

        .btn-secondary {
            border-color: var(--teal);
            color: var(--teal-dark);
            background: #fff;
        }

        .btn-ghost {
            border-color: var(--line);
            background: transparent;
            color: var(--ink);
        }

        .section {
            width: min(1120px, calc(100% - 32px));
            margin: 0 auto;
            padding: 58px 0;
        }

        .hero {
            width: min(1120px, calc(100% - 32px));
            margin: 0 auto;
            min-height: calc(100vh - 72px);
            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(310px, .72fr);
            align-items: center;
            gap: 48px;
            padding: 54px 0 42px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 18px;
            color: var(--teal-dark);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            content: "";
            width: 32px;
            height: 3px;
            background: var(--coral);
        }

        h1 {
            margin: 0;
            font-size: clamp(42px, 7vw, 82px);
            line-height: .96;
            max-width: 840px;
        }

        .hero-title span {
            color: var(--teal);
            display: block;
        }

        .hero-summary {
            max-width: 720px;
            margin: 24px 0 0;
            color: #39434f;
            font-size: clamp(16px, 2vw, 19px);
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
        }

        .hero-meta {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 40px;
            max-width: 700px;
        }

        .metric {
            border-top: 3px solid var(--teal);
            padding-top: 12px;
        }

        .metric:nth-child(2) {
            border-color: var(--coral);
        }

        .metric:nth-child(3) {
            border-color: var(--gold);
        }

        .metric strong {
            display: block;
            font-size: 24px;
            line-height: 1.1;
        }

        .metric span {
            color: var(--muted);
            font-size: 13px;
        }

        .profile-panel {
            position: relative;
            background: var(--teal-dark);
            color: #fff;
            border-radius: 8px;
            overflow: hidden;
            min-height: 560px;
            display: grid;
            align-content: end;
        }

        .profile-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(16, 76, 73, .08), rgba(16, 76, 73, .72)),
                url("{{ $photoSrc }}") center top / cover no-repeat;
        }

        .profile-info {
            position: relative;
            padding: 26px;
            background: rgba(16, 76, 73, .92);
        }

        .profile-info h2 {
            margin: 0 0 6px;
            font-size: 26px;
            line-height: 1.1;
        }

        .profile-info p {
            margin: 0;
            color: rgba(255, 255, 255, .82);
        }

        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: 18px;
        }

        .quick-links a {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 8px;
            color: #fff;
            text-decoration: none;
        }

        .quick-links a:hover {
            background: rgba(255, 255, 255, .13);
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 24px;
            margin-bottom: 28px;
        }

        .section-heading h2 {
            margin: 0;
            font-size: clamp(28px, 4vw, 44px);
            line-height: 1.05;
        }

        .section-heading p {
            max-width: 520px;
            margin: 0;
            color: var(--muted);
        }

        .band {
            background: var(--surface);
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }

        .skill-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .skill-pill {
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 16px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
        }

        .skill-pill span {
            min-width: 0;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .skill-pill small {
            color: var(--muted);
            white-space: nowrap;
        }

        .timeline {
            display: grid;
            gap: 16px;
        }

        .timeline-item {
            display: grid;
            grid-template-columns: 220px minmax(0, 1fr);
            gap: 24px;
            padding: 22px 0;
            border-top: 1px solid var(--line);
        }

        .timeline-item:last-child {
            border-bottom: 1px solid var(--line);
        }

        .timeline-date {
            color: var(--teal-dark);
            font-weight: 900;
        }

        .timeline-body h3 {
            margin: 0 0 4px;
            font-size: 22px;
            line-height: 1.25;
        }

        .timeline-company {
            color: var(--coral);
            font-weight: 800;
            margin-bottom: 8px;
        }

        .timeline-body p {
            margin: 0;
            color: #4a5561;
        }

        .project-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .project-card {
            min-height: 260px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 18px;
            padding: 22px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
        }

        .project-card:nth-child(3n + 1) {
            background: var(--green-soft);
        }

        .project-card:nth-child(3n + 2) {
            background: var(--gold-soft);
        }

        .project-card:nth-child(3n + 3) {
            background: var(--coral-soft);
        }

        .project-card h3 {
            margin: 0 0 10px;
            font-size: 21px;
            line-height: 1.25;
            overflow-wrap: anywhere;
        }

        .project-card p {
            margin: 0;
            color: #47515d;
            overflow-wrap: anywhere;
        }

        .project-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--teal-dark);
            font-weight: 900;
            text-decoration: none;
        }

        .two-column {
            display: grid;
            grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
            gap: 34px;
            align-items: start;
        }

        .plain-list {
            display: grid;
            gap: 12px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .plain-list li {
            padding: 16px 0;
            border-top: 1px solid var(--line);
        }

        .plain-list strong {
            display: block;
            margin-bottom: 4px;
            font-size: 17px;
        }

        .plain-list span {
            color: var(--muted);
        }

        .contact-panel {
            display: grid;
            grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
            gap: 36px;
            align-items: center;
            padding: 42px;
            background: var(--teal-dark);
            color: #fff;
            border-radius: 8px;
        }

        .contact-panel h2 {
            margin: 0;
            font-size: clamp(30px, 4vw, 48px);
            line-height: 1.05;
        }

        .contact-panel p {
            color: rgba(255, 255, 255, .78);
        }

        .contact-list {
            display: grid;
            gap: 12px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            color: rgba(255, 255, 255, .9);
            text-decoration: none;
        }

        .contact-item i {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: rgba(255, 255, 255, .12);
            flex: 0 0 auto;
        }

        .contact-item span {
            overflow-wrap: anywhere;
        }

        .site-footer {
            padding: 22px 0 38px;
            color: var(--muted);
            text-align: center;
            font-size: 14px;
        }

        @media (max-width: 980px) {
            .hero,
            .two-column,
            .contact-panel {
                grid-template-columns: 1fr;
            }

            .hero {
                min-height: auto;
                gap: 32px;
            }

            .profile-panel {
                min-height: 480px;
            }

            .skill-grid,
            .project-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .section-heading {
                align-items: start;
                flex-direction: column;
            }
        }

        @media (max-width: 720px) {
            .nav {
                min-height: auto;
                padding: 12px 0;
                align-items: start;
                flex-direction: column;
            }

            .nav-links {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 3px;
            }

            .hero-meta,
            .skill-grid,
            .project-grid {
                grid-template-columns: 1fr;
            }

            .timeline-item {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .profile-panel {
                min-height: 420px;
            }

            .section {
                padding: 44px 0;
            }

            .contact-panel {
                padding: 28px 20px;
            }
        }

        @media print {
            .site-header,
            .hero-actions,
            .quick-links,
            .site-footer {
                display: none !important;
            }

            body {
                background: #fff;
            }

            .hero,
            .section {
                width: 100%;
                padding: 18px 0;
            }

            .profile-panel,
            .contact-panel,
            .project-card,
            .skill-pill {
                box-shadow: none;
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <nav class="nav" aria-label="Portfolio navigation">
            <a href="#top" class="brand">
                <span class="brand-mark">{{ \Illuminate\Support\Str::of($cv->full_name)->explode(' ')->filter()->map(fn ($part) => \Illuminate\Support\Str::substr($part, 0, 1))->take(2)->implode('') }}</span>
                <span class="brand-text">
                    <span class="brand-name">{{ $cv->full_name }}</span>
                    <span class="brand-role">{{ $primaryRole }}</span>
                </span>
            </a>
            <div class="nav-links">
                <a href="#skills">Skills</a>
                <a href="#experience">Experience</a>
                <a href="#projects">Projects</a>
                <a href="#contact">Contact</a>
                <a href="{{ $cvUrl }}">CV View</a>
            </div>
        </nav>
    </header>

    <main id="top">
        <section class="hero" aria-label="Portfolio intro">
            <div>
                <p class="eyebrow">{{ $primaryRole }}</p>
                <h1 class="hero-title">{{ $cv->full_name }} <span>builds practical web solutions.</span></h1>
                <p class="hero-summary">{{ $summary }}</p>

                <div class="hero-actions">
                    <a href="{{ $cvUrl }}" class="btn btn-primary">
                        <i class="fa fa-file-text"></i>
                        <span>CV View</span>
                    </a>
                    @if($cv->email)
                        <a href="mailto:{{ $cv->email }}" class="btn btn-secondary">
                            <i class="fa fa-envelope"></i>
                            <span>Contact</span>
                        </a>
                    @endif
                    @if($cv->website_url)
                        <a href="{{ $cv->website_url }}" target="_blank" rel="noopener" class="btn btn-ghost">
                            <i class="fa fa-globe"></i>
                            <span>Website</span>
                        </a>
                    @endif
                </div>

                <div class="hero-meta" aria-label="Career highlights">
                    <div class="metric">
                        <strong>{{ $experienceYears }}</strong>
                        <span>Professional experience</span>
                    </div>
                    <div class="metric">
                        <strong>{{ $cv->projects->count() }}</strong>
                        <span>Featured projects</span>
                    </div>
                    <div class="metric">
                        <strong>{{ $cv->skills->count() }}</strong>
                        <span>Listed skills</span>
                    </div>
                </div>
            </div>

            <aside class="profile-panel" aria-label="Profile summary">
                <div class="profile-info">
                    <h2>{{ $cv->full_name }}</h2>
                    <p>
                        {{ $currentCompany ? $primaryRole . ' at ' . $currentCompany : $primaryRole }}
                    </p>
                    <div class="quick-links">
                        @if($cv->github_url)
                            <a href="{{ $cv->github_url }}" target="_blank" rel="noopener" aria-label="GitHub">
                                <i class="fa-brands fa-github"></i>
                            </a>
                        @endif
                        @if($cv->linkedin_url)
                            <a href="{{ $cv->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        @endif
                        @if($cv->website_url)
                            <a href="{{ $cv->website_url }}" target="_blank" rel="noopener" aria-label="Website">
                                <i class="fa fa-globe"></i>
                            </a>
                        @endif
                        @if($cv->email)
                            <a href="mailto:{{ $cv->email }}" aria-label="Email">
                                <i class="fa fa-envelope"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </aside>
        </section>

        @if($featuredSkills->isNotEmpty())
            <div class="band" id="skills">
                <section class="section">
                    <div class="section-heading">
                        <h2>Core Skills</h2>
                        <p>Tools and strengths pulled from the public CV profile.</p>
                    </div>
                    <div class="skill-grid">
                        @foreach($featuredSkills->take(12) as $skill)
                            <div class="skill-pill">
                                <span>{{ $skill->skill_name }}</span>
                                @if($skill->skill_level)
                                    <small>{{ $skill->skill_level }}</small>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        @endif

        @if($cv->employments->isNotEmpty())
            <section class="section" id="experience">
                <div class="section-heading">
                    <h2>Experience</h2>
                    <p>Recent work history, responsibilities, and practical delivery experience.</p>
                </div>
                <div class="timeline">
                    @foreach($cv->employments as $employment)
                        <article class="timeline-item">
                            <div class="timeline-date">
                                {{ $formatDate($employment->start_date) ?: 'Experience' }}
                                @if($employment->start_date)
                                    - {{ $employment->is_current ? 'Present' : $formatDate($employment->end_date) }}
                                @endif
                            </div>
                            <div class="timeline-body">
                                <h3>{{ $employment->designation ?: 'Role' }}</h3>
                                @if($employment->company_name)
                                    <div class="timeline-company">{{ $employment->company_name }}</div>
                                @endif
                                @if($employment->responsibilities)
                                    <p>{{ \Illuminate\Support\Str::limit($employment->responsibilities, 220) }}</p>
                                @elseif($employment->achievements)
                                    <p>{{ \Illuminate\Support\Str::limit($employment->achievements, 220) }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if($cv->projects->isNotEmpty())
            <div class="band" id="projects">
                <section class="section">
                    <div class="section-heading">
                        <h2>Featured Projects</h2>
                        <p>Selected project work from the CV, with live links where available.</p>
                    </div>
                    <div class="project-grid">
                        @foreach($cv->projects as $project)
                            <article class="project-card">
                                <div>
                                    <h3>{{ $project->title }}</h3>
                                    @if($project->description)
                                        <p>{{ \Illuminate\Support\Str::limit($project->description, 210) }}</p>
                                    @endif
                                </div>
                                @if($project->link)
                                    <a href="{{ $project->link }}" class="project-link" target="_blank" rel="noopener">
                                        <span>View project</span>
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>
        @endif

        <section class="section">
            <div class="two-column">
                @if($cv->academics->isNotEmpty())
                    <div>
                        <div class="section-heading">
                            <h2>Education</h2>
                        </div>
                        <ul class="plain-list">
                            @foreach($cv->academics as $academic)
                                <li>
                                    <strong>{{ $academic->degree_name }}</strong>
                                    <span>
                                        {{ $academic->institution }}
                                        @if($academic->board_or_university)
                                            | {{ $academic->board_or_university }}
                                        @endif
                                        @if($academic->result)
                                            | {{ $academic->result }}
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($cv->trainings->isNotEmpty() || $cv->languages->isNotEmpty())
                    <div>
                        <div class="section-heading">
                            <h2>Training</h2>
                        </div>
                        <ul class="plain-list">
                            @foreach($cv->trainings as $training)
                                <li>
                                    <strong>{{ $training->training_title }}</strong>
                                    <span>{{ $training->institute }}{{ $training->year ? ' | ' . $training->year : '' }}</span>
                                </li>
                            @endforeach
                            @if($cv->languages->isNotEmpty())
                                <li>
                                    <strong>Language Proficiency</strong>
                                    <span>
                                        @foreach($cv->languages as $language)
                                            {{ $language->language_name }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>
        </section>

        <section class="section" id="contact">
            <div class="contact-panel">
                <div>
                    <h2>Available for useful software work.</h2>
                    <p>Use the CV view for full career details and print support, or reach out directly through the contact information.</p>
                    <div class="hero-actions">
                        <a href="{{ $cvUrl }}" class="btn btn-primary">
                            <i class="fa fa-file-text"></i>
                            <span>CV View</span>
                        </a>
                        @if(!empty($printEnabled))
                            <a href="{{ $printUrl }}" class="btn btn-secondary">
                                <i class="fa fa-print"></i>
                                <span>Print CV</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="contact-list">
                    @if($cv->email)
                        <a class="contact-item" href="mailto:{{ $cv->email }}">
                            <i class="fa fa-envelope"></i>
                            <span>{{ $cv->email }}</span>
                        </a>
                    @endif
                    @if($cv->mobile)
                        <a class="contact-item" href="tel:{{ preg_replace('/\s+/', '', $cv->mobile) }}">
                            <i class="fa fa-phone"></i>
                            <span>{{ $cv->mobile }}</span>
                        </a>
                    @endif
                    @if($cv->present_address)
                        <div class="contact-item">
                            <i class="fa fa-location-dot"></i>
                            <span>{{ $cv->present_address }}</span>
                        </div>
                    @endif
                    @if($cv->website_url)
                        <a class="contact-item" href="{{ $cv->website_url }}" target="_blank" rel="noopener">
                            <i class="fa fa-globe"></i>
                            <span>{{ $cv->website_url }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <span>{{ $cv->full_name }} Portfolio</span>
    </footer>
</body>
</html>
