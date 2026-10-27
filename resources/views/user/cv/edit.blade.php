@extends('user.dashboard_layout')

@php
    $emptyEmployment = ['company_name' => '', 'designation' => '', 'department' => '', 'start_date' => '', 'end_date' => '', 'is_current' => 0, 'responsibilities' => '', 'achievements' => '', 'company_location' => '', 'business_type' => ''];
    $emptyProject = ['title' => '', 'role' => '', 'technologies' => '', 'link' => '', 'github_url' => '', 'demo_user' => '', 'demo_password' => '', 'description' => '', 'problem' => '', 'solution' => ''];
    $emptyAcademic = ['degree_name' => '', 'institution' => '', 'board_or_university' => '', 'group_or_major' => '', 'result' => '', 'passing_year' => ''];
    $emptyTraining = ['training_title' => '', 'institute' => '', 'duration' => '', 'year' => '', 'certificate_details' => ''];
    $emptyQualification = ['title' => '', 'authority' => '', 'result_or_score' => '', 'year' => '', 'details' => ''];
    $emptySkill = ['skill_type' => '', 'skill_name' => '', 'skill_level' => ''];
    $emptyLanguage = ['language_name' => '', 'reading_level' => '', 'writing_level' => '', 'speaking_level' => ''];
    $emptyReference = ['name' => '', 'designation' => '', 'organization' => '', 'phone' => '', 'email' => '', 'relationship' => ''];

    $employments = old('employments', $cv ? $cv->employments->toArray() : []);
    $projects = old('projects', $cv ? $cv->projects->toArray() : []);
    $academics = old('academics', $cv ? $cv->academics->toArray() : []);
    $trainings = old('trainings', $cv ? $cv->trainings->toArray() : []);
    $qualifications = old('professional_qualifications', $cv ? $cv->professionalQualifications->toArray() : []);
    $skills = old('skills', $cv ? $cv->skills->toArray() : []);
    $languages = old('languages', $cv ? $cv->languages->toArray() : []);
    $references = old('references', $cv ? $cv->references->toArray() : []);

    $employments = count($employments) ? $employments : [$emptyEmployment];
    $projects = count($projects) ? $projects : [$emptyProject];
    $academics = count($academics) ? $academics : [$emptyAcademic];
    $trainings = count($trainings) ? $trainings : [$emptyTraining];
    $qualifications = count($qualifications) ? $qualifications : [$emptyQualification];
    $skills = count($skills) ? $skills : [$emptySkill];
    $languages = count($languages) ? $languages : [$emptyLanguage];
    $references = count($references) ? $references : [$emptyReference];

    $photoUrl = $cv?->photo ? asset($cv->photo) : ($user->image ? asset($user->image) : asset($general_setting->default_avatar ?? 'uploads/website-images/avatar-image-2024-07-02-10-08-24-5849.png'));
    $headline = $cv?->employments?->first()?->designation ?? 'Software Engineer';
@endphp

@section('title')
    <title>FlowCV Studio · {{ $cv?->full_name ?: $user->name }}</title>
@endsection

@section('breadcrumb')
@endsection

@push('style_section')
<style>
    /* =========================================================
       FLOWCV MODERN STUDIO ARCHITECTURE
       ========================================================= */
    :root {
        --fcv-bg: #f4f6fb;
        --fcv-card: #ffffff;
        --fcv-border: #e2e8f0;
        --fcv-border-hover: #cbd5e1;
        --fcv-text: #0f172a;
        --fcv-muted: #64748b;
        --fcv-accent: #e11d48;
        --fcv-accent-soft: #ffe4e6;
        --fcv-navy: #172c47;
        --fcv-navy-dark: #0f1f33;
        --fcv-navy-light: #244165;
        --fcv-primary: #0f172a;
        --fcv-success: #10b981;
        --fcv-shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.05);
        --fcv-shadow-md: 0 4px 12px rgba(15, 23, 42, 0.08);
        --fcv-shadow-lg: 0 12px 28px rgba(15, 23, 42, 0.12);
        --fcv-radius: 10px;
    }

    /* Force Fullscreen Studio Mode */
    body.flowcv-studio-active .dashbord_sidebar,
    body.flowcv-studio-active .optech-breadcrumb {
        display: none !important;
    }
    body.flowcv-studio-active .col-xxl-9 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding: 0 !important;
    }
    body.flowcv-studio-active .container {
        max-width: 100% !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    body.flowcv-studio-active .optech-section-padding {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
    body.flowcv-studio-active .dashbord_bg {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        box-shadow: none !important;
    }

    .flowcv-root {
        background: var(--fcv-bg);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: var(--fcv-text);
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    /* Top FlowCV Navigation Header */
    .flowcv-navbar {
        position: sticky;
        top: 0;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 24px;
        background: #ffffff;
        border-bottom: 1px solid var(--fcv-border);
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .flowcv-nav-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .flowcv-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        border-radius: 8px;
        border: 1px solid var(--fcv-border);
        background: #f8fafc;
        color: var(--fcv-text);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .flowcv-back-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .flowcv-nav-tabs {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 999px;
    }

    .flowcv-nav-tab {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        color: var(--fcv-muted);
        border: none;
        background: transparent;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .flowcv-nav-tab:hover {
        color: var(--fcv-text);
    }

    .flowcv-nav-tab.active {
        background: var(--fcv-accent-soft);
        color: var(--fcv-accent);
        box-shadow: 0 2px 6px rgba(225, 29, 72, 0.15);
    }

    .flowcv-nav-tab.active i {
        color: var(--fcv-accent);
    }

    .flowcv-nav-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .flowcv-resume-dropdown {
        padding: 8px 14px;
        background: #f8fafc;
        border: 1px solid var(--fcv-border);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        cursor: pointer;
    }

    .flowcv-btn-download {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        background: #172c47;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        border-radius: 8px;
        border: none;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 4px 10px rgba(23, 44, 71, 0.2);
    }

    .flowcv-btn-download:hover {
        background: #0f1f33;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .flowcv-btn-save {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: #10b981;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .flowcv-btn-save:hover {
        background: #059669;
    }

    .flowcv-save-status {
        font-size: 12px;
        font-weight: 600;
        color: var(--fcv-muted);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .flowcv-save-status.saved {
        color: var(--fcv-success);
    }

    .flowcv-more-dropdown {
        position: relative;
    }

    .flowcv-btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1px solid var(--fcv-border);
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--fcv-muted);
        cursor: pointer;
        transition: all 0.2s;
    }

    .flowcv-btn-icon:hover {
        background: #e2e8f0;
        color: var(--fcv-text);
    }

    .flowcv-dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        width: 220px;
        background: #ffffff;
        border: 1px solid var(--fcv-border);
        border-radius: 10px;
        box-shadow: var(--fcv-shadow-lg);
        padding: 6px;
        display: none;
        z-index: 200;
    }

    .flowcv-dropdown-menu.show {
        display: block;
    }

    .flowcv-dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 500;
        color: var(--fcv-text);
        text-decoration: none;
        border-radius: 6px;
        transition: background 0.15s;
        border: none;
        background: transparent;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .flowcv-dropdown-item:hover {
        background: #f1f5f9;
        color: var(--fcv-accent);
    }

    /* Split-View Workspace */
    .flowcv-workspace {
        display: grid;
        grid-template-columns: 46% 54%;
        gap: 28px;
        padding: 24px 32px 60px;
        max-width: 1680px;
        margin: 0 auto;
    }

    /* Left Column: Form & Accordion Editor */
    .flowcv-editor-col {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Top Identity Card */
    .flowcv-identity-card {
        background: #ffffff;
        border: 1px solid var(--fcv-border);
        border-radius: var(--fcv-radius);
        padding: 20px;
        box-shadow: var(--fcv-shadow-sm);
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
    }

    .flowcv-avatar-wrap {
        position: relative;
        width: 86px;
        height: 86px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        flex-shrink: 0;
        background: #e2e8f0;
        cursor: pointer;
    }

    .flowcv-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .flowcv-avatar-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        color: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 600;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .flowcv-avatar-wrap:hover .flowcv-avatar-overlay {
        opacity: 1;
    }

    .flowcv-identity-info {
        flex: 1;
        min-width: 0;
    }

    /* CRITICAL OVERRIDES: Override techseba_dark.css which turns all h1-h6 white */
    .flowcv-root h1,
    .flowcv-root h2,
    .flowcv-root h3,
    .flowcv-root h4,
    .flowcv-root h5,
    .flowcv-root h6 {
        color: #0f172a !important;
        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
    }

    .flowcv-identity-name {
        margin: 0 0 4px;
        font-size: 20px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        letter-spacing: -0.3px;
    }

    .flowcv-identity-headline {
        margin: 0 0 10px;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        color: #2563eb !important;
    }

    .flowcv-contact-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 12px;
        font-size: 12px;
        color: #475569 !important;
    }

    .flowcv-contact-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #475569 !important;
    }

    /* FlowCV Accordion Cards */
    .flowcv-card {
        background: #ffffff;
        border: 1px solid var(--fcv-border);
        border-radius: var(--fcv-radius);
        box-shadow: var(--fcv-shadow-sm);
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .flowcv-card:hover {
        border-color: var(--fcv-border-hover);
        box-shadow: var(--fcv-shadow-md);
    }

    .flowcv-card.is-open {
        border-color: #cbd5e1;
    }

    .flowcv-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: #ffffff;
        cursor: pointer;
        user-select: none;
        transition: background 0.15s;
    }

    .flowcv-card-header:hover {
        background: #f8fafc;
    }

    .flowcv-card-title-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .flowcv-card-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #e2e8f0 !important;
        color: #172c47 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .flowcv-card-title {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        margin: 0 !important;
        text-transform: capitalize;
    }

    .flowcv-card-count {
        font-size: 11px !important;
        font-weight: 700 !important;
        padding: 2px 8px;
        border-radius: 999px;
        background: #e2e8f0 !important;
        color: #334155 !important;
    }

    .flowcv-item-title {
        font-size: 13.5px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }

    .flowcv-label {
        display: block;
        font-size: 12.5px !important;
        font-weight: 700 !important;
        color: #334155 !important;
        margin-bottom: 6px;
    }

    .flowcv-card-chevron {
        color: #94a3b8;
        font-size: 12px;
        transition: transform 0.2s ease;
    }

    .flowcv-card.is-open .flowcv-card-chevron {
        transform: rotate(180deg);
        color: var(--fcv-text);
    }

    .flowcv-card-body {
        display: none;
        padding: 20px;
        border-top: 1px solid #f1f5f9;
        background: #ffffff;
    }

    .flowcv-card.is-open .flowcv-card-body {
        display: block;
    }

    /* Form Fields inside Cards */
    .flowcv-field-group {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 14px;
    }

    .flowcv-field-full {
        grid-column: 1 / -1;
    }

    .flowcv-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    .flowcv-input,
    .flowcv-textarea,
    .flowcv-select {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        font-size: 13.5px;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        transition: all 0.15s ease;
    }

    .flowcv-input:focus,
    .flowcv-textarea:focus,
    .flowcv-select:focus {
        border-color: #172c47;
        box-shadow: 0 0 0 3px rgba(23, 44, 71, 0.12);
    }

    .flowcv-textarea {
        resize: vertical;
        min-height: 85px;
        line-height: 1.5;
    }

    /* Repeater Items */
    .flowcv-repeater-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 16px;
    }

    .flowcv-repeater-item {
        border: 1px solid var(--fcv-border);
        border-radius: 8px;
        padding: 16px;
        background: #f8fafc;
        position: relative;
        transition: border 0.15s;
    }

    .flowcv-repeater-item:hover {
        border-color: #cbd5e1;
    }

    .flowcv-item-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .flowcv-item-title {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
    }

    .flowcv-btn-delete {
        background: transparent;
        border: none;
        color: #ef4444;
        cursor: pointer;
        padding: 4px 8px;
        font-size: 13px;
        border-radius: 6px;
        transition: background 0.15s;
    }

    .flowcv-btn-delete:hover {
        background: #fee2e2;
    }

    .flowcv-btn-add {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 10px;
        border: 1.5px dashed #cbd5e1;
        border-radius: 8px;
        background: #f8fafc;
        color: #172c47;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .flowcv-btn-add:hover {
        border-color: #172c47;
        background: #ffffff;
    }

    /* Right Column: Sticky Live Preview Canvas */
    .flowcv-preview-col {
        position: sticky;
        top: 74px;
        max-height: calc(100vh - 90px);
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow: hidden;
    }

    .flowcv-preview-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 650px;
        margin-bottom: 12px;
        padding: 6px 14px;
        background: #ffffff;
        border: 1px solid var(--fcv-border);
        border-radius: 8px;
        box-shadow: var(--fcv-shadow-sm);
    }

    .flowcv-live-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 700;
        color: #10b981;
    }

    .flowcv-pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulseDot 1.8s infinite;
    }

    @keyframes pulseDot {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .flowcv-zoom-controls {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .flowcv-zoom-btn {
        padding: 4px 10px;
        background: #f1f5f9;
        border: 1px solid var(--fcv-border);
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
    }

    .flowcv-zoom-btn:hover {
        background: #e2e8f0;
    }

    .flowcv-canvas-scrollbox {
        width: 100%;
        overflow-y: auto;
        overflow-x: hidden;
        display: flex;
        justify-content: center;
        padding: 8px 12px 24px;
        max-height: calc(100vh - 160px);
    }

    /* THE A4 LIVE CV CANVAS (Matching the FlowCV Screenshot) */
    .flowcv-paper-sheet {
        width: 100%;
        max-width: 630px;
        min-height: 890px;
        background: #ffffff;
        box-shadow: 0 14px 38px rgba(15, 23, 42, 0.16);
        border-radius: 3px;
        display: grid;
        grid-template-columns: 38% 62%;
        overflow: hidden;
        transform-origin: top center;
        transition: transform 0.2s ease;
    }

    /* Left Sidebar: Navy Blue Column */
    .fcv-side {
        background: #172c47;
        color: #ffffff;
        padding: 24px 18px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .fcv-side-header {
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        padding-bottom: 16px;
    }

    .fcv-side-name {
        font-size: 17px;
        font-weight: 800;
        margin: 0 0 4px;
        color: #ffffff;
        line-height: 1.2;
    }

    .fcv-side-title {
        font-size: 10.5px;
        font-weight: 600;
        color: #93c5fd;
        margin: 0 0 12px;
        line-height: 1.3;
    }

    .fcv-side-avatar {
        width: 74px;
        height: 74px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 12px;
        border: 2px solid rgba(255, 255, 255, 0.85);
        display: block;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
    }

    .fcv-side-contacts {
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-size: 9px;
        color: #cbd5e1;
        text-align: left;
        line-height: 1.35;
    }

    .fcv-side-contact-item {
        display: flex;
        align-items: center;
        gap: 6px;
        overflow-wrap: anywhere;
    }

    .fcv-side-contact-item i {
        font-size: 10px;
        color: #93c5fd;
        width: 12px;
        text-align: center;
    }

    .fcv-side-section-title {
        font-size: 10.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #ffffff;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        padding-bottom: 4px;
        margin: 0 0 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .fcv-side-summary {
        font-size: 8.5px;
        line-height: 1.45;
        color: #cbd5e1;
        margin: 0;
        text-align: justify;
    }

    .fcv-side-edu-item {
        margin-bottom: 8px;
    }

    .fcv-side-edu-degree {
        font-size: 9.5px;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
    }

    .fcv-side-edu-inst {
        font-size: 8.5px;
        color: #93c5fd;
        margin: 1px 0;
    }

    .fcv-side-edu-meta {
        font-size: 8px;
        color: #cbd5e1;
    }

    /* Right Main Content: White Column */
    .fcv-main {
        background: #ffffff;
        padding: 24px 22px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .fcv-main-section-title {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #0f172a;
        border-bottom: 1.5px solid #0f172a;
        padding-bottom: 4px;
        margin: 0 0 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .fcv-job-item {
        margin-bottom: 12px;
    }

    .fcv-job-head {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    .fcv-job-company {
        font-size: 10.5px;
        font-weight: 800;
        color: #0f172a;
    }

    .fcv-job-dates {
        font-size: 8.5px;
        font-weight: 600;
        color: #64748b;
    }

    .fcv-job-role {
        font-size: 9.5px;
        font-weight: 700;
        color: #2563eb;
        margin: 1px 0 3px;
    }

    .fcv-job-desc {
        font-size: 8.5px;
        line-height: 1.45;
        color: #334155;
        margin: 0;
        white-space: pre-line;
    }

    .fcv-skills-grid {
        display: flex;
        flex-direction: column;
        gap: 5px;
        font-size: 8.5px;
    }

    .fcv-skill-row {
        line-height: 1.4;
    }

    .fcv-skill-tag-name {
        font-weight: 700;
        color: #0f172a;
    }

    .fcv-skill-tag-val {
        color: #475569;
    }

    .fcv-proj-item {
        margin-bottom: 10px;
    }

    .fcv-proj-title {
        font-size: 10px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 2px;
    }

    .fcv-proj-stack {
        font-size: 8.5px;
        font-weight: 600;
        color: #2563eb;
        margin-bottom: 3px;
    }

    .fcv-proj-desc {
        font-size: 8.5px;
        line-height: 1.42;
        color: #334155;
        margin: 0;
    }

    /* Tabs Panel switching */
    .flowcv-tab-panel {
        display: none;
    }
    .flowcv-tab-panel.active {
        display: block;
    }

    /* Choose Template Split-View Styling */
    .flowcv-template-list-card {
        background: #ffffff;
        border: 2px solid var(--fcv-border);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        gap: 16px;
        align-items: center;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .flowcv-template-list-card:hover {
        border-color: #94a3b8;
        box-shadow: var(--fcv-shadow-md);
        transform: translateY(-1px);
    }

    .flowcv-template-list-card.active {
        border-color: #172c47;
        background: #f8fafc;
        box-shadow: 0 4px 14px rgba(23, 44, 71, 0.12);
    }

    .flowcv-template-badge-selected {
        display: none;
        position: absolute;
        top: 12px;
        right: 14px;
        background: #172c47;
        color: #ffffff !important;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 999px;
    }

    .flowcv-template-list-card.active .flowcv-template-badge-selected {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .flowcv-template-thumb-box {
        width: 84px;
        height: 110px;
        border-radius: 8px;
        background: #e2e8f0;
        flex-shrink: 0;
        border: 1px solid #cbd5e1;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .flowcv-template-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .flowcv-template-card-info {
        flex: 1;
        min-width: 0;
    }

    .flowcv-template-card-title {
        font-size: 15.5px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        margin: 0 0 4px !important;
    }

    .flowcv-template-card-desc {
        font-size: 12px;
        color: #64748b;
        margin: 0 0 10px;
        line-height: 1.4;
    }

    .flowcv-template-card-tags {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .flowcv-template-tag {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 5px;
        background: #e2e8f0;
        color: #334155 !important;
    }

    .flowcv-category-pill {
        padding: 6px 14px;
        border-radius: 999px;
        border: 1px solid var(--fcv-border);
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
    }

    .flowcv-category-pill:hover,
    .flowcv-category-pill.active {
        background: #172c47;
        color: #ffffff;
        border-color: #172c47;
    }

    /* AI Tools Tab Styling */
    .flowcv-ai-panel {
        background: #ffffff;
        border: 1px solid var(--fcv-border);
        border-radius: var(--fcv-radius);
        padding: 24px;
    }

    .flowcv-ai-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #a855f7, #ec4899);
        color: #fff;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .flowcv-ai-suggestions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .flowcv-ai-card {
        padding: 14px;
        border: 1px solid var(--fcv-border);
        border-radius: 8px;
        background: #f8fafc;
    }

    .flowcv-ai-card strong {
        display: block;
        color: #0f172a;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .flowcv-ai-card p {
        font-size: 12px;
        color: var(--fcv-muted);
        margin: 0 0 10px;
    }

    .flowcv-btn-ai-apply {
        padding: 6px 12px;
        background: #172c47;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        border-radius: 6px;
        border: none;
        cursor: pointer;
    }

    @media (max-width: 1199px) {
        .flowcv-workspace {
            grid-template-columns: 1fr;
        }
        .flowcv-preview-col {
            position: static;
            max-height: none;
        }
    }
</style>
@endpush

@section('dashboard-content')
<!-- Hidden Form for Spreadsheet Import -->
<form action="{{ profile_route('user.cv.import-spreadsheet') }}" method="post" enctype="multipart/form-data" id="importSpreadsheetForm" style="display: none;">
    @csrf
    <input type="file" name="spreadsheet_file" id="spreadsheet_file_input_hidden" accept=".xlsx,.xls,.csv,.json,.txt" onchange="document.getElementById('importSpreadsheetForm').submit()">
</form>

<div class="flowcv-root" id="flowcvApp">
    <!-- 1. Top Navigation Bar -->
    <header class="flowcv-navbar">
        <div class="flowcv-nav-left">
            <a href="{{ profile_route('user.dashboard') }}" class="flowcv-back-btn">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>

            <div class="flowcv-nav-tabs" role="tablist">
                <button type="button" class="flowcv-nav-tab" data-nav-target="overview">
                    <i class="far fa-compass"></i> Overview
                </button>
                <button type="button" class="flowcv-nav-tab active" data-nav-target="content">
                    <i class="far fa-file-alt"></i> Content
                </button>
                <button type="button" class="flowcv-nav-tab" data-nav-target="templates">
                    <i class="fas fa-th-large"></i> Choose Template
                </button>
                <button type="button" class="flowcv-nav-tab" data-nav-target="ai-tools">
                    <i class="fas fa-magic"></i> AI Tools
                </button>
            </div>
        </div>

        <div class="flowcv-nav-right">
            <span class="flowcv-save-status saved" id="saveStatusIndicator">
                <i class="fas fa-check-circle"></i> Saved
            </span>

            <button type="button" class="flowcv-btn-save" id="btnManualSave">
                <i class="fas fa-save"></i> Save Changes
            </button>

            <select class="flowcv-resume-dropdown" id="resumeSelector">
                <option value="1">Resume No. 1 (Modern Two-Tone)</option>
                <option value="2">Resume No. 2 (Corporate BDJobs)</option>
            </select>

            <a href="{{ profile_route('user.cv.pdf') }}" class="flowcv-btn-download" target="_blank">
                <i class="fas fa-download"></i> Download
            </a>

            <div class="flowcv-more-dropdown">
                <button type="button" class="flowcv-btn-icon" id="btnMoreActions" aria-label="More actions">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <div class="flowcv-dropdown-menu" id="moreActionsMenu">
                    <a href="{{ profile_route('cv.public', $user->username) }}" target="_blank" class="flowcv-dropdown-item">
                        <i class="fas fa-external-link-alt"></i> View Public CV
                    </a>
                    <a href="{{ profile_route('user.cv.print') }}" target="_blank" class="flowcv-dropdown-item">
                        <i class="fas fa-print"></i> Print CV (A4)
                    </a>
                    <button type="button" class="flowcv-dropdown-item" onclick="document.getElementById('spreadsheet_file_input_hidden').click()">
                        <i class="fas fa-file-excel"></i> Import Excel / CSV
                    </button>
                    <a href="{{ profile_route('user.cv.export-spreadsheet') }}" class="flowcv-dropdown-item">
                        <i class="fas fa-file-export"></i> Export Spreadsheet
                    </a>
                    <button type="button" class="flowcv-dropdown-item" id="btnToggleStudioMode">
                        <i class="fas fa-expand"></i> Toggle Fullscreen Mode
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- TAB 1: OVERVIEW PANEL -->
    <div class="flowcv-tab-panel" id="panel-overview" style="padding: 30px; max-width: 1000px; margin: 0 auto;">
        <div style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: var(--fcv-shadow-sm);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                <div>
                    <h3 style="margin: 0 0 6px; font-size: 22px; color: #0f172a;">CV Performance & Completeness</h3>
                    <p style="margin: 0; color: #64748b; font-size: 14px;">Your resume profile is ready to impress recruiters and enterprise clients.</p>
                </div>
                <div style="text-align: right;">
                    <span style="font-size: 32px; font-weight: 800; color: #10b981;">95%</span>
                    <small style="display: block; color: #64748b; font-weight: 600;">ATS Strength</small>
                </div>
            </div>

            <div style="width: 100%; height: 10px; background: #e2e8f0; border-radius: 999px; overflow: hidden; margin-bottom: 28px;">
                <div style="width: 95%; height: 100%; background: linear-gradient(90deg, #10b981, #3b82f6); border-radius: 999px;"></div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                <div style="padding: 18px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc;">
                    <div style="color: #10b981; font-size: 20px; margin-bottom: 8px;"><i class="fas fa-check-circle"></i></div>
                    <strong style="display: block; font-size: 14px; margin-bottom: 4px;">Experience Documented</strong>
                    <p style="margin: 0; font-size: 12px; color: #64748b;">{{ count($employments) }} professional positions with measurable achievements.</p>
                </div>
                <div style="padding: 18px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc;">
                    <div style="color: #10b981; font-size: 20px; margin-bottom: 8px;"><i class="fas fa-check-circle"></i></div>
                    <strong style="display: block; font-size: 14px; margin-bottom: 4px;">Technical Skills Stack</strong>
                    <p style="margin: 0; font-size: 12px; color: #64748b;">{{ count($skills) }} skills categorised into AI, Backend, Frontend and DevOps.</p>
                </div>
                <div style="padding: 18px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc;">
                    <div style="color: #10b981; font-size: 20px; margin-bottom: 8px;"><i class="fas fa-check-circle"></i></div>
                    <strong style="display: block; font-size: 14px; margin-bottom: 4px;">Production Projects</strong>
                    <p style="margin: 0; font-size: 12px; color: #64748b;">{{ count($projects) }} projects with demo credentials & live links.</p>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 12px;">
                <button type="button" class="flowcv-btn-save" onclick="document.querySelector('[data-nav-target=content]').click()">
                    <i class="fas fa-edit"></i> Continue Editing Resume
                </button>
                <a href="{{ profile_route('user.cv.pdf') }}" class="flowcv-btn-download">
                    <i class="fas fa-download"></i> Download PDF
                </a>
            </div>
        </div>
    </div>

    <!-- TAB 2: CONTENT PANEL (The Core FlowCV Split-View Editor) -->
    <div class="flowcv-tab-panel active" id="panel-content">
        <form id="cvMainForm" action="{{ profile_route('user.cv.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="template_id" id="input_template_id" value="{{ $selectedCvTemplate?->id ?? 1 }}">
            <input type="hidden" name="portfolio_template_id" value="{{ $selectedPortfolioTemplate?->id ?? 1 }}">
            <input type="hidden" name="active_tab" value="content">

            <div class="flowcv-workspace">
                <!-- ================= LEFT EDITOR COLUMN ================= -->
                <div class="flowcv-editor-col">
                    <!-- Top Profile Identity Card -->
                    <div class="flowcv-identity-card">
                        <label class="flowcv-avatar-wrap" title="Click to upload profile photo">
                            <img src="{{ $photoUrl }}" alt="Avatar" class="flowcv-avatar-img" id="identityAvatarPreview">
                            <div class="flowcv-avatar-overlay">
                                <i class="fas fa-camera"></i>
                                <span>Change</span>
                            </div>
                            <input type="file" name="photo" id="photoFileInput" accept="image/*" style="display: none;">
                        </label>

                        <div class="flowcv-identity-info">
                            <h2 class="flowcv-identity-name" id="badge_name">{{ $cv?->full_name ?: $user->name }}</h2>
                            <div class="flowcv-identity-headline" id="badge_headline">{{ $headline }}</div>
                            <div class="flowcv-contact-pills">
                                <span class="flowcv-contact-pill"><i class="fas fa-envelope"></i> <span id="badge_email">{{ $cv?->email ?: $user->email }}</span></span>
                                <span class="flowcv-contact-pill"><i class="fas fa-phone"></i> <span id="badge_mobile">{{ $cv?->mobile ?: ($user->phone ?: '+880...') }}</span></span>
                                <span class="flowcv-contact-pill"><i class="fas fa-map-marker-alt"></i> <span id="badge_address">{{ Str::limit($cv?->present_address ?: 'Dhaka, Bangladesh', 35) }}</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- ACCORDION CARD 1: PROFILE & PERSONAL DETAILS -->
                    <div class="flowcv-card is-open">
                        <div class="flowcv-card-header" onclick="toggleCard(this)">
                            <div class="flowcv-card-title-left">
                                <div class="flowcv-card-icon"><i class="fas fa-user"></i></div>
                                <h3 class="flowcv-card-title">Profile</h3>
                            </div>
                            <i class="fas fa-chevron-down flowcv-card-chevron"></i>
                        </div>
                        <div class="flowcv-card-body">
                            <div class="flowcv-field-group">
                                <div>
                                    <label class="flowcv-label">Full Name *</label>
                                    <input type="text" name="full_name" class="flowcv-input live-sync" data-target="live_name" value="{{ old('full_name', $cv?->full_name ?: $user->name) }}" required>
                                </div>
                                <div>
                                    <label class="flowcv-label">Professional Headline / Role</label>
                                    <input type="text" id="custom_headline_input" class="flowcv-input live-sync" data-target="live_headline" value="{{ $headline }}" placeholder="e.g. AI & Full-Stack Software Engineer">
                                </div>
                            </div>

                            <div class="flowcv-field-group">
                                <div>
                                    <label class="flowcv-label">Email Address *</label>
                                    <input type="email" name="email" class="flowcv-input live-sync" data-target="live_email" value="{{ old('email', $cv?->email ?: $user->email) }}" required>
                                </div>
                                <div>
                                    <label class="flowcv-label">Mobile Number *</label>
                                    <input type="text" name="mobile" class="flowcv-input live-sync" data-target="live_mobile" value="{{ old('mobile', $cv?->mobile ?: $user->phone) }}" required>
                                </div>
                            </div>

                            <div class="flowcv-field-group">
                                <div class="flowcv-field-full">
                                    <label class="flowcv-label">Present Address / Location</label>
                                    <input type="text" name="present_address" class="flowcv-input live-sync" data-target="live_address" value="{{ old('present_address', $cv?->present_address) }}" placeholder="e.g. Panthapath, Dhanmondi, Dhaka-1208">
                                </div>
                            </div>

                            <div class="flowcv-field-group">
                                <div>
                                    <label class="flowcv-label">Website / Portfolio URL</label>
                                    <input type="url" name="website_url" class="flowcv-input" value="{{ old('website_url', $cv?->website_url) }}" placeholder="https://yourdomain.com">
                                </div>
                                <div>
                                    <label class="flowcv-label">LinkedIn URL</label>
                                    <input type="url" id="linkedin_input" class="flowcv-input live-sync" data-target="live_linkedin" value="{{ $cv?->linkedin_url }}" placeholder="linkedin.com/in/username">
                                </div>
                            </div>

                            <div class="flowcv-field-group">
                                <div class="flowcv-field-full">
                                    <label class="flowcv-label">Professional Summary (About Me)</label>
                                    <textarea name="career_summary" class="flowcv-textarea live-sync" data-target="live_summary" rows="4" placeholder="Brief summary of your background, experience, key achievements, and passions...">{{ old('career_summary', $cv?->career_summary) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACCORDION CARD 2: EDUCATION -->
                    <div class="flowcv-card is-open">
                        <div class="flowcv-card-header" onclick="toggleCard(this)">
                            <div class="flowcv-card-title-left">
                                <div class="flowcv-card-icon"><i class="fas fa-graduation-cap"></i></div>
                                <h3 class="flowcv-card-title">Education</h3>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="flowcv-card-count" id="edu_count">{{ count($academics) }}</span>
                                <i class="fas fa-chevron-down flowcv-card-chevron"></i>
                            </div>
                        </div>
                        <div class="flowcv-card-body">
                            <div class="flowcv-repeater-list" id="educationList">
                                @foreach($academics as $i => $edu)
                                    <div class="flowcv-repeater-item" data-index="{{ $i }}">
                                        <div class="flowcv-item-header">
                                            <span class="flowcv-item-title">Education #{{ $i + 1 }}</span>
                                            @if($i > 0)
                                                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'education')"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div>
                                                <label class="flowcv-label">Degree / Certificate</label>
                                                <input type="text" name="academics[{{ $i }}][degree_name]" class="flowcv-input live-edu-degree" value="{{ $edu['degree_name'] ?? '' }}" placeholder="e.g. B.Sc in CSE">
                                            </div>
                                            <div>
                                                <label class="flowcv-label">Institution Name</label>
                                                <input type="text" name="academics[{{ $i }}][institution]" class="flowcv-input live-edu-inst" value="{{ $edu['institution'] ?? '' }}" placeholder="e.g. Dhaka International University">
                                            </div>
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div>
                                                <label class="flowcv-label">Passing Year / Duration</label>
                                                <input type="text" name="academics[{{ $i }}][passing_year]" class="flowcv-input live-edu-year" value="{{ $edu['passing_year'] ?? '' }}" placeholder="e.g. September 2021 – September 2025">
                                            </div>
                                            <div>
                                                <label class="flowcv-label">Board / Result / Location</label>
                                                <input type="text" name="academics[{{ $i }}][board_or_university]" class="flowcv-input live-edu-loc" value="{{ $edu['board_or_university'] ?? '' }}" placeholder="e.g. Satarkul, Badda, Dhaka">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="flowcv-btn-add" onclick="addEducationRow()">
                                <i class="fas fa-plus"></i> Add Education
                            </button>
                        </div>
                    </div>

                    <!-- ACCORDION CARD 3: TRAINING -->
                    <div class="flowcv-card">
                        <div class="flowcv-card-header" onclick="toggleCard(this)">
                            <div class="flowcv-card-title-left">
                                <div class="flowcv-card-icon"><i class="fas fa-certificate"></i></div>
                                <h3 class="flowcv-card-title">Training</h3>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="flowcv-card-count">{{ count($trainings) }}</span>
                                <i class="fas fa-chevron-down flowcv-card-chevron"></i>
                            </div>
                        </div>
                        <div class="flowcv-card-body">
                            <div class="flowcv-repeater-list" id="trainingList">
                                @foreach($trainings as $i => $train)
                                    <div class="flowcv-repeater-item">
                                        <div class="flowcv-item-header">
                                            <span class="flowcv-item-title">Training #{{ $i + 1 }}</span>
                                            @if($i > 0)
                                                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'training')"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div>
                                                <label class="flowcv-label">Training Title</label>
                                                <input type="text" name="trainings[{{ $i }}][training_title]" class="flowcv-input live-train-title" value="{{ $train['training_title'] ?? '' }}" placeholder="e.g. Diploma in Web Application Development">
                                            </div>
                                            <div>
                                                <label class="flowcv-label">Institute / Program</label>
                                                <input type="text" name="trainings[{{ $i }}][institute]" class="flowcv-input live-train-inst" value="{{ $train['institute'] ?? '' }}" placeholder="e.g. IsDB-BISEW IT Scholarship Program">
                                            </div>
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div>
                                                <label class="flowcv-label">Duration / Period</label>
                                                <input type="text" name="trainings[{{ $i }}][duration]" class="flowcv-input live-train-period" value="{{ $train['duration'] ?? '' }}" placeholder="e.g. 1 Year (850 Hours)">
                                            </div>
                                            <div>
                                                <label class="flowcv-label">Certificate Details</label>
                                                <input type="text" name="trainings[{{ $i }}][certificate_details]" class="flowcv-input" value="{{ $train['certificate_details'] ?? '' }}" placeholder="Certification ID or skills learned">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="flowcv-btn-add" onclick="addTrainingRow()">
                                <i class="fas fa-plus"></i> Add Training
                            </button>
                        </div>
                    </div>

                    <!-- ACCORDION CARD 4: PROFESSIONAL EXPERIENCE -->
                    <div class="flowcv-card is-open">
                        <div class="flowcv-card-header" onclick="toggleCard(this)">
                            <div class="flowcv-card-title-left">
                                <div class="flowcv-card-icon"><i class="fas fa-briefcase"></i></div>
                                <h3 class="flowcv-card-title">Professional Experience</h3>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="flowcv-card-count">{{ count($employments) }}</span>
                                <i class="fas fa-chevron-down flowcv-card-chevron"></i>
                            </div>
                        </div>
                        <div class="flowcv-card-body">
                            <div class="flowcv-repeater-list" id="experienceList">
                                @foreach($employments as $i => $emp)
                                    <div class="flowcv-repeater-item" data-index="{{ $i }}">
                                        <div class="flowcv-item-header">
                                            <span class="flowcv-item-title">{{ $emp['designation'] ?: 'Position #'.($i+1) }}</span>
                                            @if($i > 0)
                                                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'experience')"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div>
                                                <label class="flowcv-label">Company Name *</label>
                                                <input type="text" name="employments[{{ $i }}][company_name]" class="flowcv-input live-job-company" value="{{ $emp['company_name'] ?? '' }}" placeholder="e.g. American Wellness Center">
                                            </div>
                                            <div>
                                                <label class="flowcv-label">Job Title / Designation *</label>
                                                <input type="text" name="employments[{{ $i }}][designation]" class="flowcv-input live-job-role" value="{{ $emp['designation'] ?? '' }}" placeholder="e.g. Software Developer">
                                            </div>
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div>
                                                <label class="flowcv-label">Start Date</label>
                                                <input type="date" name="employments[{{ $i }}][start_date]" class="flowcv-input live-job-start" value="{{ $emp['start_date'] ? \Illuminate\Support\Carbon::parse($emp['start_date'])->format('Y-m-d') : '' }}">
                                            </div>
                                            <div>
                                                <label class="flowcv-label">End Date</label>
                                                <input type="date" name="employments[{{ $i }}][end_date]" class="flowcv-input live-job-end" value="{{ $emp['end_date'] ? \Illuminate\Support\Carbon::parse($emp['end_date'])->format('Y-m-d') : '' }}" {{ !empty($emp['is_current']) ? 'disabled' : '' }}>
                                                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; margin-top: 5px; color: #64748b; cursor: pointer;">
                                                    <input type="checkbox" name="employments[{{ $i }}][is_current]" value="1" {{ !empty($emp['is_current']) ? 'checked' : '' }} onchange="const end = this.closest('.flowcv-field-group').querySelector('.live-job-end'); end.disabled = this.checked; updateLivePreview();">
                                                    Currently Working Here
                                                </label>
                                            </div>
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div class="flowcv-field-full">
                                                <label class="flowcv-label">Company Location</label>
                                                <input type="text" name="employments[{{ $i }}][company_location]" class="flowcv-input live-job-loc" value="{{ $emp['company_location'] ?? '' }}" placeholder="e.g. Dhanmondi-32, Dhaka">
                                            </div>
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div class="flowcv-field-full">
                                                <label class="flowcv-label">Key Responsibilities & Achievements (Bullet Points)</label>
                                                <textarea name="employments[{{ $i }}][responsibilities]" class="flowcv-textarea live-job-desc" rows="4" placeholder="• Developed ERP, CRM, and Clinic systems serving 3 branches and 200+ users.&#10;• Built 10+ n8n automated workflows connecting CRM and external APIs.&#10;• Integrated LLM and RAG assistant with Gemini and Claude.">{{ $emp['responsibilities'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="flowcv-btn-add" onclick="addExperienceRow()">
                                <i class="fas fa-plus"></i> Add Professional Experience
                            </button>
                        </div>
                    </div>

                    <!-- ACCORDION CARD 5: TECHNICAL SKILLS -->
                    <div class="flowcv-card is-open">
                        <div class="flowcv-card-header" onclick="toggleCard(this)">
                            <div class="flowcv-card-title-left">
                                <div class="flowcv-card-icon"><i class="fas fa-lightbulb"></i></div>
                                <h3 class="flowcv-card-title">Technical Skills</h3>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="flowcv-card-count">{{ count($skills) }}</span>
                                <i class="fas fa-chevron-down flowcv-card-chevron"></i>
                            </div>
                        </div>
                        <div class="flowcv-card-body">
                            <div class="flowcv-repeater-list" id="skillsList">
                                @foreach($skills as $i => $sk)
                                    <div class="flowcv-repeater-item" style="padding: 12px;">
                                        <div style="display: flex; gap: 10px; align-items: center;">
                                            <div style="flex: 2;">
                                                <input type="text" name="skills[{{ $i }}][skill_name]" class="flowcv-input live-skill-name" value="{{ $sk['skill_name'] ?? '' }}" placeholder="e.g. Laravel, Vue.js, Python, Docker">
                                            </div>
                                            <div style="flex: 1.5;">
                                                <select name="skills[{{ $i }}][skill_type]" class="flowcv-select live-skill-cat">
                                                    <option value="AI" {{ ($sk['skill_type'] ?? '') == 'AI' ? 'selected' : '' }}>AI & LLM</option>
                                                    <option value="Backend" {{ ($sk['skill_type'] ?? '') == 'Backend' ? 'selected' : '' }}>Backend</option>
                                                    <option value="Frontend" {{ ($sk['skill_type'] ?? '') == 'Frontend' ? 'selected' : '' }}>Frontend</option>
                                                    <option value="Database" {{ ($sk['skill_type'] ?? '') == 'Database' ? 'selected' : '' }}>Database</option>
                                                    <option value="DevOps" {{ ($sk['skill_type'] ?? '') == 'DevOps' ? 'selected' : '' }}>DevOps</option>
                                                    <option value="Integration" {{ ($sk['skill_type'] ?? '') == 'Integration' ? 'selected' : '' }}>Integration</option>
                                                </select>
                                            </div>
                                            <div style="flex: 1;">
                                                <select name="skills[{{ $i }}][skill_level]" class="flowcv-select">
                                                    <option value="Expert" {{ ($sk['skill_level'] ?? '') == 'Expert' ? 'selected' : '' }}>Expert</option>
                                                    <option value="Intermediate" {{ ($sk['skill_level'] ?? '') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                    <option value="Basic" {{ ($sk['skill_level'] ?? '') == 'Basic' ? 'selected' : '' }}>Basic</option>
                                                </select>
                                            </div>
                                            @if($i > 0)
                                                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'skills')"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="flowcv-btn-add" onclick="addSkillRow()">
                                <i class="fas fa-plus"></i> Add Skill
                            </button>
                        </div>
                    </div>

                    <!-- ACCORDION CARD 6: PROJECTS -->
                    <div class="flowcv-card is-open">
                        <div class="flowcv-card-header" onclick="toggleCard(this)">
                            <div class="flowcv-card-title-left">
                                <div class="flowcv-card-icon"><i class="fas fa-folder-open"></i></div>
                                <h3 class="flowcv-card-title">Projects</h3>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="flowcv-card-count">{{ count($projects) }}</span>
                                <i class="fas fa-chevron-down flowcv-card-chevron"></i>
                            </div>
                        </div>
                        <div class="flowcv-card-body">
                            <div class="flowcv-repeater-list" id="projectsList">
                                @foreach($projects as $i => $proj)
                                    <div class="flowcv-repeater-item" data-index="{{ $i }}">
                                        <div class="flowcv-item-header">
                                            <span class="flowcv-item-title">{{ $proj['title'] ?: 'Project #'.($i+1) }}</span>
                                            @if($i > 0)
                                                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'projects')"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div>
                                                <label class="flowcv-label">Project Title *</label>
                                                <input type="text" name="projects[{{ $i }}][title]" class="flowcv-input live-proj-title" value="{{ $proj['title'] ?? '' }}" placeholder="e.g. SocialOrg Finance">
                                            </div>
                                            <div>
                                                <label class="flowcv-label">Technologies Used</label>
                                                <input type="text" name="projects[{{ $i }}][technologies]" class="flowcv-input live-proj-tech" value="{{ $proj['technologies'] ?? '' }}" placeholder="e.g. Laravel, Vue.js, Inertia.js">
                                            </div>
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div>
                                                <label class="flowcv-label">Live Demo Link</label>
                                                <input type="url" name="projects[{{ $i }}][link]" class="flowcv-input" value="{{ $proj['link'] ?? '' }}" placeholder="https://demo.app.com">
                                            </div>
                                            <div>
                                                <label class="flowcv-label">GitHub URL</label>
                                                <input type="url" name="projects[{{ $i }}][github_url]" class="flowcv-input" value="{{ $proj['github_url'] ?? '' }}" placeholder="https://github.com/repo">
                                            </div>
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div class="flowcv-field-full">
                                                <label class="flowcv-label">Project Overview & Responsibilities</label>
                                                <textarea name="projects[{{ $i }}][description]" class="flowcv-textarea live-proj-desc" rows="3" placeholder="Brief description of project features, user base, architecture and achievements...">{{ $proj['description'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="flowcv-btn-add" onclick="addProjectRow()">
                                <i class="fas fa-plus"></i> Add Project
                            </button>
                        </div>
                    </div>

                    <!-- ACCORDION CARD 7: REFERENCES -->
                    <div class="flowcv-card">
                        <div class="flowcv-card-header" onclick="toggleCard(this)">
                            <div class="flowcv-card-title-left">
                                <div class="flowcv-card-icon"><i class="fas fa-user-friends"></i></div>
                                <h3 class="flowcv-card-title">References</h3>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="flowcv-card-count">{{ count($references) }}</span>
                                <i class="fas fa-chevron-down flowcv-card-chevron"></i>
                            </div>
                        </div>
                        <div class="flowcv-card-body">
                            <div class="flowcv-repeater-list" id="referencesList">
                                @foreach($references as $i => $ref)
                                    <div class="flowcv-repeater-item">
                                        <div class="flowcv-item-header">
                                            <span class="flowcv-item-title">{{ $ref['name'] ?: 'Reference #'.($i+1) }}</span>
                                            @if($i > 0)
                                                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'references')"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div>
                                                <label class="flowcv-label">Referee Name</label>
                                                <input type="text" name="references[{{ $i }}][name]" class="flowcv-input live-ref-name" value="{{ $ref['name'] ?? '' }}" placeholder="e.g. Dr. John Doe">
                                            </div>
                                            <div>
                                                <label class="flowcv-label">Designation & Org</label>
                                                <input type="text" name="references[{{ $i }}][designation]" class="flowcv-input live-ref-desig" value="{{ $ref['designation'] ?? '' }}" placeholder="e.g. CTO, Tech Corp">
                                            </div>
                                        </div>
                                        <div class="flowcv-field-group">
                                            <div>
                                                <label class="flowcv-label">Phone</label>
                                                <input type="text" name="references[{{ $i }}][phone]" class="flowcv-input" value="{{ $ref['phone'] ?? '' }}" placeholder="+8801...">
                                            </div>
                                            <div>
                                                <label class="flowcv-label">Email</label>
                                                <input type="email" name="references[{{ $i }}][email]" class="flowcv-input" value="{{ $ref['email'] ?? '' }}" placeholder="referee@org.com">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="flowcv-btn-add" onclick="addReferenceRow()">
                                <i class="fas fa-plus"></i> Add Reference
                            </button>
                        </div>
                    </div>

                    <!-- Bottom Floating Save Bar -->
                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 20px;">
                        <button type="submit" class="flowcv-btn-save" style="padding: 12px 28px; font-size: 15px;">
                            <i class="fas fa-save"></i> Save All Changes
                        </button>
                    </div>
                </div>

                <!-- ================= RIGHT LIVE PREVIEW CANVAS ================= -->
                <div class="flowcv-preview-col">
                    <!-- Preview Toolbar -->
                    <div class="flowcv-preview-toolbar">
                        <div class="flowcv-live-badge">
                            <span class="flowcv-pulse-dot"></span> Real-Time Live Preview
                        </div>

                        <div class="flowcv-zoom-controls">
                            <button type="button" class="flowcv-zoom-btn" onclick="zoomCanvas(0.9)"><i class="fas fa-minus"></i></button>
                            <span style="font-size: 11px; font-weight: 700; color: #475569;" id="zoomLabel">100%</span>
                            <button type="button" class="flowcv-zoom-btn" onclick="zoomCanvas(1.1)"><i class="fas fa-plus"></i></button>
                            <button type="button" class="flowcv-zoom-btn" onclick="resetZoom()">Fit</button>
                        </div>
                    </div>

                    <!-- Scrollable Canvas Viewport -->
                    <div class="flowcv-canvas-scrollbox">
                        <!-- THE A4 CANVAS (Dual-Column Modern FlowCV Layout) -->
                        <div class="flowcv-paper-sheet" id="liveCvSheet">
                            <!-- Left Dark Navy Column -->
                            <div class="fcv-side">
                                <div class="fcv-side-header">
                                    <h1 class="fcv-side-name" id="cv_view_name">{{ $cv?->full_name ?: $user->name }}</h1>
                                    <div class="fcv-side-title" id="cv_view_headline">{{ $headline }}</div>
                                    <img src="{{ $photoUrl }}" alt="Profile" class="fcv-side-avatar" id="cv_view_avatar">

                                    <div class="fcv-side-contacts">
                                        <div class="fcv-side-contact-item">
                                            <i class="fas fa-envelope"></i>
                                            <span id="cv_view_email">{{ $cv?->email ?: $user->email }}</span>
                                        </div>
                                        <div class="fcv-side-contact-item">
                                            <i class="fas fa-phone"></i>
                                            <span id="cv_view_mobile">{{ $cv?->mobile ?: ($user->phone ?: '+880...') }}</span>
                                        </div>
                                        <div class="fcv-side-contact-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span id="cv_view_address">{{ $cv?->present_address ?: 'Panthapath, Dhanmondi, Dhaka-1208' }}</span>
                                        </div>
                                        <div class="fcv-side-contact-item" id="cv_view_linkedin_wrap" style="{{ empty($cv?->linkedin_url) ? 'display:none;' : '' }}">
                                            <i class="fab fa-linkedin"></i>
                                            <span id="cv_view_linkedin">{{ $cv?->linkedin_url }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Side Section 1: Profile -->
                                <div>
                                    <div class="fcv-side-section-title"><i class="fas fa-user-circle"></i> Profile</div>
                                    <p class="fcv-side-summary" id="cv_view_summary">
                                        {{ $cv?->career_summary ?: 'Senior Full-Stack Software Engineer with strong experience in Laravel, Vue.js, Python and scalable architectures.' }}
                                    </p>
                                </div>

                                <!-- Side Section 2: Education -->
                                <div>
                                    <div class="fcv-side-section-title"><i class="fas fa-graduation-cap"></i> Education</div>
                                    <div id="cv_view_education">
                                        @foreach($academics as $edu)
                                            @if(!empty($edu['degree_name']) || !empty($edu['institution']))
                                                <div class="fcv-side-edu-item">
                                                    <p class="fcv-side-edu-degree">{{ $edu['degree_name'] }}</p>
                                                    <p class="fcv-side-edu-inst">{{ $edu['institution'] }}</p>
                                                    <p class="fcv-side-edu-meta">{{ $edu['passing_year'] }} {{ !empty($edu['board_or_university']) ? '| '.$edu['board_or_university'] : '' }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Side Section 3: Training -->
                                <div>
                                    <div class="fcv-side-section-title"><i class="fas fa-certificate"></i> Training</div>
                                    <div id="cv_view_training">
                                        @foreach($trainings as $tr)
                                            @if(!empty($tr['training_title']))
                                                <div class="fcv-side-edu-item">
                                                    <p class="fcv-side-edu-degree">{{ $tr['training_title'] }}</p>
                                                    <p class="fcv-side-edu-inst">{{ $tr['institute'] }}</p>
                                                    <p class="fcv-side-edu-meta">{{ $tr['duration'] }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Right White Main Column -->
                            <div class="fcv-main">
                                <!-- Main Section 1: Professional Experience -->
                                <div>
                                    <div class="fcv-main-section-title"><i class="fas fa-briefcase"></i> Professional Experience</div>
                                    <div id="cv_view_experience">
                                        @foreach($employments as $emp)
                                            @if(!empty($emp['company_name']) || !empty($emp['designation']))
                                                <div class="fcv-job-item">
                                                    <div class="fcv-job-head">
                                                        <span class="fcv-job-company">{{ $emp['company_name'] }}</span>
                                                        <span class="fcv-job-dates">
                                                            {{ $emp['start_date'] ? \Illuminate\Support\Carbon::parse($emp['start_date'])->format('Y') : '' }} - 
                                                            {{ !empty($emp['is_current']) ? 'Present' : ($emp['end_date'] ? \Illuminate\Support\Carbon::parse($emp['end_date'])->format('Y') : '') }}
                                                            {{ !empty($emp['company_location']) ? '| '.$emp['company_location'] : '' }}
                                                        </span>
                                                    </div>
                                                    <div class="fcv-job-role">{{ $emp['designation'] }}</div>
                                                    <p class="fcv-job-desc">{{ $emp['responsibilities'] }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Main Section 2: Technical Skills -->
                                <div>
                                    <div class="fcv-main-section-title"><i class="fas fa-laptop-code"></i> Technical Skills</div>
                                    <div class="fcv-skills-grid" id="cv_view_skills">
                                        @php
                                            $skillsByType = collect($skills)->groupBy('skill_type');
                                        @endphp
                                        @foreach($skillsByType as $type => $group)
                                            <div class="fcv-skill-row">
                                                <span class="fcv-skill-tag-name">{{ $type ?: 'Skills' }}:</span>
                                                <span class="fcv-skill-tag-val">{{ $group->pluck('skill_name')->filter()->implode(', ') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Main Section 3: Projects -->
                                <div>
                                    <div class="fcv-main-section-title"><i class="fas fa-tasks"></i> Projects</div>
                                    <div id="cv_view_projects">
                                        @foreach($projects as $proj)
                                            @if(!empty($proj['title']))
                                                <div class="fcv-proj-item">
                                                    <div class="fcv-proj-title">{{ $proj['title'] }}</div>
                                                    @if(!empty($proj['technologies']))
                                                        <div class="fcv-proj-stack">{{ $proj['technologies'] }}</div>
                                                    @endif
                                                    <p class="fcv-proj-desc">{{ $proj['description'] }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- TAB 3: CHOOSE TEMPLATE SPLIT-VIEW PANEL -->
    <div class="flowcv-tab-panel" id="panel-templates">
        <div class="flowcv-workspace">
            <!-- ================= LEFT COLUMN: TEMPLATE GALLERY & PAGINATION ================= -->
            <div class="flowcv-editor-col">
                <div class="flowcv-identity-card" style="display: block; padding: 20px;">
                    <div style="margin-bottom: 16px;">
                        <h3 style="margin: 0 0 4px; font-size: 19px; font-weight: 800; color: #0f172a !important;">Choose CV Template</h3>
                        <p style="margin: 0; font-size: 13px; color: #64748b;">Click on any template below to immediately preview your real CV data on the right.</p>
                    </div>

                    <!-- Search & Filter Controls -->
                    <div style="display: flex; gap: 10px; margin-bottom: 14px;">
                        <div style="position: relative; flex: 1;">
                            <i class="fas fa-search" style="position: absolute; left: 12px; top: 12px; color: #94a3b8; font-size: 13px;"></i>
                            <input type="text" id="templateSearchInput" class="flowcv-input" placeholder="Search templates by name..." style="padding-left: 34px;">
                        </div>
                    </div>

                    <!-- Category Pills -->
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;" id="templateCategoryPills">
                        <button type="button" class="flowcv-category-pill active" data-cat="all">All</button>
                        @foreach($cvTemplateCategories as $cat)
                            <button type="button" class="flowcv-category-pill" data-cat="{{ $cat }}">{{ $cat }}</button>
                        @endforeach
                    </div>
                </div>

                <!-- Template Cards List -->
                <div id="templateGalleryCards" style="display: flex; flex-direction: column; gap: 14px;">
                    @foreach($templates as $tpl)
                        @php
                            $isSelected = ($selectedCvTemplate?->id ?? 1) == $tpl->id;
                            $thumb = $tpl->thumbnail_url ?: asset('uploads/website-images/templates/' . $tpl->slug . '.webp');
                        @endphp
                        <div class="flowcv-template-list-card {{ $isSelected ? 'active' : '' }}"
                             onclick="selectTemplateFromGallery({{ $tpl->id }}, '{{ $tpl->slug }}', '{{ addslashes($tpl->name) }}', this)">
                            <div class="flowcv-template-thumb-box">
                                <img src="{{ $thumb }}" alt="{{ $tpl->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fas fa-file-alt" style="display: none; font-size: 28px; color: #64748b;"></i>
                            </div>

                            <div class="flowcv-template-card-info">
                                <h4 class="flowcv-template-card-title">{{ $tpl->name }}</h4>
                                <p class="flowcv-template-card-desc">{{ $tpl->description ?: 'Clean professional resume layout designed for maximum interview callbacks.' }}</p>
                                <div class="flowcv-template-card-tags">
                                    @if($tpl->category)<span class="flowcv-template-tag">{{ $tpl->category }}</span>@endif
                                    @if($tpl->style)<span class="flowcv-template-tag" style="background: #f1f5f9; color: #64748b;">{{ $tpl->style }}</span>@endif
                                </div>
                            </div>

                            <span class="flowcv-template-badge-selected"><i class="fas fa-check"></i> Selected</span>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination Bar -->
                <div id="templatePaginationControls" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 18px; background: #ffffff; border-radius: 10px; border: 1px solid var(--fcv-border); margin-top: 8px;">
                    <button type="button" id="btnPrevTemplatesPage" class="flowcv-zoom-btn" style="padding: 7px 16px; font-weight: 700;" disabled onclick="changeTemplatePage(-1)">
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <span id="templatePageStatus" style="font-size: 13px; font-weight: 700; color: #334155;">Page 1 of 1</span>
                    <button type="button" id="btnNextTemplatesPage" class="flowcv-zoom-btn" style="padding: 7px 16px; font-weight: 700;" disabled onclick="changeTemplatePage(1)">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- ================= RIGHT COLUMN: LIVE TEMPLATE PREVIEW ================= -->
            <div class="flowcv-preview-col">
                <div class="flowcv-preview-toolbar">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span class="flowcv-live-badge"><span class="flowcv-pulse-dot"></span> Live Template Preview</span>
                        <span id="activePreviewTemplateBadge" style="font-size: 11.5px; font-weight: 700; color: #172c47; background: #e2e8f0; padding: 3px 10px; border-radius: 6px;">
                            {{ $selectedCvTemplate?->name ?? 'Modern Professional' }}
                        </span>
                    </div>

                    <div class="flowcv-zoom-controls">
                        <button type="button" class="flowcv-zoom-btn" onclick="zoomTemplateIframe(0.9)"><i class="fas fa-minus"></i></button>
                        <span style="font-size: 11px; font-weight: 700; color: #475569;" id="templateZoomLabel">100%</span>
                        <button type="button" class="flowcv-zoom-btn" onclick="zoomTemplateIframe(1.1)"><i class="fas fa-plus"></i></button>
                        <button type="button" class="flowcv-btn-save" style="padding: 6px 14px; font-size: 12px;" onclick="document.querySelector('[data-nav-target=content]').click()">
                            <i class="fas fa-check"></i> Use & Edit Content
                        </button>
                    </div>
                </div>

                <div class="flowcv-canvas-scrollbox" style="padding: 0; background: #eaeff5; border-radius: 8px; border: 1px solid #e2e8f0; width: 100%; height: calc(100vh - 160px); display: flex; justify-content: center; overflow: auto;">
                    <iframe id="templatePreviewIframe"
                            src="{{ profile_route('user.cv.templates.render', ['slug' => $selectedCvTemplate?->slug ?? 'modern']) }}?user_data=1"
                            style="width: 100%; min-width: 630px; height: 100%; min-height: 900px; border: none; background: #ffffff; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 4px; transition: transform 0.2s;"
                            title="Template Real-Time Preview">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 4: AI TOOLS PANEL -->
    <div class="flowcv-tab-panel" id="panel-ai-tools" style="padding: 30px; max-width: 1000px; margin: 0 auto;">
        <div class="flowcv-ai-panel">
            <span class="flowcv-ai-badge"><i class="fas fa-sparkles"></i> AI Resume Assistant</span>
            <h3 style="margin: 0 0 8px; font-size: 20px; color: #0f172a;">High-Impact Action Verbs & Bullet Improver</h3>
            <p style="color: #64748b; font-size: 13.5px; margin-bottom: 24px;">One-click copy or insert ATS-optimized bullet points into your work experience.</p>

            <div class="flowcv-ai-suggestions">
                <div class="flowcv-ai-card">
                    <strong>Architected Scalable Backend</strong>
                    <p>"Architected modular Laravel micro-applications serving 15+ business domains with Passport OAuth2 and Redis caching."</p>
                    <button type="button" class="flowcv-btn-ai-apply" onclick="copyAiText(this, 'Architected modular Laravel micro-applications serving 15+ business domains with Passport OAuth2 and Redis caching.')">Copy Snippet</button>
                </div>
                <div class="flowcv-ai-card">
                    <strong>High-Volume Transaction Processing</strong>
                    <p>"Optimized MySQL complex join queries and SUM(CASE WHEN...) aggregation for real-time POS auditing with sub-second latency."</p>
                    <button type="button" class="flowcv-btn-ai-apply" onclick="copyAiText(this, 'Optimized MySQL complex join queries and SUM(CASE WHEN...) aggregation for real-time POS auditing with sub-second latency.')">Copy Snippet</button>
                </div>
                <div class="flowcv-ai-card">
                    <strong>AI & Automated Workflow Integration</strong>
                    <p>"Engineered LLM RAG pipelines with PostgreSQL Vector & Redis, powering AI WhatsApp and voice assistants handling 500+ daily queries."</p>
                    <button type="button" class="flowcv-btn-ai-apply" onclick="copyAiText(this, 'Engineered LLM RAG pipelines with PostgreSQL Vector & Redis, powering AI WhatsApp and voice assistants handling 500+ daily queries.')">Copy Snippet</button>
                </div>
                <div class="flowcv-ai-card">
                    <strong>DevOps & Zero-Downtime Deployment</strong>
                    <p>"Provisioned Rocky Linux production servers, Virtualmin multi-domain hosting, and automated Let\'s Encrypt SSL via CI/CD pipelines."</p>
                    <button type="button" class="flowcv-btn-ai-apply" onclick="copyAiText(this, 'Provisioned Rocky Linux production servers, Virtualmin multi-domain hosting, and automated Let\'s Encrypt SSL via CI/CD pipelines.')">Copy Snippet</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js_section')
<script>
    // Enable FlowCV Studio Fullscreen layout automatically
    document.body.classList.add('flowcv-studio-active');

    // 1. Navigation Tab Switching
    document.querySelectorAll('.flowcv-nav-tab').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.flowcv-nav-tab').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.flowcv-tab-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            const target = this.getAttribute('data-nav-target');
            const panel = document.getElementById('panel-' + target);
            if (panel) panel.classList.add('active');
        });
    });

    // 2. Accordion Card Toggle
    function toggleCard(header) {
        const card = header.closest('.flowcv-card');
        card.classList.toggle('is-open');
    }

    // 3. More Actions Dropdown
    const btnMore = document.getElementById('btnMoreActions');
    const menuMore = document.getElementById('moreActionsMenu');
    if (btnMore && menuMore) {
        btnMore.addEventListener('click', (e) => {
            e.stopPropagation();
            menuMore.classList.toggle('show');
        });
        document.addEventListener('click', () => menuMore.classList.remove('show'));
    }

    // Toggle Studio Mode
    const btnToggleStudio = document.getElementById('btnToggleStudioMode');
    if (btnToggleStudio) {
        btnToggleStudio.addEventListener('click', () => {
            document.body.classList.toggle('flowcv-studio-active');
        });
    }

    // 4. Live Sync Inputs to Preview Canvas (Real-Time 0ms sync)
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('live-sync')) {
            const targetId = e.target.getAttribute('data-target');
            const el = document.getElementById('cv_view_' + targetId.replace('live_', ''));
            if (el) {
                el.innerText = e.target.value || '';
            }
            // Also sync identity header card
            if (targetId === 'live_name') {
                const b = document.getElementById('badge_name');
                if (b) b.innerText = e.target.value;
            } else if (targetId === 'live_headline') {
                const b = document.getElementById('badge_headline');
                if (b) b.innerText = e.target.value;
            } else if (targetId === 'live_email') {
                const b = document.getElementById('badge_email');
                if (b) b.innerText = e.target.value;
            } else if (targetId === 'live_mobile') {
                const b = document.getElementById('badge_mobile');
                if (b) b.innerText = e.target.value;
            } else if (targetId === 'live_address') {
                const b = document.getElementById('badge_address');
                if (b) b.innerText = e.target.value;
            }
            triggerAutoSave();
        }

        if (e.target.matches('.live-job-company, .live-job-role, .live-job-desc, .live-job-loc, .live-job-start, .live-job-end') ||
            e.target.matches('.live-edu-degree, .live-edu-inst, .live-edu-year, .live-edu-loc') ||
            e.target.matches('.live-skill-name, .live-skill-cat') ||
            e.target.matches('.live-proj-title, .live-proj-tech, .live-proj-desc')) {
            updateLivePreview();
            triggerAutoSave();
        }
    });

    // 5. Live Avatar Photo Upload Preview
    const photoInput = document.getElementById('photoFileInput');
    if (photoInput) {
        photoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('identityAvatarPreview').src = e.target.result;
                    document.getElementById('cv_view_avatar').src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
                triggerAutoSave();
            }
        });
    }

    // 6. Synchronize Repeaters into Right Live Preview
    function updateLivePreview() {
        // Experience
        const expItems = document.querySelectorAll('#experienceList .flowcv-repeater-item');
        const expView = document.getElementById('cv_view_experience');
        if (expView) {
            let html = '';
            expItems.forEach(item => {
                const company = item.querySelector('.live-job-company')?.value || '';
                const role = item.querySelector('.live-job-role')?.value || '';
                const start = item.querySelector('.live-job-start')?.value || '';
                const end = item.querySelector('.live-job-end')?.value || '';
                const isCurrent = item.querySelector('input[type="checkbox"]')?.checked;
                const loc = item.querySelector('.live-job-loc')?.value || '';
                const desc = item.querySelector('.live-job-desc')?.value || '';

                if (company || role) {
                    const dateStr = (start ? start.substring(0,4) : '') + ' - ' + (isCurrent ? 'Present' : (end ? end.substring(0,4) : '')) + (loc ? ' | ' + loc : '');
                    html += `
                        <div class="fcv-job-item">
                            <div class="fcv-job-head">
                                <span class="fcv-job-company">${escapeHtml(company)}</span>
                                <span class="fcv-job-dates">${escapeHtml(dateStr)}</span>
                            </div>
                            <div class="fcv-job-role">${escapeHtml(role)}</div>
                            <p class="fcv-job-desc">${escapeHtml(desc)}</p>
                        </div>
                    `;
                }
            });
            expView.innerHTML = html;
        }

        // Education
        const eduItems = document.querySelectorAll('#educationList .flowcv-repeater-item');
        const eduView = document.getElementById('cv_view_education');
        if (eduView) {
            let html = '';
            eduItems.forEach(item => {
                const degree = item.querySelector('.live-edu-degree')?.value || '';
                const inst = item.querySelector('.live-edu-inst')?.value || '';
                const year = item.querySelector('.live-edu-year')?.value || '';
                const loc = item.querySelector('.live-edu-loc')?.value || '';

                if (degree || inst) {
                    html += `
                        <div class="fcv-side-edu-item">
                            <p class="fcv-side-edu-degree">${escapeHtml(degree)}</p>
                            <p class="fcv-side-edu-inst">${escapeHtml(inst)}</p>
                            <p class="fcv-side-edu-meta">${escapeHtml(year)} ${loc ? '| ' + escapeHtml(loc) : ''}</p>
                        </div>
                    `;
                }
            });
            eduView.innerHTML = html;
        }

        // Skills Grouping
        const skillItems = document.querySelectorAll('#skillsList .flowcv-repeater-item');
        const skillsView = document.getElementById('cv_view_skills');
        if (skillsView) {
            const groups = {};
            skillItems.forEach(item => {
                const name = item.querySelector('.live-skill-name')?.value || '';
                const cat = item.querySelector('.live-skill-cat')?.value || 'Skills';
                if (name) {
                    if (!groups[cat]) groups[cat] = [];
                    groups[cat].push(name);
                }
            });
            let html = '';
            for (const [cat, names] of Object.entries(groups)) {
                html += `
                    <div class="fcv-skill-row">
                        <span class="fcv-skill-tag-name">${escapeHtml(cat)}:</span>
                        <span class="fcv-skill-tag-val">${escapeHtml(names.join(', '))}</span>
                    </div>
                `;
            }
            skillsView.innerHTML = html;
        }

        // Projects
        const projItems = document.querySelectorAll('#projectsList .flowcv-repeater-item');
        const projView = document.getElementById('cv_view_projects');
        if (projView) {
            let html = '';
            projItems.forEach(item => {
                const title = item.querySelector('.live-proj-title')?.value || '';
                const tech = item.querySelector('.live-proj-tech')?.value || '';
                const desc = item.querySelector('.live-proj-desc')?.value || '';

                if (title) {
                    html += `
                        <div class="fcv-proj-item">
                            <div class="fcv-proj-title">${escapeHtml(title)}</div>
                            ${tech ? `<div class="fcv-proj-stack">${escapeHtml(tech)}</div>` : ''}
                            <p class="fcv-proj-desc">${escapeHtml(desc)}</p>
                        </div>
                    `;
                }
            });
            projView.innerHTML = html;
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // 7. Add Repeater Rows
    function addEducationRow() {
        const list = document.getElementById('educationList');
        const count = list.children.length;
        const div = document.createElement('div');
        div.className = 'flowcv-repeater-item';
        div.innerHTML = `
            <div class="flowcv-item-header">
                <span class="flowcv-item-title">Education #${count + 1}</span>
                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'education')"><i class="fas fa-trash"></i></button>
            </div>
            <div class="flowcv-field-group">
                <div>
                    <label class="flowcv-label">Degree / Certificate</label>
                    <input type="text" name="academics[${count}][degree_name]" class="flowcv-input live-edu-degree" placeholder="e.g. Master in Science">
                </div>
                <div>
                    <label class="flowcv-label">Institution Name</label>
                    <input type="text" name="academics[${count}][institution]" class="flowcv-input live-edu-inst" placeholder="University name">
                </div>
            </div>
            <div class="flowcv-field-group">
                <div>
                    <label class="flowcv-label">Passing Year</label>
                    <input type="text" name="academics[${count}][passing_year]" class="flowcv-input live-edu-year" placeholder="2024">
                </div>
                <div>
                    <label class="flowcv-label">Board / Result / Location</label>
                    <input type="text" name="academics[${count}][board_or_university]" class="flowcv-input live-edu-loc" placeholder="Location">
                </div>
            </div>
        `;
        list.appendChild(div);
        document.getElementById('edu_count').innerText = count + 1;
    }

    function addExperienceRow() {
        const list = document.getElementById('experienceList');
        const count = list.children.length;
        const div = document.createElement('div');
        div.className = 'flowcv-repeater-item';
        div.innerHTML = `
            <div class="flowcv-item-header">
                <span class="flowcv-item-title">Position #${count + 1}</span>
                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'experience')"><i class="fas fa-trash"></i></button>
            </div>
            <div class="flowcv-field-group">
                <div>
                    <label class="flowcv-label">Company Name *</label>
                    <input type="text" name="employments[${count}][company_name]" class="flowcv-input live-job-company" placeholder="Company Name">
                </div>
                <div>
                    <label class="flowcv-label">Job Title / Designation *</label>
                    <input type="text" name="employments[${count}][designation]" class="flowcv-input live-job-role" placeholder="Software Engineer">
                </div>
            </div>
            <div class="flowcv-field-group">
                <div>
                    <label class="flowcv-label">Start Date</label>
                    <input type="date" name="employments[${count}][start_date]" class="flowcv-input live-job-start">
                </div>
                <div>
                    <label class="flowcv-label">End Date</label>
                    <input type="date" name="employments[${count}][end_date]" class="flowcv-input live-job-end">
                    <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; margin-top: 5px; color: #64748b; cursor: pointer;">
                        <input type="checkbox" name="employments[${count}][is_current]" value="1" onchange="const end = this.closest('.flowcv-field-group').querySelector('.live-job-end'); end.disabled = this.checked; updateLivePreview();">
                        Currently Working Here
                    </label>
                </div>
            </div>
            <div class="flowcv-field-group">
                <div class="flowcv-field-full">
                    <label class="flowcv-label">Key Responsibilities & Achievements (Bullet Points)</label>
                    <textarea name="employments[${count}][responsibilities]" class="flowcv-textarea live-job-desc" rows="3" placeholder="• Achieved..."></textarea>
                </div>
            </div>
        `;
        list.appendChild(div);
    }

    function addSkillRow() {
        const list = document.getElementById('skillsList');
        const count = list.children.length;
        const div = document.createElement('div');
        div.className = 'flowcv-repeater-item';
        div.style.padding = '12px';
        div.innerHTML = `
            <div style="display: flex; gap: 10px; align-items: center;">
                <div style="flex: 2;">
                    <input type="text" name="skills[${count}][skill_name]" class="flowcv-input live-skill-name" placeholder="Skill Name">
                </div>
                <div style="flex: 1.5;">
                    <select name="skills[${count}][skill_type]" class="flowcv-select live-skill-cat">
                        <option value="AI">AI & LLM</option>
                        <option value="Backend" selected>Backend</option>
                        <option value="Frontend">Frontend</option>
                        <option value="Database">Database</option>
                        <option value="DevOps">DevOps</option>
                        <option value="Integration">Integration</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <select name="skills[${count}][skill_level]" class="flowcv-select">
                        <option value="Expert" selected>Expert</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Basic">Basic</option>
                    </select>
                </div>
                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'skills')"><i class="fas fa-trash"></i></button>
            </div>
        `;
        list.appendChild(div);
    }

    function addProjectRow() {
        const list = document.getElementById('projectsList');
        const count = list.children.length;
        const div = document.createElement('div');
        div.className = 'flowcv-repeater-item';
        div.innerHTML = `
            <div class="flowcv-item-header">
                <span class="flowcv-item-title">Project #${count + 1}</span>
                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'projects')"><i class="fas fa-trash"></i></button>
            </div>
            <div class="flowcv-field-group">
                <div>
                    <label class="flowcv-label">Project Title *</label>
                    <input type="text" name="projects[${count}][title]" class="flowcv-input live-proj-title" placeholder="Project Name">
                </div>
                <div>
                    <label class="flowcv-label">Technologies Used</label>
                    <input type="text" name="projects[${count}][technologies]" class="flowcv-input live-proj-tech" placeholder="Stack">
                </div>
            </div>
            <div class="flowcv-field-group">
                <div class="flowcv-field-full">
                    <label class="flowcv-label">Project Overview</label>
                    <textarea name="projects[${count}][description]" class="flowcv-textarea live-proj-desc" rows="2" placeholder="Summary..."></textarea>
                </div>
            </div>
        `;
        list.appendChild(div);
    }

    function addTrainingRow() {
        const list = document.getElementById('trainingList');
        const count = list.children.length;
        const div = document.createElement('div');
        div.className = 'flowcv-repeater-item';
        div.innerHTML = `
            <div class="flowcv-item-header">
                <span class="flowcv-item-title">Training #${count + 1}</span>
                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'training')"><i class="fas fa-trash"></i></button>
            </div>
            <div class="flowcv-field-group">
                <div>
                    <label class="flowcv-label">Training Title</label>
                    <input type="text" name="trainings[${count}][training_title]" class="flowcv-input live-train-title" placeholder="Course Name">
                </div>
                <div>
                    <label class="flowcv-label">Institute / Program</label>
                    <input type="text" name="trainings[${count}][institute]" class="flowcv-input live-train-inst" placeholder="Institute">
                </div>
            </div>
        `;
        list.appendChild(div);
    }

    function addReferenceRow() {
        const list = document.getElementById('referencesList');
        const count = list.children.length;
        const div = document.createElement('div');
        div.className = 'flowcv-repeater-item';
        div.innerHTML = `
            <div class="flowcv-item-header">
                <span class="flowcv-item-title">Reference #${count + 1}</span>
                <button type="button" class="flowcv-btn-delete" onclick="removeRepeaterRow(this, 'references')"><i class="fas fa-trash"></i></button>
            </div>
            <div class="flowcv-field-group">
                <div>
                    <label class="flowcv-label">Referee Name</label>
                    <input type="text" name="references[${count}][name]" class="flowcv-input" placeholder="Name">
                </div>
                <div>
                    <label class="flowcv-label">Designation & Org</label>
                    <input type="text" name="references[${count}][designation]" class="flowcv-input" placeholder="Role">
                </div>
            </div>
        `;
        list.appendChild(div);
    }

    function removeRepeaterRow(btn, type) {
        const item = btn.closest('.flowcv-repeater-item');
        if (item) {
            item.remove();
            updateLivePreview();
            triggerAutoSave();
        }
    }

    // 8. Auto-Save via AJAX (Debounced)
    let autoSaveTimer = null;
    function triggerAutoSave() {
        const statusEl = document.getElementById('saveStatusIndicator');
        if (statusEl) {
            statusEl.className = 'flowcv-save-status';
            statusEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        }

        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(saveFormDataAjax, 1500);
    }

    function saveFormDataAjax() {
        const form = document.getElementById('cvMainForm');
        if (!form) return;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            const statusEl = document.getElementById('saveStatusIndicator');
            if (statusEl) {
                statusEl.className = 'flowcv-save-status saved';
                statusEl.innerHTML = '<i class="fas fa-check-circle"></i> Saved';
            }
        })
        .catch(err => {
            console.error('AutoSave Error:', err);
            const statusEl = document.getElementById('saveStatusIndicator');
            if (statusEl) {
                statusEl.className = 'flowcv-save-status';
                statusEl.innerHTML = '<i class="fas fa-exclamation-circle" style="color: #ef4444;"></i> Save Failed';
            }
        });
    }

    const btnManual = document.getElementById('btnManualSave');
    if (btnManual) {
        btnManual.addEventListener('click', () => {
            saveFormDataAjax();
        });
    }

    // 9. Zoom Canvas Controls
    let currentScale = 1.0;
    function zoomCanvas(factor) {
        currentScale = Math.min(Math.max(currentScale * factor, 0.6), 1.6);
        applyScale();
    }
    function resetZoom() {
        currentScale = 1.0;
        applyScale();
    }
    function applyScale() {
        const sheet = document.getElementById('liveCvSheet');
        const label = document.getElementById('zoomLabel');
        if (sheet) {
            sheet.style.transform = `scale(${currentScale})`;
        }
        if (label) {
            label.innerText = Math.round(currentScale * 100) + '%';
        }
    }

    // 10. Copy AI Snippet
    function copyAiText(btn, text) {
        navigator.clipboard.writeText(text).then(() => {
            const prev = btn.innerText;
            btn.innerText = 'Copied!';
            btn.style.background = '#10b981';
            setTimeout(() => {
                btn.innerText = prev;
                btn.style.background = '#172c47';
            }, 1800);
        });
    }

    // ==========================================
    // 11. CHOOSE TEMPLATE GALLERY & LIVE PREVIEW
    // ==========================================
    const renderUrlPattern = "{{ profile_route('user.cv.templates.render', ['slug' => ':slug']) }}";
    const selectTemplateUrl = "{{ profile_route('user.cv.templates.select') }}";
    const indexTemplatesUrl = "{{ profile_route('user.cv.templates.index') }}";

    let templateCurrentPage = 1;
    let templateCurrentCat = 'all';
    let templateSearchTerm = '';
    let templateTotalPages = 1;

    function selectTemplateFromGallery(id, slug, name, cardEl) {
        // 1. Update active card highlight
        document.querySelectorAll('.flowcv-template-list-card').forEach(c => c.classList.remove('active'));
        if (cardEl) cardEl.classList.add('active');

        // 2. Update hidden form input & navbar selector
        const inputTpl = document.getElementById('input_template_id');
        if (inputTpl) inputTpl.value = id;

        // 3. Update right side preview badge & iframe source
        const badge = document.getElementById('activePreviewTemplateBadge');
        if (badge) badge.innerText = name;

        const iframe = document.getElementById('templatePreviewIframe');
        if (iframe) {
            iframe.src = renderUrlPattern.replace(':slug', slug) + '?user_data=1';
        }

        // 4. Save template selection immediately via AJAX
        fetch(selectTemplateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ template_id: id })
        })
        .then(res => res.json())
        .then(data => {
            const statusEl = document.getElementById('saveStatusIndicator');
            if (statusEl) {
                statusEl.className = 'flowcv-save-status saved';
                statusEl.innerHTML = '<i class="fas fa-check-circle"></i> Template Applied';
            }
        })
        .catch(err => console.error('Template Select Error:', err));
    }

    // Zoom Template Iframe
    let templateIframeScale = 1.0;
    function zoomTemplateIframe(factor) {
        templateIframeScale = Math.min(Math.max(templateIframeScale * factor, 0.6), 1.6);
        const iframe = document.getElementById('templatePreviewIframe');
        const label = document.getElementById('templateZoomLabel');
        if (iframe) {
            iframe.style.transform = `scale(${templateIframeScale})`;
            iframe.style.transformOrigin = 'top center';
        }
        if (label) {
            label.innerText = Math.round(templateIframeScale * 100) + '%';
        }
    }

    // AJAX Template Gallery Loader
    function loadTemplatesGallery(page = 1, category = 'all', search = '') {
        const container = document.getElementById('templateGalleryCards');
        if (!container) return;

        let url = `${indexTemplatesUrl}?type=cv&page=${page}`;
        if (category && category !== 'all') url += `&category=${encodeURIComponent(category)}`;
        if (search) url += `&search=${encodeURIComponent(search)}`;

        container.style.opacity = '0.5';

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            container.style.opacity = '1';
            if (!res.success) return;

            const selectedId = parseInt(document.getElementById('input_template_id')?.value || 1);
            templateCurrentPage = res.pagination.current_page;
            templateTotalPages = res.pagination.last_page || 1;

            // Render cards
            let html = '';
            if (res.data.length === 0) {
                html = '<div style="padding: 30px; text-align: center; color: #64748b; background: #fff; border-radius: 10px; border: 1px solid #e2e8f0;">No templates found matching your search.</div>';
            } else {
                res.data.forEach(t => {
                    const isSel = parseInt(t.id) === selectedId;
                    const thumb = t.thumbnail || `/uploads/website-images/templates/${t.slug}.webp`;
                    html += `
                        <div class="flowcv-template-list-card ${isSel ? 'active' : ''}"
                             onclick="selectTemplateFromGallery(${t.id}, '${t.slug}', '${escapeHtml(t.name)}', this)">
                            <div class="flowcv-template-thumb-box">
                                <img src="${thumb}" alt="${escapeHtml(t.name)}" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fas fa-file-alt" style="display: none; font-size: 28px; color: #64748b;"></i>
                            </div>

                            <div class="flowcv-template-card-info">
                                <h4 class="flowcv-template-card-title">${escapeHtml(t.name)}</h4>
                                <p class="flowcv-template-card-desc">${escapeHtml(t.description || 'Clean professional resume layout designed for maximum interview callbacks.')}</p>
                                <div class="flowcv-template-card-tags">
                                    ${t.category ? `<span class="flowcv-template-tag">${escapeHtml(t.category)}</span>` : ''}
                                    ${t.style ? `<span class="flowcv-template-tag" style="background: #f1f5f9; color: #64748b;">${escapeHtml(t.style)}</span>` : ''}
                                </div>
                            </div>

                            <span class="flowcv-template-badge-selected"><i class="fas fa-check"></i> Selected</span>
                        </div>
                    `;
                });
            }
            container.innerHTML = html;

            // Update Pagination
            const pageStatus = document.getElementById('templatePageStatus');
            if (pageStatus) {
                pageStatus.innerText = `Page ${templateCurrentPage} of ${templateTotalPages}`;
            }

            const btnPrev = document.getElementById('btnPrevTemplatesPage');
            const btnNext = document.getElementById('btnNextTemplatesPage');
            if (btnPrev) btnPrev.disabled = (templateCurrentPage <= 1);
            if (btnNext) btnNext.disabled = (templateCurrentPage >= templateTotalPages);
        })
        .catch(err => {
            container.style.opacity = '1';
            console.error('Gallery Load Error:', err);
        });
    }

    function changeTemplatePage(delta) {
        const targetPage = templateCurrentPage + delta;
        if (targetPage >= 1 && targetPage <= templateTotalPages) {
            loadTemplatesGallery(targetPage, templateCurrentCat, templateSearchTerm);
        }
    }

    // Category pills click handler
    document.querySelectorAll('#templateCategoryPills .flowcv-category-pill').forEach(pill => {
        pill.addEventListener('click', function() {
            document.querySelectorAll('#templateCategoryPills .flowcv-category-pill').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            templateCurrentCat = this.getAttribute('data-cat');
            loadTemplatesGallery(1, templateCurrentCat, templateSearchTerm);
        });
    });

    // Search input handler (debounced 350ms)
    let searchDebounce = null;
    const searchInput = document.getElementById('templateSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchDebounce);
            templateSearchTerm = this.value.trim();
            searchDebounce = setTimeout(() => {
                loadTemplatesGallery(1, templateCurrentCat, templateSearchTerm);
            }, 350);
        });
    }
</script>
@endpush
