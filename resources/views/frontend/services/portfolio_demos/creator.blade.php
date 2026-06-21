@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Tanvir Tech - Video Content Creator & Influencer')
@section('primary-color', '#ef4444')
@section('primary-rgb', '239, 68, 68')
@section('demo_slug', 'Creator Portfolio')
@section('logo-icon', 'ri-video-line')
@section('logo-text', 'Tanvir Tech')
@section('cta-text', 'Brand Collab')

@section('nav-items')
    <li><a href="#stats">Channel Stats</a></li>
    <li><a href="#videos">Recent Videos</a></li>
    <li><a href="#brands">Brands</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span style="color: var(--primary); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1.5px; display: block; margin-bottom: 12px;">Tech Reviewer & Content Creator</span>
                <h1 class="hero-title">Engaging Tech Reviews for the <span>Next Gen</span></h1>
                <p class="hero-desc">Tanvir Tech makes viral gadget reviews, software tutorials, and tech buying guides. Reaching over 500k+ subscribers on TikTok and YouTube in Bangladesh.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Work Together <i class="ri-mail-send-line"></i></a>
                    <a href="#stats" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">View Media Kit</a>
                </div>
            </div>
            <div>
                <div class="hero-img-box">
                    <i class="ri-youtube-line"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Stats Counter -->
    <section id="stats" style="background: var(--card); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 60px 0;">
        <div class="container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px; text-align: center;">
            <div>
                <h3 style="font-size: 40px; color: var(--primary); font-weight: 800;">350K+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">YouTube Subs</p>
            </div>
            <div>
                <h3 style="font-size: 40px; color: var(--primary); font-weight: 800;">150K+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">TikTok Followers</p>
            </div>
            <div>
                <h3 style="font-size: 40px; color: var(--primary); font-weight: 800;">10M+</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Monthly Video Views</p>
            </div>
        </div>
    </section>

    <!-- Recent Videos Mockup -->
    <section id="videos">
        <div class="container">
            <h2 class="section-title">Featured Content</h2>
            <p class="section-desc">Check out some of our most watched tech reviews and product showcases.</p>
            
            <div class="cards-grid">
                <div class="card" style="padding: 0; overflow: hidden;">
                    <div style="height: 180px; background: rgba(255,255,255,0.03); display: flex; align-items: center; justify-content: center; border-bottom: 1px solid var(--border);">
                        <i class="ri-play-circle-line" style="font-size: 48px; color: var(--primary);"></i>
                    </div>
                    <div style="padding: 24px;">
                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 8px;">Top 5 Smartwatches under ৳5,000</h4>
                        <p style="color: var(--muted); font-size: 13.5px;">Detailed breakdown of budget fitness bands and smartwatches available locally.</p>
                    </div>
                </div>
                <div class="card" style="padding: 0; overflow: hidden;">
                    <div style="height: 180px; background: rgba(255,255,255,0.03); display: flex; align-items: center; justify-content: center; border-bottom: 1px solid var(--border);">
                        <i class="ri-play-circle-line" style="font-size: 48px; color: var(--primary);"></i>
                    </div>
                    <div style="padding: 24px;">
                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 8px;">Unboxing the Latest Flagship Phone</h4>
                        <p style="color: var(--muted); font-size: 13.5px;">Premium build analysis, camera testing, and performance benchmark review.</p>
                    </div>
                </div>
                <div class="card" style="padding: 0; overflow: hidden;">
                    <div style="height: 180px; background: rgba(255,255,255,0.03); display: flex; align-items: center; justify-content: center; border-bottom: 1px solid var(--border);">
                        <i class="ri-play-circle-line" style="font-size: 48px; color: var(--primary);"></i>
                    </div>
                    <div style="padding: 24px;">
                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 8px;">How to Setup Your Home Studio</h4>
                        <p style="color: var(--muted); font-size: 13.5px;">Budget lighting, microphone setup, and acoustics tips for new video creators.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brands collaborated -->
    <section id="brands" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border);">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; align-items: center;">
            <div>
                <h2 class="section-title" style="text-align: left; margin-bottom: 16px;">Brand Integrations & Placements</h2>
                <p style="color: var(--muted); line-height: 1.8; margin-bottom: 24px;">We integrate products naturally into our content flow, delivering highly authentic feedback that drives clicks and increases conversions.</p>
                <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                    <span style="background: var(--card); padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; border: 1px solid var(--border);">TechSeba Sponsor</span>
                    <span style="background: var(--card); padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; border: 1px solid var(--border);">Daraz Affiliates</span>
                </div>
            </div>
            <div style="background: var(--card); border: 1px solid var(--border); padding: 40px; border-radius: 20px; text-align: center;">
                <h3 style="font-size: 22px; margin-bottom: 12px;">Get Media Kit</h3>
                <p style="color: var(--muted); font-size: 14.5px; margin-bottom: 24px;">Download our demographics, channel reach sheet, and sponsorship rate cards.</p>
                <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; width: 100%;">Inquire Partnership Pricing</a>
            </div>
        </div>
    </section>
@endsection
