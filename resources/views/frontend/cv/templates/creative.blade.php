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

    $username = $username ?? ($cv->user->username ?? 'user');
    $primaryRole = $cv->employments->first()->designation ?? 'Creative Professional & Designer';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cv->full_name }} — Creative Portfolio CV</title>
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
            background: #f8fafc;
            color: #1e293b;
            font-family: 'Outfit', 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            font-size: 10px;
            line-height: 1.5;
        }

        .resume-page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: #ffffff;
            display: flex;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        /* Left Sidebar: Deep Indigo Gradient */
        .sidebar {
            width: 72mm;
            background: linear-gradient(180deg, #0f172a 0%, #1e1b4b 60%, #311042 100%);
            color: #f8fafc;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex-shrink: 0;
        }

        .avatar-wrap {
            text-align: center;
        }

        .avatar-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
        }

        .sidebar-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #38bdf8;
            border-bottom: 1px solid rgba(56, 189, 248, 0.25);
            padding-bottom: 5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 9.5px;
            color: #cbd5e1;
            margin-bottom: 8px;
            word-break: break-all;
        }

        .contact-item i {
            color: #38bdf8;
            font-size: 11px;
            width: 14px;
            text-align: center;
        }

        .skill-pill {
            display: inline-block;
            background: rgba(255, 255, 255, 0.08);
            color: #e2e8f0;
            font-size: 9px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            margin: 0 4px 5px 0;
        }

        /* Right Content Area */
        .main-content {
            flex: 1;
            padding: 28px 24px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .header-section {
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 14px;
        }

        .person-name {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 4px 0;
            letter-spacing: -0.5px;
        }

        .person-role {
            font-size: 12px;
            font-weight: 700;
            color: #6366f1;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 8px 0;
        }

        .person-summary {
            font-size: 9.5px;
            color: #475569;
            line-height: 1.6;
            margin: 0;
        }

        .section-heading {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            padding-bottom: 4px;
            border-bottom: 1.5px solid #e2e8f0;
        }

        .section-heading i {
            color: #6366f1;
        }

        .timeline-item {
            position: relative;
            padding-left: 16px;
            border-left: 2px solid #e0e7ff;
            margin-bottom: 14px;
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
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .item-company {
            font-size: 9.5px;
            font-weight: 600;
            color: #6366f1;
            display: flex;
            justify-content: space-between;
            margin: 2px 0 5px 0;
        }

        .item-date {
            color: #94a3b8;
            font-weight: 500;
        }

        .item-desc {
            font-size: 9px;
            color: #475569;
            margin: 0;
            line-height: 1.5;
        }

        .signature-box {
            margin-top: auto;
            text-align: right;
            padding-top: 14px;
        }

        .signature-box img {
            max-height: 42px;
        }

        @media print {
            body {
                background: none;
            }
            .resume-page {
                box-shadow: none;
                width: 100%;
                min-height: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="resume-page">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="avatar-wrap">
                @if($photoSrc)
                    <img src="{{ $photoSrc }}" alt="{{ $cv->full_name }}" class="avatar-img">
                @else
                    <div class="avatar-img" style="background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-user" style="font-size: 36px; color: #cbd5e1;"></i>
                    </div>
                @endif
            </div>

            <!-- Contact Information -->
            <div>
                <div class="sidebar-title"><i class="fas fa-address-book"></i> Contact</div>
                @if($cv->email)
                    <div class="contact-item"><i class="fas fa-envelope"></i> <span>{{ $cv->email }}</span></div>
                @endif
                @if($cv->mobile)
                    <div class="contact-item"><i class="fas fa-phone"></i> <span>{{ $cv->mobile }}</span></div>
                @endif
                @if($cv->website_url)
                    <div class="contact-item"><i class="fas fa-globe"></i> <span>{{ $cv->website_url }}</span></div>
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
                            <span class="skill-pill">{{ $skill->name }}</span>
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
                            <span><strong>{{ $lang->name }}</strong>: {{ $lang->proficiency ?? 'Fluent' }}</span>
                        </div>
                    @endforeach
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
                    <p class="person-summary">{{ $cv->career_summary ?: $cv->career_objective }}</p>
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
                                <span>{{ $emp->company_name }}</span>
                                <span class="item-date">
                                    {{ $formatDate($emp->start_date) }} - {{ $emp->currently_working ? 'Present' : $formatDate($emp->end_date) }}
                                </span>
                            </div>
                            @if($emp->job_responsibilities)
                                <p class="item-desc">{!! nl2br(e($emp->job_responsibilities)) !!}</p>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            <!-- Education -->
            @if($cv->educations && $cv->educations->count())
                <section>
                    <div class="section-heading"><i class="fas fa-graduation-cap"></i> Education</div>
                    @foreach($cv->educations as $edu)
                        <div class="timeline-item">
                            <h3 class="item-role">{{ $edu->degree_title }}</h3>
                            <div class="item-company">
                                <span>{{ $edu->institution }}</span>
                                <span class="item-date">{{ $edu->passing_year ?? $formatDate($edu->end_date) }}</span>
                            </div>
                            @if($edu->result)
                                <p class="item-desc">Result / GPA: {{ $edu->result }}</p>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            <!-- Signature -->
            @if($signatureSrc)
                <div class="signature-box">
                    <img src="{{ $signatureSrc }}" alt="Signature">
                    <div style="font-size: 8.5px; color: #94a3b8; margin-top: 2px;">{{ $cv->full_name }}</div>
                </div>
            @endif
        </main>
    </div>
</body>
</html>
