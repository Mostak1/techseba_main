@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Tahmid Rahman - Tech Entrepreneur & Angel Investor')
@section('primary-color', '#06b6d4')
@section('primary-rgb', '6, 182, 212')
@section('demo_slug', 'Founder Portfolio')
@section('logo-icon', 'ri-rocket-line')
@section('logo-text', 'Tahmid.io')
@section('cta-text', 'Request Pitch Deck')

@section('nav-items')
    <li><a href="#about">Philosophy</a></li>
    <li><a href="#ventures">Ventures</a></li>
    <li><a href="#experience">My Journey</a></li>
    <li><a href="#advisory">Advisory</a></li>
    <li><a href="#faq">FAQs</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="badge">Co-Founder & Tech Operator</span>
                <h1 class="hero-title">Building and Scaling <span>SaaS Solutions</span></h1>
                <p class="hero-desc">Tahmid Rahman is a tech operator and co-founder of multiple growth-stage web platforms. Backed by local and international venture capital funds.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Request Pitch Deck <i class="ri-download-cloud-line"></i></a>
                    <a href="#ventures" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">My Ventures</a>
                </div>
            </div>
            <div style="text-align: center;">
                <img src="{{ asset('uploads/demo/founder.png') }}" class="hero-img" alt="Tahmid Rahman Founder" style="max-height: 420px; object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- Stats Row -->
    <section style="background: var(--card); padding: 50px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px; text-align: center;">
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">3 Startups</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Successfully Founded</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">$5.5M+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Venture Funding Raised</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">100K+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Active Monthly Users</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">6 Investments</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Angel Check Portfolio</p>
            </div>
        </div>
    </section>

    <!-- Detailed About / Lottie Banner -->
    <section id="about">
        <div class="container hero-grid">
            <div style="display: flex; justify-content: center; align-items: center;">
                <!-- Animated Lottie File for Tech Business / Rocket -->
                <lottie-player src="https://lottie.host/7901d848-3165-4f51-ad7b-0447387cc8bf/n5qFkC1vW2.json" background="transparent" speed="1" style="width: 320px; height: 320px;" loop autoplay></lottie-player>
            </div>
            <div>
                <span class="badge">My Vision</span>
                <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px;">Solving Real-World Problems with Capital Efficiency</h2>
                <p style="color: var(--muted); margin-bottom: 20px; line-height: 1.8;">My operator model focuses on identifying operational friction in traditional markets, building robust MVP applications, and raising VC funding to scale product distribution networks. I focus intensely on gross margin dynamics, user churn optimization, and building cohesive developer cultures.</p>
                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); padding: 16px; border-radius: 12px; margin-top: 24px;">
                    <h5 style="margin-bottom: 6px; font-weight: 600;"><i class="ri-lightbulb-fill" style="color: var(--primary); margin-right: 6px;"></i> High Product-Market Fit</h5>
                    <p style="color: var(--muted); font-size: 13px;">We focus on user feedback loops early, ensuring code is aligned with real needs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Ventures Section -->
    <section id="ventures" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Active Tech Startups</h2>
            <p class="section-desc">Selected growth companies I currently operate and guide.</p>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-bank-card-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Fintech</span>
                        <h4 class="gallery-title">Fintech Pay</h4>
                        <p class="gallery-desc">Processing micro-payments for local SMEs. Raised $2.5M Seed Round in 2025 backed by global VCs.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-shield-user-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Cybersecurity</span>
                        <h4 class="gallery-title">Cyber Shield</h4>
                        <p class="gallery-desc">SaaS threat detection and database firewalls helping local corporations guard user identities.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-truck-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Logistics</span>
                        <h4 class="gallery-title">Ship Easy</h4>
                        <p class="gallery-desc">AI-powered container allocation and route tracking dashboard tailored for RMG export businesses.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Founder Journey Timeline -->
    <section id="experience">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Startup Journey</h2>
            <p class="section-desc">Key milestones highlighting fundraises and startup exits.</p>
            
            <div class="timeline-container">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2025</div>
                    <h4 class="timeline-title">Raised $2.5M Seed for Fintech Pay</h4>
                    <p class="timeline-desc">Secured institutional VC backing from Singapore and US angel networks to scale operations.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2022</div>
                    <h4 class="timeline-title">SaaS exit to multinational group</h4>
                    <p class="timeline-desc">Sold our cloud scheduling ERP tool to a leading local logistics enterprise company.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2019</div>
                    <h4 class="timeline-title">First Startup Launch</h4>
                    <p class="timeline-desc">Co-founded a student learning platform, scaling it organically to 50k monthly active users.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Advisory / Invest -->
    <section id="advisory" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Angel Investments & Advisory</h2>
            <p class="section-desc">I invest in early-stage tech founders solving hard problems.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <span class="badge">Angel Checks</span>
                    <h3 class="card-title">$25K - $50K Ticket Size</h3>
                    <p class="card-desc" style="margin-bottom: 20px;">Investing in Pre-Seed/Seed SaaS, AI, and developer tools startups based in South Asia.</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Submit Startup Pitch</a>
                </div>
                <div class="card">
                    <span class="badge">Board Seat</span>
                    <h3 class="card-title">Strategic Advisory</h3>
                    <p class="card-desc" style="margin-bottom: 20px;">Offering guidance on product architectures, fundraising cycles, and engineering scale operations.</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Request Board advisory</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section id="faq">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-desc">Answers to common pitch submission and investment queries.</p>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What materials do you require for investment review?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Please submit a 10-slide pitch deck outlining the problem statement, product demo screens, user traction metrics, team background, and fund utilization plans.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you participate as a lead investor in syndicates?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    No, I typically act as an angel follow-on investor, participating alongside institutional VC funds or structured angel networks.
                </div>
            </div>
        </div>
    </section>
@endsection
