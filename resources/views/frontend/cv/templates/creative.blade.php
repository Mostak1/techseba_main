@php
    $defaultAvatar = 'uploads/website-images/avatar-image-2024-07-02-10-08-24-5849.png';
    $rawPhoto = $cv->photo ?: ($cv->user?->image ?: (file_exists(public_path($defaultAvatar)) ? $defaultAvatar : null));

    $photoSrc = null;
    $signatureSrc = null;

    if ($rawPhoto) {
        $photoSrc = !empty($forPdf) && file_exists(public_path($rawPhoto)) ? public_path($rawPhoto) : asset($rawPhoto);
    }

    if ($cv->signature) {
        $signatureSrc = !empty($forPdf) && file_exists(public_path($cv->signature)) ? public_path($cv->signature) : asset($cv->signature);
    }

    $formatDate = function ($date) {
        if (!$date) return '';
        try {
            return \Illuminate\Support\Carbon::parse($date)->format('M Y');
        } catch (\Throwable $e) {
            return (string) $date;
        }
    };

    $formatFullDate = function ($date) {
        if (!$date) return '';
        try {
            return \Illuminate\Support\Carbon::parse($date)->format('d F Y');
        } catch (\Throwable $e) {
            return (string) $date;
        }
    };

    $fontAwesomeHref = !empty($forPdf)
        ? public_path('frontend/assets/css/fontawesome.css')
        : asset('frontend/assets/css/fontawesome.css');

    $username = $username ?? ($cv->user?->username ?? 'user');
    $primaryRole = $cv->employments->first()->designation ?? 'Creative Professional & Software Engineer';
    $academics = $cv->academics->isNotEmpty() ? $cv->academics : ($cv->educations ?? collect());
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cv->full_name }} — Creative Executive CV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ $fontAwesomeHref }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        html, body {
            margin: 0;
            padding: 0;
            background: #f1f5f9;
            color: #1e293b;
            font-family: 'Plus Jakarta Sans', 'Outfit', system-ui, -apple-system, sans-serif;
            font-size: 9.6px;
            line-height: 1.45;
            -webkit-font-smoothing: antialiased;
        }

        .no-print-area {
            max-width: 210mm;
            margin: 14px auto 0;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 0 10px;
        }

        .btn {
            padding: 7px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            color: #ffffff;
            background: #1e1b4b;
            border: none;
            cursor: pointer;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 5px rgba(30, 27, 75, 0.2);
            transition: all 0.2s ease;
        }
        .btn:hover { background: #312e81; }
        .btn-secondary { background: #475569; }

        .resume-page {
            width: 210mm;
            min-height: 297mm;
            margin: 14px auto 26px;
            background: #ffffff;
            display: flex;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.12);
            border-radius: 4px;
            position: relative;
            box-sizing: border-box;
        }

        /* Left Sidebar: Deep Indigo Gradient */
        .sidebar {
            width: 72mm;
            background: linear-gradient(180deg, #0f172a 0%, #1e1b4b 55%, #2e1065 100%);
            color: #f8fafc;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            gap: 18px;
            flex-shrink: 0;
        }

        .avatar-wrap {
            text-align: center;
            margin-bottom: 4px;
        }

        .avatar-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
        }

        .sidebar-title {
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #38bdf8;
            border-bottom: 1px solid rgba(56, 189, 248, 0.25);
            padding-bottom: 4px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 9px;
            color: #cbd5e1;
            margin-bottom: 6px;
            word-break: break-all;
        }

        .contact-item a {
            color: #cbd5e1;
            text-decoration: none;
        }
        .contact-item a:hover { color: #ffffff; text-decoration: underline; }

        .contact-item i {
            color: #38bdf8;
            font-size: 10px;
            width: 14px;
            text-align: center;
            flex-shrink: 0;
        }

        .skill-pill {
            display: inline-block;
            background: rgba(255, 255, 255, 0.08);
            color: #e2e8f0;
            font-size: 8.5px;
            font-weight: 600;
            padding: 2.5px 7px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            margin: 0 3px 4px 0;
        }

        /* Right Content Area */
        .main-content {
            flex: 1;
            padding: 24px 22px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            min-width: 0;
        }

        .header-section {
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }

        .person-name {
            font-size: 23px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 2px 0;
            letter-spacing: -0.4px;
            text-transform: uppercase;
            line-height: 1.15;
        }

        .person-role {
            font-size: 11.5px;
            font-weight: 700;
            color: #6366f1;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin: 0 0 6px 0;
        }

        .person-summary {
            font-size: 9.2px;
            color: #475569;
            line-height: 1.5;
            margin: 0;
        }

        .section-heading {
            font-size: 11.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 9px;
            padding-bottom: 3px;
            border-bottom: 1.5px solid #e2e8f0;
            break-after: avoid;
            page-break-after: avoid;
        }

        .section-heading i {
            color: #6366f1;
        }

        .timeline-item {
            position: relative;
            padding-left: 14px;
            border-left: 2px solid #e0e7ff;
            margin-bottom: 11px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 2px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #6366f1;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 1px #6366f1;
        }

        .item-role {
            font-size: 10.8px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .item-company {
            font-size: 9.2px;
            font-weight: 600;
            color: #6366f1;
            display: flex;
            justify-content: space-between;
            margin: 1px 0 4px 0;
        }

        .item-date {
            color: #64748b;
            font-weight: 500;
            font-size: 8.8px;
        }

        .item-desc {
            font-size: 8.8px;
            color: #475569;
            margin: 0;
            line-height: 1.45;
        }

        .bullet-list {
            margin: 2px 0 0 14px;
            padding: 0;
            font-size: 8.8px;
            color: #475569;
            line-height: 1.4;
        }
        .bullet-list li { margin-bottom: 2px; }

        /* Project Cards */
        .project-card {
            border: 1px solid #e2e8f0;
            border-left: 3px solid #6366f1;
            background: #f8fafc;
            border-radius: 4px;
            padding: 6px 10px;
            margin-bottom: 7px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 2px;
        }

        .project-title {
            font-size: 10px;
            font-weight: 700;
            color: #0f172a;
        }

        .project-role {
            font-size: 8.5px;
            color: #64748b;
            font-weight: 600;
        }

        .tech-line {
            font-size: 8.5px;
            color: #6366f1;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .demo-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            font-size: 8.5px;
            margin-bottom: 3px;
        }
        .demo-bar a { color: #2563eb; text-decoration: none; }
        .demo-bar a:hover { text-decoration: underline; }

        .signature-box {
            margin-top: auto;
            text-align: right;
            padding-top: 10px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .signature-box img {
            max-height: 38px;
        }

        @media print {
            body {
                background: #ffffff !important;
            }
            .no-print-area {
                display: none !important;
            }
            .resume-page {
                box-shadow: none !important;
                width: 100% !important;
                min-height: 0 !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }
            .timeline-item, .project-card, .signature-box {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
            }
        }

        @if(!empty($forPdf))
        body {
            background: #ffffff;
            font-size: 9.2px;
        }
        .no-print-area { display: none !important; }
        .resume-page {
            width: 100%;
            margin: 0;
            box-shadow: none;
        }
        @endif
    </style>
</head>
<body>
    @if(empty($isTemplatePreview))
        <div class="no-print-area">
            <button onclick="window.print()" class="btn"><i class="fa-solid fa-print"></i> Print Resume / Save PDF</button>
            <a href="{{ profile_route('user.cv.edit') }}" class="btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i> Edit Content</a>
        </div>
    @endif

    <div class="resume-page">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="avatar-wrap">
                @if($photoSrc)
                    <img src="{{ $photoSrc }}" alt="{{ $cv->full_name }}" class="avatar-img">
                @else
                    <div class="avatar-img" style="background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-user" style="font-size: 32px; color: #cbd5e1;"></i>
                    </div>
                @endif
            </div>

            <!-- Contact Information -->
            <div>
                <div class="sidebar-title"><i class="fas fa-address-book"></i> Contact</div>
                @if($cv->email)
                    <div class="contact-item"><i class="fas fa-envelope"></i> <span><a href="mailto:{{ $cv->email }}">{{ $cv->email }}</a></span></div>
                @endif
                @if($cv->mobile)
                    <div class="contact-item"><i class="fas fa-phone"></i> <span>{{ $cv->mobile }}</span></div>
                @endif
                @if($cv->website_url)
                    <div class="contact-item"><i class="fas fa-globe"></i> <span><a href="{{ $cv->website_url }}" target="_blank">{{ str_replace(['https://', 'http://'], '', $cv->website_url) }}</a></span></div>
                @endif
                @if($cv->linkedin_url)
                    <div class="contact-item"><i class="fab fa-linkedin"></i> <span><a href="{{ $cv->linkedin_url }}" target="_blank">{{ str_replace(['https://', 'http://'], '', $cv->linkedin_url) }}</a></span></div>
                @endif
                @if($cv->github_url)
                    <div class="contact-item"><i class="fab fa-github"></i> <span><a href="{{ $cv->github_url }}" target="_blank">{{ str_replace(['https://', 'http://'], '', $cv->github_url) }}</a></span></div>
                @endif
                @if($cv->present_address)
                    <div class="contact-item"><i class="fas fa-map-marker-alt"></i> <span>{{ $cv->present_address }}</span></div>
                @endif
            </div>

            <!-- Skills -->
            @if($cv->skills && $cv->skills->count())
                <div>
                    <div class="sidebar-title"><i class="fas fa-tools"></i> Skills</div>
                    <div>
                        @foreach($cv->skills as $skill)
                            <span class="skill-pill">{{ $skill->skill_name ?? $skill->name }}@if($skill->skill_level) ({{ $skill->skill_level }})@endif</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Languages -->
            @if($cv->languages && $cv->languages->count())
                <div>
                    <div class="sidebar-title"><i class="fas fa-language"></i> Languages</div>
                    @foreach($cv->languages as $lang)
                        <div class="contact-item">
                            <i class="fas fa-check-circle"></i>
                            <span><strong>{{ $lang->language_name ?? $lang->name }}</strong>: {{ $lang->reading_level ?: ($lang->proficiency ?? 'Fluent') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Personal Info (if available) -->
            @if($cv->date_of_birth || $cv->nationality || $cv->nid_or_passport)
                <div>
                    <div class="sidebar-title"><i class="fas fa-user-tag"></i> Personal</div>
                    @if($cv->nationality)<div class="contact-item"><i class="fas fa-flag"></i> <span>{{ $cv->nationality }}</span></div>@endif
                    @if($cv->date_of_birth)<div class="contact-item"><i class="fas fa-calendar"></i> <span>{{ $formatDate($cv->date_of_birth) }}</span></div>@endif
                    @if($cv->marital_status)<div class="contact-item"><i class="fas fa-ring"></i> <span>{{ $cv->marital_status }}</span></div>@endif
                </div>
            @endif
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header-section">
                <h1 class="person-name">{{ $cv->full_name }}</h1>
                <div class="person-role">{{ $primaryRole }}</div>
                @if($cv->career_summary || $cv->career_objective)
                    <p class="person-summary">{!! clean($cv->career_summary ?: $cv->career_objective) !!}</p>
                @endif
            </header>

            <!-- Experience -->
            @if($cv->employments && $cv->employments->count())
                <section>
                    <div class="section-heading"><i class="fas fa-briefcase"></i> Work Experience</div>
                    @foreach($cv->employments as $emp)
                        <div class="timeline-item">
                            <h3 class="item-role">{{ $emp->designation }}</h3>
                            <div class="item-company">
                                <span>{{ $emp->company_name }}@if($emp->company_location) · {{ $emp->company_location }}@endif</span>
                                <span class="item-date">
                                    {{ $formatDate($emp->start_date) }} – {{ $emp->is_current ? 'Present' : $formatDate($emp->end_date) }}
                                </span>
                            </div>
                            @if($emp->responsibilities)
                                @if(strip_tags($emp->responsibilities) !== $emp->responsibilities)
                                    <div class="item-desc">{!! clean($emp->responsibilities) !!}</div>
                                @else
                                    <ul class="bullet-list">
                                        @foreach(explode("\n", $emp->responsibilities) as $line)
                                            @if(trim($line))<li>{{ trim($line, "*-• ") }}</li>@endif
                                        @endforeach
                                    </ul>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            <!-- Featured Projects -->
            @if($cv->projects && $cv->projects->isNotEmpty())
                <section>
                    <div class="section-heading"><i class="fas fa-laptop-code"></i> Featured Projects</div>
                    @foreach($cv->projects as $project)
                        <div class="project-card">
                            <div class="project-header">
                                <span class="project-title">{{ $loop->iteration }}. {{ $project->title }}</span>
                                @if($project->role)<span class="project-role">{{ $project->role }}</span>@endif
                            </div>
                            @if($project->technologies)
                                <div class="tech-line">Tech: {{ $project->technologies }}</div>
                            @endif
                            @if($project->link || $project->github_url || $project->demo_user)
                                <div class="demo-bar">
                                    @if($project->link)<span><i class="fa-solid fa-arrow-up-right-from-square"></i> <a href="{{ $project->link }}" target="_blank">Demo</a></span>@endif
                                    @if($project->github_url)<span><i class="fa-brands fa-github"></i> <a href="{{ $project->github_url }}" target="_blank">GitHub</a></span>@endif
                                    @if($project->demo_user)<span><strong>User:</strong> <code>{{ $project->demo_user }}</code></span>@endif
                                    @if($project->demo_password)<span><strong>Pass:</strong> <code>{{ $project->demo_password }}</code></span>@endif
                                </div>
                            @endif
                            @if($project->description)
                                <div class="item-desc">{!! clean($project->description) !!}</div>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            <!-- Education -->
            @if($academics->isNotEmpty())
                <section>
                    <div class="section-heading"><i class="fas fa-graduation-cap"></i> Education</div>
                    @foreach($academics as $academic)
                        <div class="timeline-item">
                            <h3 class="item-role">{{ $academic->degree_name }}</h3>
                            <div class="item-company">
                                <span>{{ $academic->institution }}@if($academic->board_or_university), {{ $academic->board_or_university }}@endif</span>
                                <span class="item-date">{{ $academic->passing_year }}</span>
                            </div>
                            @if($academic->result)
                                <p class="item-desc">Result / GPA: {{ $academic->result }} @if($academic->group_or_major)({{ $academic->group_or_major }})@endif</p>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            <!-- Certifications & Training -->
            @if($cv->trainings && $cv->trainings->isNotEmpty())
                <section>
                    <div class="section-heading"><i class="fas fa-certificate"></i> Training &amp; Certifications</div>
                    @foreach($cv->trainings as $train)
                        <div class="timeline-item">
                            <h3 class="item-role">{{ $train->training_title }}</h3>
                            <div class="item-company">
                                <span>{{ $train->institute }}</span>
                                <span class="item-date">{{ $train->year ?: $train->duration }}</span>
                            </div>
                            @if($train->certificate_details && trim($train->certificate_details) !== '*')
                                <p class="item-desc">{!! clean(ltrim(trim($train->certificate_details), "*•- \t\n\r")) !!}</p>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            <!-- Professional References -->
            @if($cv->references && $cv->references->isNotEmpty())
                <section>
                    <div class="section-heading"><i class="fas fa-users"></i> References</div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        @foreach($cv->references as $ref)
                            <div style="border: 1px solid #e2e8f0; background: #f8fafc; padding: 5px 8px; border-radius: 4px; font-size: 8.5px; break-inside: avoid;">
                                <strong style="color: #0f172a; font-size: 9.5px;">{{ $ref->name }}</strong>
                                <div style="color: #6366f1;">{{ $ref->designation }}</div>
                                <div>{{ $ref->organization }}</div>
                                @if($ref->phone)<div>Phone: {{ $ref->phone }}</div>@endif
                                @if($ref->email)<div>Email: {{ $ref->email }}</div>@endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Signature & Declaration -->
            @if($signatureSrc || $cv->declaration)
                <div class="signature-box">
                    @if($cv->declaration)
                        <p style="font-size: 8.5px; color: #64748b; margin-bottom: 6px; text-align: left;">{!! clean($cv->declaration) !!}</p>
                    @endif
                    @if($signatureSrc)
                        <img src="{{ $signatureSrc }}" alt="Signature">
                    @endif
                    <div style="font-size: 8.5px; font-weight: 700; color: #0f172a; margin-top: 2px;">{{ $cv->full_name }}</div>
                    @if($cv->declaration_date)
                        <div style="font-size: 7.5px; color: #94a3b8;">{{ $formatDate($cv->declaration_date) }}</div>
                    @endif
                </div>
            @endif
        </main>
    </div>
</body>
</html>
