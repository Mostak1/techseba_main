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

    $formatYear = function ($date) {
        if (!$date) return '';
        try {
            return \Illuminate\Support\Carbon::parse($date)->format('Y');
        } catch (\Throwable $e) {
            return (string) $date;
        }
    };

    $fontAwesomeHref = !empty($forPdf)
        ? public_path('frontend/assets/css/fontawesome.css')
        : asset('frontend/assets/css/fontawesome.css');

    $username = $username ?? ($cv->user?->username ?? 'user');
    $primaryRole = $cv->employments->first()->designation ?? 'Full-Stack Software Engineer & DevOps';

    $employments = $cv->employments ?? collect();
    $academics = $cv->academics->isNotEmpty() ? $cv->academics : ($cv->educations ?? collect());
    $trainings = $cv->trainings ?? collect();
    $skills = $cv->skills ?? collect();
    $projects = $cv->projects ?? collect();
    $certifications = $cv->professionalQualifications ?? collect();
    $languages = $cv->languages ?? collect();
    $references = $cv->references ?? collect();

    // Group skills by category/type
    $groupedSkills = $skills->groupBy(function ($item) {
        return $item->skill_type ?: 'Technical Skills';
    });
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cv->full_name }} — IT & Software Engineer Resume</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            background: #e2e8f0;
            color: #1e293b;
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 9.3px;
            line-height: 1.42;
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
            background: #0c2340;
            border: none;
            cursor: pointer;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 5px rgba(12, 35, 64, 0.2);
            transition: all 0.2s ease;
        }
        .btn:hover { background: #173b67; }
        .btn-secondary { background: #475569; }

        /* A4 Sheet Container */
        .cv-page {
            width: 210mm;
            min-height: 297mm;
            margin: 16px auto 26px;
            background: #ffffff;
            display: flex;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            border-radius: 2px;
            position: relative;
            box-sizing: border-box;
        }

        /* Left Column: Deep Navy Blue Sidebar (34% width) */
        .cv-sidebar {
            width: 74mm;
            background-color: #0c2340;
            color: #ffffff;
            padding: 22px 16px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            flex-shrink: 0;
        }

        .name-block {
            margin-bottom: 2px;
        }

        .full-name {
            font-size: 19px;
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: -0.3px;
            line-height: 1.15;
            margin: 0 0 4px 0;
        }

        .job-title {
            font-size: 10px;
            font-weight: 700;
            color: #38bdf8;
            letter-spacing: 0.4px;
            line-height: 1.25;
            text-transform: uppercase;
        }

        .avatar-wrap {
            margin: 4px 0 6px;
            text-align: center;
        }

        .avatar-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(56, 189, 248, 0.5);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .contact-list {
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 8.8px;
            color: #e2e8f0;
            word-break: break-all;
        }

        .contact-item a {
            color: #e2e8f0;
            text-decoration: none;
        }
        .contact-item a:hover { color: #38bdf8; text-decoration: underline; }

        .contact-item i {
            color: #38bdf8;
            font-size: 9.5px;
            width: 13px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-section {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .sidebar-sec-title {
            font-size: 10px;
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            border-bottom: 1px solid #38bdf8;
            padding-bottom: 3px;
            margin-bottom: 7px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sidebar-sec-title i {
            color: #38bdf8;
            font-size: 9.5px;
        }

        .profile-text {
            font-size: 8.8px;
            color: #cbd5e1;
            line-height: 1.45;
            margin: 0;
        }

        .sidebar-edu-item {
            margin-bottom: 7px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .sidebar-edu-degree {
            font-size: 9.5px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
        }

        .sidebar-edu-school {
            font-size: 8.5px;
            color: #38bdf8;
            font-weight: 600;
            margin-top: 1px;
        }

        .sidebar-edu-meta {
            font-size: 8px;
            color: #94a3b8;
            margin-top: 1px;
        }

        .sidebar-bullet-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-bullet-list li {
            font-size: 8.6px;
            color: #e2e8f0;
            display: flex;
            align-items: baseline;
            gap: 5px;
        }

        .sidebar-bullet-list li::before {
            content: "•";
            color: #38bdf8;
            font-weight: bold;
            font-size: 11px;
        }

        /* Right Column: Main Content (Pure White) */
        .cv-main {
            flex: 1;
            background: #ffffff;
            padding: 22px 22px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            min-width: 0;
        }

        .main-section {
            break-inside: auto;
            page-break-inside: auto;
        }

        .main-sec-title {
            font-size: 11px;
            font-weight: 800;
            color: #0c2340;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #0c2340;
            padding-bottom: 3px;
            margin-bottom: 9px;
            display: flex;
            align-items: center;
            gap: 7px;
            break-after: avoid;
            page-break-after: avoid;
        }

        .main-sec-title i {
            color: #0c2340;
            font-size: 10px;
        }

        /* Experience Item */
        .exp-item {
            margin-bottom: 10px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .exp-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .exp-company {
            font-size: 10.5px;
            font-weight: 800;
            color: #0c2340;
        }

        .exp-meta {
            font-size: 8.5px;
            color: #64748b;
            font-weight: 600;
        }

        .exp-role {
            font-size: 9.6px;
            font-weight: 700;
            color: #2563eb;
            margin: 1px 0 3px 0;
        }

        .exp-bullets {
            margin: 2px 0 0 14px;
            padding: 0;
            font-size: 8.8px;
            color: #334155;
            line-height: 1.4;
        }

        .exp-bullets li {
            margin-bottom: 2px;
        }

        /* Skills Grid */
        .skills-grid {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .skill-group-row {
            font-size: 8.8px;
            line-height: 1.38;
        }

        .skill-group-title {
            font-weight: 800;
            color: #0c2340;
            margin-right: 4px;
        }

        .skill-group-items {
            color: #334155;
        }

        /* Project Item */
        .project-item {
            border-left: 2.5px solid #0c2340;
            background: #f8fafc;
            padding: 5px 8px;
            border-radius: 0 4px 4px 0;
            margin-bottom: 7px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .project-title-line {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 8px;
        }

        .project-title-line strong {
            font-size: 9.8px;
            color: #0c2340;
        }

        .project-title-line a {
            color: #2563eb;
            text-decoration: none;
            font-size: 8.5px;
        }
        .project-title-line a:hover { text-decoration: underline; }

        .project-tech {
            font-size: 8.5px;
            font-weight: 600;
            color: #475569;
        }

        .project-desc {
            font-size: 8.6px;
            line-height: 1.38;
            color: #334155;
            margin: 2px 0 0;
        }

        .demo-credentials {
            font-size: 8px;
            color: #155724;
            background: #d4edda;
            padding: 1px 6px;
            border-radius: 3px;
            display: inline-block;
            margin-top: 2px;
        }

        /* Certifications & References */
        .cert-item {
            margin-bottom: 6px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .cert-title {
            font-size: 9.5px;
            font-weight: 800;
            color: #0c2340;
        }

        .cert-meta {
            font-size: 8.3px;
            color: #64748b;
        }

        .ref-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .ref-card {
            border: 1px solid #e2e8f0;
            border-left: 3px solid #0c2340;
            background: #f8fafc;
            padding: 5px 8px;
            border-radius: 4px;
            font-size: 8.5px;
            line-height: 1.35;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .ref-name {
            font-size: 9.5px;
            font-weight: 800;
            color: #0c2340;
        }

        .ref-role {
            color: #64748b;
            font-size: 8.3px;
        }

        .ref-contact-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 8.3px;
            color: #475569;
            margin-top: 2px;
            word-break: break-all;
        }

        .signature-box {
            margin-top: auto;
            display: flex;
            justify-content: flex-end;
            padding-top: 10px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        @media print {
            body {
                background: #ffffff !important;
            }
            .no-print-area {
                display: none !important;
            }
            .cv-page {
                width: 100% !important;
                max-width: 100% !important;
                min-height: 0 !important;
                height: auto !important;
                margin: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            .main-section {
                break-inside: auto !important;
                page-break-inside: auto !important;
            }
            .exp-item, .project-item, .ref-card, .cert-item, .sidebar-edu-item {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
            }
            .main-sec-title, .sidebar-sec-title {
                break-after: avoid !important;
                page-break-after: avoid !important;
            }
        }

        @if(!empty($forPdf))
        body {
            background: #ffffff;
            font-size: 9px;
        }
        .no-print-area { display: none !important; }
        .cv-page {
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
            <button type="button" class="btn" onclick="window.print()">
                <i class="fas fa-print"></i> Print CV (A4)
            </button>
            <a href="{{ profile_route('user.cv.edit') }}" class="btn btn-secondary">
                <i class="fas fa-edit"></i> Edit Content
            </a>
        </div>
    @endif

    <div class="cv-page">
        <!-- LEFT SIDEBAR (DEEP NAVY) -->
        <aside class="cv-sidebar">
            <div class="name-block">
                <h1 class="full-name">{{ $cv->full_name }}</h1>
                <div class="job-title">{{ $primaryRole }}</div>
            </div>

            @if($photoSrc)
                <div class="avatar-wrap">
                    <img src="{{ $photoSrc }}" alt="{{ $cv->full_name }}" class="avatar-img">
                </div>
            @endif

            <!-- Contact Information -->
            <div class="contact-list">
                @if($cv->email)
                    <div class="contact-item">
                        <i class="far fa-envelope"></i>
                        <span><a href="mailto:{{ $cv->email }}">{{ $cv->email }}</a></span>
                    </div>
                @endif
                @if($cv->mobile)
                    <div class="contact-item">
                        <i class="fas fa-phone-alt"></i>
                        <span>{{ $cv->mobile }}</span>
                    </div>
                @endif
                @if($cv->present_address)
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $cv->present_address }}</span>
                    </div>
                @endif
                @if($cv->linkedin_url)
                    <div class="contact-item">
                        <i class="fab fa-linkedin"></i>
                        <span><a href="{{ $cv->linkedin_url }}" target="_blank">{{ str_replace(['https://', 'http://'], '', $cv->linkedin_url) }}</a></span>
                    </div>
                @endif
                @if($cv->github_url)
                    <div class="contact-item">
                        <i class="fab fa-github"></i>
                        <span><a href="{{ $cv->github_url }}" target="_blank">{{ str_replace(['https://', 'http://'], '', $cv->github_url) }}</a></span>
                    </div>
                @endif
                @if($cv->website_url)
                    <div class="contact-item">
                        <i class="fas fa-globe"></i>
                        <span><a href="{{ $cv->website_url }}" target="_blank">{{ str_replace(['https://', 'http://'], '', $cv->website_url) }}</a></span>
                    </div>
                @endif
            </div>

            <!-- Profile Summary -->
            @if($cv->career_summary || $cv->career_objective)
                <div class="sidebar-section">
                    <div class="sidebar-sec-title">
                        <i class="fas fa-id-badge"></i> PROFILE
                    </div>
                    <p class="profile-text">
                        {!! clean($cv->career_summary ?: $cv->career_objective) !!}
                    </p>
                </div>
            @endif

            <!-- Education -->
            @if($academics->isNotEmpty())
                <div class="sidebar-section">
                    <div class="sidebar-sec-title">
                        <i class="fas fa-graduation-cap"></i> EDUCATION
                    </div>
                    @foreach($academics as $edu)
                        <div class="sidebar-edu-item">
                            <div class="sidebar-edu-degree">{{ $edu->degree_name ?? $edu->degree_title }}</div>
                            <div class="sidebar-edu-school">
                                <span>{{ $edu->institution }}</span>
                            </div>
                            <div class="sidebar-edu-meta">
                                <span>{{ $edu->passing_year ?: ($edu->passing_year ?? '') }}</span>
                                @if(!empty($edu->result))
                                    <span> | GPA/Result: {{ $edu->result }}</span>
                                @endif
                                @if(!empty($edu->group_or_major))
                                    <div>Major: {{ $edu->group_or_major }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Training & Certifications (Sidebar) -->
            @if($trainings->isNotEmpty())
                <div class="sidebar-section">
                    <div class="sidebar-sec-title">
                        <i class="fas fa-chalkboard-teacher"></i> TRAINING
                    </div>
                    @foreach($trainings as $train)
                        <div class="sidebar-edu-item">
                            <div class="sidebar-edu-degree">{{ $train->training_title }}</div>
                            <div class="sidebar-edu-school">
                                <span>{{ $train->institute ?? $train->institution }}</span>
                            </div>
                            <div class="sidebar-edu-meta">
                                <span>{{ $train->duration ?: ($train->year ?? '') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Languages -->
            @if($languages->isNotEmpty())
                <div class="sidebar-section">
                    <div class="sidebar-sec-title">
                        <i class="fas fa-language"></i> LANGUAGES
                    </div>
                    <ul class="sidebar-bullet-list">
                        @foreach($languages as $lang)
                            <li>
                                <span><strong>{{ $lang->language_name }}</strong>: {{ $lang->reading_level ?: 'Fluent' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </aside>

        <!-- RIGHT MAIN CONTENT (PURE WHITE) -->
        <main class="cv-main">
            <!-- Professional Experience -->
            @if($employments->isNotEmpty())
                <section class="main-section">
                    <div class="main-sec-title">
                        <i class="fas fa-briefcase"></i> PROFESSIONAL EXPERIENCE
                    </div>
                    @foreach($employments as $emp)
                        <div class="exp-item">
                            <div class="exp-header">
                                <span class="exp-company">{{ $emp->company_name }}</span>
                                <span class="exp-meta">{{ $formatDate($emp->start_date) }} – {{ $emp->is_current ? 'Present' : $formatDate($emp->end_date) }}@if(!empty($emp->company_location)) · {{ $emp->company_location }}@endif</span>
                            </div>
                            <div class="exp-role">{{ $emp->designation }}</div>
                            @php
                                $respText = $emp->responsibilities ?? ($emp->job_responsibilities ?? '');
                            @endphp
                            @if(!empty($respText))
                                @if(strip_tags($respText) !== $respText)
                                    <div style="font-size: 8.8px; color: #334155; line-height: 1.4;">{!! clean($respText) !!}</div>
                                @else
                                    <ul class="exp-bullets">
                                        @foreach(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $respText))) as $line)
                                            @php $cleanLine = ltrim($line, "•-*\t "); @endphp
                                            @if($cleanLine)<li>{{ $cleanLine }}</li>@endif
                                        @endforeach
                                    </ul>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            <!-- Technical Skills -->
            @if($skills->isNotEmpty())
                <section class="main-section">
                    <div class="main-sec-title">
                        <i class="fas fa-code"></i> TECHNICAL SKILLS
                    </div>
                    <div class="skills-grid">
                        @foreach($groupedSkills as $categoryName => $catSkills)
                            <div class="skill-group-row">
                                <span class="skill-group-title">{{ $categoryName }}:</span>
                                <span class="skill-group-items">{{ $catSkills->map(fn($s) => ($s->skill_name ?? $s->name) . ($s->skill_level ? ' ('.$s->skill_level.')' : ''))->filter()->implode(', ') }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Projects & Engineering Case Studies -->
            @if($projects->isNotEmpty())
                <section class="main-section">
                    <div class="main-sec-title">
                        <i class="fas fa-folder-open"></i> FEATURED PROJECTS &amp; CASE STUDIES
                    </div>
                    @foreach($projects as $proj)
                        <div class="project-item">
                            <div class="project-title-line">
                                <span>
                                    <strong>{{ $loop->iteration }}. {{ $proj->title ?? $proj->project_title }}</strong>
                                    @if(!empty($proj->role)) <span style="font-weight: 500; font-size: 8.5px; color: #64748b;">({{ $proj->role }})</span>@endif
                                </span>
                                @if(!empty($proj->link) || !empty($proj->github_url))
                                    <div>
                                        @if(!empty($proj->link))<a href="{{ $proj->link }}" target="_blank"><i class="fas fa-external-link-alt"></i> Live Demo</a>@endif
                                        @if(!empty($proj->github_url))<a href="{{ $proj->github_url }}" target="_blank" style="margin-left: 8px;"><i class="fab fa-github"></i> Code</a>@endif
                                    </div>
                                @endif
                            </div>
                            @if(!empty($proj->technologies))
                                <div class="project-tech">Tech Stack: {{ $proj->technologies }}</div>
                            @endif
                            @if(!empty($proj->demo_user) || !empty($proj->demo_password))
                                <div class="demo-credentials">
                                    @if($proj->demo_user)<span style="margin-right: 8px;"><strong>User:</strong> {{ $proj->demo_user }}</span>@endif
                                    @if($proj->demo_password)<span><strong>Pass:</strong> {{ $proj->demo_password }}</span>@endif
                                </div>
                            @endif
                            @if(!empty($proj->description))
                                <p class="project-desc">{!! clean($proj->description) !!}</p>
                            @elseif(!empty($proj->solution))
                                <p class="project-desc">{!! clean($proj->solution) !!}</p>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            <!-- Professional Qualifications -->
            @if($certifications->isNotEmpty())
                <section class="main-section">
                    <div class="main-sec-title">
                        <i class="fas fa-certificate"></i> CERTIFICATIONS &amp; QUALIFICATIONS
                    </div>
                    @foreach($certifications as $cert)
                        <div class="cert-item">
                            <div class="cert-title">{{ $cert->title }}</div>
                            <div class="cert-meta">
                                <span>{{ $cert->authority ?? ($cert->institute ?? '') }}</span>
                                @if(!empty($cert->year))<span>, {{ $cert->year }}</span>@endif
                                @if(!empty($cert->result_or_score))<span> | Score: {{ $cert->result_or_score }}</span>@endif
                            </div>
                        </div>
                    @endforeach
                </section>
            @endif

            <!-- References -->
            @if($references->isNotEmpty())
                <section class="main-section">
                    <div class="main-sec-title">
                        <i class="fas fa-users"></i> REFERENCES
                    </div>
                    <div class="ref-grid">
                        @foreach($references as $ref)
                            <div class="ref-card">
                                <div class="ref-name">{{ $ref->name }}</div>
                                <div class="ref-role">{{ $ref->designation }}@if(!empty($ref->organization)), {{ $ref->organization }}@endif</div>
                                <div style="margin-top: 2px;">
                                    @if(!empty($ref->phone))<div class="ref-contact-item"><i class="fas fa-phone-alt"></i> {{ $ref->phone }}</div>@endif
                                    @if(!empty($ref->email))<div class="ref-contact-item"><i class="far fa-envelope"></i> {{ $ref->email }}</div>@endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Declaration & Signature -->
            @if($signatureSrc || $cv->declaration)
                <div class="signature-box">
                    <div style="text-align: center; border-top: 1px dashed #cbd5e1; padding-top: 4px; min-width: 130px;">
                        @if($signatureSrc)
                            <img src="{{ $signatureSrc }}" alt="Signature" style="max-height: 36px; max-width: 120px; object-fit: contain;">
                        @endif
                        <div style="font-size: 8.5px; font-weight: 700; color: #0c2340; margin-top: 2px;">{{ $cv->full_name }}</div>
                        @if($cv->declaration_date)
                            <div style="font-size: 7.5px; color: #64748b;">{{ $formatDate($cv->declaration_date) }}</div>
                        @endif
                    </div>
                </div>
            @endif
        </main>
    </div>

</body>
</html>
