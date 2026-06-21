@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Dr. Sarah Rahman, MD - Cardiology Specialist')
@section('primary-color', '#0d9488')
@section('primary-rgb', '13, 148, 136')
@section('demo_slug', 'Doctor Portfolio')
@section('logo-icon', 'ri-heart-pulse-line')
@section('logo-text', 'Dr. Sarah')
@section('cta-text', 'Book Appointment')

@section('nav-items')
    <li><a href="#about">About Me</a></li>
    <li><a href="#services">Services</a></li>
    <li><a href="#experience">Timeline</a></li>
    <li><a href="#clinic">Chambers</a></li>
    <li><a href="#faq">FAQs</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="badge">Cardiologist & Physician</span>
                <h1 class="hero-title">Protecting Your <span>Heart Health</span> Every Day</h1>
                <p class="hero-desc">Dr. Sarah Rahman is a board-certified cardiologist with over 12 years of clinical excellence, specializing in preventative cardiology, diagnostic tests, and heart failure management.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Book Appointment <i class="ri-calendar-check-line"></i></a>
                    <a href="#services" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">Explore Services</a>
                </div>
            </div>
            <div style="text-align: center;">
                <img src="{{ asset('uploads/demo/doctor.png') }}" class="hero-img" alt="Dr. Sarah Rahman" style="max-height: 420px; object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- Stats Row -->
    <section style="background: var(--card); padding: 50px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px; text-align: center;">
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">12+ Years</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Clinical Experience</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">10,000+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Happy Patients Cured</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">2 Chambers</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Convenient Locations</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">15+ Awards</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">National Recognitions</p>
            </div>
        </div>
    </section>

    <!-- Detailed About / Lottie Banner -->
    <section id="about">
        <div class="container hero-grid">
            <div style="display: flex; justify-content: center; align-items: center;">
                <!-- Animated Lottie File for Medical / Heart Beat -->
                <lottie-player src="https://lottie.host/5d54b8d7-5ef7-47b2-a42e-5036b5ec6a25/u14Q3R2s0a.json" background="transparent" speed="1" style="width: 320px; height: 320px;" loop autoplay></lottie-player>
            </div>
            <div>
                <span class="badge">My Philosophy</span>
                <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px;">Dedicated to Advanced Cardiovascular Care</h2>
                <p style="color: var(--muted); margin-bottom: 20px; line-height: 1.8;">My clinical practice focuses not just on treating symptoms, but identifying root causes of heart problems. Through lifestyle modifications, early checkups, and cutting-edge non-invasive test procedures, I aim to maximize cardiovascular wellness.</p>
                <div style="display: flex; gap: 16px; margin-top: 24px;">
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); padding: 16px; border-radius: 12px; flex: 1;">
                        <h5 style="margin-bottom: 6px; font-weight: 600;"><i class="ri-award-fill" style="color: var(--primary); margin-right: 6px;"></i> Best Cardiologist Award</h5>
                        <p style="color: var(--muted); font-size: 13px;">Honored by Bangladesh Medical Association in 2024.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Medical Services & Diagnostic Tests</h2>
            <p class="section-desc">We offer state-of-the-art non-invasive testing and treatments to assure your heart remains in excellent shape.</p>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-pulse-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Diagnostics</span>
                        <h4 class="gallery-title">Electrocardiogram (ECG)</h4>
                        <p class="gallery-desc">Instant diagnostic mapping of heart rhythm to evaluate irregular beats, murmurs, or past cardiac events.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-heart-add-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Consultation</span>
                        <h4 class="gallery-title">Hypertension Care</h4>
                        <p class="gallery-desc">Detailed custom treatment models incorporating medical prescriptions and diet management to control high blood pressure.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-health-book-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Therapy</span>
                        <h4 class="gallery-title">Heart Failure Management</h4>
                        <p class="gallery-desc">Advanced chronic heart care protocols helping patients restore energy levels and extend life expectancy parameters.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Academic and Career Timeline -->
    <section id="experience">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Career Experience & Education</h2>
            <p class="section-desc">Highlighting academic excellence and clinical appointments over the past decade.</p>
            
            <div class="timeline-container">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2020 - Present</div>
                    <h4 class="timeline-title">Associate Professor (Cardiology)</h4>
                    <p class="timeline-desc">Leading teaching and clinical research teams at Dhaka Medical College & Hospital.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2016 - 2020</div>
                    <h4 class="timeline-title">Consultant Cardiologist</h4>
                    <p class="timeline-desc">Provided non-invasive diagnostics and emergency cardiac care consultations at Square Hospital, Dhaka.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2012 - 2016</div>
                    <h4 class="timeline-title">MD in Cardiology Degree</h4>
                    <p class="timeline-desc">Completed residency training program and clinical degree validation from BSMMU (PG Hospital).</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Chamber Details -->
    <section id="clinic" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Chamber Locations & Hours</h2>
            <p class="section-desc">Select the closest chamber location and book an online slot for counseling.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <span class="badge">Dhaka Chamber</span>
                    <h3 class="card-title">Square Hospital Chambers</h3>
                    <p class="card-desc" style="margin-bottom: 16px;">18/F, West Panthapath, Dhaka 1205</p>
                    <p style="font-size: 13.5px; color: var(--muted); margin-bottom: 20px;"><i class="ri-time-line" style="color:var(--primary); margin-right: 6px;"></i> Saturday - Wednesday: 05:00 PM - 09:00 PM</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Book Square Hospital</a>
                </div>
                <div class="card">
                    <span class="badge">Chittagong Chamber</span>
                    <h3 class="card-title">Labaid Specialized Hospital</h3>
                    <p class="card-desc" style="margin-bottom: 16px;">Jalallabad, Khulshi, Chittagong</p>
                    <p style="font-size: 13.5px; color: var(--muted); margin-bottom: 20px;"><i class="ri-time-line" style="color:var(--primary); margin-right: 6px;"></i> Thursday - Friday: 03:00 PM - 08:00 PM</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Book Labaid Chittagong</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section id="faq">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-desc">Answers to common queries regarding doctor consultations and cardiac checkups.</p>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What documents should I bring to my first cardiac consultation?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Please bring all your past medical histories, recent prescriptions, blood report logs, ECG graphs, and list of current medications you take regularly.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>How long does a general ECG or Echocardiography test take?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    A basic ECG takes only 5-10 minutes. A detailed Echocardiogram checkup takes around 20-30 minutes and the report is delivered on the same day.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do I need a prior appointment for visiting the clinic chambers?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Yes, prior appointment booking is highly recommended. You can submit the online booking request here or call the secretary on WhatsApp to confirm your serial number.
                </div>
            </div>
        </div>
    </section>
@endsection
