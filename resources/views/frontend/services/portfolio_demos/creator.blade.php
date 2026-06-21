@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Tanvir Tech - Video Content Creator & Influencer')
@section('primary-color', '#ef4444')
@section('primary-rgb', '239, 68, 68')
@section('demo_slug', 'Creator Portfolio')
@section('logo-icon', 'ri-video-line')
@section('logo-text', 'Tanvir Tech')
@section('cta-text', 'Brand Collab')

@section('nav-items')
    <li><a href="#about">About Channel</a></li>
    <li><a href="#stats">Channel Stats</a></li>
    <li><a href="#videos">Content Hub</a></li>
    <li><a href="#brands">Collabs</a></li>
    <li><a href="#faq">FAQs</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="badge">Tech Reviewer & Content Creator</span>
                <h1 class="hero-title">Engaging Tech Reviews for the <span>Next Gen</span></h1>
                <p class="hero-desc">Tanvir Tech makes viral gadget reviews, software tutorials, and tech buying guides. Reaching over 500k+ subscribers on TikTok and YouTube in Bangladesh.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Work Together <i class="ri-mail-send-line"></i></a>
                    <a href="#stats" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">Download Media Kit</a>
                </div>
            </div>
            <div style="text-align: center;">
                <img src="{{ asset('uploads/demo/creator.png') }}" class="hero-img" alt="Tanvir Tech Workspace" style="max-height: 420px; object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- Social Stats Counter -->
    <section id="stats" style="background: var(--card); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 60px 0;">
        <div class="container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px; text-align: center;">
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">350K+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">YouTube Subs</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">150K+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">TikTok Followers</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">10M+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Monthly Views</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">4.8%</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Audience Engagement</p>
            </div>
        </div>
    </section>

    <!-- Detailed About / Lottie Banner -->
    <section id="about">
        <div class="container hero-grid">
            <div style="display: flex; justify-content: center; align-items: center;">
                <!-- Animated Lottie File for YouTube / Video -->
                <lottie-player src="https://lottie.host/93278c2e-436d-4952-ba61-8ff86bdf3b05/sYxY9QWvY3.json" background="transparent" speed="1" style="width: 320px; height: 320px;" loop autoplay></lottie-player>
            </div>
            <div>
                <span class="badge">My Audience</span>
                <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px;">Unbiased, High-Production Tech Content</h2>
                <p style="color: var(--muted); margin-bottom: 20px; line-height: 1.8;">Our videos are recorded in high-fidelity 4K studio setups, featuring close-up macro shots, synthetic benchmarks, and real-world durability testing. We speak the language of Gen-Z and millennial tech consumers in Bangladesh, driving direct purchasing decisions.</p>
                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); padding: 16px; border-radius: 12px; margin-top: 24px;">
                    <h5 style="margin-bottom: 6px; font-weight: 600;"><i class="ri-heart-pulse-fill" style="color: var(--primary); margin-right: 6px;"></i> High Authenticity</h5>
                    <p style="color: var(--muted); font-size: 13px;">We never review sponsored items with biased scripts. Real feedback only.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Hub Section -->
    <section id="videos" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Core Video Columns</h2>
            <p class="section-desc">Check out our signature review playlists that generate millions of cumulative clicks.</p>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-smartphone-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Flagships</span>
                        <h4 class="gallery-title">Smartphones Unbox</h4>
                        <p class="gallery-desc">Extreme performance benchmarks, gaming heat profiles, camera comparison sets, and battery lifecycle reports.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-macbook-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Desk Setups</span>
                        <h4 class="gallery-title">Productivity Gadgets</h4>
                        <p class="gallery-desc">Exploring ergonomic chairs, mechanical keyboards, custom monitor mounts, and minimalist desk accessories.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-code-box-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Tutorials</span>
                        <h4 class="gallery-title">Software Explainer Guides</h4>
                        <p class="gallery-desc">Actionable software tutorials, productivity apps setups, browser shortcuts hacks, and coding workspace tools audits.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Channel Timeline / Achievements -->
    <section id="experience">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Audience Milestones</h2>
            <p class="section-desc">Brief timeline of our channel's organic growth and achievements.</p>
            
            <div class="timeline-container">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2025</div>
                    <h4 class="timeline-title">Passed 500k Combined Subscribers</h4>
                    <p class="timeline-desc">Secured major brand endorsements from top-tier local e-commerce merchants and gadget importers.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2023</div>
                    <h4 class="timeline-title">YouTube Silver Play Button</h4>
                    <p class="timeline-desc">Officially awarded by YouTube for crossing 100k subscribers with high-retention review guides.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2021</div>
                    <h4 class="timeline-title">Channel Launch</h4>
                    <p class="timeline-desc">Began recording smartphone unboxings and budget gear guides in a bedroom studio room.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Collab / Booking Details -->
    <section id="brands" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Brand Collab Process</h2>
            <p class="section-desc">Submit your sponsorship requests and receive our integration timeline guidelines.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <span class="badge">Dedicated Video</span>
                    <h3 class="card-title">Full Product Showcase</h3>
                    <p class="card-desc" style="margin-bottom: 16px;">A dedicated 8-12 minute video reviewing your gadget with close-ups, usage tests, and links in the description.</p>
                    <p style="font-size: 13.5px; color: var(--muted); margin-bottom: 20px;"><i class="ri-time-line" style="color:var(--primary); margin-right: 6px;"></i> Delivery Timeline: 7-10 Days</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Inquire dedicated review</a>
                </div>
                <div class="card">
                    <span class="badge">Integrations</span>
                    <h3 class="card-title">60s Video Sponsorship</h3>
                    <p class="card-desc" style="margin-bottom: 16px;">A 60-second natural product placement or sponsor shoutout inside our weekly roundup video compilations.</p>
                    <p style="font-size: 13.5px; color: var(--muted); margin-bottom: 20px;"><i class="ri-time-line" style="color:var(--primary); margin-right: 6px;"></i> Delivery Timeline: 3-5 Days</p>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; text-align: center;">Inquire integrations</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section id="faq">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-desc">Answers to common partnership and media kit questions.</p>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you accept free review units in exchange for reviews?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    We accept review units for evaluation, but it does not guarantee a video upload or a positive review. Real, authentic scripts are maintained for all tech unboxings.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>What is the geographic distribution of your audience?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Approximately 85% of our audience is based in Bangladesh, with Dhaka, Chittagong, and Sylhet representing the top-tier cities for tech and gadget buyers.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Can you deliver vertical content for TikTok & YouTube Shorts?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Yes, we offer tailored packages for vertical short-form content. These generally generate higher initial viral reach and brand awareness metrics.
                </div>
            </div>
        </div>
    </section>
@endsection
