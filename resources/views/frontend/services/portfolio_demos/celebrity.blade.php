@extends('frontend.services.portfolio_demos.layout')

@section('title', 'Tahsan Khan - Singer, Actor & Public Figure')
@section('primary-color', '#8b5cf6')
@section('primary-rgb', '139, 92, 246')
@section('demo_slug', 'Celebrity Portfolio')
@section('logo-icon', 'ri-vip-crown-2-line')
@section('logo-text', 'Tahsan')
@section('cta-text', 'Show Booking')

@section('nav-items')
    <li><a href="#about">About Me</a></li>
    <li><a href="#events">Concerts</a></li>
    <li><a href="#releases">Releases</a></li>
    <li><a href="#timeline">My Journey</a></li>
    <li><a href="#faq">FAQs</a></li>
@endsection

@section('main-content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="badge">Singer, Actor & Model</span>
                <h1 class="hero-title">Spreading Soulful <span>Music & Stories</span></h1>
                <p class="hero-desc">Tahsan Khan is a celebrated singer-songwriter, actor, and humanitarian in Bangladesh, known for creating romantic melodies and starring in widely acclaimed TV dramas for two decades.</p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta">Book for Events <i class="ri-music-2-line"></i></a>
                    <a href="#events" class="btn-cta" style="background: transparent; border: 1px solid var(--border); color: #fff !important; box-shadow: none;">Tour Schedule</a>
                </div>
            </div>
            <div style="text-align: center;">
                <img src="{{ asset('uploads/demo/celebrity.png') }}" class="hero-img" alt="Tahsan Khan Concert" style="max-height: 420px; object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- Stats Row -->
    <section style="background: var(--card); padding: 50px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px; text-align: center;">
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">20+ Years</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Artistic Journey</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">8 Official</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Music Albums</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">100+ TV</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Dramas & Series</p>
            </div>
            <div>
                <h3 style="font-size: 36px; color: var(--primary); font-weight: 800;">5M+ Fans</h3>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Social Community</p>
            </div>
        </div>
    </section>

    <!-- Detailed About / Lottie Banner -->
    <section id="about">
        <div class="container hero-grid">
            <div style="display: flex; justify-content: center; align-items: center;">
                <!-- Animated Lottie File for Music / Wave -->
                <lottie-player src="https://lottie.host/81a95e7c-a496-4bf4-bbf7-10c55cfebf0f/1bC7X5H37c.json" background="transparent" speed="1" style="width: 320px; height: 320px;" loop autoplay></lottie-player>
            </div>
            <div>
                <span class="badge">My Inspiration</span>
                <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px;">Touching Lives Through Acoustic Artistry</h2>
                <p style="color: var(--muted); margin-bottom: 20px; line-height: 1.8;">From classical training roots to pioneering alternative indie pop waves in the early 2000s, I aim to compose melodies that reflect genuine human relationships, love, and growth. Beyond recording, I enjoy performing live concerts and scripting television screenplays.</p>
                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); padding: 16px; border-radius: 12px; margin-top: 24px;">
                    <h5 style="margin-bottom: 6px; font-weight: 600;"><i class="ri-disc-fill" style="color: var(--primary); margin-right: 6px;"></i> Spotify verified profile</h5>
                    <p style="color: var(--muted); font-size: 13px;">Follow my official verified channel to stream new acoustic sessions instantly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tour & Concert Schedules -->
    <section id="events" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <h2 class="section-title">Upcoming Concert Tours</h2>
            <p class="section-desc">Join the crowd and sing along. Book your tickets in advance.</p>
            
            <div style="display: flex; flex-direction: column; gap: 20px; max-width: 800px; margin: 0 auto;">
                <div style="background: var(--card); border: 1px solid var(--border); padding: 24px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <span style="color: var(--primary); font-weight: 700; font-size: 14px;"><i class="ri-calendar-event-line"></i> DEC 15, 2026</span>
                        <h4 style="font-size: 18px; font-weight: 600; margin-top: 4px;">Dhaka Winter Symphony</h4>
                        <p style="color: var(--muted); font-size: 13.5px;">Army Stadium, Dhaka, Bangladesh</p>
                    </div>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="padding: 8px 16px; font-size: 13px;">Get Tickets</a>
                </div>
                <div style="background: var(--card); border: 1px solid var(--border); padding: 24px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <span style="color: var(--primary); font-weight: 700; font-size: 14px;"><i class="ri-calendar-event-line"></i> JAN 05, 2027</span>
                        <h4 style="font-size: 18px; font-weight: 600; margin-top: 4px;">Chittagong acoustic night</h4>
                        <p style="color: var(--muted); font-size: 13.5px;">MA Aziz Stadium, Chittagong, Bangladesh</p>
                    </div>
                    <a href="javascript:void(0)" onclick="openModal()" class="btn-cta" style="padding: 8px 16px; font-size: 13px;">Get Tickets</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Media Releases -->
    <section id="releases">
        <div class="container">
            <h2 class="section-title">Music & Cinematic Releases</h2>
            <p class="section-desc">Listen to recent singles or review telefilms released across streaming networks.</p>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-spotify-line" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Single</span>
                        <h4 class="gallery-title">"Alo Alo" (Acoustic Redux)</h4>
                        <p class="gallery-desc">Re-recording the classic alternative track with soft piano keys and clean vocals.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-movie-2-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Drama</span>
                        <h4 class="gallery-title">"Prem O Shomoy" Telefilm</h4>
                        <p class="gallery-desc">Romantic telefilm exploring love, schedules conflicts and relationships in corporate cities.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrapper" style="height: 180px;">
                        <i class="ri-t-shirt-fill" style="font-size: 64px; color: var(--primary);"></i>
                    </div>
                    <div class="gallery-content">
                        <span class="gallery-tag">Merch</span>
                        <h4 class="gallery-title">Official Concert Hoodies</h4>
                        <p class="gallery-desc">Premium cotton hoodies printed with classic song lyrics and official tour graphics.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Career Timeline -->
    <section id="timeline" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">My Artistic Journey</h2>
            <p class="section-desc">Key milestones highlighting my music and cinematic career.</p>
            
            <div class="timeline-container">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2020 - Present</div>
                    <h4 class="timeline-title">Humanitarian Ambassador & Soloist</h4>
                    <p class="timeline-desc">Appointed as Goodwill Ambassador for UN development campaigns, coordinating social fundraisers.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2010 - 2020</div>
                    <h4 class="timeline-title">Acting & Drama Golden Era</h4>
                    <p class="timeline-desc">Starred in major television blockbusters and released consecutive chart-topping solo albums.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2001 - 2007</div>
                    <h4 class="timeline-title">Band Career Start</h4>
                    <p class="timeline-desc">Co-founded alternative indie rock bands, writing original tracks that defined university rock trends.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section id="faq">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-desc">Answers to common booking and show coordination questions.</p>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>How can I book Tahsan for college fest concerts?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Please submit your college event request form detailing the venue, capacity, proposed date, and sound system resources. Our management team will coordinate within 3 business days.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you offer autographed merch packages?</span>
                    <i class="ri-arrow-down-s-line faq-icon"></i>
                </div>
                <div class="faq-answer">
                    Yes, concert merch purchased during pre-orders includes autographed postcards and posters. Check the official Merch section for active sales.
                </div>
            </div>
        </div>
    </section>
@endsection
