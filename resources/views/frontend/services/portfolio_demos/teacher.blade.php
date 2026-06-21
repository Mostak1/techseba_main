@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Professor Rafiqul Islam - Physics & Mathematics Private Tutor')
@section('primary-color', '#6366f1')
@section('primary-rgb', '99, 102, 241')
@section('demo_slug', 'Teacher Portfolio')
@section('logo-icon', 'ri-graduation-cap-line')
@section('logo-text', 'Rafiqul Physics')
@section('cta-text', 'Admission Open')

@section('nav-items')
    <li><a href="#about">About Mentorship</a></li>
    <li><a href="#batches">Batches</a></li>
    <li><a href="#experience">My Career</a></li>
    <li><a href="#orientation">Orientation</a></li>
    <li><a href="#faq">FAQs</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="badge">HSC & Admission Physics Specialist</span>
                <h1 class="hero-title">Physics Made <span>Simple & Intuitive</span></h1>
                <p class="hero-desc">Professor Rafiqul Islam has been mentoring HSC, BUET, and Medical admission seekers for the last 15 years, helping over 5,000+ students secure A+ and top placements.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Enroll in Next Batch <i class="ri-arrow-right-line"></i></a>
                    <a href="#batches" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">Class Schedules</a>
                </div>
            </div>
            <div style="text-align: center;">
                <img src="{{ asset('uploads/demo/teacher.png') }}" class="hero-img" alt="Professor Rafiqul Islam" style="max-height: 420px; object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- Stats Row -->
    <section style="background: var(--card); padding: 50px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px; text-align: center;">
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">15+ Years</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Teaching Mentorship</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">5,000+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Students Mentored</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">94%</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">HSC A+ Rate</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">850+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">BUET/Medical Placers</p>
            </div>
        </div>
    </section>

    <!-- Detailed About / Lottie Banner -->
    <section id="about">
        <div class="container hero-grid">
            <div style="display: flex; justify-content: center; align-items: center;">
                <!-- Animated Lottie File for Study / Books -->
                <lottie-player src="https://lottie.host/e2ef30ea-61a7-47b2-bd7a-4712411ceba5/f1cOsh1G8H.json" background="transparent" speed="1" style="width: 320px; height: 320px;" loop autoplay></lottie-player>
            </div>
            <div>
                <span class="badge">My Approach</span>
                <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px;">Mastering Conceptual Depth & Short Techniques</h2>
                <p style="color: var(--muted); margin-bottom: 20px; line-height: 1.8;">Our physics program does not encourage memorization. We construct deep physical analogies, derive equations from scratch, and practice advanced mathematics tools so you are fully prepared for competitive board exams and elite engineering admission questions.</p>
                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); padding: 16px; border-radius: 12px; margin-top: 24px;">
                    <h5 style="margin-bottom: 6px; font-weight: 600;"><i class="ri-checkbox-circle-fill" style="color: var(--primary); margin-right: 6px;"></i> Weekly Evaluation Tests</h5>
                    <p style="color: var(--muted); font-size: 13px;">Every class block ends with a comprehensive model test mimicking actual exam sheets.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Batches Section -->
    <section id="batches" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Academic & Admission Batches</h2>
            <p class="section-desc">We offer intensive guidance packages structured around full-syllabus conceptual clarity.</p>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-book-read-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">HSC Batch</span>
                        <h4 class="gallery-title">HSC Physics Syllabus</h4>
                        <p class="gallery-desc">Comprehensive lessons on Newtonian mechanics, thermodynamics, electromagnetism, and modern quantum physics.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-building-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Admission</span>
                        <h4 class="gallery-title">BUET & Engineering Prep</h4>
                        <p class="gallery-desc">Rigorous engineering mathematics and analytical physics problems geared specifically for BUET, RUET, KUET patterns.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-microscope-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Science</span>
                        <h4 class="gallery-title">Medical Physics Shortcuts</h4>
                        <p class="gallery-desc">Focused question-bank discussions, fast math approximations, and core concept checklists for medical admission cards.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mentoring Timeline -->
    <section id="experience">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Teaching Milestones</h2>
            <p class="section-desc">Brief history of my professional appointments at premier institutions.</p>
            
            <div class="timeline-container">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2018 - Present</div>
                    <h4 class="timeline-title">Senior Physics Mentor</h4>
                    <p class="timeline-desc">Founder of Rafiqul Physics Academy. Leading class structures for HSC and engineering aspirants.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2012 - 2018</div>
                    <h4 class="timeline-title">Lecturer at Notre Dame College</h4>
                    <p class="timeline-desc">Taught classroom physics, supervised labs, and managed academic exam questions.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2010</div>
                    <h4 class="timeline-title">Graduation from University of Dhaka</h4>
                    <p class="timeline-desc">Completed M.Sc. in Applied Physics with first-class honors ranking.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Orientation Details -->
    <section id="orientation" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Academic Center Locations</h2>
            <p class="section-desc">Join our offline classes at one of our locations.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <span class="badge">Farmgate Branch</span>
                    <h3 class="card-title">Rafiqul Physics Farmgate</h3>
                    <p class="card-desc" style="margin-bottom: 16px;">Green Road (Adjacent to Farmgate Metro Station), Dhaka 1215</p>
                    <p style="font-size: 13.5px; color: var(--muted); margin-bottom: 20px;"><i class="ri-calendar-line" style="color:var(--primary); margin-right: 6px;"></i> Saturday, Monday, Wednesday Batches</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Book farmgate seat</a>
                </div>
                <div class="card">
                    <span class="badge">Uttara Branch</span>
                    <h3 class="card-title">Rafiqul Physics Uttara</h3>
                    <p class="card-desc" style="margin-bottom: 16px;">Sector 4, Jashimuddin Avenue, Uttara, Dhaka</p>
                    <p style="font-size: 13.5px; color: var(--muted); margin-bottom: 20px;"><i class="ri-calendar-line" style="color:var(--primary); margin-right: 6px;"></i> Sunday, Tuesday, Thursday Batches</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Book Uttara seat</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section id="faq">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-desc">Answers to common enrollment and class scheduling questions.</p>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What is the batch size for offline classrooms?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    To maintain learning standards and address doubts individually, each batch size is strictly capped at 40 students maximum.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you provide recorded class lectures for revisions?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Yes, all our offline lectures are recorded and students can access them 24/7 on our web app dashboard using their login credentials.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>What happens if a student misses a weekly model test?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Missed exams must be retaken within 2 days in our makeup session room, failing which a SMS status alert is auto-sent to their guardians.
                </div>
            </div>
        </div>
    </section>
@endsection
