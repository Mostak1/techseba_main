@extends('frontend.templates.main_demo_layout')
@php
    $serviceTitle = $serviceSeo['title'] ?? $service?->translate?->title ?? $service?->title ?? 'Website Development';
    $serviceShortDescription = $serviceSeo['short_description'] ?? $service?->translate?->short_description ?? $service?->short_description ?? '';
    $serviceDescription = $serviceSeo['description'] ?? $service?->translate?->description ?? $service?->description ?? '';
    $serviceSeoTitle = $seoTitle ?? $service?->seo_title ?? $serviceTitle;
    $serviceSeoDescription = $seoDescription ?? $service?->seo_description ?? $serviceShortDescription;
@endphp

@section('title')
    <title>{{ $serviceSeoTitle }}</title>
    <meta name="title" content="{{ $serviceSeoTitle }}">
    <meta name="description" content="{{ techseba_seo_description($serviceSeoDescription) }}">
@endsection

@push('schema')
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $serviceTitle,
        'description' => techseba_seo_description($serviceSeoDescription),
        'provider' => [
            '@type' => 'LocalBusiness',
            'name' => config('techseba_seo.organization.name'),
            'url' => config('techseba_seo.organization.url'),
        ],
        'url' => $canonicalUrl ?? url()->current(),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
@php
    $currentLang = session()->get('front_lang');

    $offers = [
        [
            'icon' => 'ri-shopping-cart-2-line', 
            'title' => 'E-commerce Website Development', 
            'desc' => 'Complete online stores with modern shopping cart, secure checkout, multiple payment integrations, and easy inventory panels.', 
            'features' => ['Product Category Setup', 'Payment Gateway Integration']
        ],
        [
            'icon' => 'ri-building-2-line', 
            'title' => 'Business Website Development', 
            'desc' => 'Professional websites designed with custom features, WhatsApp chat buttons, and standard SEO-friendly structures.', 
            'features' => ['Clear & Modern Layouts', 'Fast Loading Speeds']
        ],
        [
            'icon' => 'ri-layout-2-line', 
            'title' => 'Landing Page Design', 
            'desc' => 'Conversion-driven layouts focused on promoting services, specific products, and generating high quality leads.', 
            'features' => ['Lead Generation Forms', 'Optimized Call-to-Actions']
        ],
        [
            'icon' => 'ri-palette-line', 
            'title' => 'Portfolio Website', 
            'desc' => 'Showcase your creative skills, client testimonials, and highlight previous projects in a highly professional presentation.', 
            'features' => ['Interactive Galleries', 'Modern Profile Layouts']
        ],
        [
            'icon' => 'ri-server-line', 
            'title' => 'Website Hosting & Setup', 
            'desc' => 'Domain registration, premium high-speed hosting setup, free SSL configuration, and 24/7 technical monitoring.', 
            'features' => ['Secure Server Configuration', 'Free SSL Installation']
        ],
    ];

    $whyChoose = [
        ['title' => 'Modern & Professional Design', 'desc' => 'State-of-the-art layout matching the latest global trends.'],
        ['title' => '100% Responsive Layouts', 'desc' => 'Works flawlessly on desktops, tablets, and smartphones.'],
        ['title' => 'Fast Loading Performance', 'desc' => 'Highly optimized coding for rapid loading times and page speed.'],
        ['title' => 'Complete Setup Support', 'desc' => 'Domain, hosting, database, and SSL configured directly by experts.'],
    ];

    $portfolioTypes = [
        [
            'icon' => 'ri-stethoscope-line',
            'title' => 'Doctor Portfolio',
            'desc' => 'Specialization display, clinic info, appointment booking CTA'
        ],
        [
            'icon' => 'ri-scales-3-line',
            'title' => 'Advocate / Lawyer Portfolio',
            'desc' => 'Practice areas, case success stats, consultation CTA'
        ],
        [
            'icon' => 'ri-graduation-cap-line',
            'title' => 'Teacher / Tutor Portfolio',
            'desc' => 'Subjects taught, certifications, student testimonials'
        ],
        [
            'icon' => 'ri-tiktok-line',
            'title' => 'TikToker / Content Creator Portfolio',
            'desc' => 'Social stats counter, media kit download, brand collab CTA'
        ],
        [
            'icon' => 'ri-vip-crown-2-line',
            'title' => 'Popular Person / Celebrity Portfolio',
            'desc' => 'Fan engagement section, event schedule, merch link'
        ],
        [
            'icon' => 'ri-briefcase-line',
            'title' => 'Freelancer Portfolio',
            'desc' => 'Skills, hourly rate display, hire me CTA'
        ],
        [
            'icon' => 'ri-rocket-2-line',
            'title' => 'Startup Founder Portfolio',
            'desc' => 'Vision statement, investor pitch deck download link'
        ],
        [
            'icon' => 'ri-hand-heart-line',
            'title' => 'NGO / Social Worker Portfolio',
            'desc' => 'Mission, impact numbers, donation CTA'
        ],
    ];

    $projects = [
        [
            'title' => 'Shwapno E-commerce',
            'industry' => 'Retail & E-commerce',
            'image' => 'frontend/assets/img/p1/p1.png',
            'link' => '#'
        ],
        [
            'title' => 'Pathao Logistics',
            'industry' => 'Courier & Transport',
            'image' => 'frontend/assets/img/p1/p2.png',
            'link' => '#'
        ],
        [
            'title' => 'Praava Health Clinic',
            'industry' => 'Healthcare Services',
            'image' => 'frontend/assets/img/p1/p3.png',
            'link' => '#'
        ],
        [
            'title' => 'Sheba On-Demand Services',
            'industry' => 'Local Business Portal',
            'image' => 'frontend/assets/img/p1/p4.png',
            'link' => '#'
        ],
        [
            'title' => 'Chaldal Online Grocery',
            'industry' => 'Delivery & Shopping',
            'image' => 'frontend/assets/img/p1/p5.png',
            'link' => '#'
        ],
        [
            'title' => 'Bikroy Marketplace',
            'industry' => 'Classified Listings',
            'image' => 'frontend/assets/img/p1/p6.png',
            'link' => '#'
        ],
    ];

    $testimonials = [
        [
            'name' => 'Tariqul Islam',
            'profession' => 'Founder, AgroBD',
            'avatar' => 'TI',
            'quote' => 'TechSeba built our e-commerce platform. Our sales doubled in 3 months due to the fast loading speed and clean user experience. Highly recommended!',
            'rating' => 5
        ],
        [
            'name' => 'Dr. Farhana Rahman',
            'profession' => 'Cardiologist, Labaid',
            'avatar' => 'FR',
            'quote' => 'The appointment booking system on my portfolio website is flawless. My patients can easily book slots online, saving our staff hours of call time.',
            'rating' => 5
        ],
        [
            'name' => 'Barrister Rafiqul Alam',
            'profession' => 'Senior Partner, Alam Chambers',
            'avatar' => 'RA',
            'quote' => 'A very professional corporate website. They understood our requirements and delivered a highly polished website in just 7 days.',
            'rating' => 5
        ],
        [
            'name' => 'Sabbir Ahmed',
            'profession' => 'Freelance UI Designer',
            'avatar' => 'SA',
            'quote' => 'As a freelancer, my portfolio website is my identity. TechSeba designed a beautiful, interactive page that got me 3 new clients in the first week.',
            'rating' => 5
        ]
    ];

    $faqs = [
        ['q' => 'How much does website development cost?', 'a' => 'The cost depends on the specific project scope and features required. We offer affordable packages beginning at ৳10,200 for basic sites up to custom pricing for advanced web systems.'],
        ['q' => 'Can you redesign our existing website?', 'a' => 'Yes, we can modernize your current website, improve loading speeds, make it fully mobile responsive, and implement modern layouts while keeping existing content.'],
        ['q' => 'Will my website be mobile friendly?', 'a' => 'Absolutely. Every website we build is fully optimized with responsive coding rules for all screen dimensions.'],
        ['q' => 'Do you provide maintenance and technical support?', 'a' => 'Yes, all packages include free technical support after launch to ensure your website remains functional, updated, and secure.'],
        ['q' => 'কতদিনে ওয়েবসাইট বানিয়ে দেবেন?', 'a' => 'আমাদের সাধারণ প্যাকেজের ওয়েবসাইটগুলো আমরা ৩ থেকে ৭ দিনের মধ্যে ডিজাইন ও ডেলিভারি সম্পূর্ণ করে থাকি। কাস্টম ওয়েবসাইটের ক্ষেত্রে প্রজেক্টের রিকোয়ারমেন্টের ওপর নির্ভর করে সময় নির্ধারণ করা হয়।'],
        ['q' => 'bKash এ payment করা যাবে?', 'a' => 'হ্যাঁ, আমরা বিকাশ (bKash), নগদ (Nagad), রকেট (Rocket) এবং যেকোনো বাংলাদেশি ব্যাংক ট্রান্সফার পেমেন্ট গ্রহণ করি।'],
        ['q' => 'কোন ধরনের portfolio website বেশি popular?', 'a' => 'বর্তমানে প্রফেশনাল এবং ফ্রিল্যান্সারদের জন্য আধুনিক গ্লাস-মোটিফ ডিজাইন ও লাইভ অ্যাপয়েন্টমেন্ট বুকিং ফিচার যুক্ত পোর্টফোলিও ওয়েবসাইটগুলো সবচেয়ে বেশি জনপ্রিয়।'],
        ['q' => 'Domain এবং Hosting কি আলাদা কিনতে হবে?', 'a' => 'না, আমাদের প্রিমিয়াম প্যাকেজগুলোর সাথে আমরা ১ বছরের জন্য ডোমেইন এবং হাই-স্পিড হোস্টিং সম্পূর্ণ ফ্রিতে প্রদান করি। ফলে আপনাকে আলাদাভাবে এগুলো কিনতে হবে না।'],
        ['q' => 'Website বানানোর পর কি changes করতে পারবো?', 'a' => 'অবশ্যই। আমরা সম্পূর্ণ ড্যাশবোর্ড বুঝিয়ে দেবো যাতে আপনি নিজেই কন্টেন্ট ও ইমেজ পরিবর্তন করতে পারেন। এছাড়াও প্রথম কয়েকদিন আমাদের টিম আপনার যেকোনো পরিবর্তনের জন্য সার্বিক সহায়তা প্রদান করবে।']
    ];

    $plans = $service?->translate?->plans ?? [];
@endphp

{{-- ==================== URGENCY / OFFER BANNER ==================== --}}
<div class="swd-announcement-bar" id="swdAnnouncementBar">
    <div class="container swd-announcement-container">
        <span>🎉 এই মাসে Order করলে FREE Domain! — Limited Slots Available</span>
        <button class="swd-announcement-close" onclick="document.getElementById('swdAnnouncementBar').style.display='none'">&times;</button>
    </div>
</div>

{{-- ==================== HERO SECTION ==================== --}}
<section class="swd-hero">
    <div class="swd-hero__mesh"></div>
    <div class="container">
        <span class="swd-hero__badge">Solutions</span>
        <h1 class="swd-hero__title">
            <span>{{ $serviceTitle }}</span><br>
            <span class="swd-hero__subtitle">আপনার Business কে Online এ নিয়ে আসুন</span>
        </h1>
        <p class="swd-hero__desc">{{ $serviceShortDescription ?: 'We create professional, responsive, and high performing websites for businesses, personal brands, and online stores.' }}</p>
        <div class="swd-hero__actions">
            <a href="{{ route('contact-us') }}" class="btn-primary">Get Free Quote</a>
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank" class="btn-video"><i class="ri-play-circle-fill"></i> Watch Demo</a>
        </div>
        
        <div class="swd-hero__trust">
            <div class="swd-hero__stars">
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
            </div>
            <span>Trusted by 150+ clients in Bangladesh</span>
        </div>
        
        {{-- Showcase Mockup --}}
        <div class="swd-hero__showcase" data-aos="fade-up" data-aos-duration="800">
            <img src="{{ asset('uploads/website_development_showcase.png') }}" class="swd-hero__image" alt="Website Showcase Mockup">
        </div>

        {{-- Trust Badges Row --}}
        <div class="swd-hero__badges" data-aos="fade-up" data-aos-delay="100">
            <div class="swd-badge-item">
                <i class="ri-wallet-3-line"></i>
                <span>bKash / Nagad Accepted</span>
            </div>
            <div class="swd-badge-item">
                <i class="ri-shield-check-line"></i>
                <span>100% Money Back</span>
            </div>
            <div class="swd-badge-item">
                <i class="ri-lock-password-line"></i>
                <span>SSL Secured Gateway</span>
            </div>
            <div class="swd-badge-item">
                <i class="ri-calendar-event-line"></i>
                <span>Delivery in 7 Days</span>
            </div>
            <div class="swd-badge-item">
                <i class="ri-customer-service-2-line"></i>
                <span>24/7 Live Support</span>
            </div>
        </div>
    </div>
</section>

{{-- ==================== COUNTER SECTION ==================== --}}
<section class="swd-counters-strip">
    <div class="container">
        <div class="swd-counters-grid">
            <div class="swd-counter-item">
                <div class="swd-counter-num" data-val="200">0+</div>
                <div class="swd-counter-label">Websites Delivered</div>
            </div>
            <div class="swd-counter-item">
                <div class="swd-counter-num" data-val="150">0+</div>
                <div class="swd-counter-label">Happy Clients</div>
            </div>
            <div class="swd-counter-item">
                <div class="swd-counter-num" data-val="5">0+</div>
                <div class="swd-counter-label">Years Experience</div>
            </div>
            <div class="swd-counter-item">
                <div class="swd-counter-num" data-val="4.9">0★</div>
                <div class="swd-counter-label">Average Rating</div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== WHAT WE OFFER ==================== --}}
<section class="swd-section swd-offers">
    <div class="container">
        <div class="swd-section-head">
            <span class="swd-label">What We Offer</span>
            <h2 class="section-title">Website Services</h2>
        </div>
        <div class="swd-offers__grid">
            @foreach($offers as $i => $offer)
            <div class="swd-offer-card" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="swd-offer-card__icon"><i class="{{ $offer['icon'] }}"></i></div>
                <h4 class="swd-offer-card__title">{{ $offer['title'] }}</h4>
                <p class="swd-offer-card__desc">{{ $offer['desc'] }}</p>
                <ul class="swd-offer-card__features">
                    @foreach($offer['features'] as $f)
                    <li><i class="ri-checkbox-circle-line"></i> {{ $f }}</li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== WHY CHOOSE TECHSEBA ==================== --}}
<section class="swd-section swd-section--alt swd-why">
    <div class="container">
        <div class="swd-why__layout">
            <div class="swd-why__info">
                <span class="swd-label">Benefits</span>
                <h2 class="section-title">Why Choose TechSeba?</h2>
                <p class="section-sub">We build standard corporate websites and robust web applications focused on premium quality, reliability, and business growth.</p>
                
                <div class="swd-why__quick-stats">
                    <div class="swd-stat-box">
                        <span class="swd-stat-num">200+</span>
                        <span class="swd-stat-label">Websites Delivered</span>
                    </div>
                    <div class="swd-stat-box">
                        <span class="swd-stat-num">100%</span>
                        <span class="swd-stat-label">Client Satisfaction</span>
                    </div>
                </div>
            </div>
            <div class="swd-why__list">
                @foreach($whyChoose as $i => $item)
                <div class="swd-why-card" data-aos="fade-left" data-aos-delay="{{ $i * 80 }}">
                    <h4 class="swd-why-card__title">{{ $item['title'] }}</h4>
                    <p class="swd-why-card__desc">{{ $item['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ==================== BEFORE vs AFTER SECTION ==================== --}}
<section class="swd-section swd-comparison-visual">
    <div class="container">
        <div class="swd-section-head text-center">
            <span class="swd-label">Redesign Case</span>
            <h2 class="section-title">Before vs After Redesign</h2>
            <p class="section-sub">See the difference we make. We transform slow, outdated layouts into high-converting modern experiences.</p>
        </div>
        <div class="swd-visual-grid" data-aos="fade-up">
            <div class="swd-visual-card swd-visual-card--before">
                <div class="swd-visual-badge swd-visual-badge--before">Before (Old Website)</div>
                <div class="swd-visual-img-wrapper">
                    <img src="{{ asset('uploads/before_design_showcase.png') }}" alt="Old website legacy layout" class="swd-visual-img">
                </div>
                <div class="swd-visual-caption">Slow Loading, Not Responsive, Confusing Layout</div>
            </div>
            <div class="swd-visual-card swd-visual-card--after">
                <div class="swd-visual-badge swd-visual-badge--after">After (TechSeba Redesign)</div>
                <div class="swd-visual-img-wrapper">
                    <img src="{{ asset('uploads/website_development_showcase.png') }}" alt="Modern website layout" class="swd-visual-img">
                </div>
                <div class="swd-visual-caption">Ultra Fast, Modern Glassmorphism, 100% Mobile Ready</div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== PROCESS TIMELINE SECTION ==================== --}}
<section class="swd-section swd-process">
    <div class="container">
        <div class="swd-section-head">
            <span class="swd-label">Workflow</span>
            <h2 class="section-title">How It Works</h2>
            <p class="section-sub">Our transparent 7-day development process to launch your website quickly and efficiently.</p>
        </div>
        <div class="swd-timeline" data-aos="fade-up">
            <div class="swd-timeline-line"></div>
            <div class="swd-timeline-grid">
                {{-- Step 1 --}}
                <div class="swd-timeline-item">
                    <div class="swd-timeline-icon">
                        <i class="ri-chat-voice-line"></i>
                    </div>
                    <div class="swd-timeline-step">Step 1</div>
                    <h4 class="swd-timeline-title">Requirement Collection</h4>
                    <span class="swd-timeline-day">Day 1</span>
                    <p class="swd-timeline-desc">We discuss your ideas, goals, features, and content needs to lock the requirements.</p>
                </div>
                {{-- Step 2 --}}
                <div class="swd-timeline-item">
                    <div class="swd-timeline-icon">
                        <i class="ri-pencil-ruler-2-line"></i>
                    </div>
                    <div class="swd-timeline-step">Step 2</div>
                    <h4 class="swd-timeline-title">Design Mockup Approval</h4>
                    <span class="swd-timeline-day">Day 2-3</span>
                    <p class="swd-timeline-desc">We build interactive design prototypes for your review and finalize based on your feedback.</p>
                </div>
                {{-- Step 3 --}}
                <div class="swd-timeline-item">
                    <div class="swd-timeline-icon">
                        <i class="ri-code-s-slash-line"></i>
                    </div>
                    <div class="swd-timeline-step">Step 3</div>
                    <h4 class="swd-timeline-title">Development & Testing</h4>
                    <span class="swd-timeline-day">Day 4-6</span>
                    <p class="swd-timeline-desc">Our developers code the site with responsiveness and optimize speed, SEO, and security.</p>
                </div>
                {{-- Step 4 --}}
                <div class="swd-timeline-item">
                    <div class="swd-timeline-icon">
                        <i class="ri-rocket-fill"></i>
                    </div>
                    <div class="swd-timeline-step">Step 4</div>
                    <h4 class="swd-timeline-title">Launch & Handover</h4>
                    <span class="swd-timeline-day">Day 7</span>
                    <p class="swd-timeline-desc">We set up the live server, link domain, test the live link, and hand over admin panels.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== PORTFOLIO WEBSITE TYPES ==================== --}}
<section class="swd-section swd-portfolio-types">
    <div class="container">
        <div class="swd-section-head">
            <span class="swd-label">Portfolio Types</span>
            <h2 class="section-title">Portfolio Website Types</h2>
            <p class="section-sub">We design custom, purpose-built portfolio websites for professionals, creators, and organizations.</p>
        </div>
        <div class="swd-portfolio-grid">
            @foreach($portfolioTypes as $i => $item)
            <div class="swd-portfolio-card" data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">
                <div class="swd-portfolio-card__top">
                    <div class="swd-portfolio-card__icon">
                        <i class="{{ $item['icon'] }}"></i>
                    </div>
                    <h4 class="swd-portfolio-card__title">{{ $item['title'] }}</h4>
                    <p class="swd-portfolio-card__desc">{{ $item['desc'] }}</p>
                </div>
                <a href="{{ route('contact-us') }}" class="swd-portfolio-card__btn">View Sample</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== LIVE PROJECT GALLERY SECTION ==================== --}}
<section class="swd-section swd-recent-work">
    <div class="container">
        <div class="swd-section-head">
            <span class="swd-label">Portfolio</span>
            <h2 class="section-title">Our Recent Work</h2>
            <p class="section-sub">Take a look at some of the websites we have successfully built and launched recently.</p>
        </div>
        <div class="swd-projects-grid">
            @foreach($projects as $i => $project)
            <div class="swd-project-card" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">
                <div class="swd-project-card__img-wrapper">
                    <img src="{{ asset($project['image']) }}" alt="{{ $project['title'] }}" class="swd-project-card__img">
                </div>
                <div class="swd-project-card__body">
                    <span class="swd-project-card__niche">{{ $project['industry'] }}</span>
                    <h4 class="swd-project-card__title">{{ $project['title'] }}</h4>
                    <a href="{{ $project['link'] }}" class="swd-project-card__btn">View Live <i class="ri-external-link-line"></i></a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('portfolio') }}" class="btn-ghost">View All Projects</a>
        </div>
    </div>
</section>

{{-- ==================== PRICING PACKAGES ==================== --}}
<section class="swd-section swd-pricing" id="swd-pricing">
    <div class="container">
        <div class="swd-section-head">
            <span class="swd-label">Pricing Plans</span>
            <h2 class="section-title">Pricing Packages</h2>
            <p class="section-sub">Choose the plan that fits your business needs</p>
        </div>
        <div class="swd-pricing__grid">
            {{-- Starter Package --}}
            <div class="swd-price-card" data-aos="fade-up" data-aos-delay="0">
                <div class="swd-price-card__head">
                    <h3 class="swd-price-card__name">{{ $plans[0]['name'] ?? 'Starter Package' }}</h3>
                    <p class="swd-price-card__desc">{{ $plans[0]['description'] ?? 'Ideal for landing pages & simple websites.' }}</p>
                </div>
                <div class="swd-price-card__price">
                    @if(!empty($plans[0]['price']))
                        <span class="swd-price-card__currency">৳</span>
                        <span class="swd-price-card__amount">{{ is_numeric($plans[0]['price']) ? number_format($plans[0]['price'], 2) : $plans[0]['price'] }}</span>
                    @else
                        <span class="swd-price-card__currency">৳</span>
                        <span class="swd-price-card__amount">10,200.00</span>
                    @endif
                    <span class="swd-price-card__period">/ life</span>
                </div>
                <ul class="swd-price-card__features">
                    @if(!empty($plans[0]['features']))
                        @foreach(explode("\n", $plans[0]['features']) as $feat)
                            @if(trim($feat)) <li><i class="ri-checkbox-circle-fill"></i> {{ trim($feat) }}</li> @endif
                        @endforeach
                    @else
                        <li><i class="ri-checkbox-circle-fill"></i> Up to 5 pages</li>
                        <li><i class="ri-checkbox-circle-fill"></i> Mobile responsive layout</li>
                        <li><i class="ri-checkbox-circle-fill"></i> 1 day support</li>
                    @endif
                </ul>
                <a href="{{ route('contact-us') }}" class="btn-ghost btn-full-width">Select This Plan</a>
            </div>

            {{-- Standard Package --}}
            <div class="swd-price-card swd-price-card--featured" data-aos="fade-up" data-aos-delay="100">
                <div class="swd-price-card__badge">Most Popular</div>
                <div class="swd-price-card__head">
                    <h3 class="swd-price-card__name">{{ $plans[1]['name'] ?? 'Standard Package' }}</h3>
                    <p class="swd-price-card__desc">{{ $plans[1]['description'] ?? 'Best for small to medium scale businesses.' }}</p>
                </div>
                <div class="swd-price-card__price">
                    @if(!empty($plans[1]['price']))
                        <span class="swd-price-card__currency">৳</span>
                        <span class="swd-price-card__amount">{{ is_numeric($plans[1]['price']) ? number_format($plans[1]['price'], 2) : $plans[1]['price'] }}</span>
                    @else
                        <span class="swd-price-card__currency">৳</span>
                        <span class="swd-price-card__amount">22,000.00</span>
                    @endif
                    <span class="swd-price-card__period">/ life</span>
                </div>
                <ul class="swd-price-card__features">
                    @if(!empty($plans[1]['features']))
                        @foreach(explode("\n", $plans[1]['features']) as $feat)
                            @if(trim($feat)) <li><i class="ri-checkbox-circle-fill"></i> {{ trim($feat) }}</li> @endif
                        @endforeach
                    @else
                        <li><i class="ri-checkbox-circle-fill"></i> Up to 15 pages</li>
                        <li><i class="ri-checkbox-circle-fill"></i> Modern business folder</li>
                        <li><i class="ri-checkbox-circle-fill"></i> Google Map Integration</li>
                        <li><i class="ri-checkbox-circle-fill"></i> WhatsApp & social setup</li>
                        <li><i class="ri-checkbox-circle-fill"></i> 3 days support</li>
                    @endif
                </ul>
                <a href="{{ route('contact-us') }}" class="btn-primary btn-full-width">Select This Plan</a>
            </div>

            {{-- Custom Package --}}
            <div class="swd-price-card" data-aos="fade-up" data-aos-delay="200">
                <div class="swd-price-card__head">
                    <h3 class="swd-price-card__name">{{ $plans[2]['name'] ?? 'Custom Package' }}</h3>
                    <p class="swd-price-card__desc">{{ $plans[2]['description'] ?? 'Tailored to unique business functions.' }}</p>
                </div>
                <div class="swd-price-card__price">
                    <span class="swd-price-card__amount">{{ $plans[2]['price'] ?? 'Custom Quote' }}</span>
                </div>
                <ul class="swd-price-card__features">
                    @if(!empty($plans[2]['features']))
                        @foreach(explode("\n", $plans[2]['features']) as $feat)
                            @if(trim($feat)) <li><i class="ri-checkbox-circle-fill"></i> {{ trim($feat) }}</li> @endif
                        @endforeach
                    @else
                        <li><i class="ri-checkbox-circle-fill"></i> E-commerce development</li>
                        <li><i class="ri-checkbox-circle-fill"></i> Advanced database systems</li>
                        <li><i class="ri-checkbox-circle-fill"></i> 10 days support</li>
                    @endif
                </ul>
                <a href="{{ route('contact-us') }}" class="btn-ghost btn-full-width">Inquire Now</a>
            </div>
        </div>
    </div>
</section>

{{-- ==================== QUICK QUOTE FORM SECTION ==================== --}}
<section class="swd-section swd-quick-quote">
    <div class="container">
        <div class="swd-quick-quote__wrapper" data-aos="zoom-in">
            <div class="swd-quick-quote__info">
                <h2 class="swd-quick-quote__title">Instant Project Estimate</h2>
                <p class="swd-quick-quote__desc">Fill out this quick form and our specialists will contact you with a free customized quote within 1 hour.</p>
                <div class="swd-quick-quote__meta">
                    <span class="swd-quick-quote__meta-item"><i class="ri-checkbox-circle-fill"></i> No Obligation</span>
                    <span class="swd-quick-quote__meta-item"><i class="ri-checkbox-circle-fill"></i> Free Consultation</span>
                </div>
            </div>
            <div class="swd-quick-quote__form-box">
                <form action="{{ route('contact-us') }}" method="GET" class="swd-quote-form">
                    <div class="swd-form-group">
                        <label for="quoteName" class="swd-form-label">Full Name</label>
                        <input type="text" name="name" id="quoteName" class="swd-form-input" placeholder="Your Name" required>
                    </div>
                    <div class="swd-form-group">
                        <label for="quoteType" class="swd-form-label">Website Type</label>
                        <select name="type" id="quoteType" class="swd-form-select" required>
                            <option value="" disabled selected>Select Website Type</option>
                            <option value="Doctor">Doctor Portfolio</option>
                            <option value="Lawyer">Lawyer / Advocate Portfolio</option>
                            <option value="Business">Business Website</option>
                            <option value="TikToker">Creator / TikToker Portfolio</option>
                            <option value="Other">Other Custom Website</option>
                        </select>
                    </div>
                    <div class="swd-form-group">
                        <label for="quoteBudget" class="swd-form-label">Budget Range</label>
                        <select name="budget" id="quoteBudget" class="swd-form-select" required>
                            <option value="" disabled selected>Select Budget Range</option>
                            <option value="Under ৳10000">Under ৳10,000</option>
                            <option value="৳10000 - ৳25000">৳10,000 - ৳25,000</option>
                            <option value="৳25000+">৳25,000+</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary btn-full-width">Get Free Quote in 1 Hour</button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- ==================== COMPARISON TABLE ==================== --}}
<section class="swd-section swd-comparison">
    <div class="container">
        <div class="swd-section-head">
            <span class="swd-label">Comparison</span>
            <h2 class="section-title">Package Comparison</h2>
            <p class="section-sub">Detailed breakdown of our website development plans to help you choose the right one.</p>
        </div>
        <div class="swd-table-wrapper" data-aos="fade-up">
            <table class="swd-compare-table">
                <thead>
                    <tr>
                        <th>Features</th>
                        <th>Starter Package</th>
                        <th class="swd-col-highlight">Standard Package</th>
                        <th>Custom Package</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="swd-feat-name">Pages</td>
                        <td>1-3 Pages</td>
                        <td class="swd-col-highlight">Up to 15 Pages</td>
                        <td>Unlimited Pages</td>
                    </tr>
                    <tr>
                        <td class="swd-feat-name">Design Revisions</td>
                        <td>2 Revisions</td>
                        <td class="swd-col-highlight">5 Revisions</td>
                        <td>Unlimited Revisions</td>
                    </tr>
                    <tr>
                        <td class="swd-feat-name">SEO Configuration</td>
                        <td>Basic SEO</td>
                        <td class="swd-col-highlight">Advanced SEO</td>
                        <td>Full Custom SEO</td>
                    </tr>
                    <tr>
                        <td class="swd-feat-name">WhatsApp Chat Button</td>
                        <td><i class="ri-checkbox-circle-fill text-accent"></i></td>
                        <td class="swd-col-highlight"><i class="ri-checkbox-circle-fill text-accent"></i></td>
                        <td><i class="ri-checkbox-circle-fill text-accent"></i></td>
                    </tr>
                    <tr>
                        <td class="swd-feat-name">Google Map Integration</td>
                        <td><i class="ri-close-circle-fill text-muted"></i></td>
                        <td class="swd-col-highlight"><i class="ri-checkbox-circle-fill text-accent"></i></td>
                        <td><i class="ri-checkbox-circle-fill text-accent"></i></td>
                    </tr>
                    <tr>
                        <td class="swd-feat-name">Portfolio Types Support</td>
                        <td>1 Type</td>
                        <td class="swd-col-highlight">3 Types</td>
                        <td>Full custom portfolio</td>
                    </tr>
                    <tr>
                        <td class="swd-feat-name">After-sales Support</td>
                        <td>3 Days</td>
                        <td class="swd-col-highlight">10 Days</td>
                        <td>30 Days</td>
                    </tr>
                    <tr class="swd-price-row">
                        <td class="swd-feat-name">Price</td>
                        <td class="swd-price-val">৳10,200</td>
                        <td class="swd-col-highlight swd-price-val">৳22,000</td>
                        <td class="swd-price-val">Custom Quote</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- ==================== CLIENT TESTIMONIALS SECTION ==================== --}}
<section class="swd-section swd-testimonials">
    <div class="container">
        <div class="swd-section-head">
            <span class="swd-label">Reviews</span>
            <h2 class="section-title">Client Testimonials</h2>
            <p class="section-sub">Read honest feedback from Bangladeshi business owners and professionals who trust TechSeba.</p>
        </div>
        <div class="swd-testimonials-grid">
            @foreach($testimonials as $i => $t)
            <div class="swd-testimonial-card" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">
                <div class="swd-testimonial-card__head">
                    <div class="swd-testimonial-card__avatar">
                        <span>{{ $t['avatar'] }}</span>
                    </div>
                    <div class="swd-testimonial-meta">
                        <h4 class="swd-testimonial-card__name">{{ $t['name'] }}</h4>
                        <span class="swd-testimonial-card__profession">{{ $t['profession'] }}</span>
                    </div>
                </div>
                <div class="swd-testimonial-card__rating">
                    @for($j = 0; $j < $t['rating']; $j++)
                    <i class="ri-star-fill"></i>
                    @endfor
                </div>
                <p class="swd-testimonial-card__quote">"{{ $t['quote'] }}"</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== FAQ SECTION ==================== --}}
<section class="swd-section swd-section--alt swd-faq">
    <div class="container">
        <div class="swd-section-head">
            <span class="swd-label">Faqs</span>
            <h2 class="section-title">Common Questions</h2>
        </div>
        <div class="swd-faq__list">
            @foreach($faqs as $i => $faq)
            <div class="swd-faq-item {{ $i === 0 ? 'swd-faq-item--open' : '' }}">
                <button class="swd-faq-item__q" onclick="this.parentElement.classList.toggle('swd-faq-item--open')">
                    <span>{{ $faq['q'] }}</span>
                    <i class="ri-add-line swd-faq-item__plus"></i>
                    <i class="ri-subtract-line swd-faq-item__minus"></i>
                </button>
                <div class="swd-faq-item__a"><p>{{ $faq['a'] }}</p></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== CTA SECTION ==================== --}}
<section class="swd-section swd-cta">
    <div class="container">
        <div class="swd-cta__box" data-aos="zoom-in">
            <h2 class="swd-cta__title">Start Your Next Project With Us</h2>
            <p class="swd-cta__desc">Our professional team is here to construct websites that turn visitors into clients. Ready to start?</p>
            <a href="{{ route('contact-us') }}" class="btn-primary">Start a Project <i class="ri-arrow-right-line"></i></a>
        </div>
    </div>
</section>
{{-- ==================== STICKY BOTTOM WHATSAPP BAR ==================== --}}
<div class="swd-sticky-whatsapp" id="swdStickyWhatsapp">
    <a href="https://wa.me/8801898828248" target="_blank" class="swd-sticky-whatsapp__btn">
        <i class="ri-whatsapp-line"></i>
        <span>WhatsApp এ কথা বলুন → 01898828248</span>
    </a>
</div>

{{-- ==================== TIMED LIVE CHAT PROMPT ==================== --}}
<div class="swd-chat-prompt" id="swdChatPrompt">
    <button class="swd-chat-prompt__close" onclick="document.getElementById('swdChatPrompt').style.display='none'">&times;</button>
    <div class="swd-chat-prompt__body">
        <h4 class="swd-chat-prompt__title">Confused or Need Help? 🤔</h4>
        <p class="swd-chat-prompt__desc">Talk directly with our development head on WhatsApp to select the right package.</p>
        <a href="https://wa.me/8801898828248" target="_blank" class="btn-whatsapp">
            <i class="ri-whatsapp-fill"></i> Chat with Us
        </a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Sticky Whatsapp Bar scroll logic
        let lastScrollTop = 0;
        const whatsappBar = document.getElementById('swdStickyWhatsapp');
        window.addEventListener("scroll", function() {
            let st = window.pageYOffset || document.documentElement.scrollTop;
            if (st > lastScrollTop) {
                // Scroll Down -> Show sticky bar
                if (window.innerWidth <= 768) {
                    whatsappBar.style.bottom = "0";
                }
            } else {
                // Scroll Up -> Hide sticky bar
                whatsappBar.style.bottom = "-80px";
            }
            lastScrollTop = st <= 0 ? 0 : st;
        }, false);

        // Timed Live Chat Prompt logic
        setTimeout(function() {
            const chatPrompt = document.getElementById('swdChatPrompt');
            if (chatPrompt) {
                chatPrompt.classList.add('swd-chat-prompt--show');
            }
        }, 15000); // 15 seconds

        const counters = document.querySelectorAll('.swd-counter-num');
        const speed = 200; // The lower the slower

        const animate = (counter) => {
            const valAttr = counter.getAttribute('data-val');
            const isFloat = valAttr.includes('.');
            const target = parseFloat(valAttr);
            let count = 0;
            
            const updateCount = () => {
                const factor = isFloat ? 0.1 : 1;
                const increment = target / speed;
                
                if (count < target) {
                    count += increment;
                    if (isFloat) {
                        counter.innerText = count.toFixed(1) + '★';
                    } else {
                        counter.innerText = Math.ceil(count) + '+';
                    }
                    setTimeout(updateCount, 1);
                } else {
                    if (isFloat) {
                        counter.innerText = target.toFixed(1) + '★';
                    } else {
                        counter.innerText = target + '+';
                    }
                }
            };
            updateCount();
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animate(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => observer.observe(counter));
    });
</script>
@endsection

@push('style_section')
<style>
/* ==========================================
   SWD - SERVICE WEBSITE DEVELOPMENT STYLES
========================================== */

/* --- Urgency / Offer Banner --- */
.swd-announcement-bar {
    background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
    color: #ffffff;
    padding: 12px 0;
    text-align: center;
    font-size: 14.5px;
    font-weight: 700;
    position: relative;
    z-index: 1000;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.swd-announcement-container {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}
.swd-announcement-close {
    background: transparent;
    border: none;
    color: #ffffff;
    font-size: 22px;
    cursor: pointer;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    line-height: 1;
    opacity: 0.8;
    transition: opacity 0.2s;
}
.swd-announcement-close:hover {
    opacity: 1;
}

/* --- Before vs After Visual Redesign Comparison --- */
.swd-comparison-visual {
    background: var(--bg);
}
.swd-visual-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    margin-top: 48px;
}
.swd-visual-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 24px;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.swd-visual-card--before {
    border-color: rgba(239, 68, 68, 0.2);
}
.swd-visual-card--after {
    border-color: rgba(16, 185, 129, 0.3);
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.05);
}
.swd-visual-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 10;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.swd-visual-badge--before {
    background: #ef4444;
    color: #ffffff;
}
.swd-visual-badge--after {
    background: #10b981;
    color: #ffffff;
}
.swd-visual-img-wrapper {
    position: relative;
    padding-top: 65%;
    overflow: hidden;
    border-radius: 12px;
    border: 1px solid var(--border);
    margin-bottom: 20px;
}
.swd-visual-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.swd-visual-caption {
    font-size: 14.5px;
    font-weight: 600;
    text-align: center;
    color: var(--muted);
}
.swd-visual-card--after .swd-visual-caption {
    color: var(--accent);
}

/* --- Quick Quote Form --- */
.swd-quick-quote {
    background: var(--bg);
}
.swd-quick-quote__wrapper {
    background: linear-gradient(135deg, rgba(20, 29, 53, 0.8) 0%, rgba(10, 15, 30, 0.98) 100%);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 50px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
    position: relative;
    overflow: hidden;
}
.swd-quick-quote__wrapper::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -20%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(0, 212, 255, 0.08), transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.swd-quick-quote__title {
    font-size: clamp(24px, 3.5vw, 32px);
    font-weight: 800;
    color: var(--text) !important;
    margin-bottom: 16px;
}
.swd-quick-quote__desc {
    color: var(--muted);
    font-size: 15px;
    line-height: 1.65;
    margin-bottom: 30px;
}
.swd-quick-quote__meta {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.swd-quick-quote__meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: var(--text);
    font-weight: 500;
}
.swd-quick-quote__meta-item i {
    color: var(--accent);
    font-size: 18px;
}
.swd-quick-quote__form-box {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 30px;
    backdrop-filter: blur(10px);
}
.swd-form-group {
    margin-bottom: 20px;
}
.swd-form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 8px;
}
.swd-form-input,
.swd-form-select {
    width: 100%;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 12px 16px;
    color: var(--text);
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.swd-form-input:focus,
.swd-form-select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 10px rgba(0, 212, 255, 0.15);
}
.swd-form-select option {
    background: #0f172a;
    color: #ffffff;
}

/* --- Sticky Whatsapp Bar --- */
.swd-sticky-whatsapp {
    position: fixed;
    bottom: -80px;
    left: 0;
    right: 0;
    z-index: 999;
    padding: 12px 16px;
    background: rgba(15, 23, 42, 0.95);
    border-top: 1px solid var(--border);
    backdrop-filter: blur(10px);
    transition: bottom 0.3s ease-in-out;
    display: none;
}
.swd-sticky-whatsapp__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #25d366;
    color: #ffffff !important;
    text-decoration: none;
    font-weight: 700;
    font-size: 14.5px;
    padding: 12px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
}
.swd-sticky-whatsapp__btn i {
    font-size: 20px;
}

/* --- Timed Live Chat Prompt --- */
.swd-chat-prompt {
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 320px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    z-index: 1001;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    transform: translateY(100px);
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.swd-chat-prompt--show {
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
}
.swd-chat-prompt__close {
    position: absolute;
    top: 12px;
    right: 12px;
    background: transparent;
    border: none;
    color: var(--muted);
    font-size: 18px;
    cursor: pointer;
    line-height: 1;
}
.swd-chat-prompt__close:hover {
    color: var(--text);
}
.swd-chat-prompt__title {
    font-size: 15px;
    font-weight: 700;
    color: var(--text) !important;
    margin-bottom: 8px;
}
.swd-chat-prompt__desc {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.5;
    margin-bottom: 16px;
}
.btn-whatsapp {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    background: #25d366;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13.5px;
    padding: 10px;
    border-radius: 8px;
    text-decoration: none;
    transition: background-color 0.2s;
}
.btn-whatsapp:hover {
    background: #20ba5a;
}

/* --- Hero --- */
.swd-hero {
    position: relative;
    padding: 120px 0 100px;
    background: var(--bg2);
    text-align: center;
    border-bottom: 1px solid var(--border);
    overflow: hidden;
}
.swd-hero__mesh {
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 60% 50% at 50% 50%, rgba(0, 212, 255, 0.08) 0%, transparent 80%),
                radial-gradient(ellipse 40% 40% at 20% 80%, rgba(123, 79, 255, 0.04) 0%, transparent 60%);
    z-index: 1;
    pointer-events: none;
}
.swd-hero .container {
    position: relative;
    z-index: 2;
}
.swd-hero__badge {
    display: inline-flex;
    align-items: center;
    background: rgba(0, 212, 255, 0.08);
    border: 1px solid rgba(0, 212, 255, 0.2);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    color: var(--accent);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
    margin-bottom: 24px;
}
.swd-hero__title {
    font-size: clamp(32px, 5.5vw, 56px);
    font-weight: 700;
    line-height: 1.15;
    letter-spacing: -1px;
    color: var(--text) !important;
    margin-bottom: 20px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}
.swd-hero__desc {
    color: var(--muted);
    font-size: 17px;
    line-height: 1.7;
    max-width: 620px;
    margin: 0 auto 36px;
}
.swd-hero__actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 50px;
}

/* Hero Showcase Image */
.swd-hero__showcase {
    max-width: 820px;
    margin: 0 auto;
    border-radius: 20px;
    padding: 10px;
    background: rgba(20, 29, 53, 0.4);
    border: 1px solid var(--border);
    box-shadow: 0 30px 70px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.05);
}
.swd-hero__image {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 14px;
    box-shadow: 0 0 30px var(--glow);
    transition: transform 0.5s ease, box-shadow 0.5s ease;
}
.swd-hero__showcase:hover .swd-hero__image {
    transform: scale(1.005);
    box-shadow: 0 0 40px rgba(0, 212, 255, 0.3);
}

/* --- Sections --- */
.swd-section {
    padding: 100px 0;
    background: var(--bg);
}
.swd-section--alt {
    background: var(--bg2);
}
.swd-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--accent);
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 12px;
    display: block;
}

/* --- Offer Cards --- */
.swd-offers__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.swd-offer-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 36px 30px;
    transition: all 0.3s ease;
}
.swd-offer-card:hover {
    border-color: rgba(0, 212, 255, 0.3);
    transform: translateY(-4px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
}
.swd-offer-card__icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: rgba(0, 212, 255, 0.08);
    border: 1px solid rgba(0, 212, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: var(--accent);
    margin-bottom: 24px;
}
.swd-offer-card__title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 14px;
    color: var(--text) !important;
}
.swd-offer-card__desc {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.6;
    margin-bottom: 20px;
}
.swd-offer-card__features {
    list-style: none;
    padding: 0;
    margin: 0;
    border-top: 1px solid rgba(0, 212, 255, 0.06);
    padding-top: 16px;
}
.swd-offer-card__features li {
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.swd-offer-card__features li:last-child {
    margin-bottom: 0;
}
.swd-offer-card__features li i {
    color: var(--accent);
}

/* --- Why Choose Us (Layout with Info & List) --- */
.swd-why__layout {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 80px;
    align-items: center;
}
.swd-why__info .section-sub {
    margin-bottom: 36px;
}
.swd-why__quick-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.swd-stat-box {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
}
.swd-stat-num {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 32px;
    font-weight: 700;
    color: var(--accent);
    display: block;
}
.swd-stat-label {
    font-size: 12px;
    color: var(--muted);
    margin-top: 4px;
    display: block;
}

.swd-why__list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.swd-why-card {
    background: var(--card);
    border-left: 3px solid var(--accent);
    border-top: 1px solid var(--border);
    border-right: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    border-radius: 0 12px 12px 0;
    padding: 24px 28px;
    transition: all 0.3s ease;
}
.swd-why-card:hover {
    border-left-color: var(--accent2);
    transform: translateX(6px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
}
.swd-why-card__title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 6px;
    color: var(--text) !important;
}
.swd-why-card__desc {
    font-size: 13.5px;
    color: var(--muted);
    margin: 0;
    line-height: 1.5;
}

/* --- Pricing Packages --- */
.swd-pricing__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    align-items: start;
}
.swd-price-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 40px 32px;
    position: relative;
    transition: all 0.3s ease;
}
.swd-price-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.4);
}
.swd-price-card--featured {
    border-color: rgba(0, 212, 255, 0.4);
    background: linear-gradient(145deg, var(--card) 0%, rgba(0, 212, 255, 0.03) 100%);
    box-shadow: 0 20px 50px rgba(0, 212, 255, 0.05);
}
.swd-price-card__badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 100px;
    letter-spacing: .5px;
    text-transform: uppercase;
}
.swd-price-card__name {
    font-size: 20px;
    font-weight: 700;
    color: var(--text) !important;
    margin-bottom: 8px;
}
.swd-price-card__desc {
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 24px;
    line-height: 1.5;
}
.swd-price-card__price {
    display: flex;
    align-items: baseline;
    padding-bottom: 24px;
    border-bottom: 1px solid rgba(0, 212, 255, 0.06);
    margin-bottom: 28px;
}
.swd-price-card__currency {
    font-size: 20px;
    font-weight: 600;
    color: var(--text);
    margin-right: 4px;
}
.swd-price-card__amount {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 38px;
    font-weight: 700;
    color: var(--text) !important;
}
.swd-price-card__period {
    font-size: 14px;
    color: var(--muted);
    margin-left: 6px;
}
.swd-price-card__features {
    list-style: none;
    padding: 0;
    margin: 0 0 32px;
}
.swd-price-card__features li {
    font-size: 14px;
    color: var(--muted);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.swd-price-card__features li:last-child {
    margin-bottom: 0;
}
.swd-price-card__features li i {
    color: var(--accent);
    font-size: 16px;
}
.btn-full-width {
    display: block;
    width: 100%;
    text-align: center;
}

/* --- FAQ --- */
.swd-faq__list {
    max-width: 740px;
    margin: 0 auto;
}
.swd-faq-item {
    border: 1px solid var(--border);
    border-radius: 12px;
    margin-bottom: 14px;
    background: var(--card);
    overflow: hidden;
    transition: all 0.25s ease;
}
.swd-faq-item--open {
    border-color: rgba(0, 212, 255, 0.3);
}
.swd-faq-item__q {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    background: transparent;
    border: none;
    cursor: pointer;
    font-size: 15.5px;
    font-weight: 600;
    color: var(--text) !important;
    text-align: left;
    gap: 16px;
    outline: none;
}
.swd-faq-item__q:hover {
    background: rgba(255, 255, 255, 0.01);
}
.swd-faq-item__plus,
.swd-faq-item__minus {
    font-size: 18px;
    color: var(--accent);
    flex-shrink: 0;
}
.swd-faq-item__minus {
    display: none;
}
.swd-faq-item--open .swd-faq-item__plus {
    display: none;
}
.swd-faq-item--open .swd-faq-item__minus {
    display: block;
}
.swd-faq-item__a {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out, padding 0.3s ease-out;
    padding: 0 24px;
}
.swd-faq-item--open .swd-faq-item__a {
    max-height: 250px;
    padding: 0 24px 20px;
    border-top: 1px solid rgba(0, 212, 255, 0.04);
    padding-top: 14px;
}
.swd-faq-item__a p {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.65;
    margin: 0;
}

/* --- CTA Box --- */
.swd-cta__box {
    background: linear-gradient(135deg, rgba(20, 29, 53, 0.7) 0%, rgba(10, 15, 30, 0.95) 100%);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 60px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.swd-cta__box::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(0, 212, 255, 0.08), transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.swd-cta__title {
    font-size: clamp(24px, 4vw, 36px);
    font-weight: 700;
    color: var(--text) !important;
    margin-bottom: 14px;
}
.swd-cta__desc {
    color: var(--muted);
    font-size: 16px;
    line-height: 1.6;
    max-width: 540px;
    margin: 0 auto 30px;
}

/* --- Hero Subtitle & Video Button & Trust block --- */
.swd-hero__subtitle {
    font-size: clamp(18px, 3.5vw, 26px);
    color: var(--accent);
    margin-top: 12px;
    font-weight: 700;
    display: inline-block;
}
.btn-video {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text) !important;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid var(--border);
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.25s ease;
}
.btn-video i {
    font-size: 22px;
    color: var(--accent);
}
.btn-video:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: var(--accent);
    box-shadow: 0 0 15px rgba(0, 212, 255, 0.2);
}
.swd-hero__trust {
    margin-top: 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: var(--muted);
}
.swd-hero__stars {
    display: flex;
    gap: 4px;
    color: #ffb800;
    font-size: 18px;
}

/* --- Workflow Process Timeline --- */
.swd-process {
    background: var(--bg2);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}
.swd-timeline {
    position: relative;
    margin-top: 60px;
    padding: 20px 0;
}
.swd-timeline-line {
    position: absolute;
    top: 52px;
    left: 12%;
    right: 12%;
    height: 3px;
    background: linear-gradient(90deg, var(--accent) 0%, var(--accent2) 100%);
    z-index: 1;
}
.swd-timeline-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    position: relative;
    z-index: 2;
}
.swd-timeline-item {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.swd-timeline-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: var(--card);
    border: 3px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: var(--accent);
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}
.swd-timeline-item:hover .swd-timeline-icon {
    transform: scale(1.08);
    border-color: var(--accent);
    color: #ffffff;
    background: var(--accent);
    box-shadow: 0 0 20px rgba(0, 212, 255, 0.4);
}
.swd-timeline-step {
    font-size: 11px;
    font-weight: 700;
    color: var(--accent);
    text-transform: uppercase;
    margin-bottom: 6px;
}
.swd-timeline-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--text) !important;
    margin-bottom: 8px;
}
.swd-timeline-day {
    font-size: 12px;
    font-weight: 600;
    color: var(--muted);
    background: rgba(255,255,255,0.05);
    padding: 3px 12px;
    border-radius: 100px;
    margin-bottom: 12px;
}
.swd-timeline-desc {
    font-size: 13px;
    line-height: 1.65;
    color: var(--muted);
    padding: 0 10px;
}

/* --- Package Comparison Table --- */
.swd-comparison {
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}
.swd-table-wrapper {
    overflow-x: auto;
    margin-top: 48px;
    border: 1px solid var(--border);
    border-radius: 16px;
    background: var(--card);
}
.swd-compare-table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
    font-size: 14.5px;
    color: var(--muted);
    min-width: 750px;
}
.swd-compare-table th, 
.swd-compare-table td {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
}
.swd-compare-table th {
    background: rgba(255, 255, 255, 0.005);
    color: var(--text);
    font-weight: 700;
    font-size: 15.5px;
}
.swd-feat-name {
    text-align: left;
    font-weight: 600;
    color: var(--text);
}
.swd-col-highlight {
    background: rgba(0, 212, 255, 0.015);
    border-left: 2px solid var(--accent);
    border-right: 2px solid var(--accent);
    color: var(--text);
}
th.swd-col-highlight {
    border-top: 2px solid var(--accent);
    background: rgba(0, 212, 255, 0.03);
}
tr:last-child td.swd-col-highlight {
    border-bottom: 2px solid var(--accent);
}
.swd-price-row td {
    font-weight: 700;
    font-size: 16.5px;
}
.swd-price-val {
    color: var(--accent);
}
.text-accent {
    color: var(--accent) !important;
    font-size: 18px;
}
.text-muted {
    color: var(--muted) !important;
    font-size: 18px;
}

/* --- Trust Badges Row --- */
.swd-hero__badges {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 28px;
    margin-top: 48px;
    padding: 20px 24px;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid var(--border);
    border-radius: 16px;
}
.swd-badge-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13.5px;
    color: var(--muted);
    font-weight: 500;
}
.swd-badge-item i {
    color: var(--accent);
    font-size: 18px;
}

/* --- Counter Section --- */
.swd-counters-strip {
    background: var(--bg2);
    border-bottom: 1px solid var(--border);
    padding: 50px 0;
}
.swd-counters-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    text-align: center;
}
.swd-counter-num {
    font-size: clamp(32px, 5vw, 44px);
    font-weight: 800;
    color: var(--accent);
    margin-bottom: 6px;
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent2) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.swd-counter-label {
    font-size: 13.5px;
    color: var(--muted);
    font-weight: 500;
}

/* --- Live Project Gallery --- */
.swd-projects-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-top: 48px;
}
.swd-project-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}
.swd-project-card:hover {
    transform: translateY(-5px);
    border-color: var(--accent);
    box-shadow: 0 12px 30px var(--glow);
}
.swd-project-card__img-wrapper {
    position: relative;
    padding-top: 60%;
    overflow: hidden;
    border-bottom: 1px solid var(--border);
}
.swd-project-card__img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.swd-project-card:hover .swd-project-card__img {
    transform: scale(1.04);
}
.swd-project-card__body {
    padding: 24px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.swd-project-card__niche {
    font-size: 11px;
    font-weight: 700;
    color: var(--accent);
    text-transform: uppercase;
    letter-spacing: 1px;
    display: block;
    margin-bottom: 8px;
}
.swd-project-card__title {
    font-size: 16.5px;
    font-weight: 700;
    color: var(--text) !important;
    margin-bottom: 20px;
    line-height: 1.4;
}
.swd-project-card__btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text) !important;
    text-decoration: none;
    transition: color 0.2s;
    margin-top: auto;
}
.swd-project-card__btn:hover {
    color: var(--accent) !important;
}

/* --- Client Testimonials --- */
.swd-testimonials-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    margin-top: 48px;
}
.swd-testimonial-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 36px;
    position: relative;
    transition: all 0.3s ease;
}
.swd-testimonial-card:hover {
    border-color: rgba(0, 212, 255, 0.2);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
.swd-testimonial-card__head {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
}
.swd-testimonial-card__avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent2) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-weight: 700;
    font-size: 16px;
}
.swd-testimonial-meta {
    display: flex;
    flex-direction: column;
}
.swd-testimonial-card__name {
    font-size: 15.5px;
    font-weight: 700;
    color: var(--text) !important;
    margin-bottom: 3px;
}
.swd-testimonial-card__profession {
    font-size: 12px;
    color: var(--muted);
}
.swd-testimonial-card__rating {
    display: flex;
    gap: 4px;
    color: #ffb800;
    margin-bottom: 16px;
    font-size: 14px;
}
.swd-testimonial-card__quote {
    font-size: 14px;
    line-height: 1.7;
    color: var(--muted);
    font-style: italic;
    margin: 0;
}

/* --- Portfolio Website Types (Light Section) --- */
.swd-portfolio-types {
    background: #f8fafc !important;
    padding: 100px 0;
}
.swd-portfolio-types .section-title {
    color: #0f172a !important;
}
.swd-portfolio-types .section-sub {
    color: #475569 !important;
}
.swd-portfolio-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    margin-top: 48px;
}
.swd-portfolio-card {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 16px !important;
    padding: 28px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    text-align: center;
    transition: all 0.3s ease;
}
.swd-portfolio-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
    border-color: var(--accent) !important;
}
.swd-portfolio-card__icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(123, 79, 255, 0.06);
    border: 1px solid rgba(123, 79, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: var(--accent2);
    margin-bottom: 20px;
}
.swd-portfolio-card__title {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a !important;
    margin-bottom: 10px;
    line-height: 1.4;
}
.swd-portfolio-card__desc {
    font-size: 13px;
    color: #475569 !important;
    line-height: 1.6;
    margin-bottom: 24px;
}
.swd-portfolio-card__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 9px 20px;
    font-size: 12px;
    font-weight: 600;
    color: var(--accent2) !important;
    border: 1px solid var(--accent2) !important;
    border-radius: 8px !important;
    text-decoration: none;
    transition: all 0.25s ease;
    background: transparent !important;
}
.swd-portfolio-card__btn:hover {
    background: var(--accent2) !important;
    color: #ffffff !important;
}

/* ==========================================
   RESPONSIVE DESIGN RULES
========================================== */

@media (max-width: 1024px) {
    .swd-offers__grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .swd-why__layout {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .swd-pricing__grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .swd-portfolio-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .swd-projects-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .swd-timeline-line {
        display: none;
    }
    .swd-timeline-grid {
        grid-template-columns: 1fr;
        gap: 36px;
    }
    .swd-timeline-item {
        align-items: flex-start;
        text-align: left;
        padding-left: 86px;
        position: relative;
    }
    .swd-timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        margin-bottom: 0;
    }
    .swd-quick-quote__wrapper {
        grid-template-columns: 1fr;
        gap: 40px;
        padding: 36px 24px;
    }
}

@media (max-width: 768px) {
    .swd-hero {
        padding: 90px 0 70px;
    }
    .swd-hero__actions {
        margin-bottom: 35px;
    }
    .swd-section {
        padding: 70px 0;
    }
    .swd-offers__grid {
        grid-template-columns: 1fr;
    }
    .swd-pricing__grid {
        grid-template-columns: 1fr;
        max-width: 460px;
        margin: 0 auto;
    }
    .swd-why__quick-stats {
        max-width: 460px;
    }
    .swd-cta__box {
        padding: 45px 24px;
    }
    .swd-portfolio-types {
        padding: 70px 0;
    }
    .swd-projects-grid {
        grid-template-columns: 1fr;
    }
    .swd-testimonials-grid {
        grid-template-columns: 1fr;
    }
    .swd-counters-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    .swd-hero__badges {
        gap: 16px;
    }
    .swd-compare-table th, 
    .swd-compare-table td {
        padding: 14px 16px;
        font-size: 13px;
    }
    .swd-visual-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    .swd-announcement-bar {
        font-size: 13px;
        padding: 10px 32px 10px 10px;
    }
}

@media (max-width: 576px) {
    .swd-portfolio-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 12px !important;
    }
    .swd-portfolio-card {
        padding: 20px 12px !important;
        border-radius: 12px !important;
    }
    .swd-portfolio-card__icon {
        width: 46px;
        height: 46px;
        font-size: 20px;
        margin-bottom: 12px;
    }
    .swd-portfolio-card__title {
        font-size: 13.5px !important;
        margin-bottom: 6px;
    }
    .swd-portfolio-card__desc {
        font-size: 11px !important;
        line-height: 1.5;
        margin-bottom: 16px;
    }
    .swd-portfolio-card__btn {
        padding: 7px 14px;
        font-size: 10.5px;
        border-radius: 6px !important;
        width: 100%;
    }
    .swd-testimonial-card {
        padding: 24px !important;
    }
    .swd-projects-grid {
        gap: 16px !important;
    }
    .swd-timeline-item {
        padding-left: 70px;
    }
    .swd-timeline-icon {
        width: 54px;
        height: 54px;
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    .swd-hero__actions {
        flex-direction: column;
        align-items: stretch;
        max-width: 280px;
        margin-left: auto;
        margin-right: auto;
    }
    .swd-hero__actions .btn-primary,
    .swd-hero__actions .btn-ghost,
    .swd-hero__actions .btn-video {
        width: 100%;
        text-align: center;
        justify-content: center;
    }
    .swd-stat-box {
        padding: 16px;
    }
    .swd-stat-num {
        font-size: 26px;
    }
    .swd-hero__badges {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .swd-counters-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
