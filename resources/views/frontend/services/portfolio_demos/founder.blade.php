@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Tahmid Rahman - Tech Entrepreneur & Angel Investor')
@section('primary-color', '#06b6d4')
@section('primary-rgb', '6, 182, 212')
@section('demo_slug', 'Founder Portfolio')
@section('logo-icon', 'ri-rocket-line')
@section('logo-text', 'Tahmid.io')
@section('cta-text', 'Request Pitch Deck')

@section('nav-items')
    <li><a href="#vision">Vision</a></li>
    <li><a href="#portfolio">Ventures</a></li>
    <li><a href="#advisory">Advisory</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span style="color: var(--primary); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1.5px; display: block; margin-bottom: 12px;">Co-Founder & CEO</span>
                <h1 class="hero-title">Building the Future of <span>SaaS & FinTech</span></h1>
                <p class="hero-desc">Tahmid Rahman is a tech operator and co-founder of multiple growth-stage web platforms. Backed by local and international venture capital funds.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Request Pitch Deck <i class="ri-download-cloud-line"></i></a>
                    <a href="#portfolio" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">My Ventures</a>
                </div>
            </div>
            <div>
                <div class="hero-img-box">
                    <i class="ri-lightbulb-flash-line"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision statement -->
    <section id="vision" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); text-align: center;">
        <div class="container">
            <h2 class="section-title">My Startup Philosophy</h2>
            <p class="section-desc" style="max-width: 800px; font-size: 18px; font-style: italic; line-height: 1.8; color: #f8fafc; margin-bottom: 30px;">
                "I believe in building software that addresses localized operational inefficiencies at scale. Our focus remains on high capital efficiency, strong product-market fit, and constructing sustainable teams."
            </p>
        </div>
    </section>

    <!-- Ventures Grid -->
    <section id="portfolio">
        <div class="container">
            <h2 class="section-title">Current Ventures</h2>
            <p class="section-desc">Active tech startups and companies I currently operate and guide.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <div class="card-icon"><i class="ri-bank-line"></i></div>
                    <h3 class="card-title">Fintech Pay</h3>
                    <p class="card-desc">Leading localized payment processing gateway built for small merchants. Raised $2.5M Seed Round in 2025.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-shield-check-line"></i></div>
                    <h3 class="card-title">Cyber Shield</h3>
                    <p class="card-desc">Cloud firewall and enterprise security audits designed specifically to guard government databases.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-truck-line"></i></div>
                    <h3 class="card-title">Ship Easy</h3>
                    <p class="card-desc">AI-powered container allocation and route tracking dashboard tailored for RMG export businesses.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Advisory / Contact -->
    <section id="advisory" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border);">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; align-items: center;">
            <div>
                <h2 class="section-title" style="text-align: left; margin-bottom: 16px;">Advisory & Board Seat</h2>
                <p style="color: var(--muted); margin-bottom: 24px; line-height: 1.8;">I periodically invest as an angel and advise early-stage (Pre-seed) founders on tech architecture, developer recruitment, and fundraising.</p>
                <div style="background: var(--card); border: 1px solid var(--border); padding: 24px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
                    <i class="ri-hand-heart-line" style="font-size: 24px; color: var(--primary);"></i>
                    <div>
                        <h5 style="margin-bottom: 2px; font-weight: 600;">Angel Portfolio</h5>
                        <p style="color: var(--muted); font-size: 13.5px;">Currently invested in 6 active tech companies globally.</p>
                    </div>
                </div>
            </div>
            <div style="background: var(--card); border: 1px solid var(--border); padding: 40px; border-radius: 20px; text-align: center;">
                <h3 style="font-size: 22px; margin-bottom: 12px;">Let's Talk Business</h3>
                <p style="color: var(--muted); font-size: 14.5px; margin-bottom: 24px;">Looking for angel investments or strategic advisory board members?</p>
                <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; width: 100%;">Submit Startup Pitch</a>
            </div>
        </div>
    </section>
@endsection
