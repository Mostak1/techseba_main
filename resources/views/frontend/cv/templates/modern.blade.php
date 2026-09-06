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
            margin: 10mm 12mm 10mm 12mm;
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
            color: #0f172a;
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 11px;
            line-height: 1.45;
        }

        .no-print-area {
            max-width: 210mm;
            margin: 15px auto 0;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 0 10px;
        }

        .btn {
            padding: 8px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            color: #ffffff;
            background: #1e3a8a;
            border: none;
            cursor: pointer;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }

        .btn-secondary { background: #475569; }

        .cv-container {
            width: 210mm;
            min-height: 297mm;
            margin: 15px auto 30px;
            padding: 12mm 14mm;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.1);
            border-radius: 4px;
        }

        /* Header */
        .cv-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 14px;
            margin-bottom: 16px;
        }

        .cv-header-info {
            flex: 1;
            padding-right: 15px;
        }

        .cv-name {
            font-size: 24px;
            font-weight: 800;
            color: #1e3a8a;
            margin: 0 0 4px 0;
            letter-spacing: -0.3px;
            text-transform: uppercase;
        }

        .cv-role {
            font-size: 13.5px;
            font-weight: 700;
            color: #0284c7;
            margin-bottom: 10px;
        }

        .contact-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 6px 14px;
            font-size: 10.5px;
            color: #334155;
        }

        .contact-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .contact-item i {
            color: #1e3a8a;
            width: 14px;
            text-align: center;
        }

        .cv-photo {
            width: 110px;
            height: 130px;
            border-radius: 6px;
            border: 2px solid #cbd5e1;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        /* Sections */
        .cv-section {
            margin-bottom: 16px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .section-title-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        .section-icon {
            width: 22px;
            height: 22px;
            background: #1e3a8a;
            color: #ffffff;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 800;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .section-text {
            color: #334155;
            text-align: justify;
            margin: 0;
        }

        /* Items (Experience & Projects) */
        .item-card {
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #e2e8f0;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .item-card:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2px;
        }

        .item-title {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
        }

        .item-sub {
            font-size: 11px;
            font-weight: 600;
            color: #0284c7;
        }

        .item-date {
            font-size: 10px;
            font-weight: 700;
            color: #475569;
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
            white-space: nowrap;
        }

        .tech-badges {
            margin: 4px 0 6px;
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .tech-badge {
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
            padding: 1px 6px;
            border-radius: 3px;
            font-size: 9.5px;
            font-weight: 600;
        }

        .demo-cred-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 3px solid #16a34a;
            padding: 4px 8px;
            border-radius: 4px;
            margin: 4px 0 6px;
            font-size: 10px;
            color: #15803d;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .bullet-list {
            margin: 4px 0 0 16px;
            padding: 0;
            color: #334155;
        }

        .bullet-list li {
            margin-bottom: 3px;
        }

        /* Skills Grid */
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .skill-chip {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 4px 8px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .skill-chip span {
            font-weight: 600;
            color: #1e293b;
        }

        .skill-level {
            font-size: 9px;
            color: #0284c7;
            font-weight: 700;
        }

        /* Tables */
        .cv-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 10.5px;
        }

        .cv-table th {
            background: #1e3a8a;
            color: #ffffff;
            text-align: left;
            padding: 6px 8px;
            font-weight: 700;
        }

        .cv-table td {
            border: 1px solid #cbd5e1;
            padding: 5px 8px;
            color: #1e293b;
        }

        .cv-table tr:nth-child(even) {
            background: #f8fafc;
        }

        .badge-result {
            background: #e0f2fe;
            color: #0369a1;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: 700;
        }

        /* Two Column Grid */
        .grid-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .ref-card {
            border-left: 3px solid #1e3a8a;
            background: #f8fafc;
            padding: 8px 10px;
            border-radius: 0 4px 4px 0;
            font-size: 10.5px;
        }

        .sig-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 25px;
        }

        .sig-box {
            text-align: center;
            width: 160px;
        }

        .sig-line {
            border-top: 1px solid #475569;
            padding-top: 4px;
            font-weight: 700;
        }

        .sig-img {
            max-height: 45px;
            margin-bottom: 4px;
        }

        /* Print Media Styles */
        @media print {
            html, body {
                background: #ffffff !important;
                color: #000000 !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .no-print-area {
                display: none !important;
            }

            .cv-container {
                width: 100% !important;
                min-height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
            }

            .cv-section, .item-card, tr, .ref-card {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
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

<div class="cv-container">
    <!-- Header -->
    <header class="cv-header">
        <div class="cv-header-info">
            <h1 class="cv-name">{{ $cv->full_name }}</h1>
            <div class="cv-role">{{ $primaryRole }}</div>

            <div class="contact-grid">
                @if($cv->mobile)
                    <div class="contact-item"><i class="fa-solid fa-phone"></i> {{ $cv->mobile }}</div>
                @endif
                @if($cv->email)
                    <div class="contact-item"><i class="fa-solid fa-envelope"></i> {{ $cv->email }}</div>
                @endif
                @if($cv->website_url)
                    <div class="contact-item"><i class="fa-solid fa-globe"></i> {{ str_replace(['http://', 'https://'], '', $cv->website_url) }}</div>
                @endif
                @if($cv->github_url)
                    <div class="contact-item"><i class="fa-brands fa-github"></i> {{ str_replace(['http://', 'https://'], '', $cv->github_url) }}</div>
                @endif
                @if($cv->linkedin_url)
                    <div class="contact-item"><i class="fa-brands fa-linkedin"></i> {{ str_replace(['http://', 'https://'], '', $cv->linkedin_url) }}</div>
                @endif
                @if($cv->present_address)
                    <div class="contact-item" style="width: 100%;"><i class="fa-solid fa-location-dot"></i> {{ $cv->present_address }}</div>
                @endif
            </div>
        </div>

        @if($photoSrc)
            <img src="{{ $photoSrc }}" alt="{{ $cv->full_name }}" class="cv-photo">
        @endif
    </header>

    <!-- Career Objective & Summary -->
    @if($cv->career_objective || $cv->career_summary)
    <div class="cv-section">
        <div class="section-title-wrap">
            <div class="section-icon"><i class="fa-solid fa-user-tie"></i></div>
            <h2 class="section-title">Executive Summary & Career Objective</h2>
        </div>
        @if($cv->career_summary)
            <p class="section-text" style="margin-bottom: 6px;">{{ $cv->career_summary }}</p>
        @endif
        @if($cv->career_objective)
            <p class="section-text"><strong>Objective:</strong> {{ $cv->career_objective }}</p>
        @endif
    </div>
    @endif

    <!-- Key Technical Skills -->
    @if($cv->skills->isNotEmpty())
    <div class="cv-section">
        <div class="section-title-wrap">
            <div class="section-icon"><i class="fa-solid fa-gears"></i></div>
            <h2 class="section-title">Key Technical Skills & Competencies</h2>
        </div>
        <div class="skills-grid">
            @foreach($cv->skills as $skill)
            <div class="skill-chip">
                <span><i class="fa-solid fa-check" style="color: #16a34a; margin-right: 4px; font-size: 9px;"></i> {{ $skill->skill_name }}</span>
                @if($skill->skill_level)
                    <span class="skill-level">{{ $skill->skill_level }}</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Commercial Projects / Case Studies -->
    @if($cv->projects->isNotEmpty())
    <div class="cv-section">
        <div class="section-title-wrap">
            <div class="section-icon"><i class="fa-solid fa-laptop-code"></i></div>
            <h2 class="section-title">Featured Software Projects & Live Demos</h2>
        </div>

        @foreach($cv->projects as $project)
        <div class="item-card">
            <div class="item-header">
                <div>
                    <span class="item-title">{{ $loop->iteration }}. {{ $project->title }}</span>
                    @if($project->role) <span class="item-sub"> — {{ $project->role }}</span> @endif
                </div>
            </div>

            @if($project->technologies)
                <div class="tech-badges">
                    @foreach(explode(',', $project->technologies) as $tech)
                        <span class="tech-badge">{{ trim($tech) }}</span>
                    @endforeach
                </div>
            @endif

            @if($project->link || $project->demo_user || $project->demo_password)
                <div class="demo-cred-box">
                    @if($project->link)
                        <span><i class="fa-solid fa-arrow-up-right-from-square"></i> <strong>Demo Link:</strong> {{ $project->link }}</span>
                    @endif
                    @if($project->demo_user)
                        <span><i class="fa-solid fa-user-check"></i> <strong>User:</strong> {{ $project->demo_user }}</span>
                    @endif
                    @if($project->demo_password)
                        <span><i class="fa-solid fa-key"></i> <strong>Password:</strong> {{ $project->demo_password }}</span>
                    @endif
                </div>
            @endif

            @if($project->problem)
                <p class="section-text" style="font-size: 10.5px; margin-top: 2px;"><strong>Problem Solved:</strong> {{ $project->problem }}</p>
            @endif

            @if($project->solution)
                <p class="section-text" style="font-size: 10.5px; margin-top: 2px;"><strong>Technical Solution:</strong> {{ $project->solution }}</p>
            @endif

            @if($project->description)
                <p class="section-text" style="font-size: 10.5px; margin-top: 2px;">{{ $project->description }}</p>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- Professional Experience -->
    @if($cv->employments->isNotEmpty())
    <div class="cv-section">
        <div class="section-title-wrap">
            <div class="section-icon"><i class="fa-solid fa-briefcase"></i></div>
            <h2 class="section-title">Professional Work Experience</h2>
        </div>

        @foreach($cv->employments as $emp)
        <div class="item-card">
            <div class="item-header">
                <div>
                    <span class="item-title">{{ $emp->company_name }}</span>
                    <span class="item-sub"> — {{ $emp->designation }}</span>
                </div>
                <span class="item-date">{{ $formatDate($emp->start_date) }} – {{ $emp->is_current ? 'Present' : $formatDate($emp->end_date) }}</span>
            </div>

            @if($emp->responsibilities)
                <ul class="bullet-list">
                    @foreach(explode("\n", $emp->responsibilities) as $line)
                        @if(trim($line))<li>{{ trim($line, "*- ") }}</li>@endif
                    @endforeach
                </ul>
            @endif

            @if($emp->achievements)
                <p style="margin: 4px 0 2px; font-weight: 700; color: #1e3a8a;">Key Achievements:</p>
                <ul class="bullet-list">
                    @foreach(explode("\n", $emp->achievements) as $line)
                        @if(trim($line))<li>{{ trim($line, "*- ") }}</li>@endif
                    @endforeach
                </ul>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- Academic Qualifications -->
    @if($cv->academics->isNotEmpty())
    <div class="cv-section">
        <div class="section-title-wrap">
            <div class="section-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            <h2 class="section-title">Academic Qualifications</h2>
        </div>
        <table class="cv-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Degree / Examination</th>
                    <th style="width: 30%;">Board / University</th>
                    <th style="width: 25%;">Institution</th>
                    <th style="width: 10%;">Result</th>
                    <th style="width: 10%;">Year</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cv->academics as $academic)
                <tr>
                    <td>
                        <strong>{{ $academic->degree_name }}</strong>
                        @if($academic->group_or_major)<br><small style="color: #64748b;">Major: {{ $academic->group_or_major }}</small>@endif
                    </td>
                    <td>{{ $academic->board_or_university }}</td>
                    <td>{{ $academic->institution }}</td>
                    <td><span class="badge-result">{{ $academic->result }}</span></td>
                    <td>{{ $academic->passing_year ?: 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Training & Certifications -->
    @if($cv->trainings->isNotEmpty())
    <div class="cv-section">
        <div class="section-title-wrap">
            <div class="section-icon"><i class="fa-solid fa-certificate"></i></div>
            <h2 class="section-title">Training & Certifications</h2>
        </div>
        <table class="cv-table">
            <thead>
                <tr>
                    <th style="width: 35%;">Course / Certification</th>
                    <th style="width: 35%;">Institute / Academy</th>
                    <th style="width: 15%;">Year</th>
                    <th style="width: 15%;">Duration / Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cv->trainings as $training)
                <tr>
                    <td><strong>{{ $training->training_title }}</strong></td>
                    <td>{{ $training->institute }}</td>
                    <td>{{ $training->year }}</td>
                    <td>{{ $training->certificate_details ?: 'Completed' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Language Proficiency -->
    @if($cv->languages->isNotEmpty())
    <div class="cv-section">
        <div class="section-title-wrap">
            <div class="section-icon"><i class="fa-solid fa-language"></i></div>
            <h2 class="section-title">Language Proficiency</h2>
        </div>
        <table class="cv-table">
            <thead>
                <tr>
                    <th>Language</th>
                    <th>Reading</th>
                    <th>Writing</th>
                    <th>Speaking</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cv->languages as $lang)
                <tr>
                    <td><strong>{{ $lang->language_name }}</strong></td>
                    <td>{{ $lang->reading_level }}</td>
                    <td>{{ $lang->writing_level }}</td>
                    <td>{{ $lang->speaking_level }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Personal Details -->
    <div class="cv-section">
        <div class="section-title-wrap">
            <div class="section-icon"><i class="fa-solid fa-id-card"></i></div>
            <h2 class="section-title">Personal Information</h2>
        </div>
        <div class="grid-2col" style="font-size: 10.5px;">
            <div>
                <div><strong>Date of Birth:</strong> {{ $formatFullDate($cv->date_of_birth) }}</div>
                <div><strong>Nationality:</strong> {{ $cv->nationality }}</div>
                <div><strong>Gender:</strong> {{ $cv->gender }}</div>
            </div>
            <div>
                <div><strong>Marital Status:</strong> {{ $cv->marital_status }}</div>
                <div><strong>Religion:</strong> {{ $cv->religion }}</div>
                @if($cv->permanent_address)
                    <div><strong>Permanent Address:</strong> {{ $cv->permanent_address }}</div>
                @endif
            </div>
        </div>
    </div>

    <!-- References & Declaration -->
    @if($cv->references->isNotEmpty())
    <div class="cv-section">
        <div class="section-title-wrap">
            <div class="section-icon"><i class="fa-solid fa-users"></i></div>
            <h2 class="section-title">Professional References</h2>
        </div>
        <div class="grid-2col">
            @foreach($cv->references as $ref)
            <div class="ref-card">
                <div style="font-weight: 700; color: #1e3a8a; font-size: 11.5px; margin-bottom: 2px;">{{ $ref->name }}</div>
                <div><strong>Designation:</strong> {{ $ref->designation }}</div>
                <div><strong>Organization:</strong> {{ $ref->organization }}</div>
                @if($ref->phone)<div><strong>Phone:</strong> {{ $ref->phone }}</div>@endif
                @if($ref->email)<div><strong>Email:</strong> {{ $ref->email }}</div>@endif
                @if($ref->relationship)<div><strong>Relation:</strong> {{ $ref->relationship }}</div>@endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Declaration -->
    <div class="cv-section">
        <div class="section-title-wrap">
            <div class="section-icon"><i class="fa-solid fa-file-signature"></i></div>
            <h2 class="section-title">Declaration</h2>
        </div>
        <p class="section-text">{{ $cv->declaration ?: 'I hereby declare that all details provided above are authentic and complete to the best of my knowledge.' }}</p>

        <div class="sig-area">
            <div class="sig-box">
                @if($signatureSrc)
                    <img src="{{ $signatureSrc }}" class="sig-img" alt="Signature">
                @endif
                <div class="sig-line">{{ $cv->full_name }}</div>
                <div style="font-size: 9.5px; color: #64748b;">Signature</div>
            </div>
            <div class="sig-box">
                <div style="margin-bottom: 24px; font-weight: 600;">{{ $formatFullDate($cv->declaration_date ?: now()) }}</div>
                <div class="sig-line">Date</div>
            </div>
        </div>
    </div>
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
