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
    <title>{{ $cv->full_name }} — Curriculum Vitae</title>
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
            background: #eef2f5;
            color: #2d3748;
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            font-size: 11px;
            line-height: 1.42;
        }

        .no-print-area {
            max-width: 210mm;
            margin: 10px auto 0;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 0 10px;
        }

        .btn {
            padding: 7px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            color: #ffffff;
            background: #5a8f85;
            border: none;
            cursor: pointer;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.12);
        }

        .btn-secondary { background: #4a5568; }

        /* Outer A4 Sheet Container */
        .cv-page {
            width: 210mm;
            min-height: 297mm;
            margin: 10px auto 20px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            display: flex;
            position: relative;
            overflow: hidden;
        }

        /* Sidebar Styling (Matching User Image: Soft Sage Teal #75a095) */
        .cv-sidebar {
            width: 32%;
            background: #75a095;
            color: #0f241f;
            padding: 22px 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-photo-wrap {
            width: 115px;
            height: 115px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            margin-bottom: 12px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-photo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-name {
            font-size: 22px;
            font-weight: 800;
            color: #0d1e1a;
            text-align: center;
            margin: 0 0 4px 0;
            line-height: 1.15;
        }

        .sidebar-role {
            font-size: 12px;
            font-weight: 700;
            color: #15362f;
            text-align: center;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .sidebar-divider {
            width: 100%;
            border-top: 1.5px solid #567e74;
            margin: 12px 0;
        }

        .sidebar-section-title {
            font-size: 13.5px;
            font-weight: 800;
            color: #0c1c18;
            text-align: center;
            margin: 0 0 10px 0;
            text-transform: capitalize;
            letter-spacing: 0.3px;
        }

        .contact-list {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 7px;
            font-size: 10.5px;
            color: #0f241f;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 7px;
            word-break: break-word;
        }

        .contact-item i {
            font-size: 11px;
            width: 15px;
            text-align: center;
            color: #0b1a16;
        }

        .contact-item a {
            color: #0f241f;
            text-decoration: none;
            font-weight: 600;
        }

        .skills-bullet-list {
            width: 100%;
            padding-left: 16px;
            margin: 0;
            color: #0f241f;
            font-size: 10.5px;
            line-height: 1.45;
        }

        .skills-bullet-list li {
            margin-bottom: 4.5px;
            font-weight: 600;
        }

        /* Main Content Styling (Matching User Image: Clean White + Soft Teal Accent #5a8e84) */
        .cv-main {
            width: 68%;
            background: #ffffff;
            padding: 22px 24px;
        }

        .main-section-title {
            font-size: 17px;
            font-weight: 800;
            color: #5a8e84;
            text-align: center;
            margin: 0 0 10px 0;
            letter-spacing: 0.3px;
        }

        .section-block {
            margin-bottom: 14px;
        }

        .profile-summary-text {
            font-size: 11px;
            color: #2d3748;
            text-align: justify;
            line-height: 1.48;
            margin: 0;
        }

        /* Career Summary / Experience Item */
        .exp-entry {
            margin-bottom: 12px;
        }

        .exp-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 3px;
        }

        .exp-dates {
            font-size: 11px;
            font-weight: 700;
            color: #1a202c;
            width: 32%;
        }

        .exp-meta {
            width: 68%;
            text-align: left;
        }

        .exp-company {
            font-size: 12.5px;
            font-weight: 800;
            color: #1a202c;
        }

        .exp-designation {
            font-size: 11.5px;
            font-weight: 700;
            color: #2d3748;
        }

        .sub-heading-italic {
            font-size: 11px;
            font-weight: 700;
            font-style: italic;
            color: #2d3748;
            margin: 4px 0 2px 0;
        }

        .entry-bullet-list {
            padding-left: 16px;
            margin: 2px 0 4px 0;
            color: #2d3748;
            font-size: 10.5px;
            line-height: 1.4;
        }

        .entry-bullet-list li {
            margin-bottom: 2.5px;
        }

        /* Projects Section Styling */
        .project-card-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #5a8e84;
            padding: 7px 10px;
            border-radius: 3px;
            margin-bottom: 8px;
        }

        .project-title-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .project-name {
            font-size: 12px;
            font-weight: 800;
            color: #1a202c;
        }

        .project-role-badge {
            font-size: 10px;
            font-weight: 700;
            color: #2b6cb0;
        }

        .demo-info-line {
            background: #e6fffa;
            border: 1px solid #b2f5ea;
            color: #234e52;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            margin: 3px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Education Bullet List */
        .education-list {
            padding-left: 16px;
            margin: 0;
            color: #1a202c;
            font-size: 11px;
            line-height: 1.5;
        }

        .education-list li {
            margin-bottom: 4px;
        }

        .declaration-box {
            margin-top: 10px;
            font-size: 10px;
            color: #4a5568;
        }

        .sig-flex {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 14px;
        }

        .sig-col {
            text-align: center;
            width: 140px;
        }

        .sig-line-top {
            border-top: 1px solid #4a5568;
            padding-top: 2px;
            font-weight: 700;
            font-size: 10px;
        }

        .page-footer-num {
            position: absolute;
            bottom: 8px;
            right: 25px;
            font-size: 9px;
            color: #718096;
        }

        .page-break {
            page-break-before: always;
            break-before: page;
        }

        /* Print Specifics for Exact 2 A4 Pages */
        @media print {
            html, body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .no-print-area {
                display: none !important;
            }

            .cv-page {
                width: 100% !important;
                min-height: 297mm !important;
                margin: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
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
            <button onclick="window.print()" class="btn"><i class="fa-solid fa-print"></i> Print CV / Save PDF</button>
        @endif
        <a href="{{ route('freelancer', $username) }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back to Portfolio</a>
    </div>
@endif

<!-- PAGE 1 OF 2 -->
<div class="cv-page">
    <!-- Left Sidebar -->
    <aside class="cv-sidebar">
        <div class="profile-photo-wrap">
            @if($photoSrc)
                <img src="{{ $photoSrc }}" alt="{{ $cv->full_name }}">
            @else
                <i class="fa-solid fa-user" style="font-size: 50px; color: #75a095;"></i>
            @endif
        </div>

        <h1 class="sidebar-name">{{ $cv->full_name }}</h1>
        <div class="sidebar-role">{{ $primaryRole }}</div>

        <div class="sidebar-divider"></div>

        <!-- Contact Details -->
        <h3 class="sidebar-section-title">Contact Details</h3>
        <div class="contact-list">
            @if($cv->mobile)
                <div class="contact-item"><i class="fa-solid fa-phone"></i> {{ $cv->mobile }}</div>
            @endif
            @if($cv->email)
                <div class="contact-item"><i class="fa-solid fa-envelope"></i> <a href="mailto:{{ $cv->email }}">{{ $cv->email }}</a></div>
            @endif
            @if($cv->present_address)
                <div class="contact-item"><i class="fa-solid fa-location-dot"></i> {{ $cv->present_address }}</div>
            @endif
            @if($cv->website_url)
                <div class="contact-item"><i class="fa-solid fa-globe"></i> <a href="{{ $cv->website_url }}" target="_blank">{{ str_replace(['http://', 'https://'], '', $cv->website_url) }}</a></div>
            @endif
            @if($cv->linkedin_url)
                <div class="contact-item"><i class="fa-brands fa-linkedin"></i> <a href="{{ $cv->linkedin_url }}" target="_blank">LinkedIn Profile</a></div>
            @endif
            @if($cv->github_url)
                <div class="contact-item"><i class="fa-brands fa-github"></i> <a href="{{ $cv->github_url }}" target="_blank">GitHub Profile</a></div>
            @endif
        </div>

        <div class="sidebar-divider"></div>

        <!-- Core Skills -->
        <h3 class="sidebar-section-title">Core Skills</h3>
        @if($cv->skills->isNotEmpty())
            <ul class="skills-bullet-list">
                @foreach($cv->skills as $skill)
                    <li>{{ $skill->skill_name }}</li>
                @endforeach
            </ul>
        @endif
    </aside>

    <!-- Main Content Area (Page 1) -->
    <main class="cv-main">
        <!-- Professional Profile -->
        <div class="section-block">
            <h2 class="main-section-title">Professional Profile</h2>
            <p class="profile-summary-text">
                {{ $cv->career_summary ?: 'Senior Full-Stack Laravel Developer and DevOps Specialist experienced in architecting scalable enterprise web applications, RESTful APIs, multi-tenant SaaS platforms, and Rocky Linux server infrastructure.' }}
                @if($cv->career_objective)
                    <br><br><strong>Objective:</strong> {{ $cv->career_objective }}
                @endif
            </p>
        </div>

        <!-- Featured Software Projects & Live Demos -->
        @if($cv->projects->isNotEmpty())
        <div class="section-block">
            <h2 class="main-section-title">Featured Software Projects & Demos</h2>

            @foreach($cv->projects as $project)
            <div class="project-card-box">
                <div class="project-title-row">
                    <span class="project-name">{{ $loop->iteration }}. {{ $project->title }}</span>
                    @if($project->role) <span class="project-role-badge">{{ $project->role }}</span> @endif
                </div>

                @if($project->link || $project->demo_user || $project->demo_password)
                    <div class="demo-info-line">
                        @if($project->link)
                            <span><i class="fa-solid fa-link"></i> <strong>Demo:</strong> {{ $project->link }}</span>
                        @endif
                        @if($project->demo_user)
                            <span><i class="fa-solid fa-user"></i> <strong>User:</strong> {{ $project->demo_user }}</span>
                        @endif
                        @if($project->demo_password)
                            <span><i class="fa-solid fa-key"></i> <strong>Pass:</strong> {{ $project->demo_password }}</span>
                        @endif
                    </div>
                @endif

                @if($project->technologies)
                    <div style="font-size: 10px; color: #4a5568; margin-bottom: 2px;">
                        <strong>Tech Stack:</strong> {{ $project->technologies }}
                    </div>
                @endif

                @if($project->description)
                    <p class="profile-summary-text" style="font-size: 10.5px; line-height: 1.38;">{{ $project->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </main>

    <div class="page-footer-num">Page 1</div>
</div>

<!-- PAGE BREAK FOR PRINT -->
<div class="page-break"></div>

<!-- PAGE 2 OF 2 -->
<div class="cv-page">
    <!-- Left Sidebar Continuation -->
    <aside class="cv-sidebar">
        <h3 class="sidebar-section-title" style="margin-top: 10px;">Personal Details</h3>
        <div class="contact-list">
            <div class="contact-item"><strong>Date of Birth:</strong> {{ $formatFullDate($cv->date_of_birth) }}</div>
            <div class="contact-item"><strong>Nationality:</strong> {{ $cv->nationality }}</div>
            <div class="contact-item"><strong>Gender:</strong> {{ $cv->gender }}</div>
            <div class="contact-item"><strong>Marital Status:</strong> {{ $cv->marital_status }}</div>
            @if($cv->permanent_address)
                <div class="contact-item"><strong>Permanent:</strong> {{ $cv->permanent_address }}</div>
            @endif
        </div>

        <div class="sidebar-divider"></div>

        <!-- Languages -->
        @if($cv->languages->isNotEmpty())
            <h3 class="sidebar-section-title">Languages</h3>
            <ul class="skills-bullet-list">
                @foreach($cv->languages as $lang)
                    <li>{{ $lang->language_name }} ({{ $lang->speaking_level }})</li>
                @endforeach
            </ul>
        @endif

        <div class="sidebar-divider"></div>

        <!-- References -->
        @if($cv->references->isNotEmpty())
            <h3 class="sidebar-section-title">References</h3>
            @foreach($cv->references as $ref)
                <div style="font-size: 10px; margin-bottom: 8px; color: #0f241f;">
                    <strong>{{ $ref->name }}</strong><br>
                    {{ $ref->designation }} — {{ $ref->organization }}<br>
                    @if($ref->phone) Tel: {{ $ref->phone }} @endif
                </div>
            @endforeach
        @endif
    </aside>

    <!-- Main Content Area (Page 2) -->
    <main class="cv-main">
        <!-- Career Summary / Work Experience -->
        @if($cv->employments->isNotEmpty())
        <div class="section-block">
            <h2 class="main-section-title">Career Summary</h2>

            @foreach($cv->employments as $emp)
            <div class="exp-entry">
                <div class="exp-header-row">
                    <div class="exp-dates">{{ $formatDate($emp->start_date) }} – {{ $emp->is_current ? 'Present' : $formatDate($emp->end_date) }}</div>
                    <div class="exp-meta">
                        <div class="exp-company">{{ $emp->company_name }}</div>
                        <div class="exp-designation">{{ $emp->designation }}</div>
                    </div>
                </div>

                @if($emp->responsibilities)
                    <div class="sub-heading-italic">Key Responsibilities</div>
                    <ul class="entry-bullet-list">
                        @foreach(explode("\n", $emp->responsibilities) as $line)
                            @if(trim($line))<li>{{ trim($line, "*- ") }}</li>@endif
                        @endforeach
                    </ul>
                @endif

                @if($emp->achievements)
                    <div class="sub-heading-italic">Key Achievements</div>
                    <ul class="entry-bullet-list">
                        @foreach(explode("\n", $emp->achievements) as $line)
                            @if(trim($line))<li>{{ trim($line, "*- ") }}</li>@endif
                        @endforeach
                    </ul>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Education -->
        @if($cv->academics->isNotEmpty())
        <div class="section-block">
            <h2 class="main-section-title">Education</h2>
            <ul class="education-list">
                @foreach($cv->academics as $academic)
                <li>
                    <strong>{{ $academic->degree_name }}</strong> @if($academic->group_or_major)({{ $academic->group_or_major }})@endif | {{ $academic->institution }} | {{ $academic->board_or_university }} | <strong>{{ $academic->result }}</strong> @if($academic->passing_year)({{ $academic->passing_year }})@endif
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Training & Certifications -->
        @if($cv->trainings->isNotEmpty())
        <div class="section-block">
            <h2 class="main-section-title">Training & Certifications</h2>
            <ul class="education-list">
                @foreach($cv->trainings as $training)
                <li>
                    <strong>{{ $training->training_title }}</strong> | {{ $training->institute }} @if($training->year)({{ $training->year }})@endif @if($training->certificate_details)| {{ $training->certificate_details }}@endif
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Declaration -->
        <div class="declaration-box">
            <p style="margin: 0; text-align: justify; font-size: 10px;">{{ $cv->declaration ?: 'I hereby declare that all information provided in this curriculum vitae is authentic, correct, and complete to the best of my knowledge.' }}</p>

            <div class="sig-flex">
                <div class="sig-col">
                    @if($signatureSrc)
                        <img src="{{ $signatureSrc }}" class="sig-img" alt="Signature">
                    @endif
                    <div class="sig-line-top">{{ $cv->full_name }}</div>
                    <div style="font-size: 9px;">Signature</div>
                </div>
                <div class="sig-col">
                    <div style="margin-bottom: 16px; font-weight: 700; font-size: 10px;">{{ $formatFullDate($cv->declaration_date ?: now()) }}</div>
                    <div class="sig-line-top">Date</div>
                </div>
            </div>
        </div>
    </main>

    <div class="page-footer-num">Page 2</div>
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
