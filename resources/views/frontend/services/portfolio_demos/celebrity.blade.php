@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Tahsan Khan - Singer, Actor & Public Figure')
@section('primary-color', '#8b5cf6')
@section('primary-rgb', '139, 92, 246')
@section('demo_slug', 'Celebrity Portfolio')
@section('logo-icon', 'ri-vip-crown-2-line')
@section('logo-text', 'Tahsan')
@section('cta-text', 'Show Booking')

@section('nav-items')
    <li><a href="#events">Upcoming Shows</a></li>
    <li><a href="#media">Music & Media</a></li>
    <li><a href="#fanbase">Fan Club</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span style="color: var(--primary); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1.5px; display: block; margin-bottom: 12px;">Singer & Actor</span>
                <h1 class="hero-title">Connecting Hearts Through <span>Music & Art</span></h1>
                <p class="hero-desc">Tahsan Khan is an iconic Bangladeshi musician, actor, and model. Entertaining millions with soulful melodies and chart-topping dramas for over two decades.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Book for Concerts <i class="ri-music-2-line"></i></a>
                    <a href="#events" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">Tour Schedule</a>
                </div>
            </div>
            <div>
                <div class="hero-img-box">
                    <i class="ri-disc-line"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Event Schedule -->
    <section id="events" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Upcoming Shows & Appearances</h2>
            <p class="section-desc">Catch me performing live in your city. Check out the tour schedules below.</p>
            
            <div style="display: flex; flex-direction: column; gap: 16px; max-width: 800px; margin: 0 auto;">
                <div style="background: var(--card); border: 1px solid var(--border); padding: 24px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <span style="color: var(--primary); font-weight: 700; font-size: 14px;">DEC 15, 2026</span>
                        <h4 style="font-size: 17px; font-weight: 600; margin-top: 4px;">Dhaka Winter Concert</h4>
                        <p style="color: var(--muted); font-size: 13.5px;">Army Stadium, Dhaka, Bangladesh</p>
                    </div>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="padding: 8px 16px; font-size: 13px;">Get Tickets</a>
                </div>
                <div style="background: var(--card); border: 1px solid var(--border); padding: 24px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <span style="color: var(--primary); font-weight: 700; font-size: 14px;">JAN 05, 2027</span>
                        <h4 style="font-size: 17px; font-weight: 600; margin-top: 4px;">Chittagong Gala Night</h4>
                        <p style="color: var(--muted); font-size: 13.5px;">MA Aziz Stadium, Chittagong, Bangladesh</p>
                    </div>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="padding: 8px 16px; font-size: 13px;">Get Tickets</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Music & Media -->
    <section id="media">
        <div class="container">
            <h2 class="section-title">Latest Releases</h2>
            <p class="section-desc">Stream my latest songs, music videos, and cinematic drama trailers online.</p>
            
            <div class="cards-grid">
                <div class="card">
                    <div class="card-icon"><i class="ri-spotify-line"></i></div>
                    <h3 class="card-title">Spotify Hits</h3>
                    <p class="card-desc">Listen to my official playlist featuring acoustic tracks, romantic melodies, and rock singles.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-film-line"></i></div>
                    <h3 class="card-title">Featured Drama</h3>
                    <p class="card-desc">Watch clips and review ratings of my upcoming television films and Eid special series.</p>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="ri-t-shirt-line"></i></div>
                    <h3 class="card-title">Official Merch</h3>
                    <p class="card-desc">Pre-order official customized tees, autographed albums, and exclusive poster prints.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fan Base Section -->
    <section id="fanbase" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border);">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; align-items: center;">
            <div>
                <h2 class="section-title" style="text-align: left; margin-bottom: 16px;">Tahsan's Fan Club</h2>
                <p style="color: var(--muted); margin-bottom: 24px; line-height: 1.8;">Join the official email list to receive exclusive behind-the-scenes diaries, early concert booking discounts, and monthly video newsletters.</p>
                <div style="background: var(--card); border: 1px solid var(--border); padding: 24px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
                    <i class="ri-customer-service-line" style="font-size: 24px; color: var(--primary);"></i>
                    <div>
                        <h5 style="margin-bottom: 2px; font-weight: 600;">PR & Management</h5>
                        <p style="color: var(--muted); font-size: 13.5px;">For corporate endorsements, write to booking@tahsan.com</p>
                    </div>
                </div>
            </div>
            <div style="background: var(--card); border: 1px solid var(--border); padding: 40px; border-radius: 20px; text-align: center;">
                <h3 style="font-size: 22px; margin-bottom: 12px;">Join Fan Club</h3>
                <p style="color: var(--muted); font-size: 14.5px; margin-bottom: 24px;">Sign up with your details to participate in the next fan meet & greet raffle draw.</p>
                <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="display: block; width: 100%;">Sign Up Now</a>
            </div>
        </div>
    </section>
@endsection
