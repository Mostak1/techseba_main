@extends('layout')
@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}">
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}">
    @if($general_setting->recaptcha_status == 1)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
@endsection
@section('front-content')

@php
    $currentLang = session()->get('front_lang');
    $heroContent = getContent('digital_agency_hero_section.content', true);
    $serviceContent = getContent('main_demo_service_section.content', true);
    $successContent = getContent('main_demo_service_success_section.content', true);
    $customerBrandContent = getContent('customer_brand_section.content', true);
    $agencyFeatureSection = getContent('digital_agency_feature_section.content', true);
    $blogSection = getContent('main_demo_blog_section.content', true);
    $ctaContent = getContent('main_demo_cta_section.content', true);
    $pricingContent = getContent('it_solutions_pricing_section.content', true);
    $packageInformation = $currentLang === 'en'
        ? ($pricingContent->data_values['package_information'] ?? [])
        : getTranslatedValue($pricingContent, 'package_information', $currentLang);

    // E-commerce Cart Check
    $totalCart = 0;
    if (class_exists('Modules\Ecommerce\Entities\Cart')) {
        if (auth()->check()) {
            $totalCart = Modules\Ecommerce\Entities\Cart::where('user_id', auth()->id())->count();
        } else {
            $totalCart = Modules\Ecommerce\Entities\Cart::where('session_id', session()->get('session_id'))->count();
        }
    }
@endphp

<!-- TOPBAR -->
<div class="topbar">
  <div class="inner">
    <div class="left">
      <span>📍 {{ $footer->address }}</span>
      <a href="tel:{{ $footer->phone }}">📞 {{ $footer->phone }}</a>
      <a href="mailto:{{ $footer->email }}">✉ {{ $footer->email }}</a>
    </div>
    <div class="right" style="display:flex;align-items:center;gap:14px;">
      
      <!-- Currency Switcher -->
      <form action="{{ route('currency-switcher') }}" id="currency_form" style="margin:0;display:inline-flex;align-items:center;">
          <select id="currency_dropdown" name="currency_code" style="background:transparent;color:var(--muted);border:none;font-size:13px;cursor:pointer;outline:none;padding:0 4px;">
              @foreach ($currency_list as $currency_item)
                  <option {{ Session::get('currency_code') == $currency_item->currency_code ? 'selected' : '' }} value="{{ $currency_item->currency_code }}" style="background:var(--card);color:var(--text);">
                      {{ $currency_item->currency_code }}
                  </option>
              @endforeach
          </select>
      </form>

      <span style="color:var(--border)">|</span>

      <!-- Language Switcher -->
      <form action="{{ route('language-switcher') }}" id="language_form" style="margin:0;display:inline-flex;align-items:center;">
          <select id="language_dropdown" name="lang_code" style="background:transparent;color:var(--muted);border:none;font-size:13px;cursor:pointer;outline:none;padding:0 4px;">
              @foreach ($language_list as $language_item)
                  <option {{ Session::get('front_lang') == $language_item->lang_code ? 'selected' : '' }} value="{{ $language_item->lang_code }}" style="background:var(--card);color:var(--text);">
                      {{ $language_item->lang_name }}
                  </option>
              @endforeach
          </select>
      </form>

      <span style="color:var(--border)">|</span>

      @auth
        <a href="{{ route('user.dashboard') }}">{{ __('translate.Dashboard') }}</a>
      @else
        <a href="{{ route('user.login') }}">{{ __('translate.Login') }}</a>
      @endauth
      <span style="color:var(--border)">|</span>
      <span style="color:var(--muted)">Available 24/7</span>
    </div>
  </div>
</div>

<!-- NAVBAR -->
<nav class="custom-navbar">
  <div class="nav-inner">
    <a class="logo" href="{{ route('home') }}">Tech<span>Seba</span></a>
    <ul class="nav-links">
      <li><a href="{{ route('home') }}" class="active">Home</a></li>
      @if(page_enabled('services'))
      <li><a href="{{ route('services') }}">Services</a></li>
      @endif
      @if(page_enabled('blogs'))
      <li><a href="{{ route('blogs') }}">Blog</a></li>
      @endif
      <li class="has-dropdown">
        <a href="#">Pages</a>
        <div class="dropdown">
          @if(page_enabled('about-us'))
          <a href="{{ route('about-us') }}">About Us</a>
          @endif
          @if(page_enabled('teams'))
          <a href="{{ route('teams') }}">Our Teams</a>
          @endif
          <div class="has-sub">
            <a href="#">Utility</a>
            <div class="subdrop">
              @if(page_enabled('faq'))
              <a href="{{ route('faq') }}">FAQ</a>
              @endif
              @if(page_enabled('testimonials'))
              <a href="{{ route('testimonials') }}">Testimonials</a>
              @endif
            </div>
          </div>
        </div>
      </li>
      @if(page_enabled('contact-us'))
      <li><a href="{{ route('contact-us') }}">Contact</a></li>
      @endif
    </ul>
    <div class="nav-right">
      @if(page_enabled('shop') && $totalCart > 0)
      <a href="{{ class_exists('Modules\Ecommerce\Entities\Cart') ? route('cart.index') : '#' }}" class="btn-ghost" style="padding: 8px 12px; display: inline-flex; align-items: center; gap: 6px;">
          🛒 <span class="cart-count">{{ $totalCart }}</span>
      </a>
      @endif
      @if(page_enabled('contact-us'))
      <a href="{{ route('contact-us') }}" class="btn-ghost">Get in Touch</a>
      @endif
      @if(page_enabled('services'))
      <a href="{{ route('services') }}" class="btn-primary">View Services</a>
      @endif
    </div>
    <div class="hamburger" id="hamburger">
      <span></span><span></span><span></span>
    </div>
  </div>
  <div class="mobile-nav" id="mobileNav">
    <ul>
      <li><a href="{{ route('home') }}">Home</a></li>
      @if(page_enabled('services'))
      <li><a href="{{ route('services') }}">Services</a></li>
      @endif
      @if(page_enabled('blogs'))
      <li><a href="{{ route('blogs') }}">Blog</a></li>
      @endif
      @if(page_enabled('about-us'))
      <li><a href="{{ route('about-us') }}">About Us</a></li>
      @endif
      @if(page_enabled('teams'))
      <li><a href="{{ route('teams') }}">Our Teams</a></li>
      @endif
      @if(page_enabled('faq'))
      <li><a href="{{ route('faq') }}">FAQ</a></li>
      @endif
      @if(page_enabled('testimonials'))
      <li><a href="{{ route('testimonials') }}">Testimonials</a></li>
      @endif
      @if(page_enabled('contact-us'))
      <li><a href="{{ route('contact-us') }}">Contact</a></li>
      @endif
    </ul>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-gradient"></div>
  <canvas id="heroCanvas" style="position:absolute;inset:0;z-index:0;width:100%;height:100%;opacity:.4;"></canvas>
  <div class="hero-content">
    <div class="hero-text">
      <div class="hero-badge"><span class="dot"></span> {{ getTranslatedValue($heroContent, 'heading', $currentLang) }}</div>
      <h1>{!! getTranslatedValue($heroContent, 'title', $currentLang) !!}</h1>
      <p>{{ getTranslatedValue($heroContent, 'description', $currentLang) }}</p>
      <div class="hero-cta">
        <a href="{{ route('contact-us') }}" class="btn-primary">{{ getTranslatedValue($heroContent, 'left_button_text', $currentLang) }}</a>
        <a href="{{ route('services') }}" class="btn-ghost">{{ getTranslatedValue($heroContent, 'right_button_text', $currentLang) }}</a>
      </div>
    </div>
    <div class="hero-visual">
      <div class="hero-card">
        <div style="font-size:13px;color:var(--muted);margin-bottom:16px;font-weight:600;">LIVE METRICS</div>
        <div class="hero-stats">
          <div class="stat-item"><div class="stat-num">200+</div><div class="stat-label">Happy Clients</div></div>
          <div class="stat-item"><div class="stat-num">350+</div><div class="stat-label">Projects Done</div></div>
          <div class="stat-item"><div class="stat-num">15+</div><div class="stat-label">Skilled Experts</div></div>
          <div class="stat-item"><div class="stat-num">98%</div><div class="stat-label">Satisfaction</div></div>
        </div>
        <div style="margin-top:20px;font-size:12px;color:var(--muted);margin-bottom:10px;font-weight:600;">SERVICES OFFERED</div>
        <div class="hero-services-preview">
          @foreach($listings->take(6) as $listing)
            <span class="service-chip">{{ $listing->translate?->title }}</span>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="section about-strip">
  <div class="section-inner">
    <div class="about-grid">
      <div>
        <div class="section-label">About Us</div>
        <h2 class="section-title">{{ getTranslatedValue($successContent, 'heading', $currentLang) }}</h2>
        <p style="color:var(--muted);font-size:15px;line-height:1.7;margin-bottom:24px;">{{ getTranslatedValue($successContent, 'description', $currentLang) }}</p>
        <div class="about-features">
          <div class="feature-row">
            <div class="feature-icon">📊</div>
            <div class="feature-text"><h5>Custom Reports & Dashboards</h5><p>Real-time insights to help you make data-driven decisions.</p></div>
          </div>
          <div class="feature-row">
            <div class="feature-icon">🔄</div>
            <div class="feature-text"><h5>Legacy Software Modernization</h5><p>Upgrade outdated systems without disrupting operations.</p></div>
          </div>
          <div class="feature-row">
            <div class="feature-icon">🏢</div>
            <div class="feature-text"><h5>Enterprise Software Solutions</h5><p>Scalable tools built for high-demand business environments.</p></div>
          </div>
        </div>
        <a href="{{ route('about-us') }}" class="btn-primary" style="display:inline-flex;margin-top:28px;padding:12px 28px;">More About Us →</a>
      </div>
      <div class="about-visual reveal">
        <div class="stat-grid">
          <div class="stat-card"><div class="num">200<span class="plus">+</span></div><div class="lbl">Happy Clients</div></div>
          <div class="stat-card"><div class="num">350<span class="plus">+</span></div><div class="lbl">Finished Projects</div></div>
          <div class="stat-card"><div class="num">15<span class="plus">+</span></div><div class="lbl">Skilled Experts</div></div>
          <div class="stat-card"><div class="num">98<span class="plus">%</span></div><div class="lbl">Client Satisfaction</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="section">
  <div class="section-inner">
    <div class="section-head reveal">
      <div class="section-label">Our Services</div>
      <h2 class="section-title">{{ getTranslatedValue($serviceContent, 'heading', $currentLang) }}</h2>
      <p class="section-sub">From POS systems to enterprise ERP—we deliver every layer of your digital infrastructure.</p>
    </div>
    <div class="services-grid">
      @foreach($listings as $listing)
      <div class="service-card reveal" onclick="window.location='{{ route('service', $listing->slug) }}'">
        <div class="service-icon">
          @if(Str::contains(Str::lower($listing->translate?->title), 'pos'))
            🖥️
          @elseif(Str::contains(Str::lower($listing->translate?->title), ['pbx', 'telephon', 'call']))
            📞
          @elseif(Str::contains(Str::lower($listing->translate?->title), ['web', 'landing']))
            🌐
          @elseif(Str::contains(Str::lower($listing->translate?->title), ['ecommerce', 'shop', 'cart']))
            🛒
          @elseif(Str::contains(Str::lower($listing->translate?->title), 'erp'))
            ⚙️
          @elseif(Str::contains(Str::lower($listing->translate?->title), ['hr', 'payroll', 'employee']))
            👥
          @elseif(Str::contains(Str::lower($listing->translate?->title), 'cctv'))
            📹
          @elseif(Str::contains(Str::lower($listing->translate?->title), ['network', 'server']))
            📡
          @else
            📋
          @endif
        </div>
        <div class="service-price">
          @if($listing->price > 0)
            From {{ currency($listing->price) }}
          @else
            Custom Quote
          @endif
        </div>
        <h5>{{ $listing->translate?->title }}</h5>
        <p>{!! Str::limit(strip_tags(clean($listing->translate?->description)), 120) !!}</p>
        <a href="{{ route('service', $listing->slug) }}" class="service-link">Learn More <span>→</span></a>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- PORTFOLIO -->
<section class="section portfolio-section">
  <div class="section-inner">
    <div class="section-head reveal">
      <div class="section-label">Our Work</div>
      <h2 class="section-title">Recent Projects</h2>
      <p class="section-sub">A snapshot of what we've built for clients across industries.</p>
    </div>
    <div class="portfolio-grid">
      @foreach($projects as $project)
      <div class="portfolio-card reveal" onclick="window.location='{{ route('portfolio.show', $project->slug) }}'">
        <img src="{{ asset($project->thumb_image) }}" alt="{{ $project->translate?->title }}">
        <div class="portfolio-overlay">
          <div class="tag">{{ $project->category?->name }}</div>
          <h4>{{ $project->translate?->title }}</h4>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- PROCESS -->
<section class="section">
  <div class="section-inner">
    <div class="section-head reveal">
      <div class="section-label">How We Work</div>
      <h2 class="section-title">Our Delivery Process</h2>
      <p class="section-sub">A clear, proven workflow from idea to launch and beyond.</p>
    </div>
    <div class="process-grid">
      <div class="process-card reveal">
        <div class="process-icon">🗂️</div>
        <h4>Planning & Strategy</h4>
        <p>We understand your requirements and create a clear roadmap to achieve your business goals efficiently.</p>
      </div>
      <div class="process-card reveal">
        <div class="process-icon">💻</div>
        <h4>Development & Execution</h4>
        <p>Our team builds and implements reliable solutions using modern, battle-tested technologies.</p>
      </div>
      <div class="process-card reveal">
        <div class="process-icon">🔍</div>
        <h4>Testing & Support</h4>
        <p>We test, optimize, and provide ongoing support to ensure smooth, uninterrupted performance.</p>
      </div>
    </div>
  </div>
</section>

@if(($general_setting->pricing_status ?? 1) == 1)
<!-- PRICING -->
<section class="section" style="background:var(--bg2);">
  <div class="section-inner">
    <div class="section-head reveal">
      <div class="section-label">Pricing</div>
      <h2 class="section-title">{{ getTranslatedValue($pricingContent, 'heading', $currentLang) }}</h2>
      <p class="section-sub">Transparent pricing with no hidden fees. Scale as you grow.</p>
    </div>
    <div class="pricing-grid">
      @foreach($packageInformation as $package)
      <div class="pricing-card @if(($package['title'] ?? '') == 'Business' || $loop->iteration == 2) featured @endif reveal">
        <div class="pricing-plan">{{ $package['title'] ?? '' }}</div>
        <div class="pricing-price">{{ currency($package['price'] ?? 0) }}</div>
        <p class="pricing-desc">{{ $package['description'] ?? 'Tailored plan for your business needs.' }}</p>
        <ul class="pricing-features">
          @if(isset($package['features']) && is_array($package['features']))
            @foreach($package['features'] as $feature)
              <li>{{ $feature }}</li>
            @endforeach
          @endif
        </ul>
        <a href="{{ route('contact-us') }}" class="@if(($package['title'] ?? '') == 'Business' || $loop->iteration == 2) btn-filled @else btn-outline @endif">Get Started</a>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- CONTACT STRIP -->
<section class="section cta-section">
  <div class="section-inner">
    <div class="cta-inner">
      <div>
        <div class="section-label">Get In Touch</div>
        <h2 class="section-title">Empowering Your Business with TechSeba</h2>
        <p style="color:var(--muted);font-size:15px;line-height:1.7;margin-bottom:36px;">We help businesses grow with modern technology—custom development, system integration, and ongoing support.</p>
        <div class="cta-info">
          <div class="contact-item">
            <div class="contact-icon">📍</div>
            <div><h5>Address</h5><p>{{ $footer->address }}</p></div>
          </div>
          <div class="contact-item">
            <div class="contact-icon">📞</div>
            <div><h5>Phone</h5><a href="tel:{{ $footer->phone }}">{{ $footer->phone }}</a></div>
          </div>
          <div class="contact-item">
            <div class="contact-icon">✉️</div>
            <div><h5>Email</h5><a href="mailto:{{ $footer->email }}">{{ $footer->email }}</a></div>
          </div>
          <div class="contact-item">
            <div class="contact-icon">🕐</div>
            <div><h5>Hours</h5><p>Available 24/7 for Support & Services</p></div>
          </div>
        </div>
      </div>
      <form action="{{ route('store-contact-message') }}" method="POST" class="cta-form reveal">
        @csrf
        <h4 style="font-size:20px;margin-bottom:22px;">Send Us a Message</h4>
        <div class="form-row">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" placeholder="Your name" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="your@email.com" required>
          </div>
        </div>
        <div class="form-group">
          <label>Phone</label>
          <input type="text" name="phone" placeholder="Your Phone Number">
        </div>
        <div class="form-group">
          <label>Message</label>
          <textarea name="message" placeholder="Tell us about your project..." required></textarea>
        </div>
        @if($general_setting->recaptcha_status == 1)
          <div class="form-group">
            <div class="g-recaptcha" data-sitekey="{{ $general_setting->recaptcha_site_key }}"></div>
          </div>
        @endif
        <button type="submit" class="btn-filled" style="width:100%;padding:14px;font-size:14px;cursor:pointer;border:none;border-radius:10px;font-family:'Inter',sans-serif;">Send Message</button>
      </form>
    </div>
  </div>
</section>

<!-- BLOG -->
<section class="section">
  <div class="section-inner">
    <div class="section-head reveal">
      <div class="section-label">Blog</div>
      <h2 class="section-title">{{ getTranslatedValue($blogSection, 'heading', $currentLang) }}</h2>
      <p class="section-sub">Stay updated with the latest in tech, software, and digital transformation.</p>
    </div>
    <div class="blog-grid">
      @foreach($blogPosts as $blog)
      <div class="blog-card reveal" onclick="window.location='{{ route('blog', $blog->slug) }}'">
        <div class="blog-img"><img src="{{ asset($blog->image) }}" alt="{{ $blog->translate?->title }}"></div>
        <div class="blog-body">
          <div class="blog-meta">
            <span class="blog-cat">{{ $blog->category?->name }}</span>
            <span class="blog-date">{{ $blog->created_at->diffForHumans() }}</span>
          </div>
          <h4>{{ $blog->translate?->title }}</h4>
          <a href="{{ route('blog', $blog->slug) }}" class="blog-read">Read Article →</a>
        </div>
      </div>
      @endforeach
    </div>
    <div style="text-align:center;margin-top:44px;"><a href="{{ route('blogs') }}" class="btn-ghost">View All Posts →</a></div>
  </div>
</section>

<!-- FOOTER -->
<footer class="custom-footer">
  <div class="footer-inner">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="logo" href="{{ route('home') }}">Tech<span>Seba</span></a>
        <p>{{ $footer->about_us }}</p>
        <div class="footer-social">
          <a class="social-btn" href="https://www.facebook.com/techseba.it" target="_blank">f</a>
          <a class="social-btn" href="https://www.youtube.com/@ProgrammingEloquent" target="_blank">▶</a>
          <a class="social-btn" href="https://wa.me/8801898828248" target="_blank">💬</a>
        </div>
      </div>
      <div class="footer-col">
        <h5>Quick Links</h5>
        <ul>
          <li><a href="{{ route('about-us') }}">About Us</a></li>
          <li><a href="{{ route('teams') }}">Our Teams</a></li>
          <li><a href="{{ route('blogs') }}">Blogs</a></li>
          <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Services</h5>
        <ul>
          @foreach($services->take(5) as $service)
            <li><a href="{{ route('service', $service->slug) }}">{{ $service->translate?->title }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="footer-col">
        <h5>Newsletter</h5>
        <p style="font-size:13px;color:var(--muted);margin-bottom:14px;">Get ready for better business solutions.</p>
        <form action="{{ route('store-newsletter') }}" method="POST" class="footer-newsletter">
          @csrf
          <input type="email" name="email" placeholder="Your email address" required>
          <button type="submit">Subscribe</button>
        </form>
        <div style="margin-top:16px;display:flex;flex-direction:column;gap:6px;">
          <a href="{{ route('privacy-policy') }}" style="font-size:12px;color:var(--muted);text-decoration:none;">Privacy Policy</a>
          <a href="{{ route('terms-conditions') }}" style="font-size:12px;color:var(--muted);text-decoration:none;">Terms & Conditions</a>
          <a href="{{ route('faq') }}" style="font-size:12px;color:var(--muted);text-decoration:none;">FAQ</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>{{ $footer->copyright }}</p>
      <div class="footer-bottom-links">
        <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
        <a href="{{ route('terms-conditions') }}">Terms & Conditions</a>
        <a href="{{ route('faq') }}">FAQ</a>
      </div>
    </div>
  </div>
</footer>

@endsection
