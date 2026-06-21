@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Barrister Munir Chowdhury - Corporate & Civil Law Consultant')
@section('primary-color', '#d97706')
@section('primary-rgb', '217, 119, 6')
@section('demo_slug', 'Lawyer Portfolio')
@section('logo-icon', 'ri-scales-3-line')
@section('logo-text', 'Munir Chambers')
@section('cta-text', 'Request Case Review')

@section('nav-items')
    <li><a href="#about">About Chambers</a></li>
    <li><a href="#practice">Practice Areas</a></li>
    <li><a href="#experience">Case History</a></li>
    <li><a href="#chamber">Chambers</a></li>
    <li><a href="#faq">FAQs</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="badge">Supreme Court Advocate</span>
                <h1 class="hero-title">Protecting Your <span>Business, Land & Rights</span></h1>
                <p class="hero-desc">Barrister Munir Chowdhury provides comprehensive, results-driven legal advocacy and advisory for corporate compliance, civil litigation, and intellectual property disputes in Bangladesh.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Request Consultation <i class="ri-scales-fill"></i></a>
                    <a href="#practice" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">Our Expertise</a>
                </div>
            </div>
            <div style="text-align: center;">
                <img src="{{ asset('uploads/demo/lawyer.png') }}" class="hero-img" alt="Barrister Munir Chowdhury" style="max-height: 420px; object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- Stats Row -->
    <section style="background: var(--card); padding: 50px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px; text-align: center;">
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">10+ Years</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Active Court Practice</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">320+ Cases</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Successfully Resolved</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">96% Rate</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Client Satisfaction</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">50+ Corporates</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Retainer Agreements</p>
            </div>
        </div>
    </section>

    <!-- Detailed About / Lottie Banner -->
    <section id="about">
        <div class="container hero-grid">
            <div style="display: flex; justify-content: center; align-items: center;">
                <!-- Animated Lottie File for Law / Scales of Justice -->
                <lottie-player src="https://lottie.host/9e49db51-bc0f-48b4-82ea-7c9809968840/m1hN00qV8x.json" background="transparent" speed="1" style="width: 320px; height: 320px;" loop autoplay></lottie-player>
            </div>
            <div>
                <span class="badge">Legal Integrity</span>
                <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px;">Dedicated Advocates Fighting For You</h2>
                <p style="color: var(--muted); margin-bottom: 20px; line-height: 1.8;">Our legal team handles every dispute with thorough review, strategic preparation, and strong representation. Whether it is company registration, land property mutation verification, or complex intellectual property defense, we protect your legacy.</p>
                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); padding: 16px; border-radius: 12px; margin-top: 24px;">
                    <h5 style="margin-bottom: 6px; font-weight: 600;"><i class="ri-shake-hands-fill" style="color: var(--primary); margin-right: 6px;"></i> High Confidentiality</h5>
                    <p style="color: var(--muted); font-size: 13px;">All cases and business operations documents are fully secured under attorney-client privilege codes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Practice Areas -->
    <section id="practice" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Core Legal Services</h2>
            <p class="section-desc">Consult with us for reliable litigation, transactional review, and company registration.</p>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-bank-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Business</span>
                        <h4 class="gallery-title">Corporate Law</h4>
                        <p class="gallery-desc">Company incorporation, joint venture agreements, shareholder policies, taxation disputes, and licensing audits.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-community-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Property</span>
                        <h4 class="gallery-title">Real Estate Disputes</h4>
                        <p class="gallery-desc">Title searches, property mutation audits, partitions filings, eviction suits, and builders compliance agreements.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-lightbulb-flash-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">IPR</span>
                        <h4 class="gallery-title">Trademarks & Copyrights</h4>
                        <p class="gallery-desc">Filing patent registrations, protection against copyright infringement, and cease & desist issuance.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Case History Timeline -->
    <section id="experience">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Significant Case Victories</h2>
            <p class="section-desc">Chronological highlights of high-value disputes successfully closed in court.</p>
            
            <div class="timeline-container">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2025</div>
                    <h4 class="timeline-title">৳150M Property Acquisition Verdict</h4>
                    <p class="timeline-desc">Secured a favorable supreme court decree resolving a decade-long partition conflict for a local manufacturing group.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2023</div>
                    <h4 class="timeline-title">E-commerce Trademark Recovery</h4>
                    <p class="timeline-desc">Represented a leading local e-commerce platform in retrieving their hijacked trademark brand names under IP tribunal laws.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2021</div>
                    <h4 class="timeline-title">SaaS Startup Compliance Audit</h4>
                    <p class="timeline-desc">Prepared full VC funding legal structures, employee option policies, and seed allocation documentation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Chamber Details -->
    <section id="chamber" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Chamber Head Office</h2>
            <p class="section-desc">Schedule your prior consultation at our office location.</p>
            
            <div class="cards-grid" style="grid-template-columns: 1fr;">
                <div class="card" style="display: flex; flex-direction: row; gap: 30px; align-items: center; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 280px;">
                        <span class="badge">Head Chambers</span>
                        <h3 class="card-title" style="font-size: 24px; margin-bottom: 12px;">Munir & Associates</h3>
                        <p class="card-desc" style="margin-bottom: 20px;">Suite 402, Supreme Court Bar Association Building, Ramna, Dhaka 1000</p>
                        <p style="font-size: 14px; color: var(--muted); margin-bottom: 8px;"><i class="ri-phone-fill" style="color:var(--primary); margin-right: 6px;"></i> +880 1898 828248 (Secretary)</p>
                        <p style="font-size: 14px; color: var(--muted);"><i class="ri-time-line" style="color:var(--primary); margin-right: 6px;"></i> Sunday - Thursday: 04:00 PM - 09:00 PM</p>
                    </div>
                    <div style="flex: 1; min-width: 280px; background: rgba(0,0,0,0.2); padding: 30px; border-radius: 12px; text-align: center; border: 1px solid var(--border);">
                        <h4 style="margin-bottom: 12px; font-weight: 600;">Request Case Review</h4>
                        <p style="color: var(--muted); font-size: 13.5px; margin-bottom: 24px;">Submit initial brief case details and our associates will get back to you within 24 hours.</p>
                        <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: inline-block; width: 100%;">Online Case Submission</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section id="faq">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-desc">Answers to common legal queries about corporate law and chamber procedures.</p>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What is the consultation charge for a new client session?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    The basic consultation session fee depends on the complexity of the case. Submit your case summary online first, and our chamber secretary will estimate the cost and schedule a time.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you offer monthly corporate retainer structures?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Yes, we offer structured monthly retainer frameworks for businesses to handle routine employee contracts review, tax consulting, trade audits, and regulatory issues.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Can you draft company registration deeds for international partners?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Yes, we routinely assist foreign investors with joint ventures registrations at RJSC, BIDA registrations, workspace licensing, and custom compliance frameworks.
                </div>
            </div>
        </div>
    </section>
@endsection
