@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Dr. Sarah Rahman, MD - Cardiology Specialist')
@section('primary-color', '#0d9488')
@section('primary-rgb', '13, 148, 136')
@section('demo_slug', 'Doctor Portfolio')
@section('logo-icon', 'ri-heart-pulse-line')
@section('logo-text', 'Dr. Sarah')
@section('cta-text', 'Book Appointment')

@section('nav-items')
    <li><a href="#specialties">Specialties</a></li>
    <li><a href="#clinic">Clinic Info</a></li>
    <li><a href="#reviews">Testimonials</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span style="color: var(--primary); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1.5px; display: block; margin-bottom: 12px;">Cardiologist & Physician</span>
                <h1 class="hero-title">Your Heart Health is My <span>Priority</span></h1>
                <p class="hero-desc">Dr. Sarah Rahman is a board-certified cardiologist with over 12 years of experience providing compassionate heart care and advanced diagnostic consultations in Dhaka.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Book Appointment <i class="ri-calendar-check-line"></i></a>
                    <a href="#clinic" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">Clinic Locations</a>
                </div>
            </div>
            <div>
                <div class="hero-img-box">
                    <i class="ri-user-heart-line"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Specialties Grid -->
    <section id="specialties" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Medical Services & Specializations</h2>
            <p class="section-desc">Offering comprehensive clinical evaluations and non-invasive diagnostic testing for heart conditions.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <div class="card-icon"><i class="ri-pulse-line"></i></div>
                    <h3 class="card-title">ECG & Heart Monitoring</h3>
                    <p class="card-desc">State-of-the-art electrocardiogram screenings to detect irregular rhythms and cardiac health problems early.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-temp-hot-line"></i></div>
                    <h3 class="card-title">Hypertension Treatment</h3>
                    <p class="card-desc">Personalized medical guidance and lifestyle management programs to keep high blood pressure in control.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-shield-flash-line"></i></div>
                    <h3 class="card-title">Preventative Cardiology</h3>
                    <p class="card-desc">Thorough cardiovascular risk assessments designed to help you avoid future coronary blockages.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Clinic Info -->
    <section id="clinic">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; align-items: center;">
            <div>
                <h2 class="section-title" style="text-align: left; margin-bottom: 16px;">Clinic Location & Consultation Hours</h2>
                <p style="color: var(--muted); margin-bottom: 30px;">Visit me at my primary chambers. Please book ahead online or via phone to ensure a slot.</p>
                
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; gap: 16px; align-items: flex-start;">
                        <i class="ri-map-pin-2-line" style="font-size: 24px; color: var(--primary);"></i>
                        <div>
                            <h4 style="font-size: 16px; font-weight:600; margin-bottom: 4px;">Square Hospital Chamber</h4>
                            <p style="color: var(--muted); font-size: 14px;">18/F, Bir Uttam Qazi Nuruzzaman Sarak, West Panthapath, Dhaka 1205</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 16px; align-items: flex-start;">
                        <i class="ri-time-line" style="font-size: 24px; color: var(--primary);"></i>
                        <div>
                            <h4 style="font-size: 16px; font-weight:600; margin-bottom: 4px;">Visiting Hours</h4>
                            <p style="color: var(--muted); font-size: 14px;">Saturday to Wednesday: 05:00 PM - 09:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
            <div style="background: var(--card); border: 1px solid var(--border); padding: 40px; border-radius: 20px; text-align: center;">
                <h3 style="font-size: 22px; margin-bottom: 12px;">Need Immediate Care?</h3>
                <p style="color: var(--muted); font-size: 14.5px; margin-bottom: 24px;">For urgent booking queries, reach out directly to my secretary via WhatsApp.</p>
                <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: inline-block; width: 100%;">Online Appointment Request</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="reviews" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Patient Testimonials</h2>
            <p class="section-desc">Read reviews from individuals who recovered under my medical care.</p>
            
            <div class="cards-grid">
                <div class="testimonial-card">
                    <i class="ri-double-quotes-r quote-icon"></i>
                    <p class="testimonial-text">"Dr. Sarah is extremely patient. She diagnosed my heart murmur instantly and guided me through the treatment plan with immense care."</p>
                    <div class="user-info">
                        <div class="avatar">MA</div>
                        <div class="user-details">
                            <h5>Muzahid Ahmed</h5>
                            <span>Recovered Patient</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <i class="ri-double-quotes-r quote-icon"></i>
                    <p class="testimonial-text">"The booking process was so simple! Visited the Panthapath clinic and received very professional treatment. Strongly recommended."</p>
                    <div class="user-info">
                        <div class="avatar">NS</div>
                        <div class="user-details">
                            <h5>Nazma Sultana</h5>
                            <span>Hypertension Patient</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
