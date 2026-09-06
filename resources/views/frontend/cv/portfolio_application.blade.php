@php
    $photoSrc = $cv->photo ? asset($cv->photo) : asset('uploads/website-images/avatar-image-2024-07-02-10-08-24-5849.png');
    $currentEmployment = $cv->employments->firstWhere('is_current', true) ?: $cv->employments->first();
    $primaryRole = $currentEmployment?->designation ?: 'Senior Software Engineer';
    $currentCompany = $currentEmployment?->company_name ?: 'TechSeba';
    $summarySource = $cv->career_summary ?: $cv->career_objective;
    $summary = $summarySource ?: 'Experienced software engineer specialized in building enterprise web applications, high-performance APIs, and scalable modular database architectures.';
    
    $experienceYears = $cv->total_experience ? rtrim(rtrim(number_format((float) $cv->total_experience, 1), '0'), '.') . '+ Years' : '3.5+ Years';

    // Skill categorizations
    $technicalSkills = $cv->skills->filter(fn ($s) => in_array($s->skill_type, ['Technical Skills', 'Computer Skills', 'Software Skills']));
    $otherSkills = $cv->skills->filter(fn ($s) => !in_array($s->skill_type, ['Technical Skills', 'Computer Skills', 'Software Skills']));
    
    $ratings = is_array($cv->proficiency_ratings) ? $cv->proficiency_ratings : [];
    
    $formatDate = function ($date) {
        return $date ? \Illuminate\Support\Carbon::parse($date)->format('M Y') : 'Present';
    };
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cv->full_name }} — {{ $primaryRole }} Portfolio</title>

    <meta name="description" content="{{ Str::limit(strip_tags($summary), 160) }}">
    <meta property="og:title" content="{{ $cv->full_name }} — {{ $primaryRole }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($summary), 160) }}">
    <meta property="og:type" content="website">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-surface: #ffffff;
            --bg-subtle: #f1f5f9;
            --text-main: #0f172a;
            --text-muted: #475569;
            --text-subtle: #64748b;
            
            --primary: #0f172a;
            --primary-light: #1e293b;
            --accent: #2563eb;
            --accent-hover: #1d4ed8;
            --accent-soft: #eff6ff;
            --accent-border: #bfdbfe;

            --border: #e2e8f0;
            --border-dark: #cbd5e1;
            
            --success: #16a34a;
            --success-soft: #f0fdf4;
            --card-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.04), 0 2px 4px -2px rgba(15, 23, 42, 0.03);
            --hover-shadow: 0 12px 24px -4px rgba(15, 23, 42, 0.08), 0 4px 8px -2px rgba(15, 23, 42, 0.04);
            
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-full: 9999px;
            
            --font-main: 'Inter', system-ui, -apple-system, sans-serif;
            --font-heading: 'Plus Jakarta Sans', var(--font-main);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: var(--font-main);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .container {
            width: min(1180px, calc(100% - 3rem));
            margin-inline: auto;
        }

        /* Top Bar / Header Navigation */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 1.125rem;
            color: var(--primary);
        }

        .brand-avatar {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            object-fit: cover;
            border: 2px solid var(--border);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
            list-style: none;
        }

        .nav-links a {
            font-size: 0.925rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0.65rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid transparent;
            font-family: var(--font-heading);
            white-space: nowrap;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
            transform: translateY(-1px);
        }

        .btn-accent {
            background-color: var(--accent);
            color: #ffffff;
        }

        .btn-accent:hover {
            background-color: var(--accent-hover);
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
            transform: translateY(-1px);
        }

        .btn-outline {
            background-color: var(--bg-surface);
            color: var(--text-main);
            border-color: var(--border-dark);
        }

        .btn-outline:hover {
            background-color: var(--bg-subtle);
            border-color: var(--text-muted);
        }

        .btn-sm {
            padding: 0.45rem 0.9rem;
            font-size: 0.825rem;
        }

        /* Hero Section */
        .hero-section {
            padding: 4.5rem 0 3.5rem;
            background: linear-gradient(180deg, #ffffff 0%, var(--bg-body) 100%);
            border-bottom: 1px solid var(--border);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 3.5rem;
            align-items: start;
        }

        .hero-photo-wrapper {
            position: relative;
        }

        .hero-photo {
            width: 100%;
            aspect-ratio: 1 / 1.15;
            object-fit: cover;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--hover-shadow);
            background: #fff;
        }

        .status-badge {
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: #ffffff;
            border: 1px solid var(--border);
            padding: 6px 14px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-main);
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            white-space: nowrap;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--success);
            box-shadow: 0 0 0 3px var(--success-soft);
        }

        .hero-content h1 {
            font-family: var(--font-heading);
            font-size: 2.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--primary);
            line-height: 1.15;
            margin-bottom: 0.5rem;
        }

        .hero-role {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hero-role .company-tag {
            color: var(--text-muted);
            font-weight: 400;
            font-size: 1rem;
        }

        .hero-bio {
            font-size: 1.05rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 1.75rem;
            max-width: 780px;
        }

        .hero-meta-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 18px 28px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .meta-item i {
            color: var(--accent);
            font-size: 0.95rem;
        }

        .hero-cta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
            margin-bottom: 2rem;
        }

        .social-links {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: var(--bg-surface);
            border: 1px solid var(--border);
            display: grid;
            place-items: center;
            color: var(--text-muted);
            font-size: 1.1rem;
            transition: all 0.2s ease;
        }

        .social-icon:hover {
            color: var(--accent);
            border-color: var(--accent-border);
            background: var(--accent-soft);
            transform: translateY(-2px);
        }

        /* Metrics Bar */
        .metrics-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            padding: 1.5rem;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--card-shadow);
        }

        .metric-card {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .metric-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-md);
            background: var(--accent-soft);
            color: var(--accent);
            display: grid;
            place-items: center;
            font-size: 1.15rem;
            flex-shrink: 0;
        }

        .metric-data {
            line-height: 1.25;
        }

        .metric-value {
            font-family: var(--font-heading);
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--primary);
        }

        .metric-label {
            font-size: 0.8rem;
            color: var(--text-subtle);
            font-weight: 500;
        }

        /* Section Commons */
        .section {
            padding: 4.5rem 0;
        }

        .section-header {
            margin-bottom: 3rem;
            text-align: left;
        }

        .section-title-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .section-title {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.02em;
        }

        .section-subtitle {
            font-size: 1rem;
            color: var(--text-muted);
            margin-top: 0.4rem;
            max-width: 650px;
        }

        /* About & Deep Insights Section */
        .insights-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: var(--card-shadow);
            transition: all 0.25s ease;
        }

        .card:hover {
            box-shadow: var(--hover-shadow);
            border-color: var(--border-dark);
        }

        .card-full {
            grid-column: 1 / -1;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.25rem;
        }

        .card-icon {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-md);
            background: var(--primary);
            color: #fff;
            display: grid;
            place-items: center;
            font-size: 1rem;
        }

        .card-title {
            font-family: var(--font-heading);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
        }

        .card-body {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.75;
            white-space: pre-line;
        }

        /* Skill Matrix */
        .skills-matrix {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem;
        }

        .skill-group-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            box-shadow: var(--card-shadow);
        }

        .skill-group-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border);
        }

        .skill-group-title {
            font-family: var(--font-heading);
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .skill-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .skill-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: var(--radius-md);
            background: var(--bg-subtle);
            border: 1px solid var(--border);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .skill-pill i {
            color: var(--accent);
            font-size: 0.8rem;
        }

        .skill-pill.featured {
            background: var(--accent-soft);
            border-color: var(--accent-border);
            color: var(--accent);
        }

        /* Deep Rating Cards */
        .proficiency-accordion {
            margin-top: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 1.25rem;
        }

        .proficiency-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 1.25rem;
        }

        .prof-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .prof-name {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--primary);
        }

        .stars {
            color: #eab308;
            font-size: 0.8rem;
            display: flex;
            gap: 3px;
        }

        .prof-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.55;
        }

        /* Experience Timeline */
        .timeline {
            position: relative;
            max-width: 960px;
            margin: 0 auto;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 10px;
            bottom: 10px;
            left: 20px;
            width: 2px;
            background: var(--border);
        }

        .timeline-item {
            position: relative;
            padding-left: 60px;
            margin-bottom: 2.5rem;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: 11px;
            top: 20px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--bg-surface);
            border: 3px solid var(--accent);
            z-index: 2;
        }

        .timeline-item.current .timeline-dot {
            background: var(--accent);
            box-shadow: 0 0 0 4px var(--accent-soft);
        }

        .timeline-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: var(--card-shadow);
        }

        .timeline-header {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 1rem;
        }

        .role-title {
            font-family: var(--font-heading);
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary);
        }

        .company-name {
            font-size: 1rem;
            font-weight: 600;
            color: var(--accent);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 2px;
        }

        .duration-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: var(--radius-full);
            background: var(--bg-subtle);
            border: 1px solid var(--border);
            font-size: 0.825rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .duration-badge.current {
            background: var(--success-soft);
            border-color: #bbf7d0;
            color: var(--success);
        }

        .responsibilities-list {
            margin-top: 1rem;
            padding-left: 1.25rem;
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .responsibilities-list li {
            margin-bottom: 0.5rem;
        }

        .achievement-highlight {
            margin-top: 1.25rem;
            padding: 1rem;
            background: #fffbe6;
            border: 1px solid #fef08a;
            border-radius: var(--radius-md);
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.9rem;
            color: #854d0e;
        }

        .achievement-highlight i {
            color: #ca8a04;
            font-size: 1rem;
            margin-top: 2px;
        }

        /* Case Studies / Projects Section */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 2rem;
        }

        .project-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .project-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--hover-shadow);
            border-color: var(--border-dark);
        }

        .project-content {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .project-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 0.75rem;
        }

        .project-title {
            font-family: var(--font-heading);
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.3;
        }

        .project-role-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            background: var(--bg-subtle);
            color: var(--text-muted);
            font-size: 0.775rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .case-block {
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .case-label {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 0.775rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-subtle);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .case-text {
            color: var(--text-muted);
            line-height: 1.6;
        }

        .project-tech-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: auto;
            padding-top: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .tech-pill {
            padding: 3px 9px;
            border-radius: var(--radius-sm);
            background: var(--accent-soft);
            color: var(--accent);
            font-size: 0.775rem;
            font-weight: 600;
        }

        .project-footer {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        /* Education & Qualifications */
        .edu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem;
        }

        .edu-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            box-shadow: var(--card-shadow);
        }

        .edu-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-md);
            background: var(--accent-soft);
            color: var(--accent);
            display: grid;
            place-items: center;
            font-size: 1.1rem;
            margin-bottom: 1.25rem;
        }

        .edu-degree {
            font-family: var(--font-heading);
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 4px;
        }

        .edu-inst {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .edu-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.85rem;
            color: var(--text-subtle);
        }

        /* Resume Preview Section */
        .resume-preview-box {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 3rem;
            box-shadow: var(--card-shadow);
            max-width: 920px;
            margin: 0 auto;
        }

        .resume-preview-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 2rem;
            border-bottom: 2px solid var(--primary);
            margin-bottom: 2rem;
        }

        .cv-title-name {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
        }

        /* References Grid */
        .references-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .ref-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 1.5rem;
        }

        .ref-name {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--primary);
        }

        .ref-role {
            font-size: 0.875rem;
            color: var(--accent);
            font-weight: 600;
            margin-bottom: 4px;
        }

        .ref-org {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
        }

        /* Contact Section */
        .contact-section {
            background: linear-gradient(180deg, var(--bg-body) 0%, #ffffff 100%);
            border-top: 1px solid var(--border);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 3.5rem;
            align-items: start;
        }

        .contact-info-list {
            display: grid;
            gap: 1.25rem;
            margin-top: 1.5rem;
        }

        .contact-item-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .contact-item-icon {
            width: 46px;
            height: 46px;
            border-radius: var(--radius-md);
            background: var(--accent-soft);
            color: var(--accent);
            display: grid;
            place-items: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .contact-item-label {
            font-size: 0.8rem;
            color: var(--text-subtle);
            font-weight: 600;
            text-transform: uppercase;
        }

        .contact-item-val {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.95rem;
        }

        .contact-form-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            box-shadow: var(--card-shadow);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 6px;
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.925rem;
            font-family: var(--font-main);
            border: 1px solid var(--border-dark);
            border-radius: var(--radius-md);
            background: var(--bg-body);
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--accent);
            background: #ffffff;
            box-shadow: 0 0 0 3px var(--accent-soft);
        }

        /* Footer */
        .site-footer {
            padding: 2.5rem 0;
            border-top: 1px solid var(--border);
            background: var(--primary);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .footer-inner {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        .footer-brand {
            color: #ffffff;
            font-family: var(--font-heading);
            font-weight: 700;
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .hero-photo {
                max-width: 220px;
            }
            .metrics-bar {
                grid-template-columns: repeat(2, 1fr);
            }
            .insights-grid {
                grid-template-columns: 1fr;
            }
            .contact-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .hero-content h1 {
                font-size: 2.15rem;
            }
            .metrics-bar {
                grid-template-columns: 1fr;
            }
            .projects-grid {
                grid-template-columns: 1fr;
            }
            .timeline::before {
                left: 10px;
            }
            .timeline-item {
                padding-left: 36px;
            }
            .timeline-dot {
                left: 1px;
            }
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="navbar">
        <div class="container nav-inner">
            <a href="#" class="brand">
                <img src="{{ $photoSrc }}" alt="{{ $cv->full_name }}" class="brand-avatar">
                <span>{{ $cv->full_name }}</span>
            </a>
            
            <ul class="nav-links">
                <li><a href="#about">About</a></li>
                <li><a href="#skills">Skills</a></li>
                <li><a href="#experience">Experience</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#education">Education</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>

            <div class="nav-actions">
                @if(route('public.cv.print', $username))
                    <a href="{{ route('public.cv.print', $username) }}" target="_blank" class="btn btn-outline btn-sm">
                        <i class="fa-solid fa-file-pdf"></i> Print CV
                    </a>
                @endif
                <a href="#contact" class="btn btn-primary btn-sm">Hire Me</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-photo-wrapper">
                    <img src="{{ $photoSrc }}" alt="{{ $cv->full_name }}" class="hero-photo">
                    <div class="status-badge">
                        <span class="status-dot"></span>
                        <span>Available for Opportunities</span>
                    </div>
                </div>

                <div class="hero-content">
                    <h1>{{ $cv->full_name }}</h1>
                    <div class="hero-role">
                        <span>{{ $primaryRole }}</span>
                        @if($currentCompany)
                            <span class="company-tag">at {{ $currentCompany }}</span>
                        @endif
                    </div>

                    <p class="hero-bio">
                        {{ $summary }}
                    </p>

                    <div class="hero-meta-grid">
                        @if($cv->present_address)
                            <div class="meta-item">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>{{ $cv->present_address }}</span>
                            </div>
                        @endif
                        @if($cv->email)
                            <div class="meta-item">
                                <i class="fa-solid fa-envelope"></i>
                                <span>{{ $cv->email }}</span>
                            </div>
                        @endif
                        @if($cv->mobile)
                            <div class="meta-item">
                                <i class="fa-solid fa-phone"></i>
                                <span>{{ $cv->mobile }}</span>
                            </div>
                        @endif
                        <div class="meta-item">
                            <i class="fa-solid fa-briefcase"></i>
                            <span>{{ $experienceYears }} Professional Experience</span>
                        </div>
                    </div>

                    <div class="hero-cta">
                        <a href="#projects" class="btn btn-accent">
                            <i class="fa-solid fa-diagram-project"></i> View Featured Projects
                        </a>
                        <a href="#resume" class="btn btn-outline">
                            <i class="fa-solid fa-file-invoice"></i> Resume Preview
                        </a>

                        <div class="social-links">
                            @if($cv->linkedin_url)
                                <a href="{{ $cv->linkedin_url }}" target="_blank" class="social-icon" title="LinkedIn">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                            @endif
                            @if($cv->github_url)
                                <a href="{{ $cv->github_url }}" target="_blank" class="social-icon" title="GitHub">
                                    <i class="fa-brands fa-github"></i>
                                </a>
                            @endif
                            @if($cv->website_url)
                                <a href="{{ $cv->website_url }}" target="_blank" class="social-icon" title="Website">
                                    <i class="fa-solid fa-globe"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Metrics Grid -->
                    <div class="metrics-bar">
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                            <div class="metric-data">
                                <div class="metric-value">{{ $experienceYears }}</div>
                                <div class="metric-label">Tech Industry Experience</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fa-solid fa-code"></i></div>
                            <div class="metric-data">
                                <div class="metric-value">{{ $cv->projects->count() ?: 5 }}+</div>
                                <div class="metric-label">Commercial Web Applications</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fa-solid fa-layer-group"></i></div>
                            <div class="metric-data">
                                <div class="metric-value">Laravel / React</div>
                                <div class="metric-label">Core Engineering Stack</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                            <div class="metric-data">
                                <div class="metric-value">IsDB PGD</div>
                                <div class="metric-label">Web Application Dev</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Deep Engineering Insights & Architecture Section -->
    <section class="section" id="about">
        <div class="container">
            <div class="section-header">
                <span class="section-title-tag"><i class="fa-solid fa-microchip"></i> Engineering Focus</span>
                <h2 class="section-title">Background & Architecture Experience</h2>
                <p class="section-subtitle">Deep dive into software engineering philosophy, complex problem-solving, and scratch-built system architectures.</p>
            </div>

            <div class="insights-grid">
                @if($cv->technical_challenge)
                    <div class="card card-full">
                        <div class="card-header">
                            <div class="card-icon"><i class="fa-solid fa-gears"></i></div>
                            <h3 class="card-title">Complex Technical Challenge Solved</h3>
                        </div>
                        <div class="card-body">
                            {{ $cv->technical_challenge }}
                        </div>
                    </div>
                @endif

                @if($cv->built_from_scratch)
                    <div class="card">
                        <div class="card-header">
                            <div class="card-icon" style="background: var(--accent);"><i class="fa-solid fa-code-commit"></i></div>
                            <h3 class="card-title">Systems Built From Scratch</h3>
                        </div>
                        <div class="card-body">
                            {{ $cv->built_from_scratch }}
                        </div>
                    </div>
                @endif

                @if($cv->sparks_joy)
                    <div class="card">
                        <div class="card-header">
                            <div class="card-icon" style="background: #059669;"><i class="fa-solid fa-heart"></i></div>
                            <h3 class="card-title">Leadership & Passion Beyond Code</h3>
                        </div>
                        <div class="card-body">
                            {{ $cv->sparks_joy }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Technical Skills Section -->
    <section class="section" id="skills" style="background: var(--bg-surface); border-y: 1px solid var(--border);">
        <div class="container">
            <div class="section-header">
                <span class="section-title-tag"><i class="fa-solid fa-laptop-code"></i> Technical Matrix</span>
                <h2 class="section-title">Core Skills & Engineering Competencies</h2>
                <p class="section-subtitle">Categorized proficiency across modern full-stack web technologies, databases, and enterprise software practices.</p>
            </div>

            <div class="skills-matrix">
                <!-- Backend Group -->
                <div class="skill-group-card">
                    <div class="skill-group-header">
                        <span class="skill-group-title"><i class="fa-solid fa-server" style="color: var(--accent);"></i> Backend & Frameworks</span>
                        <span class="skill-pill featured">Core Stack</span>
                    </div>
                    <div class="skill-tags">
                        <span class="skill-pill featured"><i class="fa-solid fa-check"></i> PHP 8+</span>
                        <span class="skill-pill featured"><i class="fa-solid fa-check"></i> Laravel 10/11</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> CodeIgniter 4</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> RESTful APIs</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> OOP & Design Patterns</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> Service Layer Architecture</span>
                    </div>
                </div>

                <!-- Frontend Group -->
                <div class="skill-group-card">
                    <div class="skill-group-header">
                        <span class="skill-group-title"><i class="fa-solid fa-desktop" style="color: #0284c7;"></i> Frontend & UI</span>
                        <span class="skill-pill">Modern Web</span>
                    </div>
                    <div class="skill-tags">
                        <span class="skill-pill featured"><i class="fa-solid fa-check"></i> JavaScript (ES6+)</span>
                        <span class="skill-pill featured"><i class="fa-solid fa-check"></i> React.js</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> Blade Templating</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> HTML5 / CSS3 / Grid</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> Tailwind CSS / Bootstrap</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> jQuery & AJAX</span>
                    </div>
                </div>

                <!-- Database & Infrastructure Group -->
                <div class="skill-group-card">
                    <div class="skill-group-header">
                        <span class="skill-group-title"><i class="fa-solid fa-database" style="color: #059669;"></i> Database & Infrastructure</span>
                        <span class="skill-pill">Data Layer</span>
                    </div>
                    <div class="skill-tags">
                        <span class="skill-pill featured"><i class="fa-solid fa-check"></i> MySQL Database</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> Eloquent ORM</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> Query Optimization</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> Redis Caching</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> Firebase Authentication</span>
                        <span class="skill-pill"><i class="fa-solid fa-check"></i> Git / GitHub Version Control</span>
                    </div>
                </div>
            </div>

            <!-- Detailed Engineering Proficiency Notes -->
            @if(!empty($ratings))
                <div style="margin-top: 3.5rem;">
                    <h3 style="font-family: var(--font-heading); font-size: 1.3rem; font-weight: 700; margin-bottom: 1.25rem;">
                        <i class="fa-solid fa-sliders" style="color: var(--accent);"></i> In-Depth Skill Breakdown & Experience Notes
                    </h3>
                    <div class="proficiency-accordion">
                        @foreach(['laravel' => 'Laravel Framework', 'php' => 'PHP (OOP & PSR)', 'javascript' => 'JavaScript & React', 'sql' => 'MySQL & Database Optimization', 'css' => 'CSS3 & Responsive Design', 'redis' => 'Redis & Caching'] as $key => $label)
                            @if(isset($ratings[$key]))
                                <div class="proficiency-card">
                                    <div class="prof-header">
                                        <span class="prof-name">{{ $label }}</span>
                                        <div class="stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star" style="color: {{ $i <= ($ratings[$key] ?? 0) ? '#eab308' : '#cbd5e1' }};"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    @if(isset($ratings[$key.'_description']))
                                        <p class="prof-desc">{{ $ratings[$key.'_description'] }}</p>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Professional Experience Section -->
    <section class="section" id="experience">
        <div class="container">
            <div class="section-header">
                <span class="section-title-tag"><i class="fa-solid fa-briefcase"></i> Work History</span>
                <h2 class="section-title">Professional Work Experience</h2>
                <p class="section-subtitle">Proven track record of engineering leadership, commercial software development, and cross-functional team delivery.</p>
            </div>

            <div class="timeline">
                @foreach($cv->employments as $emp)
                    <div class="timeline-item {{ $emp->is_current ? 'current' : '' }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-card">
                            <div class="timeline-header">
                                <div>
                                    <h3 class="role-title">{{ $emp->designation }}</h3>
                                    <div class="company-name">
                                        <i class="fa-solid fa-building"></i> {{ $emp->company_name }}
                                        @if($emp->business_type)
                                            <span style="font-size: 0.8rem; font-weight: 500; color: var(--text-subtle); border-left: 1px solid var(--border-dark); padding-left: 8px;">{{ $emp->business_type }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="duration-badge {{ $emp->is_current ? 'current' : '' }}">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ $formatDate($emp->start_date) }} — {{ $emp->is_current ? 'Present' : $formatDate($emp->end_date) }}
                                </div>
                            </div>

                            @if($emp->responsibilities)
                                <ul class="responsibilities-list">
                                    @foreach(explode("\n", str_replace("\r", "", $emp->responsibilities)) as $resp)
                                        @if(trim($resp))
                                            <li>{{ trim($resp) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif

                            @if($emp->achievements)
                                <div class="achievement-highlight">
                                    <i class="fa-solid fa-trophy"></i>
                                    <div>
                                        <strong>Key Achievement:</strong> {{ $emp->achievements }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Projects Section (Case Studies) -->
    <section class="section" id="projects" style="background: var(--bg-surface); border-y: 1px solid var(--border);">
        <div class="container">
            <div class="section-header">
                <span class="section-title-tag"><i class="fa-solid fa-folder-open"></i> Portfolio Case Studies</span>
                <h2 class="section-title">Featured Engineering Projects</h2>
                <p class="section-subtitle">Real-world commercial applications, custom ERP modules, e-learning platforms, and interactive web applications.</p>
            </div>

            <div class="projects-grid">
                @foreach($cv->projects as $proj)
                    <div class="project-card">
                        <div class="project-content">
                            <div class="project-header">
                                <h3 class="project-title">{{ $proj->title }}</h3>
                            </div>
                            
                            <span class="project-role-badge">
                                <i class="fa-solid fa-user-gear"></i> {{ $proj->role ?: 'Software Engineer' }}
                            </span>

                            @if($proj->problem)
                                <div class="case-block">
                                    <div class="case-label"><i class="fa-solid fa-circle-exclamation" style="color: #ef4444;"></i> The Challenge</div>
                                    <div class="case-text">{{ $proj->problem }}</div>
                                </div>
                            @endif

                            @if($proj->solution)
                                <div class="case-block">
                                    <div class="case-label"><i class="fa-solid fa-lightbulb" style="color: #eab308;"></i> The Solution</div>
                                    <div class="case-text">{{ $proj->solution }}</div>
                                </div>
                            @endif

                            @if(!$proj->problem && $proj->description)
                                <div class="case-block">
                                    <div class="case-text">{{ $proj->description }}</div>
                                </div>
                            @endif

                            @if($proj->demo_user || $proj->demo_password)
                                <div class="demo-access-box" style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: #f0fdf4; border: 1px dashed #86efac; border-radius: var(--radius-md); font-size: 0.85rem; color: #166534;">
                                    <div style="font-weight: 700; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                                        <i class="fa-solid fa-key" style="color: #16a34a;"></i> Demo Access Credentials:
                                    </div>
                                    @if($proj->demo_user)
                                        <div><strong>Demo User:</strong> <code style="background: #dcfce7; padding: 2px 6px; border-radius: 4px; color: #14532d;">{{ $proj->demo_user }}</code></div>
                                    @endif
                                    @if($proj->demo_password)
                                        <div style="margin-top: 2px;"><strong>Demo Password:</strong> <code style="background: #dcfce7; padding: 2px 6px; border-radius: 4px; color: #14532d;">{{ $proj->demo_password }}</code></div>
                                    @endif
                                </div>
                            @endif

                            <div class="project-tech-stack">
                                @if($proj->technologies)
                                    @foreach(explode(',', $proj->technologies) as $tech)
                                        <span class="tech-pill">{{ trim($tech) }}</span>
                                    @endforeach
                                @else
                                    <span class="tech-pill">Laravel</span>
                                    <span class="tech-pill">PHP</span>
                                    <span class="tech-pill">MySQL</span>
                                @endif
                            </div>

                            <div class="project-footer">
                                @if($proj->link)
                                    <a href="{{ $proj->link }}" target="_blank" class="btn btn-accent btn-sm">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Live Demo
                                    </a>
                                @endif
                                @if($proj->github_url)
                                    <a href="{{ $proj->github_url }}" target="_blank" class="btn btn-outline btn-sm">
                                        <i class="fa-brands fa-github"></i> Repository
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Education & Certifications -->
    <section class="section" id="education">
        <div class="container">
            <div class="section-header">
                <span class="section-title-tag"><i class="fa-solid fa-graduation-cap"></i> Qualifications</span>
                <h2 class="section-title">Education & Training</h2>
                <p class="section-subtitle">Academic background, postgraduate diplomas, and professional IT training.</p>
            </div>

            <div class="edu-grid">
                <!-- Training / PGD -->
                @foreach($cv->trainings as $tr)
                    <div class="edu-card" style="border-left: 4px solid var(--accent);">
                        <div class="edu-icon"><i class="fa-solid fa-award"></i></div>
                        <h3 class="edu-degree">{{ $tr->training_title }}</h3>
                        <div class="edu-inst">{{ $tr->institute }}</div>
                        <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">
                            {{ $tr->certificate_details }}
                        </p>
                    </div>
                @endforeach

                <!-- Academic Degrees -->
                @foreach($cv->academics as $acad)
                    <div class="edu-card">
                        <div class="edu-icon"><i class="fa-solid fa-university"></i></div>
                        <h3 class="edu-degree">{{ $acad->degree_name }} in {{ $acad->group_or_major }}</h3>
                        <div class="edu-inst">{{ $acad->institution }}</div>
                        <div class="edu-meta">
                            <span><i class="fa-solid fa-building-columns"></i> {{ $acad->board_or_university }}</span>
                            @if($acad->result)
                                <span><i class="fa-solid fa-star"></i> {{ $acad->result }}</span>
                            @endif
                            @if($acad->passing_year)
                                <span><i class="fa-regular fa-calendar"></i> {{ $acad->passing_year }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- References -->
            @if($cv->references->isNotEmpty())
                <div style="margin-top: 3.5rem;">
                    <h3 style="font-family: var(--font-heading); font-size: 1.3rem; font-weight: 700; margin-bottom: 1.25rem; color: var(--primary);">
                        <i class="fa-solid fa-user-check" style="color: var(--accent);"></i> Professional & Academic References
                    </h3>
                    <div class="references-grid">
                        @foreach($cv->references as $ref)
                            <div class="ref-card">
                                <div class="ref-name">{{ $ref->name }}</div>
                                <div class="ref-role">{{ $ref->designation }}</div>
                                <div class="ref-org">{{ $ref->organization }}</div>
                                <div style="font-size: 0.85rem; color: var(--text-muted);">
                                    @if($ref->phone)
                                        <div><i class="fa-solid fa-phone" style="width: 16px;"></i> {{ $ref->phone }}</div>
                                    @endif
                                    @if($ref->email)
                                        <div><i class="fa-solid fa-envelope" style="width: 16px;"></i> {{ $ref->email }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Resume Preview Section -->
    <section class="section" id="resume" style="background: var(--bg-surface); border-y: 1px solid var(--border);">
        <div class="container">
            <div class="section-header" style="text-align: center;">
                <span class="section-title-tag"><i class="fa-solid fa-file-pdf"></i> Verification</span>
                <h2 class="section-title">Official Resume Document</h2>
                <p class="section-subtitle" style="margin-inline: auto;">Download or print the traditional recruiter CV generated dynamically from database records.</p>
            </div>

            <div class="resume-preview-box">
                <div class="resume-preview-header">
                    <div>
                        <div class="cv-title-name">{{ $cv->full_name }}</div>
                        <div style="font-size: 1.1rem; color: var(--accent); font-weight: 600;">{{ $primaryRole }}</div>
                        <div style="font-size: 0.9rem; color: var(--text-muted); margin-top: 4px;">{{ $cv->present_address }}</div>
                    </div>
                    <div>
                        <a href="{{ route('public.cv.print', $username) }}" target="_blank" class="btn btn-accent">
                            <i class="fa-solid fa-download"></i> Download / Print Resume
                        </a>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; font-size: 0.95rem; color: var(--text-muted);">
                    <div>
                        <h4 style="font-family: var(--font-heading); color: var(--primary); font-size: 1rem; margin-bottom: 0.5rem; border-bottom: 1px solid var(--border); padding-bottom: 4px;">
                            Summary Statement
                        </h4>
                        <p>{{ $summary }}</p>
                    </div>

                    <div>
                        <h4 style="font-family: var(--font-heading); color: var(--primary); font-size: 1rem; margin-bottom: 0.5rem; border-bottom: 1px solid var(--border); padding-bottom: 4px;">
                            Direct Contact Channels
                        </h4>
                        <ul style="list-style: none; display: grid; gap: 8px;">
                            <li><i class="fa-solid fa-envelope" style="width: 20px; color: var(--accent);"></i> {{ $cv->email }}</li>
                            <li><i class="fa-solid fa-phone" style="width: 20px; color: var(--accent);"></i> {{ $cv->mobile }}</li>
                            <li><i class="fa-brands fa-linkedin-in" style="width: 20px; color: var(--accent);"></i> {{ $cv->linkedin_url }}</li>
                            <li><i class="fa-brands fa-github" style="width: 20px; color: var(--accent);"></i> {{ $cv->github_url }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section contact-section" id="contact">
        <div class="container">
            <div class="contact-grid">
                <div>
                    <div class="section-header">
                        <span class="section-title-tag"><i class="fa-solid fa-paper-plane"></i> Get In Touch</span>
                        <h2 class="section-title">Let's Discuss Your Project or Team Needs</h2>
                        <p class="section-subtitle">Currently exploring high-impact software engineering roles and consulting projects.</p>
                    </div>

                    <div class="contact-info-list">
                        @if($cv->email)
                            <div class="contact-item-card">
                                <div class="contact-item-icon"><i class="fa-solid fa-envelope"></i></div>
                                <div>
                                    <div class="contact-item-label">Direct Email</div>
                                    <a href="mailto:{{ $cv->email }}" class="contact-item-val">{{ $cv->email }}</a>
                                </div>
                            </div>
                        @endif

                        @if($cv->mobile)
                            <div class="contact-item-card">
                                <div class="contact-item-icon"><i class="fa-solid fa-phone"></i></div>
                                <div>
                                    <div class="contact-item-label">Mobile & WhatsApp</div>
                                    <a href="tel:{{ $cv->mobile }}" class="contact-item-val">{{ $cv->mobile }}</a>
                                </div>
                            </div>
                        @endif

                        @if($cv->present_address)
                            <div class="contact-item-card">
                                <div class="contact-item-icon"><i class="fa-solid fa-location-dot"></i></div>
                                <div>
                                    <div class="contact-item-label">Location</div>
                                    <div class="contact-item-val">{{ $cv->present_address }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="contact-form-card">
                    <h3 style="font-family: var(--font-heading); font-size: 1.35rem; font-weight: 800; color: var(--primary); margin-bottom: 1.5rem;">
                        Send a Message
                    </h3>
                    <form id="portfolioContactForm" onsubmit="event.preventDefault(); alert('Thank you! Your message has been sent successfully.');">
                        <div class="form-group">
                            <label class="form-label">Your Name</label>
                            <input type="text" class="form-input" placeholder="e.g. John Doe" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Your Email</label>
                            <input type="email" class="form-input" placeholder="e.g. john@company.com" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea class="form-textarea" rows="4" placeholder="Tell me about your project or opportunity..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-accent" style="width: 100%;">
                            <i class="fa-solid fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container footer-inner">
            <div>
                <div class="footer-brand">{{ $cv->full_name }} — {{ $primaryRole }}</div>
                <div style="font-size: 0.825rem; margin-top: 4px;">&copy; {{ date('Y') }} All Rights Reserved. Built with Laravel 10.</div>
            </div>
            <div class="social-links">
                @if($cv->linkedin_url)
                    <a href="{{ $cv->linkedin_url }}" target="_blank" class="social-icon" style="background: #1e293b; color: #fff; border-color: #334155;"><i class="fa-brands fa-linkedin-in"></i></a>
                @endif
                @if($cv->github_url)
                    <a href="{{ $cv->github_url }}" target="_blank" class="social-icon" style="background: #1e293b; color: #fff; border-color: #334155;"><i class="fa-brands fa-github"></i></a>
                @endif
                @if($cv->website_url)
                    <a href="{{ $cv->website_url }}" target="_blank" class="social-icon" style="background: #1e293b; color: #fff; border-color: #334155;"><i class="fa-solid fa-globe"></i></a>
                @endif
            </div>
        </div>
    </footer>

</body>
</html>
