@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Hope Foundation Bangladesh - Non-Profit NGO')
@section('primary-color', '#f43f5e')
@section('primary-rgb', '244, 63, 94')
@section('demo_slug', 'NGO Portfolio')
@section('logo-icon', 'ri-heart-line')
@section('logo-text', 'Hope BD')
@section('cta-text', 'Donate Now')

@section('nav-items')
    <li><a href="#mission">Our Mission</a></li>
    <li><a href="#impact">Our Impact</a></li>
    <li><a href="#projects">Active Projects</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span style="color: var(--primary); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1.5px; display: block; margin-bottom: 12px;">Non-Profit Organization</span>
                <h1 class="hero-title">Hope & Education for <span>Underprivileged Kids</span></h1>
                <p class="hero-desc">Hope Foundation Bangladesh is dedicated to providing free basic education, warm meals, and health checkups to street children and low-income families.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Support Our Cause <i class="ri-heart-add-line"></i></a>
                    <a href="#projects" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">Active Campaigns</a>
                </div>
            </div>
            <div>
                <div class="hero-img-box">
                    <i class="ri-service-line"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Stats -->
    <section id="impact" style="background: var(--card); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 60px 0;">
        <div class="container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px; text-align: center;">
            <div>
                <h3 style="font-size: 40px; color: var(--primary); font-weight: 800;">12,000+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Children Educated</p>
            </div>
            <div>
                <h3 style="font-size: 40px; color: var(--primary); font-weight: 800;">50,000+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Meals Distributed</p>
            </div>
            <div>
                <h3 style="font-size: 40px; color: var(--primary); font-weight: 800;">15 Clinics</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Free Health Chamber Setups</p>
            </div>
        </div>
    </section>

    <!-- Active Projects -->
    <section id="projects">
        <div class="container">
            <h2 class="section-title">Active Projects & Programs</h2>
            <p class="section-desc">Join our hands as volunteers or donors to drive positive social impact.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <div class="card-icon"><i class="ri-book-open-line"></i></div>
                    <h3 class="card-title">Street School Project</h3>
                    <p class="card-desc">Providing standard basic learning kits, notebooks, and school bags to underprivileged street kids.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-restaurant-line"></i></div>
                    <h3 class="card-title">Feed the Hungry</h3>
                    <p class="card-desc">Ensuring clean nutritional rice-based lunches to children in slums and daily wage workers.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-first-aid-kit-line"></i></div>
                    <h3 class="card-title">Slum Medical Camps</h3>
                    <p class="card-desc">Conducting bi-weekly health checkups, distribution of clean drinking water, and essential medicines.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Support -->
    <section id="mission" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border);">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; align-items: center;">
            <div>
                <h2 class="section-title" style="text-align: left; margin-bottom: 16px;">Transparency & Accountability</h2>
                <p style="color: var(--muted); margin-bottom: 24px; line-height: 1.8;">Our audited finance logs, tax certifications, and program reports are published annually. Every single donation is tracked directly from funding to field execution.</p>
                <div style="background: var(--card); border: 1px solid var(--border); padding: 24px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
                    <i class="ri-shield-check-line" style="font-size: 24px; color: var(--primary);"></i>
                    <div>
                        <h5 style="margin-bottom: 2px; font-weight: 600;">Government Registered</h5>
                        <p style="color: var(--muted); font-size: 13.5px;">Registered under NGO Affairs Bureau Bangladesh.</p>
                    </div>
                </div>
            </div>
            <div style="background: var(--card); border: 1px solid var(--border); padding: 40px; border-radius: 20px; text-align: center;">
                <h3 style="font-size: 22px; margin-bottom: 12px;">Become a Partner</h3>
                <p style="color: var(--muted); font-size: 14.5px; margin-bottom: 24px;">Support us through CSR sponsorship programs or corporate donation packages.</p>
                <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; width: 100%;">Connect with Operations</a>
            </div>
        </div>
    </section>
@endsection
