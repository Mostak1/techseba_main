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
        return $date ? \Illuminate\Support\Carbon::parse($date)->format('d M Y') : '';
    };

    $username = $username ?? ($cv->user->username ?? 'mostak');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $cv->full_name }} CV</title>
    <style>
        @page {
            size: A4;
            margin: 14mm;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            margin: 0;
            color: #111827;
            background: #eef2f7;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            line-height: 1.45;
        }

        .cv-actions {
            max-width: 820px;
            margin: 18px auto 12px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .cv-action-btn {
            border: 1px solid #123f7a;
            background: #123f7a;
            color: #fff;
            padding: 8px 14px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            cursor: pointer;
        }

        .cv-action-btn.disabled {
            border-color: #9ca3af;
            background: #9ca3af;
            cursor: not-allowed;
        }

        .cv-page {
            width: 210mm;
            max-width: 100%;
            min-height: 297mm;
            margin: 14px auto 24px;
            padding: 16mm 18mm;
            background: #fff;
            box-shadow: 0 8px 28px rgba(15, 23, 42, .12);
            position: relative;
            box-sizing: border-box;
            border-radius: 4px;
        }

        .page-break {
            height: 20px;
            page-break-before: always;
            break-before: page;
        }

        .cv-header {
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 14px;
            margin-bottom: 16px;
            position: relative;
            min-height: 116px;
        }

        .cv-name {
            font-size: 28px;
            line-height: 1.1;
            margin: 0 126px 8px 0;
            color: #102a63;
            letter-spacing: 0;
        }

        .cv-contact {
            margin-right: 126px;
            color: #374151;
        }

        .cv-photo {
            position: absolute;
            right: 0;
            top: 0;
            width: 105px;
            height: 125px;
            border: 1px solid #9ca3af;
            object-fit: cover;
        }

        .section {
            margin-top: 14px;
            break-inside: auto;
            page-break-inside: auto;
        }

        .section-title {
            margin: 0 0 8px;
            padding: 5px 8px;
            background: #e8eef9;
            border-left: 4px solid #1e3a8a;
            color: #102a63;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.25;
            break-after: avoid;
            page-break-after: avoid;
        }

        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .info-grid th,
        .info-grid td,
        .cv-table th,
        .cv-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 7px;
            vertical-align: top;
        }

        .info-grid th {
            width: 32%;
            background: #f8fafc;
            text-align: left;
            color: #374151;
        }

        .section p, .job-item p {
            margin: 0 0 6px;
        }

        .section ul, .section ol, .job-item ul, .job-item ol {
            margin: 0 0 6px 18px;
            padding: 0;
        }

        .info-grid td p, .cv-table td p {
            margin: 0;
        }

        .cv-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cv-table th {
            background: #f1f5f9;
            color: #1f2937;
            text-align: left;
        }

        .job-item, .project-item {
            border: 1px solid #cbd5e1;
            padding: 9px;
            margin-bottom: 8px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .job-title {
            font-size: 14px;
            font-weight: 700;
            color: #102a63;
            margin-bottom: 3px;
        }

        .muted {
            color: #4b5563;
        }

        .skill-group {
            margin-bottom: 8px;
        }

        .skill-group-title {
            font-weight: 700;
            color: #102a63;
            margin-bottom: 3px;
        }

        .references {
            display: table;
            width: 100%;
            border-spacing: 10px 0;
            margin-left: -10px;
        }

        .reference-box {
            display: table-cell;
            width: 50%;
            border: 1px solid #cbd5e1;
            padding: 8px;
        }

        .signature {
            margin-top: 18px;
            width: 220px;
            text-align: center;
        }

        .signature img {
            max-width: 180px;
            max-height: 65px;
            display: block;
            margin: 0 auto 4px;
        }

        .signature-line {
            border-top: 1px solid #111827;
            padding-top: 4px;
        }

        @media print {
            body {
                background: #fff !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .no-print, .cv-actions {
                display: none !important;
            }

            .cv-page {
                width: 100% !important;
                max-width: 100% !important;
                min-height: 0 !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
            }

            .page-break {
                display: none !important;
            }

            .section {
                break-inside: auto !important;
                page-break-inside: auto !important;
            }

            .section-title {
                break-after: avoid !important;
                page-break-after: avoid !important;
            }

            .job-item,
            .project-item,
            .reference-box,
            .signature,
            tr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }

        @if(!empty($forPdf))
        body {
            background: #fff;
            font-size: 12px;
            line-height: 1.35;
        }

        .cv-actions {
            display: none !important;
        }

        .cv-page {
            width: auto;
            max-width: none;
            min-height: auto;
            margin: 0;
            padding: 0;
            box-shadow: none;
        }

        .cv-header {
            min-height: 105px;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .cv-name {
            font-size: 24px;
        }

        .section {
            margin-top: 11px;
        }

        .section-title {
            padding: 4px 7px;
            margin-bottom: 6px;
        }

        .info-grid th,
        .info-grid td,
        .cv-table th,
        .cv-table td {
            padding: 4px 6px;
        }
        @endif
    </style>
</head>
<body>
@if(!empty($showActions))
    <div class="cv-actions no-print">
        @if(!empty($printEnabled))
            <a href="{{ $printUrl }}" class="cv-action-btn">Print</a>
        @else
            <span class="cv-action-btn disabled">Print Disabled</span>
        @endif
    </div>
@endif

<main class="cv-page">
    <header class="cv-header">
        <h1 class="cv-name">{{ $cv->full_name }}</h1>
        <div class="cv-contact">
            @if($cv->mobile)<div><strong>Mobile:</strong> {{ $cv->mobile }}</div>@endif
            @if($cv->email)<div><strong>Email:</strong> <a href="mailto:{{ $cv->email }}">{{ $cv->email }}</a></div>@endif
            @if($cv->website_url)<div><strong>Website:</strong> <a href="{{ $cv->website_url }}" target="_blank">{{ $cv->website_url }}</a></div>@endif
            @if($cv->linkedin_url)<div><strong>LinkedIn:</strong> <a href="{{ $cv->linkedin_url }}" target="_blank">{{ $cv->linkedin_url }}</a></div>@endif
            @if($cv->github_url)<div><strong>GitHub:</strong> <a href="{{ $cv->github_url }}" target="_blank">{{ $cv->github_url }}</a></div>@endif
            @if($cv->present_address)<div><strong>Address:</strong> {{ $cv->present_address }}</div>@endif
        </div>
        @if($photoSrc)
            <img src="{{ $photoSrc }}" class="cv-photo" alt="{{ $cv->full_name }}">
        @endif
    </header>

    <section class="section">
        <h2 class="section-title">Personal Information</h2>
        <table class="info-grid">
            <tr><th>Father's Name</th><td>{{ $cv->father_name }}</td></tr>
            <tr><th>Mother's Name</th><td>{{ $cv->mother_name }}</td></tr>
            <tr><th>Date of Birth</th><td>{{ $formatDate($cv->date_of_birth) }}</td></tr>
            <tr><th>Gender</th><td>{{ $cv->gender }}</td></tr>
            <tr><th>Marital Status</th><td>{{ $cv->marital_status }}</td></tr>
            <tr><th>Nationality</th><td>{{ $cv->nationality }}</td></tr>
            <tr><th>Religion</th><td>{{ $cv->religion }}</td></tr>
            <tr><th>National ID / Passport</th><td>{{ $cv->nid_or_passport }}</td></tr>
            <tr><th>Present Address</th><td>{!! clean($cv->present_address) !!}</td></tr>
            <tr><th>Permanent Address</th><td>{!! clean($cv->permanent_address) !!}</td></tr>
        </table>
    </section>

    @if($cv->career_objective)
        <section class="section">
            <h2 class="section-title">Career Objective</h2>
            <div>{!! clean($cv->career_objective) !!}</div>
        </section>
    @endif

    @if($cv->career_summary || $cv->formatted_total_experience)
        <section class="section">
            <h2 class="section-title">Career Summary / Profile Summary</h2>
            @if($cv->formatted_total_experience)<p><strong>Total Experience:</strong> {{ $cv->formatted_total_experience }}</p>@endif
            @if($cv->career_summary)<div>{!! clean($cv->career_summary) !!}</div>@endif
        </section>
    @endif

    @if($cv->employments->isNotEmpty())
        <section class="section">
            <h2 class="section-title">Employment History</h2>
            @foreach($cv->employments as $employment)
                <div class="job-item">
                    <div class="job-title">{{ $employment->designation }}{{ $employment->company_name ? ' at '.$employment->company_name : '' }}</div>
                    <div class="muted">
                        {{ $employment->department }}
                        @if($employment->start_date)
                            | {{ $formatDate($employment->start_date) }} -
                            {{ $employment->is_current ? 'Present' : $formatDate($employment->end_date) }}
                        @endif
                    </div>
                    @if($employment->company_location || $employment->business_type)
                        <div class="muted">{{ $employment->company_location }}{{ $employment->business_type ? ' | '.$employment->business_type : '' }}</div>
                    @endif
                    @if($employment->responsibilities)<div><strong>Responsibilities:</strong><br>{!! clean($employment->responsibilities) !!}</div>@endif
                    @if($employment->achievements)<div style="margin-top: 4px;"><strong>Major Achievements:</strong><br>{!! clean($employment->achievements) !!}</div>@endif
                </div>
            @endforeach
        </section>
    @endif

    @if($cv->academics->isNotEmpty())
        <section class="section">
            <h2 class="section-title">Academic Qualification</h2>
            <table class="cv-table">
                <thead>
                <tr>
                    <th>Exam / Degree</th>
                    <th>Institution</th>
                    <th>Board / University</th>
                    <th>Group / Major</th>
                    <th>Result</th>
                    <th>Year</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cv->academics as $academic)
                    <tr>
                        <td>{{ $academic->degree_name }}</td>
                        <td>{{ $academic->institution }}</td>
                        <td>{{ $academic->board_or_university }}</td>
                        <td>{{ $academic->group_or_major }}</td>
                        <td>{{ $academic->result }}</td>
                        <td>{{ $academic->passing_year }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    @endif

    @if($cv->trainings->isNotEmpty())
        <section class="section">
            <h2 class="section-title">Training / Certification</h2>
            <table class="cv-table">
                <thead><tr><th>Title</th><th>Institute</th><th>Duration</th><th>Year</th><th>Certificate Details</th></tr></thead>
                <tbody>
                @foreach($cv->trainings as $training)
                    <tr>
                        <td>{{ $training->training_title }}</td>
                        <td>{{ $training->institute }}</td>
                        <td>{{ $training->duration }}</td>
                        <td>{{ $training->year }}</td>
                        <td>{!! clean($training->certificate_details) !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    @endif

    @if($cv->professionalQualifications->isNotEmpty())
        <section class="section">
            <h2 class="section-title">Professional Qualification</h2>
            <table class="cv-table">
                <thead><tr><th>Title</th><th>Institute / Authority</th><th>Result / Score</th><th>Year</th><th>Details</th></tr></thead>
                <tbody>
                @foreach($cv->professionalQualifications as $qualification)
                    <tr>
                        <td>{{ $qualification->title }}</td>
                        <td>{{ $qualification->authority }}</td>
                        <td>{{ $qualification->result_or_score }}</td>
                        <td>{{ $qualification->year }}</td>
                        <td>{!! clean($qualification->details) !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    @endif

    @if($cv->skills->isNotEmpty())
        <section class="section">
            <h2 class="section-title">Skills</h2>
            @foreach($cv->skills->groupBy(fn($skill) => $skill->skill_type ?: 'General') as $type => $skills)
                <div class="skill-group">
                    <div class="skill-group-title">{{ $type }}</div>
                    <div>
                        @foreach($skills as $skill)
                            {{ $skill->skill_name }}@if($skill->skill_level) ({{ $skill->skill_level }})@endif{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </div>
                </div>
            @endforeach
        </section>
    @endif

    @if($cv->projects->isNotEmpty())
        <section class="section">
            <h2 class="section-title">Projects &amp; Case Studies</h2>
            @foreach($cv->projects as $project)
                <div class="project-item">
                    <div class="job-title">{{ $loop->iteration }}. {{ $project->title }} @if($project->role)<span class="muted" style="font-weight: normal; font-size: 12px;">({{ $project->role }})</span>@endif</div>
                    @if($project->link || $project->github_url)
                        <div style="font-size: 11px; margin-top: 2px;">
                            @if($project->link)<strong>Demo:</strong> <a href="{{ $project->link }}" target="_blank">{{ $project->link }}</a>@endif
                            @if($project->github_url)<span style="margin-left: 10px;"><strong>GitHub:</strong> <a href="{{ $project->github_url }}" target="_blank">{{ $project->github_url }}</a></span>@endif
                        </div>
                    @endif
                    @if($project->demo_user || $project->demo_password)
                        <div style="font-size: 11px; color: #155724; background-color: #d4edda; border: 1px dashed #c3e6cb; padding: 2px 7px; border-radius: 4px; margin: 4px 0; display: inline-block;">
                            @if($project->demo_user)<span style="margin-right: 12px;"><strong>User:</strong> <code>{{ $project->demo_user }}</code></span>@endif
                            @if($project->demo_password)<span><strong>Pass:</strong> <code>{{ $project->demo_password }}</code></span>@endif
                        </div>
                    @endif
                    @if($project->technologies)<div class="muted" style="font-size: 11px; margin-top: 2px;"><strong>Technologies:</strong> {{ $project->technologies }}</div>@endif
                    @if($project->description)<div style="margin-top: 3px; font-size: 12px; color: #374151;">{!! clean($project->description) !!}</div>@endif
                    @if($project->problem)<div style="margin-top: 2px; font-size: 11px; color: #4b5563;"><strong>Problem:</strong> {!! clean($project->problem) !!}</div>@endif
                    @if($project->solution)<div style="margin-top: 2px; font-size: 11px; color: #4b5563;"><strong>Solution:</strong> {!! clean($project->solution) !!}</div>@endif
                </div>
            @endforeach
        </section>
    @endif

    @if($cv->languages->isNotEmpty())
        <section class="section">
            <h2 class="section-title">Language Proficiency</h2>
            <table class="cv-table">
                <thead><tr><th>Language</th><th>Reading</th><th>Writing</th><th>Speaking</th></tr></thead>
                <tbody>
                @foreach($cv->languages as $language)
                    <tr>
                        <td>{{ $language->language_name }}</td>
                        <td>{{ $language->reading_level }}</td>
                        <td>{{ $language->writing_level }}</td>
                        <td>{{ $language->speaking_level }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    @endif

    @if($cv->references->isNotEmpty())
        <section class="section">
            <h2 class="section-title">References</h2>
            <div class="references">
                @foreach($cv->references->take(2) as $reference)
                    <div class="reference-box">
                        <strong>{{ $reference->name }}</strong><br>
                        {{ $reference->designation }}<br>
                        {{ $reference->organization }}<br>
                        @if($reference->phone)Phone: {{ $reference->phone }}<br>@endif
                        @if($reference->email)Email: {{ $reference->email }}<br>@endif
                        @if($reference->relationship)Relationship: {{ $reference->relationship }}@endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if($cv->declaration || $signatureSrc || $cv->declaration_date)
        <section class="section">
            <h2 class="section-title">Declaration</h2>
            @if($cv->declaration)<div>{!! clean($cv->declaration) !!}</div>@endif
            @if($cv->declaration_date)<p style="margin-top: 4px;"><strong>Date:</strong> {{ $formatDate($cv->declaration_date) }}</p>@endif
            <div class="signature">
                @if($signatureSrc)<img src="{{ $signatureSrc }}" alt="Signature">@endif
                <div class="signature-line">Signature</div>
            </div>
        </section>
    @endif
</main>

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
