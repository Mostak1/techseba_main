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
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $cv->full_name }} - CV</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }

        body {
            margin: 0;
            padding: 0;
            color: #1f2937;
            background: #f3f4f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 10.5px;
            line-height: 1.3;
        }

        .no-print-area {
            max-width: 800px;
            margin: 20px auto;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            color: white;
            background: #0a165e;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background: #6b7280;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 12mm;
            margin: 0 auto 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        /* Decorative Background */
        .page::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 40px;
            height: 100%;
            background: linear-gradient(to bottom, #0a165e 0%, #0a165e 150px, transparent 150px);
            z-index: 0;
        }

        .page-content {
            position: relative;
            z-index: 1;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-left: 10px;
        }

        .header-left {
            flex: 1;
        }

        .name {
            font-size: 28px;
            font-weight: 800;
            color: #0a165e;
            margin: 0;
            text-transform: uppercase;
        }

        .designation {
            font-size: 16px;
            color: #4b5563;
            margin: 5px 0 15px;
        }

        .contact-info {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 8px 12px;
            align-items: center;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contact-icon {
            width: 20px;
            height: 20px;
            background: #0a165e;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .header-right {
            width: 120px;
            height: 140px;
            border: 4px solid #f3f4f6;
            border-radius: 8px;
            overflow: hidden;
            background: #eee;
        }

        .header-right img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Section Layout */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 25px;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 3px;
        }

        .section-icon {
            width: 24px;
            height: 24px;
            background: #0a165e;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #0a165e;
            text-transform: uppercase;
            margin: 0;
        }

        /* List Styling */
        .list-unstyled {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .list-item {
            margin-bottom: 8px;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px;
        }

        .info-label {
            width: 100px;
            font-weight: 600;
            color: #374151;
        }

        .info-value {
            flex: 1;
            color: #4b5563;
        }

        /* Experience Item */
        .experience-item {
            margin-bottom: 15px;
        }

        .exp-header {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            color: #111827;
        }

        .exp-company {
            color: #0a165e;
            font-size: 12px;
        }

        .exp-role {
            font-style: italic;
            color: #4b5563;
            margin: 2px 0;
        }

        .exp-details {
            margin-top: 5px;
        }

        .exp-details strong {
            display: block;
            margin-bottom: 3px;
            font-size: 10.5px;
        }

        .exp-list {
            padding-left: 15px;
            margin: 5px 0;
        }

        .exp-list li {
            margin-bottom: 3px;
        }

        /* Table Styling */
        .cv-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .cv-table th, .cv-table td {
            border: 1px solid #e5e7eb;
            padding: 4px 6px;
            text-align: left;
        }

        .cv-table th {
            background: #0a165e;
            color: white;
            font-weight: 600;
        }

        /* Skills */
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .skill-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .skill-item i {
            color: #0a165e;
            font-size: 10px;
        }

        /* Skills Cloud (Tags) */
        .skills-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .skill-tag {
            border: 1px solid #d1d5db;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            background: #f9fafb;
        }

        /* Reference */
        .reference-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .ref-box {
            border-left: 2px solid #0a165e;
            padding-left: 10px;
        }

        /* Declaration */
        .declaration-box {
            margin-top: 15px;
        }

        .signature-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 25px;
        }

        .sig-item {
            text-align: center;
            width: 150px;
        }

        .sig-line {
            border-top: 1px solid #374151;
            padding-top: 5px;
        }

        .sig-img {
            max-height: 40px;
            margin-bottom: 5px;
        }

        @media print {
            body {
                background: white;
            }
            .no-print-area {
                display: none;
            }
            .page {
                margin: 0;
                box-shadow: none;
            }
            .page {
                page-break-after: always;
            }
            .page:last-child {
                page-break-after: avoid;
            }
        }

        /* PDF Specific Styles (DomPDF Compatibility) */
        @if(!empty($forPdf))
        .main-grid {
            display: block;
            width: 100%;
        }
        .grid-left {
            float: left;
            width: 40%;
            padding-right: 20px;
        }
        .grid-right {
            float: left;
            width: 55%;
        }
        .section {
            clear: both;
            margin-bottom: 10px;
        }
        .header {
            display: block;
            width: 100%;
        }
        .header-left {
            float: left;
            width: 75%;
        }
        .header-right {
            float: right;
            width: 120px;
        }
        .contact-info {
            display: block;
        }
        .contact-item {
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 5px;
        }
        .skills-grid {
            display: block;
        }
        .skill-item {
            float: left;
            width: 31%;
            margin-bottom: 5px;
        }
        .reference-grid {
            display: block;
        }
        .ref-box {
            float: left;
            width: 48%;
            margin-right: 2%;
            margin-bottom: 15px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        @endif
    </style>
</head>
<body>

@if(!empty($showActions))
    <div class="no-print-area">
        @if(!empty($printEnabled))
            <button onclick="window.print()" class="btn">Print</button>
        @endif
        @if(!empty($pdfEnabled))
            <a href="{{ $pdfUrl }}" class="btn btn-secondary">Download PDF</a>
        @endif
    </div>
@endif

<div class="page">
    <div class="page-content clearfix">
        <header class="header clearfix">
            <div class="header-left">
                <h1 class="name">{{ $cv->full_name }}</h1>
                <p class="designation">{{ $cv->employments->first()->designation ?? '' }}</p>
                
                <div class="contact-info">
                    @if($cv->mobile)
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fa fa-phone"></i></div>
                        <span>{{ $cv->mobile }}</span>
                    </div>
                    @endif
                    
                    @if($cv->email)
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fa fa-envelope"></i></div>
                        <span>{{ $cv->email }}</span>
                    </div>
                    @endif

                    @if($cv->website_url)
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fa fa-globe"></i></div>
                        <span>{{ str_replace(['http://', 'https://'], '', $cv->website_url) }}</span>
                    </div>
                    @endif

                    @if($cv->github_url)
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fa-brands fa-github"></i></div>
                        <span>{{ str_replace(['http://', 'https://'], '', $cv->github_url) }}</span>
                    </div>
                    @endif

                    @if($cv->linkedin_url)
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fa-brands fa-linkedin-in"></i></div>
                        <span>{{ str_replace(['http://', 'https://'], '', $cv->linkedin_url) }}</span>
                    </div>
                    @endif

                    @if($cv->present_address)
                    <div class="contact-item" style="grid-column: 1 / -1;">
                        <div class="contact-icon"><i class="fa fa-location-dot"></i></div>
                        <span><strong>Present Address:</strong> {{ $cv->present_address }}</span>
                    </div>
                    @endif

                    @if($cv->permanent_address)
                    <div class="contact-item" style="grid-column: 1 / -1;">
                        <div class="contact-icon"><i class="fa fa-location-dot"></i></div>
                        <span><strong>Permanent Address:</strong> {{ $cv->permanent_address }}</span>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="header-right">
                @if($photoSrc)
                    <img src="{{ $photoSrc }}" alt="{{ $cv->full_name }}">
                @else
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">No Photo</div>
                @endif
            </div>
        </header>

        <div class="main-grid clearfix">
            <div class="grid-left">
                <!-- Career Objective -->
                @if($cv->career_objective)
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa fa-bullseye"></i></div>
                        <h2 class="section-title">Career Objective</h2>
                    </div>
                    <p style="text-align: justify;">{{ $cv->career_objective }}</p>
                </div>
                @endif

                <!-- Personal Information -->
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa fa-user"></i></div>
                        <h2 class="section-title">Personal Information</h2>
                    </div>
                    <div class="info-row"><div class="info-label">Date of Birth</div><div class="info-value">: {{ $formatFullDate($cv->date_of_birth) }}</div></div>
                    <div class="info-row"><div class="info-label">Nationality</div><div class="info-value">: {{ $cv->nationality }}</div></div>
                    <div class="info-row"><div class="info-label">Gender</div><div class="info-value">: {{ $cv->gender }}</div></div>
                    <div class="info-row"><div class="info-label">Marital Status</div><div class="info-value">: {{ $cv->marital_status }}</div></div>
                    <div class="info-row"><div class="info-label">Religion</div><div class="info-value">: {{ $cv->religion }}</div></div>
                </div>

                <!-- Career Summary -->
                @if($cv->career_summary)
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa fa-briefcase"></i></div>
                        <h2 class="section-title">Career Summary</h2>
                    </div>
                    <p style="text-align: justify;">{{ $cv->career_summary }}</p>
                </div>
                @endif
            </div>

            <div class="grid-right">
                <!-- Employment History -->
                @if($cv->employments->isNotEmpty())
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa fa-briefcase"></i></div>
                        <h2 class="section-title">Employment History</h2>
                    </div>
                    @foreach($cv->employments as $emp)
                    <div class="experience-item">
                        <div class="exp-header">
                            <span class="exp-company">{{ $loop->iteration }}. {{ $emp->company_name }}</span>
                            <span class="muted">{{ $formatDate($emp->start_date) }} – {{ $emp->is_current ? 'Present' : $formatDate($emp->end_date) }}</span>
                        </div>
                        <div class="exp-role">{{ $emp->designation }}</div>
                        <div class="exp-details">
                            @if($emp->responsibilities)
                            <strong>Responsibilities:</strong>
                            <ul class="exp-list">
                                @foreach(explode("\n", $emp->responsibilities) as $line)
                                    @if(trim($line))<li>{{ trim($line, "*- ") }}</li>@endif
                                @endforeach
                            </ul>
                            @endif

                            @if($emp->achievements)
                            <strong>Achievements:</strong>
                            <ul class="exp-list">
                                @foreach(explode("\n", $emp->achievements) as $line)
                                    @if(trim($line))<li>{{ trim($line, "*- ") }}</li>@endif
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Academic Qualification -->
        @if($cv->academics->isNotEmpty())
        <div class="section">
            <div class="section-header">
                <div class="section-icon"><i class="fa fa-graduation-cap"></i></div>
                <h2 class="section-title">Academic Qualification</h2>
            </div>
            <table class="cv-table">
                <thead>
                    <tr>
                        <th>Examination</th>
                        <th>Board / University</th>
                        <th>Institution</th>
                        <th>Passing Year</th>
                        <th>GPA / CGPA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cv->academics as $academic)
                    <tr>
                        <td>{{ $academic->degree_name }}</td>
                        <td>{{ $academic->board_or_university }}</td>
                        <td>{{ $academic->institution }}</td>
                        <td>{{ $academic->passing_year }}</td>
                        <td>{{ $academic->result }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Key Skills -->
        @if($cv->skills->isNotEmpty())
        <div class="section">
            <div class="section-header">
                <div class="section-icon"><i class="fa fa-gear"></i></div>
                <h2 class="section-title">Key Skills</h2>
            </div>
            <div class="skills-grid">
                @foreach($cv->skills as $skill)
                <div class="skill-item">
                    <i class="fa fa-circle-check"></i>
                    <span>{{ $skill->skill_name }} @if($skill->skill_level)({{ $skill->skill_level }})@endif</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div style="position: absolute; bottom: 15mm; left: 0; width: 100%; text-align: center; color: #6b7280; font-size: 10px; border-top: 1px solid #e5e7eb; padding-top: 5px;">
            Page 1 of 2
        </div>
    </div>
</div>

<div class="page">
    <div class="page-content clearfix">
        <div class="main-grid clearfix">
            <div class="grid-left">
                <!-- Training & Certifications -->
                @if($cv->trainings->isNotEmpty())
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa fa-certificate"></i></div>
                        <h2 class="section-title">Training & Certifications</h2>
                    </div>
                    @foreach($cv->trainings as $training)
                    <div class="experience-item">
                        <div class="exp-header">
                            <span class="exp-company">{{ $loop->iteration }}. {{ $training->training_title }}</span>
                        </div>
                        <div class="muted">{{ $training->year }}</div>
                        <div class="exp-role">{{ $training->institute }}</div>
                        <div style="margin-top: 3px;">{{ $training->certificate_details }}</div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Language Proficiency -->
                @if($cv->languages->isNotEmpty())
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa fa-language"></i></div>
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
                                <td>{{ $lang->language_name }}</td>
                                <td>{{ $lang->reading_level }}</td>
                                <td>{{ $lang->writing_level }}</td>
                                <td>{{ $lang->speaking_level }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <!-- Projects -->
                @if($cv->projects->isNotEmpty())
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa fa-diagram-project"></i></div>
                        <h2 class="section-title">Projects</h2>
                    </div>
                    @foreach($cv->projects as $project)
                    <div class="experience-item">
                        <div class="exp-header">
                            <span class="exp-company">{{ $loop->iteration }}. {{ $project->title }}</span>
                        </div>
                        @if($project->link)
                            <div class="muted" style="font-size: 9px;"><i class="fa fa-link"></i> {{ $project->link }}</div>
                        @endif
                        <div style="margin-top: 3px; text-align: justify;">{{ $project->description }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="grid-right">
                 <!-- Professional Skills / Technical Competencies (Grouped) -->
                 <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fa fa-briefcase"></i></div>
                        <h2 class="section-title">Professional Skills / Technical Competencies</h2>
                    </div>
                    @foreach($cv->skills->groupBy('skill_type') as $type => $skills)
                        @if($type)
                        <div style="margin-bottom: 12px;">
                            <div style="font-weight: 700; margin-bottom: 5px; color: #0a165e;">
                                @if($type == 'Computer Skills') <i class="fa fa-desktop"></i> @elseif($type == 'Software Skills') <i class="fa fa-code"></i> @else <i class="fa fa-bullhorn"></i> @endif
                                {{ $type }}
                            </div>
                            <div class="skills-cloud">
                                @foreach($skills as $skill)
                                    <span class="skill-tag">{{ $skill->skill_name }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Reference -->
        @if($cv->references->isNotEmpty())
        <div class="section">
            <div class="section-header">
                <div class="section-icon"><i class="fa fa-users"></i></div>
                <h2 class="section-title">Reference</h2>
            </div>
            <div class="reference-grid">
                @foreach($cv->references as $ref)
                <div class="ref-box">
                    <div style="font-weight: 700; font-size: 12px; color: #0a165e;">{{ $loop->iteration }}. {{ $ref->name }}</div>
                    <div class="info-row"><div class="info-label" style="width: 80px;">Designation</div><div class="info-value">: {{ $ref->designation }}</div></div>
                    <div class="info-row"><div class="info-label" style="width: 80px;">Organization</div><div class="info-value">: {{ $ref->organization }}</div></div>
                    <div class="info-row"><div class="info-label" style="width: 80px;">Phone</div><div class="info-value">: {{ $ref->phone }}</div></div>
                    <div class="info-row"><div class="info-label" style="width: 80px;">Email</div><div class="info-value">: {{ $ref->email }}</div></div>
                    <div class="info-row"><div class="info-label" style="width: 80px;">Relationship</div><div class="info-value">: {{ $ref->relationship }}</div></div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Declaration -->
        <div class="declaration-box">
            <div class="section-header">
                <div class="section-icon"><i class="fa fa-pen-nib"></i></div>
                <h2 class="section-title">Declaration</h2>
            </div>
            <p>{{ $cv->declaration ?: 'I hereby declare that the information provided in this resume is true, complete and correct to the best of my knowledge and belief. I understand that any false information may lead to disqualification or termination.' }}</p>
            
            <div class="signature-area">
                <div class="sig-item">
                    @if($signatureSrc)
                        <img src="{{ $signatureSrc }}" class="sig-img" alt="Signature">
                    @endif
                    <div class="sig-line">{{ $cv->full_name }}</div>
                    <div>Signature</div>
                </div>
                <div class="sig-item">
                    <div style="margin-bottom: 22px;">{{ $formatFullDate($cv->declaration_date ?: now()) }}</div>
                    <div class="sig-line">Date</div>
                </div>
            </div>
        </div>

        <div style="position: absolute; bottom: 15mm; left: 0; width: 100%; text-align: center; color: #6b7280; font-size: 10px; border-top: 1px solid #e5e7eb; padding-top: 5px;">
            Page 2 of 2
        </div>
    </div>
</div>

</body>
</html>
