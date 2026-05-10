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

    $dateValue = fn($value) => $value ? \Illuminate\Support\Carbon::parse($value)->format('Y-m-d') : '';
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
        .cv-editor-section {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 18px;
            margin-bottom: 18px;
            background: #fff;
        }

        .cv-editor-section h5 {
            margin: 0 0 14px;
            color: #0a165e;
        }

        .cv-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .cv-grid.three {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .cv-full {
            grid-column: 1 / -1;
        }

        .cv-editor-section textarea {
            min-height: 96px;
            resize: vertical;
        }

        .cv-repeat-row {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 14px;
            margin-bottom: 12px;
            background: #f8fafc;
        }

        .cv-repeat-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 10px;
        }

        .cv-small-btn {
            border: 1px solid #0a165e;
            border-radius: 4px;
            padding: 7px 12px;
            background: #0a165e;
            color: #fff;
            font-weight: 700;
        }

        .cv-small-btn.remove-row {
            border-color: #dc2626;
            background: #dc2626;
        }

        .cv-checks {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .cv-check {
            display: flex;
            align-items: center;
            gap: 8px;
            min-height: 48px;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #f8fafc;
        }

        .cv-form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .cv-preview-image {
            width: 92px;
            height: 110px;
            object-fit: cover;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            margin-top: 8px;
        }

        @media (max-width: 767px) {
            .cv-grid,
            .cv-grid.three,
            .cv-checks {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('dashboard-content')
    <div class="dashbord_titel">
        <h4>Digital CV</h4>
    </div>

    <form class="d_profile_setting_from" method="post" action="{{ route('user.cv.update') }}" enctype="multipart/form-data">
        @csrf

        <section class="cv-editor-section">
            <h5>Personal Information</h5>
            <div class="cv-grid">
                <div class="optech-checkout-field">
                    <label>Full Name*</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $cv->full_name ?? $user->name) }}">
                </div>
                <div class="optech-checkout-field">
                    <label>Email*</label>
                    <input type="email" name="email" value="{{ old('email', $cv->email ?? $user->email) }}">
                </div>
                <div class="optech-checkout-field">
                    <label>Mobile Number*</label>
                    <input type="text" name="mobile" value="{{ old('mobile', $cv->mobile ?? ($user->phone ?? '')) }}">
                </div>
                <div class="optech-checkout-field">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $dateValue($cv->date_of_birth ?? null)) }}">
                </div>
                <div class="optech-checkout-field">
                    <label>Father's Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name', $cv->father_name ?? '') }}">
                </div>
                <div class="optech-checkout-field">
                    <label>Mother's Name</label>
                    <input type="text" name="mother_name" value="{{ old('mother_name', $cv->mother_name ?? '') }}">
                </div>
                <div class="optech-checkout-field">
                    <label>Gender</label>
                    <select name="gender">
                        @foreach(['' => 'Select', 'Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('gender', $cv->gender ?? '') == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="optech-checkout-field">
                    <label>Marital Status</label>
                    <select name="marital_status">
                        @foreach(['' => 'Select', 'Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('marital_status', $cv->marital_status ?? '') == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="optech-checkout-field">
                    <label>Nationality</label>
                    <input type="text" name="nationality" value="{{ old('nationality', $cv->nationality ?? 'Bangladeshi') }}">
                </div>
                <div class="optech-checkout-field">
                    <label>Religion</label>
                    <input type="text" name="religion" value="{{ old('religion', $cv->religion ?? '') }}">
                </div>
                <div class="optech-checkout-field">
                    <label>National ID / Passport</label>
                    <input type="text" name="nid_or_passport" value="{{ old('nid_or_passport', $cv->nid_or_passport ?? '') }}">
                </div>
                <div class="optech-checkout-field">
                    <label>Photo</label>
                    <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp,image/*">
                    @if($cv?->photo)
                        <img src="{{ asset($cv->photo) }}" alt="CV photo" class="cv-preview-image">
                    @endif
                </div>
                <div class="optech-checkout-field cv-full">
                    <label>Present Address</label>
                    <textarea name="present_address">{{ old('present_address', $cv->present_address ?? '') }}</textarea>
                </div>
                <div class="optech-checkout-field cv-full">
                    <label>Permanent Address</label>
                    <textarea name="permanent_address">{{ old('permanent_address', $cv->permanent_address ?? '') }}</textarea>
                </div>
            </div>
        </section>

        <section class="cv-editor-section">
            <h5>Career Objective</h5>
            <div class="optech-checkout-field">
                <textarea name="career_objective" placeholder="Write a short 2-4 line career objective">{{ old('career_objective', $cv->career_objective ?? '') }}</textarea>
            </div>
        </section>

        <section class="cv-editor-section">
            <h5>Career Summary / Profile Summary</h5>
            <div class="cv-grid">
                <div class="optech-checkout-field">
                    <label>Total Years of Experience</label>
                    <input type="number" step="0.01" min="0" name="total_experience" value="{{ old('total_experience', $cv->total_experience ?? '') }}">
                </div>
                <div class="optech-checkout-field cv-full">
                    <label>Sector, role, key skills, and achievements summary</label>
                    <textarea name="career_summary">{{ old('career_summary', $cv->career_summary ?? '') }}</textarea>
                </div>
            </div>
        </section>

        <section class="cv-editor-section" data-repeater="employments">
            <h5>Employment History</h5>
            <div data-repeat-list>
                @foreach($employments as $index => $employment)
                    <div class="cv-repeat-row" data-repeat-row>
                        <div class="cv-grid">
                            <div class="optech-checkout-field"><label>Company Name</label><input type="text" name="employments[{{ $index }}][company_name]" value="{{ $employment['company_name'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Designation</label><input type="text" name="employments[{{ $index }}][designation]" value="{{ $employment['designation'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Department</label><input type="text" name="employments[{{ $index }}][department]" value="{{ $employment['department'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Company Location</label><input type="text" name="employments[{{ $index }}][company_location]" value="{{ $employment['company_location'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Business Type</label><input type="text" name="employments[{{ $index }}][business_type]" value="{{ $employment['business_type'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Start Date</label><input type="date" name="employments[{{ $index }}][start_date]" value="{{ $dateValue($employment['start_date'] ?? null) }}"></div>
                            <div class="optech-checkout-field"><label>End Date</label><input type="date" name="employments[{{ $index }}][end_date]" value="{{ $dateValue($employment['end_date'] ?? null) }}"></div>
                            <label class="cv-check">
                                <input type="hidden" name="employments[{{ $index }}][is_current]" value="0">
                                <input type="checkbox" name="employments[{{ $index }}][is_current]" value="1" @checked(!empty($employment['is_current']))>
                                Currently Working
                            </label>
                            <div class="optech-checkout-field cv-full"><label>Job Responsibilities</label><textarea name="employments[{{ $index }}][responsibilities]">{{ $employment['responsibilities'] ?? '' }}</textarea></div>
                            <div class="optech-checkout-field cv-full"><label>Major Achievements</label><textarea name="employments[{{ $index }}][achievements]">{{ $employment['achievements'] ?? '' }}</textarea></div>
                        </div>
                        <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="cv-small-btn add-row">Add Employment</button>
        </section>

        <section class="cv-editor-section" data-repeater="academics">
            <h5>Academic Qualification</h5>
            <div data-repeat-list>
                @foreach($academics as $index => $academic)
                    <div class="cv-repeat-row" data-repeat-row>
                        <div class="cv-grid three">
                            <div class="optech-checkout-field"><label>Exam / Degree</label><input type="text" name="academics[{{ $index }}][degree_name]" value="{{ $academic['degree_name'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Institution</label><input type="text" name="academics[{{ $index }}][institution]" value="{{ $academic['institution'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Board / University</label><input type="text" name="academics[{{ $index }}][board_or_university]" value="{{ $academic['board_or_university'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Group / Major</label><input type="text" name="academics[{{ $index }}][group_or_major]" value="{{ $academic['group_or_major'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Result / CGPA</label><input type="text" name="academics[{{ $index }}][result]" value="{{ $academic['result'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Passing Year</label><input type="text" name="academics[{{ $index }}][passing_year]" value="{{ $academic['passing_year'] ?? '' }}"></div>
                        </div>
                        <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="cv-small-btn add-row">Add Academic Record</button>
        </section>

        <section class="cv-editor-section" data-repeater="trainings">
            <h5>Training / Certification</h5>
            <div data-repeat-list>
                @foreach($trainings as $index => $training)
                    <div class="cv-repeat-row" data-repeat-row>
                        <div class="cv-grid">
                            <div class="optech-checkout-field"><label>Training Title</label><input type="text" name="trainings[{{ $index }}][training_title]" value="{{ $training['training_title'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Institute</label><input type="text" name="trainings[{{ $index }}][institute]" value="{{ $training['institute'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Duration</label><input type="text" name="trainings[{{ $index }}][duration]" value="{{ $training['duration'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Year</label><input type="text" name="trainings[{{ $index }}][year]" value="{{ $training['year'] ?? '' }}"></div>
                            <div class="optech-checkout-field cv-full"><label>Certificate Details</label><textarea name="trainings[{{ $index }}][certificate_details]">{{ $training['certificate_details'] ?? '' }}</textarea></div>
                        </div>
                        <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="cv-small-btn add-row">Add Training</button>
        </section>

        <section class="cv-editor-section" data-repeater="professional_qualifications">
            <h5>Professional Qualification</h5>
            <div data-repeat-list>
                @foreach($qualifications as $index => $qualification)
                    <div class="cv-repeat-row" data-repeat-row>
                        <div class="cv-grid">
                            <div class="optech-checkout-field"><label>Title</label><input type="text" name="professional_qualifications[{{ $index }}][title]" value="{{ $qualification['title'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Institute / Authority</label><input type="text" name="professional_qualifications[{{ $index }}][authority]" value="{{ $qualification['authority'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Result / Score</label><input type="text" name="professional_qualifications[{{ $index }}][result_or_score]" value="{{ $qualification['result_or_score'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Year</label><input type="text" name="professional_qualifications[{{ $index }}][year]" value="{{ $qualification['year'] ?? '' }}"></div>
                            <div class="optech-checkout-field cv-full"><label>Details</label><textarea name="professional_qualifications[{{ $index }}][details]">{{ $qualification['details'] ?? '' }}</textarea></div>
                        </div>
                        <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="cv-small-btn add-row">Add Qualification</button>
        </section>

        <section class="cv-editor-section" data-repeater="skills">
            <h5>Skills</h5>
            <div data-repeat-list>
                @foreach($skills as $index => $skill)
                    <div class="cv-repeat-row" data-repeat-row>
                        <div class="cv-grid three">
                            <div class="optech-checkout-field">
                                <label>Skill Type</label>
                                <select name="skills[{{ $index }}][skill_type]">
                                    @foreach(['Computer Skills', 'Software Skills', 'Language Skills', 'Technical Skills', 'Job-related Skills'] as $type)
                                        <option value="{{ $type }}" @selected(($skill['skill_type'] ?? '') == $type)>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="optech-checkout-field"><label>Skill Name</label><input type="text" name="skills[{{ $index }}][skill_name]" value="{{ $skill['skill_name'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Skill Level</label><input type="text" name="skills[{{ $index }}][skill_level]" value="{{ $skill['skill_level'] ?? '' }}" placeholder="Beginner, Good, Expert"></div>
                        </div>
                        <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="cv-small-btn add-row">Add Skill</button>
        </section>

        <section class="cv-editor-section" data-repeater="languages">
            <h5>Language Proficiency</h5>
            <div data-repeat-list>
                @foreach($languages as $index => $language)
                    <div class="cv-repeat-row" data-repeat-row>
                        <div class="cv-grid">
                            <div class="optech-checkout-field"><label>Language Name</label><input type="text" name="languages[{{ $index }}][language_name]" value="{{ $language['language_name'] ?? '' }}"></div>
                            @foreach(['reading_level' => 'Reading Level', 'writing_level' => 'Writing Level', 'speaking_level' => 'Speaking Level'] as $field => $label)
                                <div class="optech-checkout-field">
                                    <label>{{ $label }}</label>
                                    <select name="languages[{{ $index }}][{{ $field }}]">
                                        @foreach(['' => 'Select', 'Basic' => 'Basic', 'Good' => 'Good', 'Excellent' => 'Excellent', 'Native' => 'Native'] as $value => $option)
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
        </section>

        <section class="cv-editor-section" data-repeater="references">
            <h5>References</h5>
            <div data-repeat-list>
                @foreach($references as $index => $reference)
                    <div class="cv-repeat-row" data-repeat-row>
                        <div class="cv-grid">
                            <div class="optech-checkout-field"><label>Name</label><input type="text" name="references[{{ $index }}][name]" value="{{ $reference['name'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Designation</label><input type="text" name="references[{{ $index }}][designation]" value="{{ $reference['designation'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Organization</label><input type="text" name="references[{{ $index }}][organization]" value="{{ $reference['organization'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Phone</label><input type="text" name="references[{{ $index }}][phone]" value="{{ $reference['phone'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Email</label><input type="email" name="references[{{ $index }}][email]" value="{{ $reference['email'] ?? '' }}"></div>
                            <div class="optech-checkout-field"><label>Relationship</label><input type="text" name="references[{{ $index }}][relationship]" value="{{ $reference['relationship'] ?? '' }}"></div>
                        </div>
                        <div class="cv-repeat-actions"><button type="button" class="cv-small-btn remove-row">Remove</button></div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="cv-small-btn add-row">Add Reference</button>
        </section>

        <section class="cv-editor-section">
            <h5>Declaration / Signature</h5>
            <div class="cv-grid">
                <div class="optech-checkout-field cv-full">
                    <label>Declaration Text</label>
                    <textarea name="declaration">{{ old('declaration', $cv->declaration ?? 'I hereby declare that the information given above is true and correct to the best of my knowledge.') }}</textarea>
                </div>
                <div class="optech-checkout-field">
                    <label>Declaration Date</label>
                    <input type="date" name="declaration_date" value="{{ old('declaration_date', $dateValue($cv->declaration_date ?? now())) }}">
                </div>
                <div class="optech-checkout-field">
                    <label>Signature Image</label>
                    <input type="file" name="signature" accept=".jpg,.jpeg,.png,.webp,image/*">
                    @if($cv?->signature)
                        <img src="{{ asset($cv->signature) }}" alt="Signature" class="cv-preview-image">
                    @endif
                </div>
            </div>
        </section>

        <section class="cv-editor-section">
            <h5>CV Settings</h5>
            <div class="cv-grid">
                <div class="optech-checkout-field">
                    <label>CV Template*</label>
                    <select name="template_id">
                        <option value="">Select Template</option>
                        @foreach($templates as $template)
                            <option value="{{ $template->id }}" @selected(old('template_id', $cv->template_id ?? $templates->first()?->id) == $template->id)>{{ $template->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cv-checks cv-full">
                    <label class="cv-check">
                        <input type="hidden" name="is_public" value="0">
                        <input type="checkbox" name="is_public" value="1" @checked(old('is_public', $cv->is_public ?? false))>
                        CV public হবে
                    </label>
                    <label class="cv-check">
                        <input type="hidden" name="public_print_enabled" value="0">
                        <input type="checkbox" name="public_print_enabled" value="1" @checked(old('public_print_enabled', $cv->public_print_enabled ?? false))>
                        Public visitor print করতে পারবে
                    </label>
                    <label class="cv-check">
                        <input type="hidden" name="public_pdf_enabled" value="0">
                        <input type="checkbox" name="public_pdf_enabled" value="1" @checked(old('public_pdf_enabled', $cv->public_pdf_enabled ?? false))>
                        Public visitor PDF download করতে পারবে
                    </label>
                </div>
            </div>
        </section>

        <div class="cv-form-actions">
            <button type="submit" class="optech-default-btn" data-text="{{ __('translate.Update Now') }}">
                <span class="btn-wraper">Save Digital CV</span>
            </button>
            @if($cv)
                <a href="{{ route('user.cv.preview') }}" target="_blank" class="optech-default-btn two" data-text="Preview CV">
                    <span class="btn-wraper">Preview CV</span>
                </a>
            @endif
        </div>
    </form>
@endsection

@push('js_section')
    <script>
        (function () {
            function reindex(section) {
                const key = section.dataset.repeater;
                section.querySelectorAll('[data-repeat-row]').forEach(function (row, index) {
                    row.querySelectorAll('[name]').forEach(function (field) {
                        field.name = field.name.replace(new RegExp(key + '\\[[0-9]+\\]'), key + '[' + index + ']');
                    });
                });
            }

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
        })();
    </script>
@endpush
