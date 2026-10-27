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
        return $date ? \Illuminate\Support\Carbon::parse($date)->format('M Y') : '';
    };

    $formatFullDate = function ($date) {
        return $date ? \Illuminate\Support\Carbon::parse($date)->format('d F Y') : '';
    };

    $fontAwesomeHref = !empty($forPdf)
        ? public_path('frontend/assets/css/fontawesome.css')
        : asset('frontend/assets/css/fontawesome.css');

    $username = $username ?? ($cv->user->username ?? 'mostak');
    $primaryRole = $cv->employments->first()->designation ?? 'Senior Full-Stack Laravel Developer & DevOps Engineer';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cv->full_name }} — Senior Software Engineer Resume</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ $fontAwesomeHref }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 12mm 8mm 12mm;
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
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif;
            font-size: 9.8px;
            line-height: 1.4;
            -webkit-font-smoothing: antialiased;
        }

        .no-print-area {
            max-width: 210mm;
            margin: 12px auto 0;
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
            background: #0f172a;
            border: none;
            cursor: pointer;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 4px rgba(15, 23, 42, 0.15);
            transition: all 0.2s ease;
        }

        .btn-secondary { background: #475569; }

        /* ATS US Resume Sheet Container */
        .resume-page {
            width: 210mm;
            min-height: 297mm;
            margin: 14px auto 24px;
            padding: 8mm 12mm;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
            border-radius: 4px;
            position: relative;
            box-sizing: border-box;
        }

        /* Modern Executive Header */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 6px;
            margin-bottom: 7px;
        }

        .header.no-photo {
            display: block;
            text-align: center;
        }

        .header-main {
            flex: 1;
            min-width: 0;
        }

        .header.no-photo .name,
        .header.no-photo .headline {
            text-align: center;
        }

        .header.has-photo .name,
        .header.has-photo .headline {
            text-align: left;
        }

        .name {
            font-size: 21px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.3px;
            margin: 0 0 1px 0;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .headline {
            font-size: 11.5px;
            font-weight: 700;
            color: #1d4ed8;
            margin-bottom: 5px;
            line-height: 1.2;
            letter-spacing: 0.1px;
        }

        .contact-row {
            display: flex;
            flex-wrap: wrap;
            gap: 3px 10px;
            font-size: 8.5px;
            color: #334155;
            font-weight: 500;
            line-height: 1.35;
        }

        .header.no-photo .contact-row {
            justify-content: center;
        }

        .header.has-photo .contact-row {
            justify-content: flex-start;
        }

        .contact-row a {
            color: #0f172a;
            text-decoration: none;
            font-weight: 600;
        }

        .contact-row a:hover {
            color: #1d4ed8;
        }

        .contact-row span.sep {
            color: #cbd5e1;
            font-weight: 700;
        }

        .contact-icon {
            color: #2563eb;
            margin-right: 2px;
            font-size: 8.5px;
        }

        .header-photo-wrap {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-photo {
            width: 76px;
            height: 90px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid #cbd5e1;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.1);
            display: block;
            background: #f8fafc;
        }

        /* Section Styling */
        .section {
            margin-bottom: 6px;
        }

        .section-header {
            display: flex;
            align-items: center;
            font-size: 10.5px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            border-bottom: 1.5px solid #e2e8f0;
            padding-bottom: 2px;
            margin-bottom: 5px;
            position: relative;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: -1.5px;
            left: 0;
            width: 28px;
            height: 2px;
            background: #2563eb;
            border-radius: 1px;
        }

        .summary-text {
            font-size: 9.5px;
            color: #334155;
            text-align: justify;
            line-height: 1.38;
            margin: 0;
        }

        .contact-row p {
            display: inline;
            margin: 0;
        }

        .summary-text p {
            margin: 0 0 3px;
        }

        .summary-text ul, .summary-text ol {
            margin: 0 0 3px 14px;
            padding: 0;
        }

        /* Skills Matrix */
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 3px 10px;
        }

        .skill-cat {
            font-size: 9px;
            line-height: 1.32;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-left: 2.5px solid #2563eb;
            padding: 2.5px 6px;
            border-radius: 3px;
        }

        .skill-cat-name {
            font-weight: 800;
            color: #0f172a;
        }

        .skill-cat-val {
            color: #334155;
        }

        /* Experience Entry */
        .job-entry {
            margin-bottom: 5px;
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 1px;
        }

        .job-company {
            font-size: 10.5px;
            font-weight: 800;
            color: #0f172a;
        }

        .job-role {
            font-size: 9.5px;
            font-weight: 700;
            color: #2563eb;
        }

        .job-date {
            font-size: 8.5px;
            font-weight: 700;
            color: #475569;
            background: #f1f5f9;
            padding: 1px 5px;
            border-radius: 3px;
            white-space: nowrap;
        }

        .bullet-list {
            margin: 2px 0 0 14px;
            padding: 0;
            color: #334155;
            font-size: 9px;
            line-height: 1.34;
        }

        .bullet-list li {
            margin-bottom: 1.5px;
        }

        .achievement-highlight {
            font-size: 8.5px;
            margin-top: 2px;
            background: #f0fdf4;
            border-left: 2.5px solid #16a34a;
            padding: 1.5px 6px;
            border-radius: 0 3px 3px 0;
            color: #166534;
            line-height: 1.32;
        }

        /* Project Cards */
        .project-card {
            border: 1px solid #e2e8f0;
            border-left: 3px solid #2563eb;
            background: #f8fafc;
            padding: 4px 7px;
            border-radius: 3px;
            margin-bottom: 4px;
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5px;
        }

        .project-title {
            font-size: 10px;
            font-weight: 800;
            color: #0f172a;
        }

        .project-role {
            font-size: 8.5px;
            font-weight: 700;
            color: #1d4ed8;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            padding: 1px 6px;
            border-radius: 9999px;
            white-space: nowrap;
        }

        .tech-line {
            font-size: 8.5px;
            color: #475569;
            margin-bottom: 1.5px;
            line-height: 1.3;
        }

        .demo-bar {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            padding: 1.5px 6px;
            border-radius: 2px;
            font-size: 8px;
            margin: 2px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .demo-bar a {
            color: #15803d;
            text-decoration: underline;
            font-weight: 600;
        }

        /* Education & Certification Lists */
        .edu-entry {
            margin-bottom: 3.5px;
            font-size: 9px;
            line-height: 1.35;
        }

        .page-break {
            height: 12px;
            page-break-before: always;
            break-before: page;
        }

        .page-num {
            position: absolute;
            bottom: 8px;
            right: 20px;
            font-size: 8px;
            color: #94a3b8;
        }

        /* Print Media Setup */
        @media print {
            html, body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .no-print-area {
                display: none !important;
            }

            .resume-page {
                width: 100% !important;
                max-width: 100% !important;
                min-height: 0 !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                page-break-after: avoid;
                break-after: avoid;
            }

            .page-break {
                display: block !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                line-height: 0 !important;
                border: none !important;
                page-break-before: always !important;
                break-before: page !important;
                clear: both;
            }

            .section,
            .job-entry,
            .project-card,
            .edu-entry {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }
    </style>
    @if(!empty($forPdf))
    <style>
        body {
            background: #ffffff !important;
            font-size: 9.2px !important;
            line-height: 1.34 !important;
        }
        .resume-page {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 0 !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }
        .page-break {
            display: block !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 0 !important;
            border: none !important;
            page-break-before: always !important;
            clear: both;
        }
    </style>
    @endif
</head>
<body>

@if(!empty($showActions))
    <div class="no-print-area">
        @if(!empty($printEnabled))
            <button onclick="window.print()" class="btn"><i class="fa-solid fa-print"></i> Print Resume / Save PDF</button>
        @endif
        <a href="{{ route('freelancer', $username) }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back to Portfolio</a>
    </div>
@endif

<!-- PAGE 1 OF 2 -->
<div class="resume-page">
    <!-- Modern Executive Header with Photo Support -->
    <header class="header {{ $photoSrc ? 'has-photo' : 'no-photo' }}">
        <div class="header-main">
            <h1 class="name">{{ $cv->full_name }}</h1>
            <div class="headline">{{ $primaryRole ?? 'Senior Full-Stack Laravel Developer & Team Lead' }}</div>
            <div class="contact-row">
                @if($cv->present_address || $cv->permanent_address)
                    <div><i class="fa-solid fa-location-dot contact-icon"></i> {!! clean($cv->present_address ?: $cv->permanent_address) !!}</div>
                @endif
                @if($cv->mobile)
                    @if($cv->present_address || $cv->permanent_address)<span class="sep">•</span>@endif
                    <div><i class="fa-solid fa-phone contact-icon"></i> {{ $cv->mobile }}</div>
                @endif
                @if($cv->email)
                    @if($cv->mobile || $cv->present_address || $cv->permanent_address)<span class="sep">•</span>@endif
                    <div><i class="fa-solid fa-envelope contact-icon"></i> <a href="mailto:{{ $cv->email }}">{{ $cv->email }}</a></div>
                @endif
                @if($cv->website_url)
                    @if($cv->email || $cv->mobile)<span class="sep">•</span>@endif
                    <div><i class="fa-solid fa-globe contact-icon"></i> <a href="{{ $cv->website_url }}" target="_blank">{{ $cv->website_url }}</a></div>
                @endif
                @if($cv->linkedin_url)
                    @if($cv->website_url || $cv->email)<span class="sep">•</span>@endif
                    <div><i class="fa-brands fa-linkedin contact-icon"></i> <a href="{{ $cv->linkedin_url }}" target="_blank">{{ $cv->linkedin_url }}</a></div>
                @endif
                @if($cv->github_url)
                    @if($cv->linkedin_url || $cv->website_url || $cv->email)<span class="sep">•</span>@endif
                    <div><i class="fa-brands fa-github contact-icon"></i> <a href="{{ $cv->github_url }}" target="_blank">{{ $cv->github_url }}</a></div>
                @endif
            </div>
        </div>
        @if($photoSrc)
            <div class="header-photo-wrap">
                <img src="{{ $photoSrc }}" alt="{{ $cv->full_name }}" class="header-photo">
            </div>
        @endif
    </header>

    <!-- Professional Summary -->
    <section class="section">
        <h2 class="section-header">Professional Summary</h2>
        <div class="summary-text">
            {!! clean($cv->career_summary ?: $cv->career_objective) !!}
        </div>
    </section>

    <!-- Categorized Technical Skills -->
    <section class="section">
        <h2 class="section-header">Technical Skills</h2>
        <div class="skills-grid">
            @foreach($cv->skills as $skill)
            <div class="skill-cat">
                <span class="skill-cat-name">{{ $skill->skill_name }}:</span>
                <span class="skill-cat-val">{{ $skill->skill_level }}</span>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Professional Experience -->
    @if($cv->employments->isNotEmpty())
    <section class="section">
        <h2 class="section-header">Professional Experience</h2>

        @foreach($cv->employments as $emp)
        <div class="job-entry">
            <div class="job-header">
                <div>
                    <span class="job-company">{{ $emp->company_name }}</span>
                    <span class="job-role"> — {{ $emp->designation }}</span>
                </div>
                <div class="job-date">{{ $formatDate($emp->start_date) }} – {{ $emp->is_current ? 'Present' : $formatDate($emp->end_date) }}</div>
            </div>

            @if($emp->responsibilities)
                @if(strip_tags($emp->responsibilities) !== $emp->responsibilities)
                    <div class="summary-text" style="font-size: 9px; margin-top: 1px;">{!! clean($emp->responsibilities) !!}</div>
                @else
                    <ul class="bullet-list">
                        @foreach(explode("\n", $emp->responsibilities) as $line)
                            @if(trim($line))<li>{{ trim($line, "*- ") }}</li>@endif
                        @endforeach
                    </ul>
                @endif
            @endif
            @if($emp->achievements)
                <div class="achievement-highlight">
                    <strong><i class="fa-solid fa-trophy" style="font-size: 7.5px;"></i> Key Achievement:</strong> {!! clean(ltrim(trim($emp->achievements), "*•- \t\n\r")) !!}
                </div>
            @endif
        </div>
        @endforeach
    </section>
    @endif

    <!-- Selected Featured Projects (Page 1 Top Projects) -->
    @if($cv->projects->isNotEmpty())
    <section class="section">
        <h2 class="section-header">Selected Featured Projects</h2>

        @foreach($cv->projects->take(2) as $project)
        <div class="project-card">
            <div class="project-header">
                <span class="project-title">{{ $loop->iteration }}. {{ $project->title }}</span>
                @if($project->role)<span class="project-role">{{ $project->role }}</span>@endif
            </div>

            @if($project->technologies)
                <div class="tech-line"><strong>Tech Stack:</strong> {{ $project->technologies }}</div>
            @endif

            @if($project->link || $project->demo_user || $project->demo_password)
                <div class="demo-bar">
                    @if($project->link)<span><i class="fa-solid fa-arrow-up-right-from-square"></i> <strong>Live Demo:</strong> <a href="{{ $project->link }}" target="_blank">{{ $project->link }}</a></span>@endif
                    @if($project->demo_user)<span><i class="fa-solid fa-user"></i> <strong>User:</strong> {{ $project->demo_user }}</span>@endif
                    @if($project->demo_password)<span><i class="fa-solid fa-key"></i> <strong>Pass:</strong> {{ $project->demo_password }}</span>@endif
                </div>
            @endif

            @if($project->description)
                <div class="summary-text" style="font-size: 9px; line-height: 1.34;">{!! clean($project->description) !!}</div>
            @elseif($project->solution)
                <div class="summary-text" style="font-size: 9px; line-height: 1.34;">{!! clean($project->solution) !!}</div>
            @endif
        </div>
        @endforeach
    </section>
    @endif

    <div class="page-num">Page 1 of 2</div>
</div>

<!-- PAGE BREAK FOR EXACT 2-PAGE LAYOUT -->
<div class="page-break"></div>

<!-- PAGE 2 OF 2 -->
<div class="resume-page">
    <!-- Additional Featured Projects Case Studies -->
    @if($cv->projects->count() > 2)
    <section class="section">
        <h2 class="section-header">Featured Projects & Live Demos (Contd.)</h2>

        @foreach($cv->projects->skip(2) as $project)
        <div class="project-card">
            <div class="project-header">
                <span class="project-title">{{ $loop->iteration + 2 }}. {{ $project->title }}</span>
                @if($project->role)<span class="project-role">{{ $project->role }}</span>@endif
            </div>

            @if($project->technologies)
                <div class="tech-line"><strong>Tech Stack:</strong> {{ $project->technologies }}</div>
            @endif

            @if($project->link || $project->demo_user || $project->demo_password)
                <div class="demo-bar">
                    @if($project->link)<span><i class="fa-solid fa-arrow-up-right-from-square"></i> <strong>Live Demo:</strong> <a href="{{ $project->link }}" target="_blank">{{ $project->link }}</a></span>@endif
                    @if($project->demo_user)<span><i class="fa-solid fa-user"></i> <strong>User:</strong> {{ $project->demo_user }}</span>@endif
                    @if($project->demo_password)<span><i class="fa-solid fa-key"></i> <strong>Pass:</strong> {{ $project->demo_password }}</span>@endif
                </div>
            @endif

            @if($project->description)
                <div class="summary-text" style="font-size: 9px; line-height: 1.34;">{!! clean($project->description) !!}</div>
            @elseif($project->solution)
                <div class="summary-text" style="font-size: 9px; line-height: 1.34;">{!! clean($project->solution) !!}</div>
            @endif
        </div>
        @endforeach
    </section>
    @endif

    <!-- Education -->
    @if($cv->academics->isNotEmpty())
    <section class="section">
        <h2 class="section-header">Education</h2>
        @foreach($cv->academics as $academic)
        <div class="edu-entry" style="display: flex; justify-content: space-between; align-items: baseline;">
            <div>
                <strong>{{ $academic->degree_name }}</strong> @if($academic->group_or_major)<span style="color: #475569;">({{ $academic->group_or_major }})</span>@endif — {{ $academic->institution }}, {{ $academic->board_or_university }}
            </div>
            <div style="font-weight: 700; color: #0f172a; white-space: nowrap; margin-left: 10px;">
                Result: {{ $academic->result }} @if($academic->passing_year)({{ $academic->passing_year }})@endif
            </div>
        </div>
        @endforeach
    </section>
    @endif

    <!-- Certifications & Professional Training -->
    @if($cv->trainings->isNotEmpty())
    <section class="section">
        <h2 class="section-header">Certifications & Professional Training</h2>
        @foreach($cv->trainings as $training)
        <div class="edu-entry">
            <div style="display: flex; justify-content: space-between; align-items: baseline;">
                <strong>{{ $training->training_title }}</strong>
                <span style="font-size: 8.5px; color: #475569; font-weight: 600;">{{ $training->institute }} @if($training->year)({{ $training->year }})@endif</span>
            </div>
            @if($training->certificate_details && trim($training->certificate_details) !== '*')
                <div class="summary-text" style="font-size: 8.5px; color: #475569; margin-left: 8px;">
                    • {!! clean(ltrim(trim($training->certificate_details), "*•- \t\n\r")) !!}
                </div>
            @endif
        </div>
        @endforeach
    </section>
    @endif

    <!-- Key Achievements & Leadership -->
    <section class="section">
        <h2 class="section-header">Key Achievements & Leadership</h2>
        <ul class="bullet-list">
            <li><strong>Engineering Team Leadership:</strong> Led cross-functional developer team at American Wellness Centre, enforcing code quality, modular architecture, and CI/CD best practices.</li>
            <li><strong>Enterprise Solution Delivery:</strong> Successfully engineered 5+ commercial enterprise applications across ERP, POS, Healthcare, and EdTech domains with zero floating-point accounting errors.</li>
            <li><strong>Community Welfare & Voluntary Initiative:</strong> Organized community relief distribution for 525 flood-affected victims in 2019.</li>
        </ul>
    </section>

    <!-- References -->
    @if($cv->references->isNotEmpty())
    <section class="section">
        <h2 class="section-header">Professional References</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            @foreach($cv->references as $ref)
            <div style="border: 1px solid #e2e8f0; border-left: 3px solid #2563eb; background: #f8fafc; padding: 5px 8px; border-radius: 4px; font-size: 8.5px; line-height: 1.35;">
                <div style="font-weight: 800; color: #0f172a; font-size: 10px;">{{ $ref->name }}</div>
                <div><strong>Designation:</strong> {{ $ref->designation }}</div>
                <div><strong>Organization:</strong> {{ $ref->organization }}</div>
                @if($ref->phone)<div><strong>Phone:</strong> {{ $ref->phone }}</div>@endif
                @if($ref->email)<div><strong>Email:</strong> {{ $ref->email }}</div>@endif
                @if($ref->relationship)<div><strong>Relation:</strong> {{ $ref->relationship }}</div>@endif
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Declaration -->
    <section class="section" style="margin-top: 8px;">
        <h2 class="section-header">Declaration</h2>
        <div class="summary-text" style="font-size: 8.5px; line-height: 1.35;">{!! clean($cv->declaration ?: 'I hereby declare that all information provided in this curriculum vitae is authentic, correct, and complete to the best of my knowledge.') !!}</div>

        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 14px;">
            <div style="text-align: center; width: 150px;">
                @if($signatureSrc)
                    <img src="{{ $signatureSrc }}" style="max-height: 34px; margin-bottom: 2px;" alt="Signature">
                @else
                    <div style="height: 24px;"></div>
                @endif
                <div style="border-top: 1.5px solid #334155; padding-top: 3px; font-weight: 700; font-size: 9.5px; color: #0f172a;">{{ $cv->full_name }}</div>
                <div style="font-size: 8px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Signature</div>
            </div>
            <div style="text-align: center; width: 150px;">
                <div style="margin-bottom: 6px; font-weight: 700; font-size: 9.5px; color: #0f172a;">{{ $formatFullDate($cv->declaration_date ?: now()) }}</div>
                <div style="border-top: 1.5px solid #334155; padding-top: 3px; font-weight: 700; font-size: 8px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Date</div>
            </div>
        </div>
    </section>

    <div class="page-num">Page 2 of 2</div>
</div>

@if(!empty($printMode))
    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
@endif
<script src="{{ asset('frontend/assets/js/cv-a4-paginator.js') }}"></script>
</body>
</html>
