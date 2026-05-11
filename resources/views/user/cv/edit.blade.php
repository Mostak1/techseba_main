@extends('user.dashboard_layout')

@php
    $emptyEmployment = ['company_name' => '', 'designation' => '', 'department' => '', 'start_date' => '', 'end_date' => '', 'is_current' => 0, 'responsibilities' => '', 'achievements' => '', 'company_location' => '', 'business_type' => ''];
    $emptyAcademic = ['degree_name' => '', 'institution' => '', 'board_or_university' => '', 'group_or_major' => '', 'result' => '', 'passing_year' => ''];
    $emptyTraining = ['training_title' => '', 'institute' => '', 'duration' => '', 'year' => '', 'certificate_details' => ''];
    $emptyQualification = ['title' => '', 'authority' => '', 'result_or_score' => '', 'year' => '', 'details' => ''];
    $emptySkill = ['skill_type' => '', 'skill_name' => '', 'skill_level' => ''];
    $emptyLanguage = ['language_name' => '', 'reading_level' => '', 'writing_level' => '', 'speaking_level' => ''];
    $emptyReference = ['name' => '', 'designation' => '', 'organization' => '', 'phone' => '', 'email' => '', 'relationship' => ''];

    $employments = old('employments', $cv ? $cv->employments->toArray() : []);
    $academics = old('academics', $cv ? $cv->academics->toArray() : []);
    $trainings = old('trainings', $cv ? $cv->trainings->toArray() : []);
    $qualifications = old('professional_qualifications', $cv ? $cv->professionalQualifications->toArray() : []);
    $skills = old('skills', $cv ? $cv->skills->toArray() : []);
    $languages = old('languages', $cv ? $cv->languages->toArray() : []);
    $references = old('references', $cv ? $cv->references->toArray() : []);

    $employments = count($employments) ? $employments : [$emptyEmployment];
    $academics = count($academics) ? $academics : [$emptyAcademic];
    $trainings = count($trainings) ? $trainings : [$emptyTraining];
    $qualifications = count($qualifications) ? $qualifications : [$emptyQualification];
    $skills = count($skills) ? $skills : [$emptySkill];
    $languages = count($languages) ? $languages : [$emptyLanguage];
    $references = count($references) ? $references : [$emptyReference, $emptyReference];

    $tabs = [
        'personal' => 'Personal',
        'career' => 'Career',
        'employment' => 'Employment',
        'academic' => 'Academic',
        'training' => 'Training',
        'professional' => 'Professional',
        'skills' => 'Skills',
        'language' => 'Language',
        'references' => 'References',
        'declaration' => 'Declaration',
        'settings' => 'Settings',
    ];
    $tabKeys = array_keys($tabs);
    $activeTab = request('tab', old('active_tab', 'personal'));
    $activeTab = array_key_exists($activeTab, $tabs) ? $activeTab : 'personal';
    $dateValue = fn($value) => $value ? \Illuminate\Support\Carbon::parse($value)->format('Y-m-d') : '';
    $nextTab = fn($tab) => $tabKeys[min(array_search($tab, $tabKeys) + 1, count($tabKeys) - 1)];
@endphp

@section('title')
    <title>Digital CV</title>
@endsection

@section('breadcrumb')
    <h1 class="post__title">Digital CV</h1>
    <nav class="breadcrumbs">
        <ul>
            <li><a href="{{ route('user.dashboard') }}">{{ __('translate.Home') }}</a></li>
            <li>Digital CV</li>
        </ul>
    </nav>
@endsection

@push('style_section')
    <style>
        .cv-shell {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .cv-head {
            padding: 18px 20px 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .cv-head h4 {
            margin: 0 0 12px;
            color: #0a165e;
            font-size: 22px;
        }

        .cv-tabs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
        }

        .cv-tab-btn {
            border: 1px solid #dbe3ef;
            background: #f8fafc;
            color: #334155;
            border-radius: 6px;
            padding: 8px 12px;
            font-weight: 700;
            font-size: 13px;
            white-space: nowrap;
        }

        .cv-tab-btn.active {
            border-color: #0a165e;
            background: #0a165e;
            color: #ffffff;
        }

        .cv-tab-panel {
            display: none;
            padding: 20px;
        }

        .cv-tab-panel.active {
            display: block;
        }

        .cv-section-title {
            margin: 0 0 18px;
            color: #0f172a;
            font-size: 18px;
            line-height: 1.25;
        }

        .cv-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px 16px;
        }

        .cv-grid.three {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .cv-full {
            grid-column: 1 / -1;
        }

        .cv-field label {
            display: block;
            margin-bottom: 7px;
            color: #344054;
            font-weight: 700;
            font-size: 13px;
        }

        .cv-field input,
        .cv-field textarea,
        .cv-field select {
            width: 100%;
            min-height: 46px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #ffffff;
            color: #0f172a;
            padding: 10px 12px;
            font-size: 14px;
            line-height: 1.4;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .cv-field select {
            appearance: none;
            background-image: linear-gradient(45deg, transparent 50%, #64748b 50%), linear-gradient(135deg, #64748b 50%, transparent 50%);
            background-position: calc(100% - 18px) 19px, calc(100% - 13px) 19px;
            background-size: 5px 5px, 5px 5px;
            background-repeat: no-repeat;
            padding-right: 36px;
        }

        .cv-field input:focus,
        .cv-field textarea:focus,
        .cv-field select:focus {
            border-color: #0a165e;
            box-shadow: 0 0 0 3px rgba(10, 22, 94, .10);
        }

        .cv-field textarea {
            min-height: 108px;
            resize: vertical;
        }

        .cv-repeat-row {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 14px;
            background: #f8fafc;
        }

        .cv-repeat-actions,
        .cv-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-end;
            align-items: center;
            margin-top: 16px;
        }

        .cv-small-btn,
        .cv-secondary-btn {
            border: 1px solid #0a165e;
            border-radius: 6px;
            padding: 9px 14px;
            background: #0a165e;
            color: #ffffff;
            font-weight: 700;
            line-height: 1;
        }

        .cv-secondary-btn {
            background: #ffffff;
            color: #0a165e;
            text-decoration: none;
        }

        .cv-small-btn.remove-row {
            border-color: #ef4444;
            background: #ef4444;
        }

        .cv-toggle-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .cv-toggle {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 56px;
            padding: 12px;
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            background: #f8fafc;
            color: #334155;
            font-weight: 700;
            cursor: pointer;
        }

        .cv-toggle input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .cv-toggle span:first-of-type {
            width: 38px;
            height: 22px;
            border-radius: 999px;
            background: #cbd5e1;
            position: relative;
            flex: 0 0 auto;
        }

        .cv-toggle span:first-of-type::after {
            content: "";
            position: absolute;
            width: 18px;
            height: 18px;
            left: 2px;
            top: 2px;
            border-radius: 50%;
            background: #ffffff;
            transition: transform .15s ease;
        }

        .cv-toggle input[type="checkbox"]:checked + span {
            background: #0a165e;
        }

        .cv-toggle input[type="checkbox"]:checked + span::after {
            transform: translateX(16px);
        }

        .cv-preview-image {
            width: 88px;
            height: 106px;
            object-fit: cover;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-top: 10px;
        }

        .cv-template-options {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .cv-template-card {
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            padding: 12px;
            background: #ffffff;
        }

        .cv-template-card input {
            width: auto;
            min-height: auto;
            margin-right: 8px;
        }

        @media (max-width: 991px) {
            .cv-grid,
            .cv-grid.three,
            .cv-toggle-grid,
            .cv-template-options {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('dashboard-content')
    <div class="cv-shell">
        <div class="cv-head">
            <h4>Digital CV</h4>
            <div class="cv-tabs" role="tablist">
                @foreach($tabs as $tab => $label)
                    <button type="button" class="cv-tab-btn {{ $activeTab === $tab ? 'active' : '' }}" data-tab-target="{{ $tab }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <form class="d_profile_setting_from" method="post" action="{{ route('user.cv.update') }}" enctype="multipart/form-data" id="cvForm">
            @csrf
            <input type="hidden" name="active_tab" id="active_tab" value="{{ $activeTab }}">
            <input type="hidden" name="next_tab" id="next_tab" value="">

            <section class="cv-tab-panel {{ $activeTab === 'personal' ? 'active' : '' }}" data-tab-panel="personal">
                <h5 class="cv-section-title">Personal Information</h5>
                <div class="cv-grid">
                    <div class="cv-field"><label>Full Name*</label><input type="text" name="full_name" value="{{ old('full_name', $cv->full_name ?? $user->name) }}"></div>
                    <div class="cv-field"><label>Email*</label><input type="email" name="email" value="{{ old('email', $cv->email ?? $user->email) }}"></div>
                    <div class="cv-field"><label>Mobile Number*</label><input type="text" name="mobile" value="{{ old('mobile', $cv->mobile ?? ($user->phone ?? '')) }}"></div>
                    <div class="cv-field"><label>Website / Portfolio URL</label><input type="text" name="website_url" value="{{ old('website_url', $cv->website_url ?? '') }}" placeholder="https://example.com"></div>
                    <div class="cv-field"><label>Date of Birth</label><input type="date" name="date_of_birth" value="{{ old('date_of_birth', $dateValue($cv->date_of_birth ?? null)) }}"></div>
                    <div class="cv-field"><label>Father's Name</label><input type="text" name="father_name" value="{{ old('father_name', $cv->father_name ?? '') }}"></div>
                    <div class="cv-field"><label>Mother's Name</label><input type="text" name="mother_name" value="{{ old('mother_name', $cv->mother_name ?? '') }}"></div>
                    <div class="cv-field">
                        <label>Gender</label>
                        <select name="gender">
                            @foreach(['' => 'Select Gender', 'Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('gender', $cv->gender ?? '') == $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="cv-field">
                        <label>Marital Status</label>
                        <select name="marital_status">
                            @foreach(['' => 'Select Marital Status', 'Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('marital_status', $cv->marital_status ?? '') == $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="cv-field"><label>Nationality</label><input type="text" name="nationality" value="{{ old('nationality', $cv->nationality ?? 'Bangladeshi') }}"></div>
                    <div class="cv-field"><label>Religion</label><input type="text" name="religion" value="{{ old('religion', $cv->religion ?? '') }}"></div>
                    <div class="cv-field"><label>National ID / Passport</label><input type="text" name="nid_or_passport" value="{{ old('nid_or_passport', $cv->nid_or_passport ?? '') }}"></div>
                    <div class="cv-field">
                        <label>Photo (300*300)px</label>
                        <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp,image/*">
                        @if($cv?->photo)<img src="{{ asset($cv->photo) }}" alt="CV photo" class="cv-preview-image">@endif
                    </div>
                    <div class="cv-field cv-full"><label>Present Address</label><textarea name="present_address">{{ old('present_address', $cv->present_address ?? '') }}</textarea></div>
                    <div class="cv-field cv-full"><label>Permanent Address</label><textarea name="permanent_address">{{ old('permanent_address', $cv->permanent_address ?? '') }}</textarea></div>
                </div>
                @include('user.cv.partials.actions', ['tab' => 'personal', 'next' => $nextTab('personal'), 'cv' => $cv])
            </section>

            <section class="cv-tab-panel {{ $activeTab === 'career' ? 'active' : '' }}" data-tab-panel="career">
                <h5 class="cv-section-title">Career Objective & Summary</h5>
                <div class="cv-grid">
                    <div class="cv-field cv-full"><label>Career Objective</label><textarea name="career_objective" placeholder="Write a short 2-4 line career objective">{{ old('career_objective', $cv->career_objective ?? '') }}</textarea></div>
                    <div class="cv-field"><label>Total Years of Experience</label><input type="number" step="0.01" min="0" name="total_experience" value="{{ old('total_experience', $cv->total_experience ?? '') }}"></div>
                    <div class="cv-field cv-full"><label>Career Summary / Profile Summary</label><textarea name="career_summary" placeholder="Sector, role, key skills, and achievements summary">{{ old('career_summary', $cv->career_summary ?? '') }}</textarea></div>
                </div>
                @include('user.cv.partials.actions', ['tab' => 'career', 'next' => $nextTab('career'), 'cv' => $cv])
            </section>

            <section class="cv-tab-panel {{ $activeTab === 'employment' ? 'active' : '' }}" data-tab-panel="employment" data-repeater="employments">
                <h5 class="cv-section-title">Employment History</h5>
                <div data-repeat-list>
                    @foreach($employments as $index => $employment)
                        <div class="cv-repeat-row" data-repeat-row>
                            <div class="cv-grid">
                                <div class="cv-field"><label>Company Name</label><input type="text" name="employments[{{ $index }}][company_name]" value="{{ $employment['company_name'] ?? '' }}"></div>
                                <div class="cv-field"><label>Designation</label><input type="text" name="employments[{{ $index }}][designation]" value="{{ $employment['designation'] ?? '' }}"></div>
                                <div class="cv-field"><label>Department</label><input type="text" name="employments[{{ $index }}][department]" value="{{ $employment['department'] ?? '' }}"></div>
                                <div class="cv-field"><label>Company Location</label><input type="text" name="employments[{{ $index }}][company_location]" value="{{ $employment['company_location'] ?? '' }}"></div>
                                <div class="cv-field"><label>Business Type</label><input type="text" name="employments[{{ $index }}][business_type]" value="{{ $employment['business_type'] ?? '' }}"></div>
                                <div class="cv-field"><label>Start Date</label><input type="date" name="employments[{{ $index }}][start_date]" value="{{ $dateValue($employment['start_date'] ?? null) }}"></div>
                                <div class="cv-field"><label>End Date</label><input type="date" name="employments[{{ $index }}][end_date]" value="{{ $dateValue($employment['end_date'] ?? null) }}"></div>
                                <label class="cv-toggle">
                                    <input type="hidden" name="employments[{{ $index }}][is_current]" value="0">
                                    <input type="checkbox" name="employments[{{ $index }}][is_current]" value="1" @checked(!empty($employment['is_current']))>
                                    <span></span><span>Currently Working</span>
                                </label>
                                <div class="cv-field cv-full"><label>Job Responsibilities</label><textarea name="employments[{{ $index }}][responsibilities]">{{ $employment['responsibilities'] ?? '' }}</textarea></div>
                                <div class="cv-field cv-full"><label>Major Achievements</label><textarea name="employments[{{ $index }}][achievements]">{{ $employment['achievements'] ?? '' }}</textarea></div>
                            </div>
                            <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="cv-small-btn add-row">Add Employment</button>
                @include('user.cv.partials.actions', ['tab' => 'employment', 'next' => $nextTab('employment'), 'cv' => $cv])
            </section>

            <section class="cv-tab-panel {{ $activeTab === 'academic' ? 'active' : '' }}" data-tab-panel="academic" data-repeater="academics">
                <h5 class="cv-section-title">Academic Qualification</h5>
                <div data-repeat-list>
                    @foreach($academics as $index => $academic)
                        <div class="cv-repeat-row" data-repeat-row>
                            <div class="cv-grid three">
                                <div class="cv-field"><label>Exam / Degree</label><input type="text" name="academics[{{ $index }}][degree_name]" value="{{ $academic['degree_name'] ?? '' }}"></div>
                                <div class="cv-field"><label>Institution</label><input type="text" name="academics[{{ $index }}][institution]" value="{{ $academic['institution'] ?? '' }}"></div>
                                <div class="cv-field"><label>Board / University</label><input type="text" name="academics[{{ $index }}][board_or_university]" value="{{ $academic['board_or_university'] ?? '' }}"></div>
                                <div class="cv-field"><label>Group / Major</label><input type="text" name="academics[{{ $index }}][group_or_major]" value="{{ $academic['group_or_major'] ?? '' }}"></div>
                                <div class="cv-field"><label>Result / CGPA</label><input type="text" name="academics[{{ $index }}][result]" value="{{ $academic['result'] ?? '' }}"></div>
                                <div class="cv-field"><label>Passing Year</label><input type="text" name="academics[{{ $index }}][passing_year]" value="{{ $academic['passing_year'] ?? '' }}"></div>
                            </div>
                            <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="cv-small-btn add-row">Add Academic Record</button>
                @include('user.cv.partials.actions', ['tab' => 'academic', 'next' => $nextTab('academic'), 'cv' => $cv])
            </section>

            <section class="cv-tab-panel {{ $activeTab === 'training' ? 'active' : '' }}" data-tab-panel="training" data-repeater="trainings">
                <h5 class="cv-section-title">Training / Certification</h5>
                <div data-repeat-list>
                    @foreach($trainings as $index => $training)
                        <div class="cv-repeat-row" data-repeat-row>
                            <div class="cv-grid">
                                <div class="cv-field"><label>Training Title</label><input type="text" name="trainings[{{ $index }}][training_title]" value="{{ $training['training_title'] ?? '' }}"></div>
                                <div class="cv-field"><label>Institute</label><input type="text" name="trainings[{{ $index }}][institute]" value="{{ $training['institute'] ?? '' }}"></div>
                                <div class="cv-field"><label>Duration</label><input type="text" name="trainings[{{ $index }}][duration]" value="{{ $training['duration'] ?? '' }}"></div>
                                <div class="cv-field"><label>Year</label><input type="text" name="trainings[{{ $index }}][year]" value="{{ $training['year'] ?? '' }}"></div>
                                <div class="cv-field cv-full"><label>Certificate Details</label><textarea name="trainings[{{ $index }}][certificate_details]">{{ $training['certificate_details'] ?? '' }}</textarea></div>
                            </div>
                            <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="cv-small-btn add-row">Add Training</button>
                @include('user.cv.partials.actions', ['tab' => 'training', 'next' => $nextTab('training'), 'cv' => $cv])
            </section>

            <section class="cv-tab-panel {{ $activeTab === 'professional' ? 'active' : '' }}" data-tab-panel="professional" data-repeater="professional_qualifications">
                <h5 class="cv-section-title">Professional Qualification</h5>
                <div data-repeat-list>
                    @foreach($qualifications as $index => $qualification)
                        <div class="cv-repeat-row" data-repeat-row>
                            <div class="cv-grid">
                                <div class="cv-field"><label>Title</label><input type="text" name="professional_qualifications[{{ $index }}][title]" value="{{ $qualification['title'] ?? '' }}"></div>
                                <div class="cv-field"><label>Institute / Authority</label><input type="text" name="professional_qualifications[{{ $index }}][authority]" value="{{ $qualification['authority'] ?? '' }}"></div>
                                <div class="cv-field"><label>Result / Score</label><input type="text" name="professional_qualifications[{{ $index }}][result_or_score]" value="{{ $qualification['result_or_score'] ?? '' }}"></div>
                                <div class="cv-field"><label>Year</label><input type="text" name="professional_qualifications[{{ $index }}][year]" value="{{ $qualification['year'] ?? '' }}"></div>
                                <div class="cv-field cv-full"><label>Details</label><textarea name="professional_qualifications[{{ $index }}][details]">{{ $qualification['details'] ?? '' }}</textarea></div>
                            </div>
                            <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="cv-small-btn add-row">Add Qualification</button>
                @include('user.cv.partials.actions', ['tab' => 'professional', 'next' => $nextTab('professional'), 'cv' => $cv])
            </section>

            <section class="cv-tab-panel {{ $activeTab === 'skills' ? 'active' : '' }}" data-tab-panel="skills" data-repeater="skills">
                <h5 class="cv-section-title">Skills</h5>
                <div data-repeat-list>
                    @foreach($skills as $index => $skill)
                        <div class="cv-repeat-row" data-repeat-row>
                            <div class="cv-grid three">
                                <div class="cv-field">
                                    <label>Skill Type</label>
                                    <select name="skills[{{ $index }}][skill_type]">
                                        @foreach(['Computer Skills', 'Software Skills', 'Language Skills', 'Technical Skills', 'Job-related Skills'] as $type)
                                            <option value="{{ $type }}" @selected(($skill['skill_type'] ?? '') == $type)>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="cv-field"><label>Skill Name</label><input type="text" name="skills[{{ $index }}][skill_name]" value="{{ $skill['skill_name'] ?? '' }}"></div>
                                <div class="cv-field"><label>Skill Level</label><input type="text" name="skills[{{ $index }}][skill_level]" value="{{ $skill['skill_level'] ?? '' }}" placeholder="Beginner, Good, Expert"></div>
                            </div>
                            <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="cv-small-btn add-row">Add Skill</button>
                @include('user.cv.partials.actions', ['tab' => 'skills', 'next' => $nextTab('skills'), 'cv' => $cv])
            </section>

            <section class="cv-tab-panel {{ $activeTab === 'language' ? 'active' : '' }}" data-tab-panel="language" data-repeater="languages">
                <h5 class="cv-section-title">Language Proficiency</h5>
                <div data-repeat-list>
                    @foreach($languages as $index => $language)
                        <div class="cv-repeat-row" data-repeat-row>
                            <div class="cv-grid">
                                <div class="cv-field"><label>Language Name</label><input type="text" name="languages[{{ $index }}][language_name]" value="{{ $language['language_name'] ?? '' }}"></div>
                                @foreach(['reading_level' => 'Reading Level', 'writing_level' => 'Writing Level', 'speaking_level' => 'Speaking Level'] as $field => $label)
                                    <div class="cv-field">
                                        <label>{{ $label }}</label>
                                        <select name="languages[{{ $index }}][{{ $field }}]">
                                            @foreach(['' => 'Select Level', 'Basic' => 'Basic', 'Good' => 'Good', 'Excellent' => 'Excellent', 'Native' => 'Native'] as $value => $option)
                                                <option value="{{ $value }}" @selected(($language[$field] ?? '') == $value)>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                            <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="cv-small-btn add-row">Add Language</button>
                @include('user.cv.partials.actions', ['tab' => 'language', 'next' => $nextTab('language'), 'cv' => $cv])
            </section>

            <section class="cv-tab-panel {{ $activeTab === 'references' ? 'active' : '' }}" data-tab-panel="references" data-repeater="references">
                <h5 class="cv-section-title">References</h5>
                <div data-repeat-list>
                    @foreach($references as $index => $reference)
                        <div class="cv-repeat-row" data-repeat-row>
                            <div class="cv-grid">
                                <div class="cv-field"><label>Name</label><input type="text" name="references[{{ $index }}][name]" value="{{ $reference['name'] ?? '' }}"></div>
                                <div class="cv-field"><label>Designation</label><input type="text" name="references[{{ $index }}][designation]" value="{{ $reference['designation'] ?? '' }}"></div>
                                <div class="cv-field"><label>Organization</label><input type="text" name="references[{{ $index }}][organization]" value="{{ $reference['organization'] ?? '' }}"></div>
                                <div class="cv-field"><label>Phone</label><input type="text" name="references[{{ $index }}][phone]" value="{{ $reference['phone'] ?? '' }}"></div>
                                <div class="cv-field"><label>Email</label><input type="email" name="references[{{ $index }}][email]" value="{{ $reference['email'] ?? '' }}"></div>
                                <div class="cv-field"><label>Relationship</label><input type="text" name="references[{{ $index }}][relationship]" value="{{ $reference['relationship'] ?? '' }}"></div>
                            </div>
                            <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="cv-small-btn add-row">Add Reference</button>
                @include('user.cv.partials.actions', ['tab' => 'references', 'next' => $nextTab('references'), 'cv' => $cv])
            </section>

            <section class="cv-tab-panel {{ $activeTab === 'declaration' ? 'active' : '' }}" data-tab-panel="declaration">
                <h5 class="cv-section-title">Declaration / Signature</h5>
                <div class="cv-grid">
                    <div class="cv-field cv-full"><label>Declaration Text</label><textarea name="declaration">{{ old('declaration', $cv->declaration ?? 'I hereby declare that the information given above is true and correct to the best of my knowledge.') }}</textarea></div>
                    <div class="cv-field"><label>Declaration Date</label><input type="date" name="declaration_date" value="{{ old('declaration_date', $dateValue($cv->declaration_date ?? now())) }}"></div>
                    <div class="cv-field">
                        <label>Signature Image (300*80)px</label>
                        <input type="file" name="signature" accept=".jpg,.jpeg,.png,.webp,image/*">
                        @if($cv?->signature)<img src="{{ asset($cv->signature) }}" alt="Signature" class="cv-preview-image">@endif
                    </div>
                </div>
                @include('user.cv.partials.actions', ['tab' => 'declaration', 'next' => $nextTab('declaration'), 'cv' => $cv])
            </section>

            <section class="cv-tab-panel {{ $activeTab === 'settings' ? 'active' : '' }}" data-tab-panel="settings">
                <h5 class="cv-section-title">CV Settings</h5>
                <div class="cv-grid">
                    <div class="cv-field cv-full">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 7px;">
                            <label style="margin: 0;">CV Template*</label>
                            @if($cv)
                                <a href="{{ route('user.cv.preview') }}" target="_blank" class="cv-secondary-btn" style="padding: 4px 10px; font-size: 12px; height: auto; min-height: auto;">
                                    <i class="fas fa-eye"></i> View Live Preview
                                </a>
                            @endif
                        </div>
                        <div class="cv-template-options">
                            @foreach($templates as $template)
                                <label class="cv-template-card">
                                    <input type="radio" name="template_id" value="{{ $template->id }}" @checked(old('template_id', $cv->template_id ?? $templates->first()?->id) == $template->id)>
                                    <strong>{{ $template->name }}</strong>
                                    @if($template->preview_image)
                                        <img src="{{ asset($template->preview_image) }}" alt="{{ $template->name }}" class="cv-preview-image">
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                        <div class="cv-toggle-grid cv-full">
                            <label class="cv-toggle">
                                <input type="hidden" name="is_public" value="0">
                                <input type="checkbox" name="is_public" value="1" @checked(old('is_public', $cv->is_public ?? false))>
                                <span></span><span>CV public হবে</span>
                            </label>
                            @if($cv?->is_public)
                                <div style="grid-column: span 2; display: flex; align-items: center; gap: 10px; background: #f8fafc; border: 1px solid #dbe3ef; padding: 12px; border-radius: 8px;">
                                    <div style="flex: 1; font-size: 13px; color: #0a165e; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <strong>Digital CV (user web link):</strong> <span id="publicCvLink">{{ url($user->username ?: 'cv/id/'.$user->id) }}</span>
                                    </div>
                                    <button type="button" class="cv-small-btn" onclick="copyToClipboard('{{ url($user->username ?: 'cv/id/'.$user->id) }}')" title="Copy Link">
                                        <i class="fas fa-copy"></i> Copy Link
                                    </button>
                                </div>
                            @endif
                            <label class="cv-toggle">
                                <input type="hidden" name="public_print_enabled" value="0">
                                <input type="checkbox" name="public_print_enabled" value="1" @checked(old('public_print_enabled', $cv->public_print_enabled ?? false))>
                                <span></span><span>Public visitor print করতে পারবে</span>
                            </label>
                            <label class="cv-toggle">
                                <input type="hidden" name="public_pdf_enabled" value="0">
                                <input type="checkbox" name="public_pdf_enabled" value="1" @checked(old('public_pdf_enabled', $cv->public_pdf_enabled ?? false))>
                                <span></span><span>Public visitor PDF download করতে পারবে</span>
                            </label>
                        </div>
                </div>
                @include('user.cv.partials.actions', ['tab' => 'settings', 'next' => 'settings', 'cv' => $cv, 'last' => true])
            </section>
        </form>
    </div>
@endsection

@push('js_section')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Public link copied to clipboard!');
            });
        }

        (function () {
            const form = document.getElementById('cvForm');
            const activeInput = document.getElementById('active_tab');
            const nextInput = document.getElementById('next_tab');

            function showTab(tab) {
                document.querySelectorAll('[data-tab-target]').forEach(function (button) {
                    button.classList.toggle('active', button.dataset.tabTarget === tab);
                });

                document.querySelectorAll('[data-tab-panel]').forEach(function (panel) {
                    panel.classList.toggle('active', panel.dataset.tabPanel === tab);
                });

                activeInput.value = tab;
                nextInput.value = '';
            }

            function reindex(section) {
                const key = section.dataset.repeater;
                section.querySelectorAll('[data-repeat-row]').forEach(function (row, index) {
                    row.querySelectorAll('[name]').forEach(function (field) {
                        field.name = field.name.replace(new RegExp(key + '\\[[0-9]+\\]'), key + '[' + index + ']');
                    });
                });
            }

            document.querySelectorAll('[data-tab-target]').forEach(function (button) {
                button.addEventListener('click', function () {
                    showTab(button.dataset.tabTarget);
                });
            });

            document.querySelectorAll('[data-repeater]').forEach(function (section) {
                section.addEventListener('click', function (event) {
                    if (event.target.classList.contains('add-row')) {
                        const list = section.querySelector('[data-repeat-list]');
                        const clone = list.querySelector('[data-repeat-row]').cloneNode(true);

                        clone.querySelectorAll('input, textarea, select').forEach(function (field) {
                            if (field.type === 'checkbox') {
                                field.checked = false;
                            } else if (field.type !== 'hidden') {
                                field.value = '';
                            }
                        });

                        list.appendChild(clone);
                        reindex(section);
                    }

                    if (event.target.classList.contains('remove-row')) {
                        const list = section.querySelector('[data-repeat-list]');
                        if (list.querySelectorAll('[data-repeat-row]').length > 1) {
                            event.target.closest('[data-repeat-row]').remove();
                            reindex(section);
                        }
                    }
                });
            });

            document.querySelectorAll('[data-save-next]').forEach(function (button) {
                button.addEventListener('click', function () {
                    activeInput.value = button.dataset.currentTab;
                    nextInput.value = button.dataset.saveNext;
                    form.submit();
                });
            });

            document.querySelectorAll('[data-save-tab]').forEach(function (button) {
                button.addEventListener('click', function () {
                    activeInput.value = button.dataset.saveTab;
                    nextInput.value = '';
                });
            });
        })();
    </script>
@endpush
