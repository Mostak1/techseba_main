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

    $username = $username ?? ($cv->user->username ?? 'user');
    $primaryRole = $cv->employments->first()->designation ?? 'AI & Full-Stack Software Engineer';

    // Partition child entities across 2 pages cleanly
    $employments = $cv->employments ?? collect();
    $academics = $cv->academics ?? ($cv->educations ?? collect());
    $trainings = $cv->trainings ?? collect();
    $skills = $cv->skills ?? collect();
    $projects = $cv->projects ?? collect();
    $certifications = $cv->professionalQualifications ?? collect();
    $languages = $cv->languages ?? collect();
    $references = $cv->references ?? collect();

    // Page 1 vs Page 2 partitioning
    $page1Trainings = $trainings->slice(0, 1);
    $page2Trainings = $trainings->slice(1);

    $page1Projects = $projects->slice(0, 1);
    $page2Projects = $projects->slice(1);

    // Group skills by category if available, otherwise default IT grouped structure
    $groupedSkills = $skills->groupBy(function ($item) {
        return $item->category ?? ($item->skill_type ?? 'Key Competencies');
    });

    // Default categorized skills fallback if user skills lack categories
    $hasCategoryGroupedSkills = $groupedSkills->count() > 1;

    $hasPage2 = ($page2Projects->isNotEmpty() || $page2Trainings->isNotEmpty() || $certifications->isNotEmpty() || $references->isNotEmpty() || $languages->isNotEmpty());
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
            font-size: 9.5px;
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
        .btn:hover {
            background: #173b67;
        }

        /* Standard A4 Sheet: 210mm x 297mm */
        .cv-page {
            width: 210mm;
            min-height: 297mm;
            max-height: 297mm;
            margin: 18px auto 26px;
            background: #ffffff;
            display: flex;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            border-radius: 2px;
            overflow: hidden;
            page-break-after: always;
            position: relative;
            box-sizing: border-box;
        }

        /* Left Column: Deep Navy Blue Sidebar (approx 36% width) */
        .cv-sidebar {
            width: 76mm;
            background-color: #0c2340;
            color: #ffffff;
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            gap: 15px;
            box-sizing: border-box;
        }

        .name-block {
            margin-bottom: 2px;
        }

        .full-name {
            font-size: 23px;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 4px 0;
            line-height: 1.15;
            letter-spacing: -0.3px;
        }

        .job-title {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            line-height: 1.35;
        }

        .avatar-wrap {
            text-align: center;
            margin: 8px 0 10px;
        }

        .avatar-img {
            width: 95px;
            height: 95px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #1e3a5f;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.35);
        }

        /* Contact Details with Icons */
        .contact-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 9.5px;
            color: #f1f5f9;
            margin-bottom: 2px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            word-break: break-all;
            line-height: 1.35;
        }

        .contact-item i {
            font-size: 10.5px;
            color: #38bdf8;
            width: 13px;
            margin-top: 1.5px;
            flex-shrink: 0;
        }

        .contact-item a {
            color: #f1f5f9;
            text-decoration: none;
        }

        /* Sidebar Section */
        .sidebar-section {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sidebar-sec-title {
            font-size: 11px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 7px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.16);
            padding-bottom: 4px;
            margin-bottom: 2px;
        }

        .sidebar-sec-title i {
            font-size: 10.5px;
            color: #38bdf8;
        }

        .profile-text {
            font-size: 9px;
            line-height: 1.48;
            color: #cbd5e1;
            text-align: justify;
            margin: 0;
        }

        .sidebar-edu-item, .sidebar-train-item {
            margin-bottom: 7px;
        }

        .sidebar-edu-degree {
            font-size: 10px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.25;
        }

        .sidebar-edu-school {
            font-size: 9px;
            color: #e2e8f0;
            margin: 1px 0;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .sidebar-edu-school i {
            font-size: 8px;
            color: #38bdf8;
        }

        .sidebar-edu-meta {
            font-size: 8.5px;
            color: #94a3b8;
        }

        .sidebar-bullet-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .sidebar-bullet-list li {
            font-size: 9px;
            color: #f1f5f9;
            display: flex;
            align-items: flex-start;
            gap: 6px;
            line-height: 1.35;
        }

        .sidebar-bullet-list li::before {
            content: "•";
            color: #38bdf8;
            font-weight: bold;
            font-size: 12px;
            line-height: 1;
        }

        /* Right Column: Main Content (approx 64% width) */
        .cv-main {
            width: 134mm;
            padding: 24px 22px;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            gap: 15px;
            color: #1e293b;
            box-sizing: border-box;
        }

        .main-section {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .main-sec-title {
            font-size: 12px;
            font-weight: 800;
            color: #0c2340;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: flex;
            align-items: center;
            gap: 7px;
            border-bottom: 1.5px solid #0c2340;
            padding-bottom: 4px;
            margin-bottom: 4px;
        }

        .main-sec-title i {
            font-size: 11.5px;
            color: #0c2340;
        }

        /* Professional Experience */
        .exp-item {
            margin-bottom: 9px;
        }

        .exp-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 2px;
        }

        .exp-company {
            font-size: 11px;
            font-weight: 800;
            color: #0c2340;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .exp-company i {
            font-size: 8.5px;
            color: #64748b;
        }

        .exp-role {
            font-size: 10px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1px;
        }

        .exp-meta {
            font-size: 8.5px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .exp-bullets {
            margin: 0;
            padding-left: 13px;
            font-size: 9px;
            line-height: 1.45;
            color: #334155;
        }

        .exp-bullets li {
            margin-bottom: 3px;
        }

        /* Technical Skills Section */
        .skills-grid {
            display: flex;
            flex-direction: column;
            gap: 5px;
            font-size: 9px;
            line-height: 1.42;
            color: #334155;
        }

        .skill-group-row {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .skill-group-title {
            font-weight: 800;
            color: #0c2340;
            white-space: nowrap;
        }

        .skill-group-items {
            color: #334155;
        }

        /* Projects Section */
        .project-item {
            margin-bottom: 8px;
        }

        .project-title-line {
            font-size: 10.5px;
            font-weight: 800;
            color: #0c2340;
            margin-bottom: 1px;
            display: flex;
            align-items: baseline;
            gap: 5px;
            flex-wrap: wrap;
        }

        .project-title-line a {
            color: #0c2340;
            text-decoration: none;
        }

        .project-title-line i {
            font-size: 8.5px;
            color: #64748b;
        }

        .project-tech {
            font-size: 9px;
            font-weight: 600;
            color: #475569;
        }

        .project-desc {
            font-size: 9px;
            line-height: 1.42;
            color: #334155;
            margin: 2px 0 0;
        }

        /* Certifications & References */
        .cert-item {
            margin-bottom: 7px;
        }

        .cert-title {
            font-size: 10px;
            font-weight: 800;
            color: #0c2340;
        }

        .cert-meta {
            font-size: 8.5px;
            color: #64748b;
            margin-top: 1px;
        }

        .ref-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .ref-card {
            font-size: 9px;
            line-height: 1.4;
            color: #334155;
        }

        .ref-name {
            font-size: 10px;
            font-weight: 800;
            color: #0c2340;
        }

        .ref-role {
            color: #64748b;
            font-size: 8.5px;
        }

        .ref-contact {
            color: #475569;
            font-size: 8.5px;
            margin-top: 2px;
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .ref-contact-item {
            display: flex;
            align-items: center;
            gap: 5px;
            word-break: break-all;
        }

        .ref-contact-item i {
            font-size: 8.5px;
            color: #64748b;
        }

        @media print {
            body {
                background: #ffffff !important;
            }
            .no-print-area {
                display: none !important;
            }
            .cv-page {
                margin: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                max-height: 297mm !important;
                height: 297mm !important;
                page-break-after: always !important;
            }
        }
    </style>
</head>
<body>

    @if(empty($isTemplatePreview))
        <div class="no-print-area">
            <button type="button" class="btn" onclick="window.print()">
                <i class="fas fa-print"></i> Print CV (A4)
            </button>
            <a href="{{ profile_route('user.cv.edit') }}" class="btn" style="background: #475569;">
                <i class="fas fa-edit"></i> Edit Content
            </a>
        </div>
    @endif

    <!-- ========================================== -->
    <!--                 PAGE 1                     -->
    <!-- ========================================== -->
    <div class="cv-page" id="cvPage1">
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
                        <span>{{ $cv->email }}</span>
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
                        <span>{{ str_replace(['https://', 'http://'], '', $cv->linkedin_url) }}</span>
                    </div>
                @endif
                @if($cv->github_url)
                    <div class="contact-item">
                        <i class="fab fa-github"></i>
                        <span>{{ str_replace(['https://', 'http://'], '', $cv->github_url) }}</span>
                    </div>
                @endif
                @if($cv->website_url)
                    <div class="contact-item">
                        <i class="fas fa-globe"></i>
                        <span>{{ str_replace(['https://', 'http://'], '', $cv->website_url) }}</span>
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
                        {{ $cv->career_summary ?: $cv->career_objective }}
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
                            <div class="sidebar-edu-degree">{{ $edu->degree_title }}</div>
                            <div class="sidebar-edu-school">
                                <span>{{ $edu->institution }}</span>
                                <i class="fas fa-external-link-alt"></i>
                            </div>
                            <div class="sidebar-edu-meta">
                                <span>{{ $edu->passing_year ? $edu->passing_year : $formatDate($edu->end_date ?? null) }}</span>
                                @if(!empty($edu->result))
                                    <span> | GPA: {{ $edu->result }}</span>
                                @endif
                                @if(!empty($edu->concentration))
                                    <div>{{ $edu->concentration }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Training (Page 1) -->
            @if($page1Trainings->isNotEmpty())
                <div class="sidebar-section">
                    <div class="sidebar-sec-title">
                        <i class="fas fa-chalkboard-teacher"></i> TRAINING
                    </div>
                    @foreach($page1Trainings as $train)
                        <div class="sidebar-train-item">
                            <div class="sidebar-edu-degree">{{ $train->training_title }}</div>
                            <div class="sidebar-edu-school">
                                <span>{{ $train->institution }}</span>
                                <i class="fas fa-external-link-alt"></i>
                            </div>
                            <div class="sidebar-edu-meta">
                                <span>{{ $train->duration ? $train->duration : ($train->completion_year ?? '') }}</span>
                            </div>
                        </div>
                    @endforeach
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
                                <span class="exp-company">
                                    {{ $emp->company_name }}
                                    <i class="fas fa-external-link-alt"></i>
                                </span>
                            </div>
                            <div class="exp-role">{{ $emp->designation }}</div>
                            <div class="exp-meta">
                                <span>{{ $formatDate($emp->start_date) }} - {{ (!empty($emp->is_current) || !empty($emp->currently_working)) ? 'Present' : $formatDate($emp->end_date) }}</span>
                                @if(!empty($emp->company_location))
                                    <span> | {{ $emp->company_location }}</span>
                                @endif
                            </div>
                            @php
                                $respText = $emp->responsibilities ?? ($emp->job_responsibilities ?? '');
                                $bulletLines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $respText)));
                            @endphp
                            @if(!empty($bulletLines))
                                <ul class="exp-bullets">
                                    @foreach($bulletLines as $line)
                                        @php
                                            $cleanLine = ltrim($line, "•-*\t ");
                                        @endphp
                                        @if($cleanLine)
                                            <li>{{ $cleanLine }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            <!-- Technical Skills -->
            <section class="main-section">
                <div class="main-sec-title">
                    <i class="fas fa-code"></i> TECHNICAL SKILLS
                </div>
                <div class="skills-grid">
                    @if($hasCategoryGroupedSkills)
                        @foreach($groupedSkills as $categoryName => $catSkills)
                            <div class="skill-group-row">
                                <span class="skill-group-title">{{ $categoryName }}:</span>
                                <span class="skill-group-items">{{ $catSkills->map(fn($s) => $s->skill_name ?? $s->name)->filter()->implode(', ') }}</span>
                            </div>
                        @endforeach
                    @elseif($skills->isNotEmpty())
                        <div class="skill-group-row">
                            <span class="skill-group-title">Core Technologies:</span>
                            <span class="skill-group-items">{{ $skills->map(fn($s) => $s->skill_name ?? $s->name)->filter()->implode(', ') }}</span>
                        </div>
                    @else
                        <!-- Default High-Impact IT Skills Matching Image -->
                        <div class="skill-group-row">
                            <span class="skill-group-title">AI & Automation:</span>
                            <span class="skill-group-items">LLM, RAG, AI Agents, Voice AI, n8n, Prompt Engineering</span>
                        </div>
                        <div class="skill-group-row">
                            <span class="skill-group-title">Backend Architecture:</span>
                            <span class="skill-group-items">Laravel 11, PHP 8.3, Python, REST APIs, Microservices</span>
                        </div>
                        <div class="skill-group-row">
                            <span class="skill-group-title">Frontend Engineering:</span>
                            <span class="skill-group-items">Vue.js 3, JavaScript (ES6+), Tailwind CSS, Bootstrap, Inertia.js</span>
                        </div>
                        <div class="skill-group-row">
                            <span class="skill-group-title">Databases & Caching:</span>
                            <span class="skill-group-items">MySQL, PostgreSQL, MariaDB, Redis, Eloquent ORM</span>
                        </div>
                        <div class="skill-group-row">
                            <span class="skill-group-title">DevOps & Cloud:</span>
                            <span class="skill-group-items">Docker, Linux / Ubuntu Server, Nginx, Git, CI/CD Actions</span>
                        </div>
                        <div class="skill-group-row">
                            <span class="skill-group-title">APIs & Integrations:</span>
                            <span class="skill-group-items">Vapi, WhatsApp Business API, Facebook API, SSLCommerz, bKash</span>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Projects (Page 1 Item) -->
            @if($page1Projects->isNotEmpty())
                <section class="main-section">
                    <div class="main-sec-title">
                        <i class="fas fa-folder-open"></i> PROJECTS
                    </div>
                    @foreach($page1Projects as $proj)
                        <div class="project-item">
                            <div class="project-title-line">
                                <span>
                                    <strong>{{ $proj->project_title ?? ($proj->title ?? 'Featured Project') }}</strong>
                                    <i class="fas fa-external-link-alt"></i>
                                </span>
                                @if(!empty($proj->technologies_used) || !empty($proj->technologies))
                                    <span class="project-tech">| {{ $proj->technologies_used ?? $proj->technologies }}</span>
                                @endif
                            </div>
                            @if(!empty($proj->project_description) || !empty($proj->description))
                                <p class="project-desc">{{ $proj->project_description ?? $proj->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif
        </main>
    </div>

    <!-- ========================================== -->
    <!--                 PAGE 2                     -->
    <!-- ========================================== -->
    @if($hasPage2)
        <div class="cv-page" id="cvPage2">
            <!-- LEFT SIDEBAR (PAGE 2) -->
            <aside class="cv-sidebar">
                <!-- Training Continued -->
                @if($page2Trainings->isNotEmpty())
                    <div class="sidebar-section">
                        <div class="sidebar-sec-title">
                            <i class="fas fa-chalkboard-teacher"></i> TRAINING
                        </div>
                        @foreach($page2Trainings as $train)
                            <div class="sidebar-train-item">
                                <div class="sidebar-edu-degree">{{ $train->training_title }}</div>
                                <div class="sidebar-edu-school">
                                    <span>{{ $train->institution }}</span>
                                    <i class="fas fa-external-link-alt"></i>
                                </div>
                                <div class="sidebar-edu-meta">
                                    <span>{{ $train->duration ? $train->duration : ($train->completion_year ?? '') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Languages -->
                <div class="sidebar-section">
                    <div class="sidebar-sec-title">
                        <i class="fas fa-language"></i> LANGUAGES
                    </div>
                    <ul class="sidebar-bullet-list">
                        @if($languages->isNotEmpty())
                            @foreach($languages as $lang)
                                <li>
                                    <span><strong>{{ $lang->language_name ?? ($lang->name ?? 'Language') }}</strong> {{ !empty($lang->proficiency) ? '('.$lang->proficiency.')' : '' }}</span>
                                </li>
                            @endforeach
                        @else
                            <li><span><strong>Bangla</strong> (Native)</span></li>
                            <li><span><strong>English</strong> (Professional Working Proficiency)</span></li>
                            <li><span><strong>Hindi</strong> (Conversational)</span></li>
                        @endif
                    </ul>
                </div>

                <!-- Interests & Focus -->
                <div class="sidebar-section">
                    <div class="sidebar-sec-title">
                        <i class="fas fa-heart"></i> INTERESTS
                    </div>
                    <ul class="sidebar-bullet-list">
                        <li><span>Open Source Software & Tools</span></li>
                        <li><span>AI Agents & Voice Automation</span></li>
                        <li><span>High-Availability System Architecture</span></li>
                        <li><span>Tech Writing & Mentorship</span></li>
                        <li><span>Automation Workflow Design</span></li>
                    </ul>
                </div>
            </aside>

            <!-- RIGHT MAIN CONTENT (PAGE 2) -->
            <main class="cv-main">
                <!-- Projects (Continued) -->
                @if($page2Projects->isNotEmpty())
                    <section class="main-section">
                        <div class="main-sec-title">
                            <i class="fas fa-folder-open"></i> PROJECTS
                        </div>
                        @foreach($page2Projects as $proj)
                            <div class="project-item">
                                <div class="project-title-line">
                                    <span>
                                        <strong>{{ $proj->project_title ?? ($proj->title ?? 'Featured Project') }}</strong>
                                        <i class="fas fa-external-link-alt"></i>
                                    </span>
                                    @if(!empty($proj->technologies_used) || !empty($proj->technologies))
                                        <span class="project-tech">| {{ $proj->technologies_used ?? $proj->technologies }}</span>
                                    @endif
                                </div>
                                @if(!empty($proj->project_description) || !empty($proj->description))
                                    <p class="project-desc">{{ $proj->project_description ?? $proj->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </section>
                @endif

                <!-- Certifications -->
                @if($certifications->isNotEmpty())
                    <section class="main-section">
                        <div class="main-sec-title">
                            <i class="fas fa-certificate"></i> CERTIFICATIONS
                        </div>
                        @foreach($certifications as $cert)
                            <div class="cert-item">
                                <div class="cert-title">{{ $cert->certification_title ?? ($cert->title ?? 'Professional Certificate') }}</div>
                                <div class="cert-meta">
                                    <span>{{ $cert->institute ?? ($cert->institution ?? 'Accredited Institute') }}</span>
                                    @if(!empty($cert->year) || !empty($cert->passing_year))
                                        <span>, {{ $cert->year ?? $cert->passing_year }}</span>
                                    @endif
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
                                    <div class="ref-role">
                                        {{ $ref->designation }}
                                        @if(!empty($ref->organization) || !empty($ref->company))
                                            , {{ $ref->organization ?? $ref->company }}
                                        @endif
                                    </div>
                                    <div class="ref-contact">
                                        @if(!empty($ref->email))
                                            <div class="ref-contact-item">
                                                <i class="far fa-envelope"></i>
                                                <span>{{ $ref->email }}</span>
                                            </div>
                                        @endif
                                        @if(!empty($ref->phone) || !empty($ref->mobile))
                                            <div class="ref-contact-item">
                                                <i class="fas fa-phone-alt"></i>
                                                <span>{{ $ref->phone ?? $ref->mobile }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if($signatureSrc)
                    <div style="margin-top: auto; display: flex; justify-content: flex-end; padding-top: 15px;">
                        <div style="text-align: center; border-top: 1px dashed #cbd5e1; padding-top: 4px; min-width: 140px;">
                            <img src="{{ $signatureSrc }}" alt="Signature" style="max-height: 38px; max-width: 130px; object-fit: contain;">
                            <div style="font-size: 8.5px; font-weight: 700; color: #64748b; margin-top: 2px;">{{ $cv->full_name }}</div>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    @endif

</body>
</html>
