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
    $getSidebarCTAData = getContent('main_demo_sidebar_cta_section.content', true);

    $offers = [
        ['icon' => 'ri-shopping-cart-2-line', 'title' => 'E-commerce Website Development', 'desc' => 'Full-featured online stores with product catalog, cart, checkout, payment gateway integration & order management.', 'features' => ['Product catalog & categories', 'Payment gateway integration', 'Order & inventory management']],
        ['icon' => 'ri-building-2-line', 'title' => 'Business Website Development', 'desc' => 'Professional company websites to establish your brand presence online with modern design and clear messaging.', 'features' => ['Company profile pages', 'Contact forms & maps', 'Responsive mobile design']],
        ['icon' => 'ri-layout-2-line', 'title' => 'Landing Page Design', 'desc' => 'High-converting landing pages designed for marketing campaigns, lead generation, and product launches.', 'features' => ['Conversion-optimized design', 'A/B testing ready', 'Fast loading speed']],
        ['icon' => 'ri-palette-line', 'title' => 'Portfolio Website', 'desc' => 'Showcase your work beautifully with a custom portfolio website that highlights your skills and projects.', 'features' => ['Gallery & project showcase', 'Filterable categories', 'Client testimonials']],
        ['icon' => 'ri-bug-line', 'title' => 'Website Testing & Setup', 'desc' => 'Complete website testing, domain setup, hosting configuration, SSL installation, and performance optimization.', 'features' => ['Cross-browser testing', 'Performance optimization', 'SSL & security setup']],
    ];

    $whyChoose = [
        ['icon' => 'ri-code-s-slash-line', 'title' => 'Clean Code', 'desc' => 'Well-structured, maintainable code following best practices.'],
        ['icon' => 'ri-smartphone-line', 'title' => 'Mobile First', 'desc' => 'Responsive designs that look great on every device.'],
        ['icon' => 'ri-speed-line', 'title' => 'Fast Loading', 'desc' => 'Optimized for speed and search engine performance.'],
        ['icon' => 'ri-customer-service-2-line', 'title' => '24/7 Support', 'desc' => 'Ongoing support and maintenance after delivery.'],
    ];

    $faqs = [
        ['q' => 'How much does website development cost in Bangladesh?', 'a' => 'Website development cost depends on the project scope, features, and complexity. Contact TechSeba for a free consultation and accurate quote tailored to your business needs.'],
        ['q' => 'Can you redesign an existing website?', 'a' => 'Yes, we can redesign your existing website with a modern look, improved performance, and better user experience while preserving your content and SEO rankings.'],
        ['q' => 'Will the website be mobile responsive?', 'a' => 'Absolutely. All our websites are built with a mobile-first approach, ensuring they look and function perfectly on smartphones, tablets, and desktops.'],
        ['q' => 'Do you provide SEO setup with website development?', 'a' => 'Yes, we include basic SEO setup including meta tags, sitemap, speed optimization, and proper heading structure with every website project.'],
        ['q' => 'How long does it take to build a website?', 'a' => 'A standard business website takes 7-15 days. E-commerce or complex web applications may take 3-6 weeks depending on features and requirements.'],
    ];

    $plans = $service?->translate?->plans ?? [];
@endphp

{{-- ==================== HERO ==================== --}}
<section class="swd-hero">
    <div class="container">
        <span class="swd-hero__badge">SOLUTIONS</span>
        <h1 class="swd-hero__title">{{ $serviceTitle }}</h1>
        <p class="swd-hero__desc">{{ $serviceShortDescription ?: 'We create professional, responsive, and SEO-ready websites for companies, service providers, e-commerce brands, and startups in Dhaka, Bangladesh.' }}</p>
        <div class="swd-hero__actions">
            <a href="{{ route('contact-us') }}" class="swd-btn swd-btn--primary">Get Free Quote</a>
            <a href="#swd-pricing" class="swd-btn swd-btn--outline">View Pricing</a>
        </div>
    </div>
</section>

{{-- ==================== WHAT WE OFFER ==================== --}}
<section class="swd-section swd-offers">
    <div class="container">
        <div class="swd-section__header">
            <span class="swd-label">Our Expertise</span>
            <h2>What We Offer</h2>
            <p>Complete website development solutions for every business need</p>
        </div>
        <div class="swd-offers__grid">
            @foreach($offers as $i => $offer)
            <div class="swd-offer-card" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="swd-offer-card__icon"><i class="{{ $offer['icon'] }}"></i></div>
                <h4 class="swd-offer-card__title">{{ $offer['title'] }}</h4>
                <p class="swd-offer-card__desc">{{ $offer['desc'] }}</p>
                <ul class="swd-offer-card__features">
                    @foreach($offer['features'] as $f)
                    <li><i class="ri-check-line"></i> {{ $f }}</li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== WHY CHOOSE ==================== --}}
<section class="swd-section swd-section--alt swd-why">
    <div class="container">
        <div class="swd-section__header">
            <span class="swd-label">Why Us</span>
            <h2>Why Choose TechSeba?</h2>
            <p>We deliver results that grow your business</p>
        </div>
        <div class="swd-why__grid">
            @foreach($whyChoose as $i => $item)
            <div class="swd-why-card" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <div class="swd-why-card__icon"><i class="{{ $item['icon'] }}"></i></div>
                <h5>{{ $item['title'] }}</h5>
                <p>{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== PRICING ==================== --}}
<section class="swd-section swd-pricing" id="swd-pricing">
    <div class="container">
        <div class="swd-section__header">
            <span class="swd-label">Plans</span>
            <h2>Pricing Packages</h2>
            <p>Transparent pricing for every budget</p>
        </div>
        <div class="swd-pricing__grid">
            {{-- Starter --}}
            <div class="swd-price-card" data-aos="fade-up" data-aos-delay="0">
                <div class="swd-price-card__head">
                    <h4>{{ $plans[0]['name'] ?? 'Starter Package' }}</h4>
                    <p>{{ $plans[0]['description'] ?? 'Perfect for small businesses and personal websites' }}</p>
                </div>
                <div class="swd-price-card__price">
                    @if(!empty($plans[0]['price']) && is_numeric($plans[0]['price']))
                        <span class="swd-price-card__amount">{{ currency($plans[0]['price']) }}</span>
                    @else
                        <span class="swd-price-card__amount">{{ $plans[0]['price'] ?? '৳20,000' }}</span>
                    @endif
                    <span class="swd-price-card__period">Starting From</span>
                </div>
                <ul class="swd-price-card__features">
                    @if(!empty($plans[0]['features']))
                        @foreach(explode("\n", $plans[0]['features']) as $feat)
                            @if(trim($feat)) <li><i class="ri-check-line"></i> {{ trim($feat) }}</li> @endif
                        @endforeach
                    @else
                        <li><i class="ri-check-line"></i> Up to 5 pages</li>
                        <li><i class="ri-check-line"></i> Mobile responsive</li>
                        <li><i class="ri-check-line"></i> Contact form</li>
                        <li><i class="ri-check-line"></i> Basic SEO setup</li>
                        <li><i class="ri-check-line"></i> 1 month support</li>
                    @endif
                </ul>
                <a href="{{ route('contact-us') }}" class="swd-btn swd-btn--outline swd-btn--full">Get Started</a>
            </div>

            {{-- Standard --}}
            <div class="swd-price-card swd-price-card--featured" data-aos="fade-up" data-aos-delay="100">
                <span class="swd-price-card__badge">Most Popular</span>
                <div class="swd-price-card__head">
                    <h4>{{ $plans[1]['name'] ?? 'Standard Package' }}</h4>
                    <p>{{ $plans[1]['description'] ?? 'For growing businesses that need more features' }}</p>
                </div>
                <div class="swd-price-card__price">
                    @if(!empty($plans[1]['price']) && is_numeric($plans[1]['price']))
                        <span class="swd-price-card__amount">{{ currency($plans[1]['price']) }}</span>
                    @else
                        <span class="swd-price-card__amount">{{ $plans[1]['price'] ?? '৳42,000' }}</span>
                    @endif
                    <span class="swd-price-card__period">Starting From</span>
                </div>
                <ul class="swd-price-card__features">
                    @if(!empty($plans[1]['features']))
                        @foreach(explode("\n", $plans[1]['features']) as $feat)
                            @if(trim($feat)) <li><i class="ri-check-line"></i> {{ trim($feat) }}</li> @endif
                        @endforeach
                    @else
                        <li><i class="ri-check-line"></i> Up to 15 pages</li>
                        <li><i class="ri-check-line"></i> CMS / Admin panel</li>
                        <li><i class="ri-check-line"></i> Advanced SEO</li>
                        <li><i class="ri-check-line"></i> Blog section</li>
                        <li><i class="ri-check-line"></i> 3 months support</li>
                    @endif
                </ul>
                <a href="{{ route('contact-us') }}" class="swd-btn swd-btn--primary swd-btn--full">Get Started</a>
            </div>

            {{-- Custom --}}
            <div class="swd-price-card" data-aos="fade-up" data-aos-delay="200">
                <div class="swd-price-card__head">
                    <h4>{{ $plans[2]['name'] ?? 'Custom Package' }}</h4>
                    <p>{{ $plans[2]['description'] ?? 'Enterprise solutions tailored to your requirements' }}</p>
                </div>
                <div class="swd-price-card__price">
                    @if(!empty($plans[2]['price']) && is_numeric($plans[2]['price']))
                        <span class="swd-price-card__amount">{{ currency($plans[2]['price']) }}</span>
                    @else
                        <span class="swd-price-card__amount">{{ $plans[2]['price'] ?? 'Custom Quote' }}</span>
                    @endif
                    <span class="swd-price-card__period">Contact for Quote</span>
                </div>
                <ul class="swd-price-card__features">
                    @if(!empty($plans[2]['features']))
                        @foreach(explode("\n", $plans[2]['features']) as $feat)
                            @if(trim($feat)) <li><i class="ri-check-line"></i> {{ trim($feat) }}</li> @endif
                        @endforeach
                    @else
                        <li><i class="ri-check-line"></i> Unlimited pages</li>
                        <li><i class="ri-check-line"></i> E-commerce ready</li>
                        <li><i class="ri-check-line"></i> Custom features</li>
                        <li><i class="ri-check-line"></i> Priority support</li>
                        <li><i class="ri-check-line"></i> 6 months support</li>
                    @endif
                </ul>
                <a href="{{ route('contact-us') }}" class="swd-btn swd-btn--outline swd-btn--full">Contact Us</a>
            </div>
        </div>
    </div>
</section>

{{-- ==================== FAQ ==================== --}}
<section class="swd-section swd-section--alt swd-faq">
    <div class="container">
        <div class="swd-section__header">
            <span class="swd-label">FAQ</span>
            <h2>Common Questions</h2>
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

{{-- ==================== CTA ==================== --}}
<section class="swd-cta">
    <div class="container">
        <div class="swd-cta__inner">
            <h2>Start Your Next Project With Us</h2>
            <p>Let's build something great together. Get a free consultation and project estimate today.</p>
            <div class="swd-cta__actions">
                <a href="{{ route('contact-us') }}" class="swd-btn swd-btn--white">Contact Us</a>
                <a href="tel:{{ $footer->phone ?? '+8801898828248' }}" class="swd-btn swd-btn--outline-white">Call Now</a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('style_section')
<style>
/* ===== SWD - Service Website Development Styles ===== */
/* --- Hero --- */
.swd-hero{background:linear-gradient(135deg,#0a0f2e 0%,#141b45 50%,#1a2255 100%);padding:100px 0 80px;text-align:center;position:relative;overflow:hidden}
.swd-hero::before{content:'';position:absolute;top:-40%;right:-20%;width:600px;height:600px;background:radial-gradient(circle,rgba(43,77,255,.12) 0%,transparent 70%);border-radius:50%}
.swd-hero__badge{display:inline-block;background:rgba(43,77,255,.15);color:var(--accent-color);font-size:12px;font-weight:600;letter-spacing:2px;padding:6px 18px;border-radius:20px;margin-bottom:20px;text-transform:uppercase}
.swd-hero__title{color:#fff;font-size:42px;font-weight:700;line-height:1.2;margin-bottom:18px;letter-spacing:-0.02em}
.swd-hero__desc{color:rgba(255,255,255,.7);font-size:16px;line-height:1.7;max-width:600px;margin:0 auto 32px}
.swd-hero__actions{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}

/* --- Buttons --- */
.swd-btn{display:inline-flex;align-items:center;justify-content:center;padding:13px 28px;border-radius:8px;font-size:15px;font-weight:600;text-decoration:none;transition:all .25s ease;cursor:pointer;border:2px solid transparent}
.swd-btn--primary{background:var(--accent-color);color:#fff;border-color:var(--accent-color)}
.swd-btn--primary:hover{background:transparent;color:var(--accent-color);border-color:var(--accent-color)}
.swd-btn--outline{background:transparent;color:#fff;border-color:rgba(255,255,255,.3)}
.swd-btn--outline:hover{background:#fff;color:var(--heading-color);border-color:#fff}
.swd-btn--white{background:#fff;color:var(--heading-color);border-color:#fff}
.swd-btn--white:hover{background:transparent;color:#fff;border-color:#fff}
.swd-btn--outline-white{background:transparent;color:#fff;border-color:rgba(255,255,255,.4)}
.swd-btn--outline-white:hover{background:#fff;color:var(--heading-color)}
.swd-btn--full{width:100%}

/* --- Sections --- */
.swd-section{padding:80px 0}
.swd-section--alt{background:var(--light-bg1)}
.swd-section__header{text-align:center;margin-bottom:48px}
.swd-section__header h2{font-size:34px;margin-bottom:10px;color:var(--heading-color)}
.swd-section__header p{color:var(--body-color);font-size:16px;margin:0}
.swd-label{display:inline-block;background:rgba(43,77,255,.08);color:var(--accent-color);font-size:12px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:5px 14px;border-radius:16px;margin-bottom:12px}

/* --- Offer Cards --- */
.swd-offers__grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.swd-offer-card{background:#fff;border:1px solid #eef0f5;border-radius:14px;padding:32px 28px;transition:all .3s ease;position:relative;overflow:hidden}
.swd-offer-card:hover{border-color:var(--accent-color);box-shadow:0 8px 30px rgba(43,77,255,.08);transform:translateY(-4px)}
.swd-offer-card__icon{width:52px;height:52px;border-radius:12px;background:linear-gradient(135deg,rgba(43,77,255,.08),rgba(43,77,255,.15));display:flex;align-items:center;justify-content:center;margin-bottom:18px;font-size:24px;color:var(--accent-color)}
.swd-offer-card__title{font-size:18px;font-weight:600;margin-bottom:10px;color:var(--heading-color)}
.swd-offer-card__desc{font-size:14px;color:var(--body-color);line-height:1.6;margin-bottom:14px}
.swd-offer-card__features{list-style:none;padding:0;margin:0}
.swd-offer-card__features li{font-size:13px;color:var(--body-color);padding:4px 0;display:flex;align-items:center;gap:8px}
.swd-offer-card__features li i{color:var(--accent-color);font-size:14px;flex-shrink:0}

/* --- Why Choose --- */
.swd-why__grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px}
.swd-why-card{background:#fff;border-radius:14px;padding:32px 24px;text-align:center;border:1px solid #eef0f5;transition:all .3s ease}
.swd-why-card:hover{box-shadow:0 10px 30px rgba(0,0,0,.06);transform:translateY(-3px)}
.swd-why-card__icon{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,var(--accent-color),#5b7cff);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:24px;color:#fff}
.swd-why-card h5{font-size:17px;margin-bottom:8px;color:var(--heading-color)}
.swd-why-card p{font-size:14px;color:var(--body-color);line-height:1.6;margin:0}

/* --- Pricing --- */
.swd-pricing__grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;align-items:start}
.swd-price-card{background:#fff;border:1px solid #eef0f5;border-radius:16px;padding:36px 28px;position:relative;transition:all .3s ease}
.swd-price-card:hover{box-shadow:0 12px 40px rgba(0,0,0,.07)}
.swd-price-card--featured{border-color:var(--accent-color);box-shadow:0 12px 40px rgba(43,77,255,.12)}
.swd-price-card__badge{position:absolute;top:-1px;right:24px;background:var(--accent-color);color:#fff;font-size:11px;font-weight:700;padding:6px 14px;border-radius:0 0 8px 8px;letter-spacing:.5px}
.swd-price-card__head h4{font-size:20px;font-weight:700;color:var(--heading-color);margin-bottom:6px}
.swd-price-card__head p{font-size:13px;color:var(--body-color);margin-bottom:20px;line-height:1.5}
.swd-price-card__price{padding:20px 0;border-top:1px solid #f0f1f5;border-bottom:1px solid #f0f1f5;margin-bottom:20px;text-align:center}
.swd-price-card__amount{display:block;font-size:32px;font-weight:800;color:var(--heading-color);line-height:1.2}
.swd-price-card__period{font-size:13px;color:var(--body-color)}
.swd-price-card__features{list-style:none;padding:0;margin:0 0 24px}
.swd-price-card__features li{font-size:14px;color:var(--body-color);padding:6px 0;display:flex;align-items:center;gap:10px}
.swd-price-card__features li i{color:var(--accent-color);font-size:16px;flex-shrink:0}

/* --- FAQ --- */
.swd-faq__list{max-width:740px;margin:0 auto}
.swd-faq-item{border:1px solid #e8eaf0;border-radius:12px;margin-bottom:12px;overflow:hidden;transition:border-color .2s}
.swd-faq-item--open{border-color:var(--accent-color)}
.swd-faq-item__q{width:100%;display:flex;align-items:center;justify-content:space-between;padding:18px 22px;background:#fff;border:none;cursor:pointer;font-size:15px;font-weight:600;color:var(--heading-color);text-align:left;gap:12px;font-family:inherit;line-height:1.5}
.swd-faq-item__q:hover{background:#fafbff}
.swd-faq-item__plus,.swd-faq-item__minus{font-size:20px;color:var(--accent-color);flex-shrink:0}
.swd-faq-item__minus{display:none}
.swd-faq-item--open .swd-faq-item__plus{display:none}
.swd-faq-item--open .swd-faq-item__minus{display:block}
.swd-faq-item__a{max-height:0;overflow:hidden;transition:max-height .3s ease,padding .3s ease;padding:0 22px}
.swd-faq-item--open .swd-faq-item__a{max-height:300px;padding:0 22px 18px}
.swd-faq-item__a p{font-size:14px;color:var(--body-color);line-height:1.7;margin:0}

/* --- CTA --- */
.swd-cta{padding:80px 0}
.swd-cta__inner{background:linear-gradient(135deg,#0d1540 0%,#1a2766 100%);border-radius:20px;padding:60px 40px;text-align:center;position:relative;overflow:hidden}
.swd-cta__inner::before{content:'';position:absolute;top:-50%;right:-30%;width:500px;height:500px;background:radial-gradient(circle,rgba(43,77,255,.15),transparent 70%);border-radius:50%}
.swd-cta__inner h2{color:#fff;font-size:32px;margin-bottom:14px;position:relative}
.swd-cta__inner p{color:rgba(255,255,255,.7);font-size:16px;margin-bottom:28px;position:relative}
.swd-cta__actions{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;position:relative}

/* ===== RESPONSIVE ===== */
@media(max-width:1199px){
    .swd-offers__grid{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:991px){
    .swd-hero{padding:80px 0 60px}
    .swd-hero__title{font-size:32px}
    .swd-section{padding:60px 0}
    .swd-why__grid{grid-template-columns:repeat(2,1fr)}
    .swd-pricing__grid{grid-template-columns:repeat(2,1fr)}
    .swd-cta__inner{padding:48px 28px}
    .swd-cta__inner h2{font-size:26px}
}
@media(max-width:767px){
    .swd-hero{padding:70px 0 50px}
    .swd-hero__title{font-size:26px}
    .swd-hero__desc{font-size:14px}
    .swd-offers__grid{grid-template-columns:1fr}
    .swd-why__grid{grid-template-columns:1fr}
    .swd-pricing__grid{grid-template-columns:1fr}
    .swd-section__header h2{font-size:26px}
    .swd-cta__inner{padding:40px 20px;border-radius:14px}
    .swd-cta__inner h2{font-size:22px}
    .swd-btn{padding:11px 22px;font-size:14px}
    .swd-price-card{padding:28px 20px}
    .swd-cta{padding:50px 0}
}
@media(max-width:480px){
    .swd-hero__title{font-size:22px}
    .swd-hero__actions{flex-direction:column;align-items:center}
    .swd-hero__actions .swd-btn{width:100%;max-width:280px}
    .swd-cta__actions{flex-direction:column;align-items:center}
    .swd-cta__actions .swd-btn{width:100%;max-width:280px}
}
</style>
@endpush
