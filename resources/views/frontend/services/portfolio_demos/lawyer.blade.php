@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Barrister Munir Chowdhury - Corporate & Civil Law Consultant')
@section('primary-color', '#d97706')
@section('primary-rgb', '217, 119, 6')
@section('demo_slug', 'Lawyer Portfolio')
@section('logo-icon', 'ri-scales-3-line')
@section('logo-text', 'Munir Chambers')
@section('cta-text', 'Request Case Review')

@section('nav-items')
    <li><a href="#practice">Practice Areas</a></li>
    <li><a href="#stats">Success Rates</a></li>
    <li><a href="#about">About</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span style="color: var(--primary); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1.5px; display: block; margin-bottom: 12px;">Corporate Legal Expert</span>
                <h1 class="hero-title">Protecting Your <span>Business & Legacy</span></h1>
                <p class="hero-desc">Barrister Munir Chowdhury offers strategic, results-driven legal advocacy in corporate law, property disputes, and intellectual property rights inside Bangladesh supreme court.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Request Legal Advice <i class="ri-auction-line"></i></a>
                    <a href="#practice" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">Our Expertise</a>
                </div>
            </div>
            <div>
                <div class="hero-img-box">
                    <i class="ri-shield-user-line"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Practice Areas -->
    <section id="practice" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Core Practice Areas</h2>
            <p class="section-desc">Providing legal consultations and court representation for commercial and corporate matters.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <div class="card-icon"><i class="ri-building-line"></i></div>
                    <h3 class="card-title">Corporate & Commercial Law</h3>
                    <p class="card-desc">Contract negotiations, legal audits, company incorporation, and compliance advisory for local startups.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-home-gear-line"></i></div>
                    <h3 class="card-title">Property & Real Estate</h3>
                    <p class="card-desc">Title deeds verification, lease agreements, landlord-tenant dispute resolutions, and land acquisitions.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-lightbulb-line"></i></div>
                    <h3 class="card-title">Intellectual Property (IP)</h3>
                    <p class="card-desc">Trademark registration, patent filings, and legal defenses against unauthorized copyright infringements.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats & Achievements -->
    <section id="stats" style="padding: 60px 0; background: var(--card);">
        <div class="container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px; text-align: center;">
            <div>
                <h3 style="font-size: 40px; color: var(--primary); font-weight: 800;">10+ Years</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Advocacy Practice</p>
            </div>
            <div>
                <h3 style="font-size: 40px; color: var(--primary); font-weight: 800;">250+ Cases</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Successfully Resolved</p>
            </div>
            <div>
                <h3 style="font-size: 40px; color: var(--primary); font-weight: 800;">94% Rate</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Positive Outcomes</p>
            </div>
        </div>
    </section>

    <!-- About / Consultation details -->
    <section id="about">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; align-items: center;">
            <div>
                <h2 class="section-title" style="text-align: left; margin-bottom: 16px;">Dedicated Legal Consultation</h2>
                <p style="color: var(--muted); margin-bottom: 24px; line-height: 1.8;">Our Chambers is built on trust, confidentiality, and deep legal insight. We study each legal challenge thoroughly to provide pragmatic solutions.</p>
                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); padding: 24px; border-radius: 12px;">
                    <h5 style="margin-bottom: 8px; font-weight: 600;"><i class="ri-phone-fill" style="color: var(--primary); margin-right: 6px;"></i> Direct Consultation Phone</h5>
                    <p style="color: var(--muted); font-size: 14px;">Call secretary at +880 1898 828248 for urgency client queries.</p>
                </div>
            </div>
            <div style="background: var(--card); border: 1px solid var(--border); padding: 40px; border-radius: 20px;">
                <h3 style="font-size: 22px; margin-bottom: 12px; text-align: center;">Book Consultation</h3>
                <p style="color: var(--muted); font-size: 14px; margin-bottom: 24px; text-align: center;">Submit your case summary and receive initial advisory within 24 hours.</p>
                <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center; width: 100%;">Online Request Chamber Form</a>
            </div>
        </div>
    </section>
@endsection
