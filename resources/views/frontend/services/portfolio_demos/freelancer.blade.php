@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Firoz Mahmud - Full-Stack Laravel Developer')
@section('primary-color', '#10b981')
@section('primary-rgb', '16, 185, 129')
@section('demo_slug', 'Freelancer Portfolio')
@section('logo-icon', 'ri-code-s-slash-line')
@section('logo-text', 'Firoz.dev')
@section('cta-text', 'Hire Me')

@section('nav-items')
    <li><a href="#skills">Skills</a></li>
    <li><a href="#work">Projects</a></li>
    <li><a href="#services">Services</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span style="color: var(--primary); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1.5px; display: block; margin-bottom: 12px;">Web Developer & Contractor</span>
                <h1 class="hero-title">Building Scalable <span>Web Solutions</span></h1>
                <p class="hero-desc">Firoz Mahmud designs and develops premium web applications using Laravel, Vue.js, and Tailwind CSS. Delivering clean code, API integrations, and robust database systems.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Start a Project <i class="ri-rocket-line"></i></a>
                    <a href="#work" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">View Portfolio</a>
                </div>
            </div>
            <div>
                <div class="hero-img-box">
                    <i class="ri-braces-line"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills -->
    <section id="skills" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Core Skills</h2>
            <p class="section-desc">Tools and frameworks I specialize in to build production-ready applications.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <div class="card-icon"><i class="ri-braces-line"></i></div>
                    <h3 class="card-title">Laravel & PHP</h3>
                    <p class="card-desc">Advanced MVC design, REST APIs, Eloquent ORM, custom package development, and server security configurations.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-vuejs-line"></i></div>
                    <h3 class="card-title">Vue.js & SPA</h3>
                    <p class="card-desc">Interactive frontend systems, state management, component architectures, and inertia.js integration.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-database-2-line"></i></div>
                    <h3 class="card-title">MySQL & PostgreSQL</h3>
                    <p class="card-desc">Optimized database structures, custom queries speed indexing, data backup configurations, and storage caching.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services / Hourly rate -->
    <section id="services">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; align-items: center;">
            <div>
                <h2 class="section-title" style="text-align: left; margin-bottom: 16px;">Freelance Pricing Model</h2>
                <p style="color: var(--muted); margin-bottom: 24px; line-height: 1.8;">I take up contracts on both fixed-price projects and hourly arrangements. Ready to sign NDA and integrate with your development teams.</p>
                
                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); padding: 24px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <h5 style="font-weight: 700; font-size: 15px;">Hourly Rate</h5>
                        <p style="color: var(--muted); font-size: 13.5px;">Negotiable based on project scale</p>
                    </div>
                    <span style="font-size: 24px; font-weight: 800; color: var(--primary);">$35/hr</span>
                </div>
            </div>
            <div style="background: var(--card); border: 1px solid var(--border); padding: 40px; border-radius: 20px; text-align: center;">
                <h3 style="font-size: 22px; margin-bottom: 12px;">Get a Quote</h3>
                <p style="color: var(--muted); font-size: 14.5px; margin-bottom: 24px;">Have a web app blueprint ready? Share it with me and get a development time roadmap.</p>
                <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; width: 100%;">Hire Me On Contract</a>
            </div>
        </div>
    </section>

    <!-- Projects Portfolio -->
    <section id="work" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Recent Projects</h2>
            <p class="section-desc">Selected projects I have successfully delivered to international clients.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <div style="font-size: 20px; font-weight:700; color:var(--primary); margin-bottom: 12px;">SaaS CRM Platform</div>
                    <p class="card-desc">Built a multi-tenant client relationship platform with customized invoice generators and live customer chat features.</p>
                </div>
                <div class="card">
                    <div style="font-size: 20px; font-weight:700; color:var(--primary); margin-bottom: 12px;">E-commerce API Engine</div>
                    <p class="card-desc">Coded a high-speed headless checkout server, handling up to 10k product requests per second, integrated with Stripe.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
