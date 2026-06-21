@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Hope Foundation Bangladesh - Non-Profit NGO')
@section('primary-color', '#f43f5e')
@section('primary-rgb', '244, 63, 94')
@section('demo_slug', 'NGO Portfolio')
@section('logo-icon', 'ri-heart-line')
@section('logo-text', 'Hope BD')
@section('cta-text', 'Donate Now')

@section('nav-items')
    <li><a href="#about">Our Mission</a></li>
    <li><a href="#impact">Our Impact</a></li>
    <li><a href="#projects">Active Projects</a></li>
    <li><a href="#timeline">Our History</a></li>
    <li><a href="#faq">FAQs</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="badge">Non-Profit Organization</span>
                <h1 class="hero-title">Hope & Education for <span>Underprivileged Kids</span></h1>
                <p class="hero-desc">Hope Foundation Bangladesh is dedicated to providing free basic education, warm nutritious meals, and diagnostic health checkups to street children and low-income families.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Support Our Cause <i class="ri-heart-add-line"></i></a>
                    <a href="#projects" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">Active Campaigns</a>
                </div>
            </div>
            <div style="text-align: center;">
                <img src="{{ asset('uploads/demo/ngo.png') }}" class="hero-img" alt="Hope Foundation Volunteers" style="max-height: 420px; object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- Impact Stats Row -->
    <section id="impact" style="background: var(--card); padding: 60px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px; text-align: center;">
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">12,000+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Children Educated</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">50,000+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Meals Distributed</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">15 Clinics</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Free Health Chamber Setups</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">120+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Active Volunteers</p>
            </div>
        </div>
    </section>

    <!-- Detailed About / Lottie Banner -->
    <section id="about">
        <div class="container hero-grid">
            <div style="display: flex; justify-content: center; align-items: center;">
                <!-- Animated Lottie File for Help / Charity -->
                <lottie-player src="https://lottie.host/9e419bdf-7b95-46f0-b747-d5d1c015e1bc/2dO7X1G31c.json" background="transparent" speed="1" style="width: 320px; height: 320px;" loop autoplay></lottie-player>
            </div>
            <div>
                <span class="badge">Our Mission</span>
                <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px;">Empowering Communities through Care & Compassion</h2>
                <p style="color: var(--muted); margin-bottom: 20px; line-height: 1.8;">We believe every child deserves access to standard learning materials, nutrition, and healthcare. Our projects coordinate directly with field officers, community leaders, and local governments to construct classrooms, drill freshwater tube-wells, and deploy mobile medical vans in remote districts.</p>
                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); padding: 16px; border-radius: 12px; margin-top: 24px;">
                    <h5 style="margin-bottom: 6px; font-weight: 600;"><i class="ri-shield-check-fill" style="color: var(--primary); margin-right: 6px;"></i> Government Approved</h5>
                    <p style="color: var(--muted); font-size: 13px;">Registered under NGO Affairs Bureau Bangladesh, with audited annual balance sheets.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Active Projects -->
    <section id="projects" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Active Projects & Programs</h2>
            <p class="section-desc">Join our hands as corporate partners or individual donors to drive social impact.</p>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-book-open-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Education</span>
                        <h4 class="gallery-title">Street School Project</h4>
                        <p class="gallery-desc">Distributing basic learning backpacks, custom notebooks, pencils, and providing tutoring setups in slum locations.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-restaurant-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Nutrition</span>
                        <h4 class="gallery-title">Feed the Hungry Campaign</h4>
                        <p class="gallery-desc">Serving clean, hot, nutritional lunches twice a week to children, street orphans, and daily wage workers.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-first-aid-kit-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Healthcare</span>
                        <h4 class="gallery-title">Mobile Medical Camps</h4>
                        <p class="gallery-desc">Deploying volunteer doctors to distribute basic medicines, vitamins, and run sanitary hygiene workshops in rural areas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- History Timeline -->
    <section id="timeline">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">NGO History & Milestones</h2>
            <p class="section-desc">Brief timeline outlining our foundation's growth and relief efforts.</p>
            
            <div class="timeline-container">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2024</div>
                    <h4 class="timeline-title">Deployed 5 Mobile Health Vans</h4>
                    <p class="timeline-desc">Expanded mobile checkup chambers across North Bengal districts with corporate partnership grants.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2021</div>
                    <h4 class="timeline-title">COVID-19 Relief Campaign</h4>
                    <p class="timeline-desc">Distributed over 20,000 hygiene bags and emergency food supplies to slum areas in Dhaka and Chittagong.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2018</div>
                    <h4 class="timeline-title">Foundation Inception</h4>
                    <p class="timeline-desc">Registered Hope BD as a local non-profit group, opening our first school branch in Mirpur.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Donate/Volunteer Options -->
    <section id="support" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Support Our Cause</h2>
            <p class="section-desc">Join our programs as a regular contributor or volunteer partner.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <span class="badge">Sponsorship</span>
                    <h3 class="card-title">Corporate CSR Partnerships</h3>
                    <p class="card-desc" style="margin-bottom: 20px;">Align your brand's social impact metrics. We provide audited project reports and tax-exempt logs.</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Partner with us</a>
                </div>
                <div class="card">
                    <span class="badge">Volunteer</span>
                    <h3 class="card-title">Become a Volunteer</h3>
                    <p class="card-desc" style="margin-bottom: 20px;">Dedicate your weekends to tutoring kids, coordinating camp logistics, or running digital campaigns.</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Register as Volunteer</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section id="faq">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-desc">Common questions regarding fund utilization, taxes, and audits.</p>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What percentage of donations goes directly to field projects?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Approximately 88% of all funds are deployed directly to community campaigns. The remaining 12% is utilized for admin coordination, reporting, and campaign setup.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Are donations to Hope BD tax-exempt?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Yes, as we are a registered NGO under NBR guidelines, all individual and corporate sponsorships qualify for official tax deductions in Bangladesh.
                </div>
            </div>
        </div>
    </section>
@endsection
