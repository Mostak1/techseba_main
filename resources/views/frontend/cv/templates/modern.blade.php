@php
    $photoSrc = null;
    $signatureSrc = null;

    if ($cv->photo) {
        $photoSrc = !empty($forPdf) && file_exists(public_path($cv->photo)) ? public_path($cv->photo) : asset($cv->photo);
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
    <link rel="stylesheet" href="{{ $fontAwesomeHref }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 10mm 8mm 10mm;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        html, body {
            margin: 0;
            padding: 0;
            background: #f8fafc;
            color: #1e293b;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 10.5px;
            line-height: 1.45;
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
            border-radius: 5px;
            text-decoration: none;
            font-weight: 700;
            color: #ffffff;
            background: #0f172a;
            border: none;
            cursor: pointer;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.12);
        }

        .btn-secondary { background: #475569; }

        /* ATS US Resume Sheet Container */
        .resume-page {
            width: 210mm;
            min-height: 297mm;
            margin: 12px auto 24px;
            padding: 10mm 12mm;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
            border-radius: 2px;
            position: relative;
        }

        /* ATS Header Section */
        .header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .name {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.3px;
            margin: 0 0 2px 0;
            text-transform: uppercase;
        }

        .headline {
            font-size: 13px;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 8px;
        }

        .contact-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px 14px;
            font-size: 10px;
            color: #334155;
            font-weight: 500;
        }

        .contact-row a {
            color: #0f172a;
            text-decoration: none;
            font-weight: 600;
        }

        .contact-row span {
            color: #94a3b8;
        }

        /* Section Styling */
        .section {
            margin-bottom: 12px;
        }

        .section-header {
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            border-bottom: 1.5px solid #cbd5e1;
            padding-bottom: 3px;
            margin-bottom: 8px;
        }

        .summary-text {
            font-size: 10.5px;
            color: #334155;
            text-align: justify;
            line-height: 1.48;
            margin: 0;
        }

        /* Skills Table / Category Grid */
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px 12px;
        }

        .skill-cat {
            font-size: 10px;
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
            margin-bottom: 10px;
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 2px;
        }

        .job-company {
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
        }

        .job-role {
            font-size: 11px;
            font-weight: 700;
            color: #2563eb;
        }

        .job-date {
            font-size: 10px;
            font-weight: 700;
            color: #475569;
        }

        .bullet-list {
            margin: 3px 0 0 16px;
            padding: 0;
            color: #334155;
            font-size: 10px;
            line-height: 1.42;
        }

        .bullet-list li {
            margin-bottom: 3px;
        }

        /* Portfolio Project Case Study Styling */
        .project-card {
            border: 1px solid #e2e8f0;
            border-left: 3.5px solid #1e3a8a;
            background: #f8fafc;
            padding: 7px 10px;
            border-radius: 3px;
            margin-bottom: 8px;
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 2px;
        }

        .project-title {
            font-size: 11.5px;
            font-weight: 800;
            color: #0f172a;
        }

        .project-role {
            font-size: 10px;
            font-weight: 700;
            color: #2563eb;
        }

        .tech-line {
            font-size: 9.5px;
            color: #475569;
            margin-bottom: 3px;
        }

        .demo-bar {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            padding: 2.5px 6px;
            border-radius: 3px;
            font-size: 9.5px;
            margin: 3px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Education & Certification Lists */
        .edu-entry {
            margin-bottom: 4px;
            font-size: 10.5px;
        }

        .page-break {
            page-break-before: always;
            break-before: page;
        }

        .page-num {
            position: absolute;
            bottom: 10px;
            right: 25px;
            font-size: 9px;
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
                min-height: 297mm !important;
                margin: 0 !important;
                padding: 8mm 10mm !important;
                box-shadow: none !important;
            }

            .page-break {
                page-break-before: always !important;
                break-before: page !important;
            }
        }
    </style>
</head>
<body>

@if(!empty($showActions))
    <div class="no-print-area">
        @if(!empty($printEnabled))
            <button onclick="window.print()" class="btn"><i class="fa-solid fa-print"></i> Print ATS Resume / Save PDF</button>
        @endif
        <a href="{{ route('freelancer', $username) }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back to Portfolio</a>
    </div>
@endif

<!-- PAGE 1 OF 2 -->
<div class="resume-page">
    <!-- US Executive Header (ATS Friendly, Zero Photo) -->
    <header class="header">
        <h1 class="name">{{ $cv->full_name }}</h1>
        <div class="headline">Senior Full-Stack Laravel Developer & Team Lead</div>
        <div class="contact-row">
            <div><i class="fa-solid fa-location-dot"></i> Dhaka, Bangladesh (Open to US Remote)</div>
            <span>•</span>
            <div><i class="fa-solid fa-phone"></i> {{ $cv->mobile }}</div>
            <span>•</span>
            <div><i class="fa-solid fa-envelope"></i> <a href="mailto:{{ $cv->email }}">{{ $cv->email }}</a></div>
            <span>•</span>
            <div><i class="fa-solid fa-globe"></i> <a href="{{ $cv->website_url }}" target="_blank">mostaksarker.com</a></div>
            <span>•</span>
            <div><i class="fa-brands fa-linkedin"></i> <a href="{{ $cv->linkedin_url }}" target="_blank">LinkedIn</a></div>
            <span>•</span>
            <div><i class="fa-brands fa-github"></i> <a href="{{ $cv->github_url }}" target="_blank">GitHub</a></div>
        </div>
    </header>

    <!-- Professional Summary -->
    <section class="section">
        <h2 class="section-header">Professional Summary</h2>
        <p class="summary-text">
            {{ $cv->career_summary }}
        </p>
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
                <ul class="bullet-list">
                    @foreach(explode("\n", $emp->responsibilities) as $line)
                        @if(trim($line))<li>{{ trim($line, "*- ") }}</li>@endif
                    @endforeach
                </ul>
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
                    @if($project->link)<span><i class="fa-solid fa-arrow-up-right-from-square"></i> <strong>Live Demo:</strong> {{ $project->link }}</span>@endif
                    @if($project->demo_user)<span><i class="fa-solid fa-user"></i> <strong>User:</strong> {{ $project->demo_user }}</span>@endif
                    @if($project->demo_password)<span><i class="fa-solid fa-key"></i> <strong>Pass:</strong> {{ $project->demo_password }}</span>@endif
                </div>
            @endif

            @if($project->description)
                <div class="summary-text" style="font-size: 10px;">{{ $project->description }}</div>
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
                    @if($project->link)<span><i class="fa-solid fa-arrow-up-right-from-square"></i> <strong>Live Demo:</strong> {{ $project->link }}</span>@endif
                    @if($project->demo_user)<span><i class="fa-solid fa-user"></i> <strong>User:</strong> {{ $project->demo_user }}</span>@endif
                    @if($project->demo_password)<span><i class="fa-solid fa-key"></i> <strong>Pass:</strong> {{ $project->demo_password }}</span>@endif
                </div>
            @endif

            @if($project->description)
                <div class="summary-text" style="font-size: 10px;">{{ $project->description }}</div>
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
        <div class="edu-entry">
            <strong>{{ $academic->degree_name }}</strong> @if($academic->group_or_major)({{ $academic->group_or_major }})@endif — {{ $academic->institution }}, {{ $academic->board_or_university }} | <strong>Result:</strong> {{ $academic->result }} @if($academic->passing_year)({{ $academic->passing_year }})@endif
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
            <strong>{{ $training->training_title }}</strong> — {{ $training->institute }} @if($training->year)({{ $training->year }})@endif
            @if($training->certificate_details)
                <div class="summary-text" style="font-size: 9.5px; color: #475569; margin-left: 10px;">• {{ $training->certificate_details }}</div>
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

    <!-- Declaration -->
    <section class="section" style="margin-top: 15px;">
        <h2 class="section-header">Declaration</h2>
        <p class="summary-text" style="font-size: 9.5px;">{{ $cv->declaration ?: 'I hereby declare that all information provided in this curriculum vitae is authentic, correct, and complete to the best of my knowledge.' }}</p>

        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 18px;">
            <div style="text-align: center; width: 140px;">
                @if($signatureSrc)
                    <img src="{{ $signatureSrc }}" style="max-height: 40px; margin-bottom: 2px;" alt="Signature">
                @endif
                <div style="border-top: 1px solid #334155; padding-top: 2px; font-weight: 700; font-size: 10px;">{{ $cv->full_name }}</div>
                <div style="font-size: 8.5px; color: #64748b;">Signature</div>
            </div>
            <div style="text-align: center; width: 140px;">
                <div style="margin-bottom: 18px; font-weight: 700; font-size: 10px;">{{ $formatFullDate($cv->declaration_date ?: now()) }}</div>
                <div style="border-top: 1px solid #334155; padding-top: 2px; font-weight: 700; font-size: 10px;">Date</div>
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
</body>
</html>
