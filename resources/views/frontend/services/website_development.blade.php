@extends('frontend.templates.main_demo_layout')
@php
    $serviceTitle = $serviceSeo['title'] ?? $service?->translate?->title ?? $service?->title ?? 'Website Development in Dhaka';
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

    $faqs = [
        ['q' => 'How much does website development cost?', 'a' => 'The cost depends on the specific project scope and features required. We offer affordable packages beginning at ৳10,200 for basic sites up to custom pricing for advanced web systems.'],
        ['q' => 'Can you redesign our existing website?', 'a' => 'Yes, we can modernize your current website, improve loading speeds, make it fully mobile responsive, and implement modern layouts while keeping existing content.'],
        ['q' => 'Will my website be mobile friendly?', 'a' => 'Absolutely. Every website we build is fully optimized with responsive coding rules for all screen dimensions.'],
        ['q' => 'Do you provide maintenance and technical support?', 'a' => 'Yes, all packages include free technical support after launch to ensure your website remains functional, updated, and secure.'],
    ];

    $plans = $service?->translate?->plans ?? [];
@endphp

{{-- ==================== HERO SECTION ==================== --}}
<section class="swd-hero">
    <div class="swd-hero__mesh"></div>
    <div class="container">
        <span class="swd-hero__badge">Solutions</span>
        <h1 class="swd-hero__title">{{ $serviceTitle }}</h1>
        <p class="swd-hero__desc">{{ $serviceShortDescription ?: 'We create professional, responsive, and high performing websites for businesses, personal brands, and online stores.' }}</p>
        <div class="swd-hero__actions">
            <a href="{{ route('contact-us') }}" class="btn-primary">Get Free Quote</a>
            <a href="#swd-pricing" class="btn-ghost">View Pricing</a>
        </div>
        
        {{-- Showcase Mockup --}}
        <div class="swd-hero__showcase" data-aos="fade-up" data-aos-duration="800">
            <img src="{{ asset('uploads/website_development_showcase.png') }}" class="swd-hero__image" alt="Website Showcase Mockup">
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
@endsection

@push('style_section')
<style>
/* ==========================================
   SWD - SERVICE WEBSITE DEVELOPMENT STYLES
========================================== */

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
    .swd-hero__actions .btn-ghost {
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
}
</style>
@endpush
