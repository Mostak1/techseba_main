@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Firoz Mahmud - Full-Stack Laravel Developer')
@section('primary-color', '#10b981')
@section('primary-rgb', '16, 185, 129')
@section('demo_slug', 'Freelancer Portfolio')
@section('logo-icon', 'ri-code-s-slash-line')
@section('logo-text', 'Firoz.dev')
@section('cta-text', 'Hire Me')

@section('nav-items')
    <li><a href="#about">About Me</a></li>
    <li><a href="#skills">Skills</a></li>
    <li><a href="#projects">My Projects</a></li>
    <li><a href="#experience">History</a></li>
    <li><a href="#pricing">Rates</a></li>
    <li><a href="#faq">FAQs</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="badge">Laravel & Vue Specialist</span>
                <h1 class="hero-title">Building Scalable, Clean <span>Web Applications</span></h1>
                <p class="hero-desc">Firoz Mahmud designs and develops premium web applications using Laravel, Vue.js, and Tailwind CSS. Delivering clean code, API integrations, and robust database systems.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Start a Project <i class="ri-rocket-line"></i></a>
                    <a href="#projects" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">View Portfolio</a>
                </div>
            </div>
            <div style="text-align: center;">
                <img src="{{ asset('uploads/demo/freelancer.png') }}" class="hero-img" alt="Firoz Developer Workspace" style="max-height: 420px; object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- Stats Row -->
    <section style="background: var(--card); padding: 50px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px; text-align: center;">
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">5+ Years</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Development Experience</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">45+ Projects</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Delivered Internationally</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">100% Rate</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Job Success on Upwork</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">20K+ Lines</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Clean Code Written</p>
            </div>
        </div>
    </section>

    <!-- Detailed About / Lottie Banner -->
    <section id="about">
        <div class="container hero-grid">
            <div style="display: flex; justify-content: center; align-items: center;">
                <!-- Animated Lottie File for Coding / Web -->
                <lottie-player src="https://lottie.host/5753b708-3604-45b7-84ad-e77be34fdb23/m0kZ6xYg2k.json" background="transparent" speed="1" style="width: 320px; height: 320px;" loop autoplay></lottie-player>
            </div>
            <div>
                <span class="badge">My Workflow</span>
                <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px;">Writing Code That Scales With Your Business</h2>
                <p style="color: var(--muted); margin-bottom: 20px; line-height: 1.8;">I follow industry best practices when coding: test-driven development (TDD), modular clean architecture, optimized database queries, and secure API gateways. I specialize in building custom SaaS tools, automated ERP modules, and high-performance checkout APIs.</p>
                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); padding: 16px; border-radius: 12px; margin-top: 24px;">
                    <h5 style="margin-bottom: 6px; font-weight: 600;"><i class="ri-git-branch-fill" style="color: var(--primary); margin-right: 6px;"></i> Git Version Controlled</h5>
                    <p style="color: var(--muted); font-size: 13px;">Fully documented branches, PR commits guidelines, and automated deployment actions pipelines.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Technical Expertise</h2>
            <p class="section-desc">The languages, frameworks, and database servers I use daily.</p>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-instance-line" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Backend</span>
                        <h4 class="gallery-title">Laravel & PHP</h4>
                        <p class="gallery-desc">Advanced MVC designs, secure Eloquent ORM relationships, caching layers, and background job queues.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-vuejs-line" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Frontend</span>
                        <h4 class="gallery-title">Vue.js & Pinia</h4>
                        <p class="gallery-desc">State management engines, reusable reactive interfaces, and seamless Inertia.js hybrid setups.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-server-line" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Database</span>
                        <h4 class="gallery-title">MySQL & Redis</h4>
                        <p class="gallery-desc">Structured tables design, custom indexing optimization, and high-performance Redis caching buffers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Portfolio -->
    <section id="projects">
        <div class="container">
            <h2 class="section-title">Featured Projects</h2>
            <p class="section-desc">Explore live applications built for clients across various sectors.</p>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div class="gallery-content">
                        <span class="gallery-tag">SaaS Startup</span>
                        <h4 class="gallery-title">TaskFlow CRM platform</h4>
                        <p class="gallery-desc">Multi-tenant client management portal with automated billing generation and customized team boards.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-content">
                        <span class="gallery-tag">E-commerce</span>
                        <h4 class="gallery-title">Checkout API Engine</h4>
                        <p class="gallery-desc">High-speed headless payment router handling up to 10k product requests per second, integrated with Stripe.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Timeline -->
    <section id="experience" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Development History</h2>
            <p class="section-desc">My professional journey as a web engineer.</p>
            
            <div class="timeline-container">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2022 - Present</div>
                    <h4 class="timeline-title">Freelance Full-Stack Contractor</h4>
                    <p class="timeline-desc">Developing enterprise APIs, custom booking portals, and payment integrations for overseas clients.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2020 - 2022</div>
                    <h4 class="timeline-title">Junior Developer at Softtech</h4>
                    <p class="timeline-desc">Maintained e-commerce modules, compiled relational databases, and optimized landing page loading speeds.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Row -->
    <section id="pricing">
        <div class="container">
            <h2 class="section-title">Contract Rates</h2>
            <p class="section-desc">Flexible packages tailored for your project scales.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <span class="badge">Hourly Model</span>
                    <h3 class="card-title">$35 / Hour</h3>
                    <p class="card-desc" style="margin-bottom: 20px;">Ideal for active code maintenance, feature updates, integrations, and bug fixes.</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Book Hourly Session</a>
                </div>
                <div class="card">
                    <span class="badge">Fixed Price</span>
                    <h3 class="card-title">Custom Quote</h3>
                    <p class="card-desc" style="margin-bottom: 20px;">Best suited for building landing pages, new SaaS blueprints, or full-cycle web applications.</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Request Project Quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section id="faq" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border);">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-desc">Common answers regarding workflow, NDA, and developer communication.</p>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you sign non-disclosure agreements (NDA)?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Yes, I routinely sign NDAs with companies before reviewing proprietary repositories or discussing custom business logic plans.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>What communication tools do you use?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    I use Slack, Discord, and Zoom for team meetings, and Trello or Jira for tracking feature sprint tickets and cards.
                </div>
            </div>
        </div>
    </section>
@endsection
