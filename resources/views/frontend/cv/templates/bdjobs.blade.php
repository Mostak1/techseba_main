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
            margin: 0 auto 24px;
            padding: 18mm;
            background: #fff;
            box-shadow: 0 8px 28px rgba(15, 23, 42, .12);
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
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .section-title {
            margin: 0 0 8px;
            padding: 5px 8px;
            background: #e8eef9;
            border-left: 4px solid #1e3a8a;
            color: #102a63;
            font-size: 15px;
            line-height: 1.25;
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

        .cv-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cv-table th {
            background: #f1f5f9;
            color: #1f2937;
            text-align: left;
        }

        .job-item {
            border: 1px solid #cbd5e1;
            padding: 9px;
            margin-bottom: 8px;
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
                background: #fff;
            }

            .no-print {
                display: none !important;
            }

            .cv-page {
                width: auto;
                min-height: auto;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }

            .section,
            .job-item,
            table {
                page-break-inside: avoid;
            }
        }
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

        @if(!empty($pdfEnabled))
            <a href="{{ $pdfUrl }}" class="cv-action-btn">PDF Download</a>
        @else
            <span class="cv-action-btn disabled">PDF Disabled</span>
        @endif
    </div>
@endif

<main class="cv-page">
    <header class="cv-header">
        <h1 class="cv-name">{{ $cv->full_name }}</h1>
        <div class="cv-contact">
            @if($cv->mobile)<div><strong>Mobile:</strong> {{ $cv->mobile }}</div>@endif
            @if($cv->email)<div><strong>Email:</strong> {{ $cv->email }}</div>@endif
            @if($cv->website_url)<div><strong>Website:</strong> {{ $cv->website_url }}</div>@endif
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
            <tr><th>Present Address</th><td>{{ $cv->present_address }}</td></tr>
            <tr><th>Permanent Address</th><td>{{ $cv->permanent_address }}</td></tr>
        </table>
    </section>

    @if($cv->career_objective)
        <section class="section">
            <h2 class="section-title">Career Objective</h2>
            <p>{!! nl2br(e($cv->career_objective)) !!}</p>
        </section>
    @endif

    @if($cv->career_summary || $cv->total_experience)
        <section class="section">
            <h2 class="section-title">Career Summary / Profile Summary</h2>
            @if($cv->total_experience)<p><strong>Total Experience:</strong> {{ $cv->total_experience }} years</p>@endif
            @if($cv->career_summary)<p>{!! nl2br(e($cv->career_summary)) !!}</p>@endif
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
                    @if($employment->responsibilities)<p><strong>Responsibilities:</strong><br>{!! nl2br(e($employment->responsibilities)) !!}</p>@endif
                    @if($employment->achievements)<p><strong>Major Achievements:</strong><br>{!! nl2br(e($employment->achievements)) !!}</p>@endif
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
                        <td>{{ $training->certificate_details }}</td>
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
                        <td>{{ $qualification->details }}</td>
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
            @if($cv->declaration)<p>{!! nl2br(e($cv->declaration)) !!}</p>@endif
            @if($cv->declaration_date)<p><strong>Date:</strong> {{ $formatDate($cv->declaration_date) }}</p>@endif
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
</body>
</html>
