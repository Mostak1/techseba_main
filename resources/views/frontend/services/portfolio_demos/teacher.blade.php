@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Professor Rafiqul Islam - Physics & Mathematics Private Tutor')
@section('primary-color', '#6366f1')
@section('primary-rgb', '99, 102, 241')
@section('demo_slug', 'Teacher Portfolio')
@section('logo-icon', 'ri-graduation-cap-line')
@section('logo-text', 'Rafiqul Physics')
@section('cta-text', 'Admission Open')

@section('nav-items')
    <li><a href="#batches">Courses & Batches</a></li>
    <li><a href="#credentials">Certifications</a></li>
    <li><a href="#success">Testimonials</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span style="color: var(--primary); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1.5px; display: block; margin-bottom: 12px;">HSC & Admission Physics Specialist</span>
                <h1 class="hero-title">Physics Made <span>Simple & Intuitive</span></h1>
                <p class="hero-desc">Professor Rafiqul Islam has been mentoring HSC, BUET, and Medical admission seekers for the last 15 years, helping over 5,000+ students secure A+ and top placements.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Enroll in Next Batch <i class="ri-arrow-right-line"></i></a>
                    <a href="#batches" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">Class Schedules</a>
                </div>
            </div>
            <div>
                <div class="hero-img-box">
                    <i class="ri-book-open-line"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Subjects & Batches -->
    <section id="batches" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Academic & Admission Batches</h2>
            <p class="section-desc">We offer intensive guidance packages structured around full-syllabus conceptual clarity and problem-solving.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <div class="card-icon"><i class="ri-book-3-line"></i></div>
                    <h3 class="card-title">HSC Physics (First & Second Paper)</h3>
                    <p class="card-desc">Detailed lectures on mechanics, electromagnetism, and modern physics. Weekly exams and doubt sessions.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-bubble-chart-line"></i></div>
                    <h3 class="card-title">Engineering Admission Prep</h3>
                    <p class="card-desc">Rigorous training geared specifically for BUET, RUET, KUET, and CUET admission exam patterns.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-mind-map-line"></i></div>
                    <h3 class="card-title">University Admission Math</h3>
                    <p class="card-desc">Shortcut techniques, quick calculation frameworks, and analytical coaching for university admission tests.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Credentials -->
    <section id="credentials">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; align-items: center;">
            <div>
                <h2 class="section-title" style="text-align: left; margin-bottom: 16px;">Mentorship Credentials</h2>
                <p style="color: var(--muted); margin-bottom: 24px;">Excellence in teaching with proven academic background and university certifications.</p>
                
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 16px;">
                    <li style="display: flex; align-items: center; gap: 12px;"><i class="ri-checkbox-circle-fill" style="color: var(--primary); font-size: 20px;"></i> B.Sc. & M.Sc. in Physics, University of Dhaka</li>
                    <li style="display: flex; align-items: center; gap: 12px;"><i class="ri-checkbox-circle-fill" style="color: var(--primary); font-size: 20px;"></i> Former Senior Lecturer at Notre Dame College</li>
                    <li style="display: flex; align-items: center; gap: 12px;"><i class="ri-checkbox-circle-fill" style="color: var(--primary); font-size: 20px;"></i> Author of "Physics Simplified" Guide Book</li>
                </ul>
            </div>
            <div style="background: var(--card); border: 1px solid var(--border); padding: 40px; border-radius: 20px; text-align: center;">
                <h3 style="font-size: 22px; margin-bottom: 12px;">Book a Demo Class</h3>
                <p style="color: var(--muted); font-size: 14px; margin-bottom: 24px;">Join our upcoming free orientations to test our teaching methods.</p>
                <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; width: 100%;">Get Free Demo Invite Link</a>
            </div>
        </div>
    </section>

    <!-- Student Testimonials -->
    <section id="success" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Success Testimonials</h2>
            <p class="section-desc">Reviews from past batch students who secured top ranks in engineering and university exams.</p>
            
            <div class="cards-grid">
                <div class="testimonial-card">
                    <i class="ri-double-quotes-r quote-icon"></i>
                    <p class="testimonial-text">"Rafiqul Sir's vector physics shortcuts saved my time in the BUET admission test. He clears basic concepts like no other teacher."</p>
                    <div class="user-info">
                        <div class="avatar">SI</div>
                        <div class="user-details">
                            <h5>Sajid Islam</h5>
                            <span>BUET Batch of 2024</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <i class="ri-double-quotes-r quote-icon"></i>
                    <p class="testimonial-text">"Got GPA 5.0 in Physics. Rafiqul Sir's class notes and intensive examination model built my confidence to handle tough exam sheets."</p>
                    <div class="user-info">
                        <div class="avatar">FH</div>
                        <div class="user-details">
                            <h5>Fariha Hossain</h5>
                            <span>HSC Batch of 2023</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
