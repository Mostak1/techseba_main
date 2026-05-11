@php
    $photoSrc = $cv->photo ? asset($cv->photo) : asset('uploads/website-images/avatar-image-2024-07-02-10-08-24-5849.png');
    $currentEmployment = $cv->employments->first();
    $primaryRole = $currentEmployment?->designation ?: 'Software Developer';
    $currentCompany = $currentEmployment?->company_name;
    $summary = $cv->career_summary ?: $cv->career_objective;
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
    <style>
        :root {
            --paper: #fbfaf7;
            --ink: #17212f;
            --muted: #687383;
            --line: #d9d3c7;
            --blue: #193c63;
            --green: #32766b;
            --red: #a94f3f;
            --gold: #c08a2c;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: Georgia, "Times New Roman", serif;
            line-height: 1.62;
        }

        a {
            color: inherit;
        }

        .page {
            width: min(1080px, calc(100% - 32px));
            margin: 0 auto;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            background: rgba(251, 250, 247, .94);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(12px);
        }

        .nav {
            min-height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
        }

        .brand {
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
        }

        .links {
            display: flex;
            align-items: center;
            gap: 18px;
            color: var(--muted);
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: 700;
        }

        .links a {
            text-decoration: none;
        }

        .links a:hover {
            color: var(--red);
        }

        .hero {
            min-height: calc(100vh - 68px);
            display: grid;
            grid-template-columns: minmax(0, 1fr) 330px;
            gap: 52px;
            align-items: center;
            padding: 58px 0 46px;
        }

        .label {
            margin: 0 0 16px;
            color: var(--red);
            font-family: Arial, sans-serif;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            max-width: 760px;
            font-size: clamp(42px, 7vw, 78px);
            line-height: 1;
            letter-spacing: 0;
        }

        .lead {
            max-width: 700px;
            margin: 24px 0 0;
            color: #3d4652;
            font-size: 19px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
            font-family: Arial, sans-serif;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 10px 18px;
            border: 1px solid var(--blue);
            border-radius: 8px;
            background: var(--blue);
            color: var(--white);
            text-decoration: none;
            font-weight: 800;
        }

        .button.secondary {
            background: transparent;
            color: var(--blue);
        }

        .portrait {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--white);
            padding: 14px;
        }

        .portrait img {
            display: block;
            width: 100%;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            border-radius: 6px;
        }

        .portrait-info {
            padding: 16px 4px 4px;
        }

        .portrait-info strong {
            display: block;
            font-size: 22px;
            line-height: 1.2;
        }

        .portrait-info span {
            color: var(--muted);
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 40px;
            font-family: Arial, sans-serif;
        }

        .stat {
            border-left: 4px solid var(--green);
            padding: 8px 0 8px 14px;
        }

        .stat:nth-child(2) {
            border-color: var(--red);
        }

        .stat:nth-child(3) {
            border-color: var(--gold);
        }

        .stat strong {
            display: block;
            font-size: 24px;
            line-height: 1.1;
        }

        .stat span {
            color: var(--muted);
            font-size: 13px;
        }

        .band {
            border-top: 1px solid var(--line);
            background: var(--white);
        }

        .section {
            padding: 58px 0;
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 24px;
            margin-bottom: 24px;
        }

        .section-head h2 {
            margin: 0;
            color: var(--blue);
            font-size: clamp(28px, 4vw, 42px);
            line-height: 1.1;
        }

        .section-head p {
            max-width: 520px;
            margin: 0;
            color: var(--muted);
            font-family: Arial, sans-serif;
        }

        .skills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .skill {
            padding: 9px 13px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--paper);
            font-family: Arial, sans-serif;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .timeline {
            display: grid;
            gap: 0;
            border-top: 1px solid var(--line);
        }

        .timeline article {
            display: grid;
            grid-template-columns: 190px minmax(0, 1fr);
            gap: 28px;
            padding: 22px 0;
            border-bottom: 1px solid var(--line);
        }

        .date {
            color: var(--red);
            font-family: Arial, sans-serif;
            font-weight: 900;
        }

        .timeline h3,
        .project h3 {
            margin: 0 0 5px;
            font-size: 22px;
            line-height: 1.25;
            overflow-wrap: anywhere;
        }

        .meta {
            color: var(--green);
            font-family: Arial, sans-serif;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .timeline p,
        .project p {
            margin: 0;
            color: #4e5865;
            overflow-wrap: anywhere;
        }

        .projects {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .project {
            min-height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 18px;
            padding: 24px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--paper);
        }

        .project a {
            color: var(--blue);
            font-family: Arial, sans-serif;
            font-weight: 900;
            text-decoration: none;
        }

        .columns {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 34px;
        }

        .list {
            margin: 0;
            padding: 0;
            list-style: none;
            border-top: 1px solid var(--line);
        }

        .list li {
            padding: 16px 0;
            border-bottom: 1px solid var(--line);
        }

        .list strong {
            display: block;
            margin-bottom: 4px;
            font-size: 18px;
        }

        .list span {
            color: var(--muted);
            font-family: Arial, sans-serif;
        }

        .contact {
            display: grid;
            grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
            gap: 34px;
            padding: 38px;
            border-radius: 8px;
            background: var(--blue);
            color: var(--white);
        }

        .contact h2 {
            margin: 0;
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.1;
        }

        .contact p,
        .contact a,
        .contact div {
            color: rgba(255, 255, 255, .82);
            overflow-wrap: anywhere;
        }

        .contact-list {
            display: grid;
            gap: 10px;
            font-family: Arial, sans-serif;
        }

        .footer {
            padding: 22px 0 38px;
            color: var(--muted);
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        @media (max-width: 880px) {
            .hero,
            .columns,
            .contact {
                grid-template-columns: 1fr;
            }

            .portrait {
                max-width: 360px;
            }

            .projects {
                grid-template-columns: 1fr;
            }

            .section-head {
                align-items: start;
                flex-direction: column;
            }
        }

        @media (max-width: 640px) {
            .nav {
                align-items: start;
                flex-direction: column;
                padding: 12px 0;
            }

            .links {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 4px;
            }

            .hero {
                min-height: auto;
                padding-top: 42px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .timeline article {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .contact {
                padding: 28px 20px;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <nav class="page nav" aria-label="Portfolio navigation">
            <a href="#top" class="brand">{{ $cv->full_name }}</a>
            <div class="links">
                <a href="#experience">Experience</a>
                <a href="#projects">Projects</a>
                <a href="#education">Education</a>
                <a href="#contact">Contact</a>
                <a href="{{ $cvUrl }}">CV View</a>
            </div>
        </nav>
    </header>

    <main id="top">
        <section class="page hero">
            <div>
                <p class="label">{{ $primaryRole }}</p>
                <h1>{{ $cv->full_name }}</h1>
                <p class="lead">
                    {{ $summary ? \Illuminate\Support\Str::limit($summary, 300) : 'A practical software professional focused on building reliable web applications and useful digital products.' }}
                </p>
                <div class="actions">
                    <a class="button" href="{{ $cvUrl }}">CV View</a>
                    @if($cv->email)
                        <a class="button secondary" href="mailto:{{ $cv->email }}">Contact</a>
                    @endif
                    @if(!empty($printEnabled))
                        <a class="button secondary" href="{{ $printUrl }}">Print CV</a>
                    @endif
                </div>
                <div class="stats">
                    <div class="stat">
                        <strong>{{ $cv->total_experience ? rtrim(rtrim(number_format((float) $cv->total_experience, 1), '0'), '.') . '+' : '3+' }}</strong>
                        <span>Years experience</span>
                    </div>
                    <div class="stat">
                        <strong>{{ $cv->projects->count() }}</strong>
                        <span>Projects</span>
                    </div>
                    <div class="stat">
                        <strong>{{ $cv->skills->count() }}</strong>
                        <span>Skills</span>
                    </div>
                </div>
            </div>

            <aside class="portrait">
                <img src="{{ $photoSrc }}" alt="{{ $cv->full_name }}">
                <div class="portrait-info">
                    <strong>{{ $primaryRole }}</strong>
                    <span>{{ $currentCompany ?: $cv->email }}</span>
                </div>
            </aside>
        </section>

        @if($cv->skills->isNotEmpty())
            <div class="band">
                <section class="page section">
                    <div class="section-head">
                        <h2>Skills</h2>
                        <p>Technical and professional strengths from the CV profile.</p>
                    </div>
                    <div class="skills">
                        @foreach($cv->skills->take(16) as $skill)
                            <span class="skill">{{ $skill->skill_name }}</span>
                        @endforeach
                    </div>
                </section>
            </div>
        @endif

        @if($cv->employments->isNotEmpty())
            <section class="page section" id="experience">
                <div class="section-head">
                    <h2>Experience</h2>
                    <p>Recent work history and responsibilities.</p>
                </div>
                <div class="timeline">
                    @foreach($cv->employments as $employment)
                        <article>
                            <div class="date">
                                {{ $formatDate($employment->start_date) ?: 'Experience' }}
                                @if($employment->start_date)
                                    - {{ $employment->is_current ? 'Present' : $formatDate($employment->end_date) }}
                                @endif
                            </div>
                            <div>
                                <h3>{{ $employment->designation }}</h3>
                                @if($employment->company_name)
                                    <div class="meta">{{ $employment->company_name }}</div>
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
                <section class="page section">
                    <div class="section-head">
                        <h2>Projects</h2>
                        <p>Selected project work with live links where available.</p>
                    </div>
                    <div class="projects">
                        @foreach($cv->projects as $project)
                            <article class="project">
                                <div>
                                    <h3>{{ $project->title }}</h3>
                                    @if($project->description)
                                        <p>{{ \Illuminate\Support\Str::limit($project->description, 210) }}</p>
                                    @endif
                                </div>
                                @if($project->link)
                                    <a href="{{ $project->link }}" target="_blank" rel="noopener">View project</a>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>
        @endif

        <section class="page section" id="education">
            <div class="columns">
                @if($cv->academics->isNotEmpty())
                    <div>
                        <div class="section-head">
                            <h2>Education</h2>
                        </div>
                        <ul class="list">
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
                        <div class="section-head">
                            <h2>Training</h2>
                        </div>
                        <ul class="list">
                            @foreach($cv->trainings as $training)
                                <li>
                                    <strong>{{ $training->training_title }}</strong>
                                    <span>{{ $training->institute }}{{ $training->year ? ' | ' . $training->year : '' }}</span>
                                </li>
                            @endforeach
                            @if($cv->languages->isNotEmpty())
                                <li>
                                    <strong>Languages</strong>
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

        <section class="page section" id="contact">
            <div class="contact">
                <div>
                    <h2>Let's build something useful.</h2>
                    <p>Open the CV for full details or contact directly through the information here.</p>
                </div>
                <div class="contact-list">
                    @if($cv->email)
                        <a href="mailto:{{ $cv->email }}">{{ $cv->email }}</a>
                    @endif
                    @if($cv->mobile)
                        <a href="tel:{{ preg_replace('/\s+/', '', $cv->mobile) }}">{{ $cv->mobile }}</a>
                    @endif
                    @if($cv->present_address)
                        <div>{{ $cv->present_address }}</div>
                    @endif
                    @if($cv->website_url)
                        <a href="{{ $cv->website_url }}" target="_blank" rel="noopener">{{ $cv->website_url }}</a>
                    @endif
                    <a href="{{ $cvUrl }}">CV View</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        {{ $cv->full_name }} Portfolio
    </footer>
</body>
</html>
