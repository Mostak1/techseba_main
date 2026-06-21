@extends('frontend.templates.main_demo_layout')
@php
    $serviceTitle = $serviceSeo['title'] ?? 'Message & WhatsApp Reply Automation Service';
    $serviceShortDescription = $serviceSeo['short_description'] ?? 'WhatsApp, Facebook Page, Instagram DM — সব জায়গায় instant auto reply। Customer হারাবেন না কখনো।';
    $serviceDescription = $serviceSeo['description'] ?? 'আপনার WhatsApp, Facebook Messenger ও Instagram DM এ automatic reply চালু করুন। TechSeba-র automation service দিয়ে ২৪/৭ customer handle করুন — কোনো staff ছাড়াই।';
    $serviceSeoTitle = $seoTitle ?? 'WhatsApp & Message Automation | Auto Reply Bot | TechSeba';
    $serviceSeoDescription = $seoDescription ?? $serviceDescription;
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
            'telephone' => config('techseba_seo.organization.telephone'),
            'email' => config('techseba_seo.organization.email'),
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Dhaka',
                'addressCountry' => 'BD',
            ],
        ],
        'areaServed' => ['Dhaka', 'Bangladesh'],
        'url' => $canonicalUrl ?? url()->current(),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
@php
    $currentLang = session()->get('front_lang');
@endphp

{{-- ==================== HERO SECTION ==================== --}}
<section class="wa-hero">
    <div class="wa-hero__mesh"></div>
    <div class="container">
        <div class="wa-hero__grid-wrapper">
            <div class="wa-hero__left-content" data-aos="fade-right" data-aos-duration="1000">
                <span class="wa-hero__badge"><i class="ri-whatsapp-line"></i> Automation Service</span>
                <h1 class="wa-hero__title">
                    এখন থেকে আপনার Business Reply দেবে <span class="text-gradient">Automatically</span> — ২৪ ঘণ্টা, ৭ দিন
                </h1>
                <h3 class="wa-hero__subtitle" style="font-size: 18px; font-weight: 500; color: var(--muted) !important; margin-bottom: 24px; line-height: 1.6;">
                    WhatsApp, Facebook Page, Instagram DM — সব জায়গায় instant auto reply। Customer হারাবেন না কখনো।
                </h3>
                <p class="wa-hero__desc" style="display: none;">{{ $serviceShortDescription }}</p>
                
                <div class="wa-hero__actions">
                    <a href="https://wa.me/8801898828248?text=I%20want%20to%20see%20a%20Free%20Demo%20of%20WhatsApp%20Automation%20Service" target="_blank" rel="noopener noreferrer" class="btn-primary">
                        <i class="ri-whatsapp-line"></i> Free Demo দেখুন
                    </a>
                    <a href="#pricing" class="btn-ghost">
                        Pricing দেখুন
                    </a>
                </div>

                {{-- Hero badge strip below buttons --}}
                <div class="wa-hero__badge-strip">
                    <div class="wa-strip-item">
                        <i class="ri-shield-check-line"></i> Setup in 24 Hours
                    </div>
                    <div class="wa-strip-item">
                        <i class="ri-terminal-box-line"></i> No Coding Needed
                    </div>
                    <div class="wa-strip-item">
                        <i class="ri-wallet-3-line"></i> bKash / Nagad Payment
                    </div>
                    <div class="wa-strip-item">
                        <i class="ri-customer-service-2-line"></i> Lifetime Support
                    </div>
                </div>
            </div>

            <div class="wa-hero__right-content" data-aos="fade-left" data-aos-duration="1000">
                {{-- Mockup Chat --}}
                <div class="wa-hero__mockup-wrapper">
                    <div class="wa-chat-window">
                        <div class="wa-chat-header">
                            <div class="wa-chat-avatar">
                                <i class="ri-customer-service-2-fill"></i>
                                <span class="wa-active-dot"></span>
                            </div>
                            <div class="wa-chat-meta">
                                <h4>TechSeba Auto-Bot</h4>
                                <span>Online | 24/7 Active</span>
                            </div>
                        </div>
                        <div class="wa-chat-body">
                            <div class="wa-msg wa-msg-incoming">
                                <div class="wa-msg-text">
                                    ভাইয়া, আপনাদের মেসেজ অটোমেশন সার্ভিসটির প্রাইস কত?
                                </div>
                                <span class="wa-msg-time">10:02 PM</span>
                            </div>
                            <div class="wa-msg wa-msg-outgoing">
                                <div class="wa-msg-text">
                                    হ্যালো! আমাদের Message & WhatsApp Reply Automation সার্ভিসের বেসিক প্ল্যান শুরু মাত্র ৳১,৯৯৯/মাস থেকে। ⚡
                                </div>
                                <span class="wa-msg-time">10:02 PM <i class="ri-double-check-line"></i></span>
                            </div>
                            <div class="wa-msg wa-msg-outgoing">
                                <div class="wa-msg-text">
                                    আপনি কি আমাদের ফিচারের বিস্তারিত তালিকা ও ডেমো দেখতে চান? নিচের যেকোনো একটি অপশন সিলেক্ট করুন:
                                    <div class="wa-chat-options">
                                        <button onclick="simulateChatResponse('demo')" class="wa-opt-btn">1️⃣ লাইভ ডেমো ভিডিও</button>
                                        <button onclick="simulateChatResponse('price')" class="wa-opt-btn">2️⃣ প্যাকেজ সমূহ</button>
                                        <button onclick="simulateChatResponse('agent')" class="wa-opt-btn">3️⃣ এজেন্টের সাথে কথা বলুন</button>
                                    </div>
                                </div>
                                <span class="wa-msg-time">10:02 PM <i class="ri-double-check-line"></i></span>
                            </div>
                            <div id="interactivePlaceholder"></div>
                        </div>
                        <div class="wa-chat-footer">
                            <input type="text" placeholder="Type a message..." disabled>
                            <button class="wa-send-btn"><i class="ri-send-plane-2-fill"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== FEATURES SECTION ==================== --}}
<section class="wa-section bg-light-sec wa-features" id="features">
    <div class="container">
        <div class="wa-section-head text-center">
            <span class="wa-label">FEATURES</span>
            <h2 class="section-title">এই Service এ যা যা পাবেন</h2>
            <p class="section-sub">আপনার ব্যবসার প্রতিটি মেসেজের সঠিক সময়ে সঠিক রিপ্লাই নিশ্চিত করার সব টুলস এক জায়গায়।</p>
        </div>
        
        <div class="wa-features__grid">
            <!-- Feature 1 -->
            <div class="wa-feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="wa-feature-icon-wrapper">
                    <i class="ri-robot-line wa-feature-icon"></i>
                </div>
                <h4 class="wa-feature-title">Auto Reply Bot</h4>
                <p class="wa-feature-desc">WhatsApp, FB Messenger ও Instagram এ কেউ message করলে সাথে সাথে reply যাবে।</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="wa-feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="wa-feature-icon-wrapper">
                    <i class="ri-git-branch-line wa-feature-icon"></i>
                </div>
                <h4 class="wa-feature-title">Custom Message Flow</h4>
                <p class="wa-feature-desc">Customer কী জিজ্ঞেস করলে কী reply দেবে — সব আপনি ঠিক করে দিতে পারবেন।</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="wa-feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="wa-feature-icon-wrapper">
                    <i class="ri-time-line wa-feature-icon"></i>
                </div>
                <h4 class="wa-feature-title">24/7 Availability</h4>
                <p class="wa-feature-desc">রাত ৩টায় customer message করলেও instant reply। কোনো staff লাগবে না।</p>
            </div>
            
            <!-- Feature 4 -->
            <div class="wa-feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="wa-feature-icon-wrapper">
                    <i class="ri-shopping-bag-3-line wa-feature-icon"></i>
                </div>
                <h4 class="wa-feature-title">Order & Inquiry Handling</h4>
                <p class="wa-feature-desc">Product price জিজ্ঞেস করলে auto price পাঠাবে, order নিতে পারবে।</p>
            </div>
            
            <!-- Feature 5 -->
            <div class="wa-feature-card" data-aos="fade-up" data-aos-delay="500">
                <div class="wa-feature-icon-wrapper">
                    <i class="ri-bar-chart-2-line wa-feature-icon"></i>
                </div>
                <h4 class="wa-feature-title">Message Analytics</h4>
                <p class="wa-feature-desc">কতজন message করেছে, কোন সময়ে বেশি আসে — সব report দেখতে পাবেন।</p>
            </div>
            
            <!-- Feature 6 -->
            <div class="wa-feature-card" data-aos="fade-up" data-aos-delay="600">
                <div class="wa-feature-icon-wrapper">
                    <i class="ri-links-line wa-feature-icon"></i>
                </div>
                <h4 class="wa-feature-title">Multi-Platform Support</h4>
                <p class="wa-feature-desc">WhatsApp Business, Facebook Page, Instagram, Telegram — সব একসাথে।</p>
            </div>
            
            <!-- Feature 7 -->
            <div class="wa-feature-card" data-aos="fade-up" data-aos-delay="700">
                <div class="wa-feature-icon-wrapper">
                    <i class="ri-price-tag-3-line wa-feature-icon"></i>
                </div>
                <h4 class="wa-feature-title">Auto Label / Tag</h4>
                <p class="wa-feature-desc">Customer-দের automatically tag করবে (New Lead, Interested, Paid etc.)</p>
            </div>
            
            <!-- Feature 8 -->
            <div class="wa-feature-card" data-aos="fade-up" data-aos-delay="800">
                <div class="wa-feature-icon-wrapper">
                    <i class="ri-megaphone-line wa-feature-icon"></i>
                </div>
                <h4 class="wa-feature-title">Broadcast Message</h4>
                <p class="wa-feature-desc">একসাথে হাজার customer কে message পাঠানো যাবে (offer, update, reminder)</p>
            </div>
        </div>
    </div>
</section>

{{-- ==================== WHO IS THIS FOR SECTION ==================== --}}
<section class="wa-section bg-light-sec wa-who-for" id="who-for">
    <div class="container">
        <div class="wa-section-head text-center">
            <span class="wa-label">TARGET AUDIENCE</span>
            <h2 class="section-title">কারা এই Service ব্যবহার করবেন?</h2>
            <p class="section-sub">বিভিন্ন ধরনের ব্যবসার মেসেজ ও হোয়াটসঅ্যাপ রিপ্লাই অটোমেশনের উদাহরণ নিচে দেওয়া হলো।</p>
        </div>

        <div class="wa-who-for__grid">
            <!-- Business 1 -->
            <div class="wa-who-card" data-aos="fade-up" data-aos-delay="100">
                <div class="wa-who-icon-wrapper">
                    <i class="ri-shopping-cart-2-line wa-who-icon"></i>
                </div>
                <h4 class="wa-who-title">Online Shop / eCommerce</h4>
                <p class="wa-who-desc">Product price, stock, delivery info auto reply</p>
            </div>

            <!-- Business 2 -->
            <div class="wa-who-card" data-aos="fade-up" data-aos-delay="200">
                <div class="wa-who-icon-wrapper">
                    <i class="ri-heart-pulse-line wa-who-icon"></i>
                </div>
                <h4 class="wa-who-title">Doctor / Clinic</h4>
                <p class="wa-who-desc">Appointment booking, chamber time auto reply</p>
            </div>

            <!-- Business 3 -->
            <div class="wa-who-card" data-aos="fade-up" data-aos-delay="300">
                <div class="wa-who-icon-wrapper">
                    <i class="ri-book-open-line wa-who-icon"></i>
                </div>
                <h4 class="wa-who-title">Coaching Center / School</h4>
                <p class="wa-who-desc">Admission info, class schedule, fees auto reply</p>
            </div>

            <!-- Business 4 -->
            <div class="wa-who-card" data-aos="fade-up" data-aos-delay="400">
                <div class="wa-who-icon-wrapper">
                    <i class="ri-customer-service-2-line wa-who-icon"></i>
                </div>
                <h4 class="wa-who-title">Service Business</h4>
                <p class="wa-who-desc">Quote request, availability, portfolio auto reply</p>
            </div>

            <!-- Business 5 -->
            <div class="wa-who-card" data-aos="fade-up" data-aos-delay="500">
                <div class="wa-who-icon-wrapper">
                    <i class="ri-scissors-line wa-who-icon"></i>
                </div>
                <h4 class="wa-who-title">Beauty Parlour / Salon</h4>
                <p class="wa-who-desc">Booking, price list, available slots auto reply</p>
            </div>

            <!-- Business 6 -->
            <div class="wa-who-card" data-aos="fade-up" data-aos-delay="600">
                <div class="wa-who-icon-wrapper">
                    <i class="ri-restaurant-2-line wa-who-icon"></i>
                </div>
                <h4 class="wa-who-title">Restaurant / Food Business</h4>
                <p class="wa-who-desc">Menu, delivery area, order confirmation</p>
            </div>

            <!-- Business 7 -->
            <div class="wa-who-card" data-aos="fade-up" data-aos-delay="700">
                <div class="wa-who-icon-wrapper">
                    <i class="ri-terminal-box-line wa-who-icon"></i>
                </div>
                <h4 class="wa-who-title">Freelancer / Agency</h4>
                <p class="wa-who-desc">Service info, portfolio, pricing auto reply</p>
            </div>

            <!-- Business 8 -->
            <div class="wa-who-card" data-aos="fade-up" data-aos-delay="800">
                <div class="wa-who-icon-wrapper">
                    <i class="ri-home-8-line wa-who-icon"></i>
                </div>
                <h4 class="wa-who-title">Real Estate</h4>
                <p class="wa-who-desc">Property info, site visit booking, price auto reply</p>
            </div>
        </div>
    </div>
</section>

{{-- ==================== HOW IT WORKS ==================== --}}
<section class="wa-section bg-light-sec wa-timeline" id="workflow">
    <div class="container">
        <div class="wa-section-head text-center">
            <span class="wa-label">HOW IT WORKS</span>
            <h2 class="section-title">কীভাবে কাজ করে?</h2>
            <p class="section-sub">খুবই সহজ ৪টি ধাপে আমরা আপনার ব্যবসার সম্পূর্ণ অটোমেশন সেটআপ সম্পন্ন করি।</p>
        </div>

        <div class="wa-timeline-container">
            <div class="wa-timeline-line"></div>
            <div class="wa-timeline-grid" data-aos="fade-up" data-aos-duration="1000">
                <!-- Step 1 -->
                <div class="wa-timeline-item">
                    <div class="wa-timeline-icon">
                        <i class="ri-clipboard-line"></i>
                    </div>
                    <div class="wa-timeline-step">Step 1</div>
                    <h4 class="wa-timeline-title">আপনি Order করুন (Day 1)</h4>
                    <p class="wa-timeline-desc">আমরা আপনার business বুঝি এবং requirement নিই</p>
                </div>
                <!-- Step 2 -->
                <div class="wa-timeline-item">
                    <div class="wa-timeline-icon">
                        <i class="ri-settings-3-line"></i>
                    </div>
                    <div class="wa-timeline-step">Step 2</div>
                    <h4 class="wa-timeline-title">Setup & Configuration (Day 1-2)</h4>
                    <p class="wa-timeline-desc">আপনার WhatsApp/Page এ bot connect করা হয়</p>
                </div>
                <!-- Step 3 -->
                <div class="wa-timeline-item">
                    <div class="wa-timeline-icon">
                        <i class="ri-git-merge-line"></i>
                    </div>
                    <div class="wa-timeline-step">Step 3</div>
                    <h4 class="wa-timeline-title">Custom Flow তৈরি (Day 2-3)</h4>
                    <p class="wa-timeline-desc">আপনার reply templates এবং flow design করা হয়</p>
                </div>
                <!-- Step 4 -->
                <div class="wa-timeline-item">
                    <div class="wa-timeline-icon">
                        <i class="ri-rocket-line"></i>
                    </div>
                    <div class="wa-timeline-step">Step 4</div>
                    <h4 class="wa-timeline-title">Live & Test করুন (Day 3-4)</h4>
                    <p class="wa-timeline-desc">System चालू করে test করা হয় এবং আপনাকে training দেওয়া হয়</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== PRICING SECTION ==================== --}}
<section class="wa-section bg-light-sec wa-pricing" id="pricing">
    <div class="container">
        <div class="wa-section-head text-center">
            <span class="wa-label">PRICING PLANS</span>
            <h2 class="section-title">আমাদের Package সমূহ</h2>
            <p class="section-sub">আপনার ব্যবসার ধরন ও প্রয়োজন অনুযায়ী যেকোনো একটি প্যাকেজ বেছে নিন।</p>
        </div>

        <div class="wa-pricing__grid">
            <!-- Starter Plan -->
            <div class="wa-pricing-card" data-aos="fade-up" data-aos-delay="100">
                <div class="pricing-plan">STARTER</div>
                <div class="pricing-price">৳১,৯৯৯<span>/মাস</span></div>
                <p class="pricing-desc">ছোট বা নতুন ব্যবসার দ্রুত স্টার্ট করার জন্য।</p>
                <ul class="pricing-features">
                    <li>1 Platform (WhatsApp OR FB Page)</li>
                    <li>Up to 500 messages/month</li>
                    <li>5 Custom Reply Templates</li>
                    <li>Basic Auto Reply Flow</li>
                    <li>Setup within 48 hours</li>
                    <li class="wa-feature-disabled">Analytics</li>
                    <li class="wa-feature-disabled">Broadcast Message</li>
                    <li class="wa-feature-disabled">Multi-platform</li>
                </ul>
                <a href="https://wa.me/8801898828248?text=Hello%20TechSeba,%20I%20want%20to%20order%20the%20STARTER%20Automation%20Package" target="_blank" rel="noopener noreferrer" class="btn-outline">Order Now</a>
            </div>

            <!-- Standard Plan (Highlighted / Most Popular) -->
            <div class="wa-pricing-card featured" data-aos="fade-up" data-aos-delay="200">
                <div class="pricing-plan">STANDARD</div>
                <div class="pricing-price">৳৩,৯৯৯<span>/মাস</span></div>
                <p class="pricing-desc">মাঝারি ই-কমার্স ও ক্রমবর্ধমান ব্যবসার জন্য সেরা সলিউশন।</p>
                <ul class="pricing-features">
                    <li>3 Platforms (WhatsApp + FB + Instagram)</li>
                    <li>Up to 3,000 messages/month</li>
                    <li>20 Custom Reply Templates</li>
                    <li>Advanced Flow (keyword-based reply)</li>
                    <li>Basic Analytics Dashboard</li>
                    <li>Broadcast to 500 contacts</li>
                    <li>Setup within 24 hours</li>
                    <li>1 month free support</li>
                    <li class="wa-feature-disabled">CRM Integration</li>
                </ul>
                <a href="https://wa.me/8801898828248?text=Hello%20TechSeba,%20I%20want%20to%20order%20the%20STANDARD%20Automation%20Package" target="_blank" rel="noopener noreferrer" class="btn-filled">Order Now</a>
            </div>

            <!-- Custom / Enterprise Plan -->
            <div class="wa-pricing-card" data-aos="fade-up" data-aos-delay="300">
                <div class="pricing-plan">CUSTOM / ENTERPRISE</div>
                <div class="pricing-price">Custom Price</div>
                <p class="pricing-desc">সম্পূর্ণ কাস্টম এআই ইন্টিগ্রেশন ও বড় ব্র্যান্ডের জন্য।</p>
                <ul class="pricing-features">
                    <li>Unlimited Platforms</li>
                    <li>Unlimited Messages</li>
                    <li>AI-powered Smart Reply</li>
                    <li>CRM & Google Sheet Integration</li>
                    <li>Full Analytics + Report</li>
                    <li>Unlimited Broadcast</li>
                    <li>Dedicated Account Manager</li>
                    <li>Priority Support 24/7</li>
                </ul>
                <a href="https://wa.me/8801898828248?text=Hello%20TechSeba,%20I%20want%20to%20discuss%20the%20CUSTOM/ENTERPRISE%20Automation%20Package" target="_blank" rel="noopener noreferrer" class="btn-outline">Order Now</a>
            </div>
        </div>

        <!-- Payment Note -->
        <div class="wa-pricing-payment-note text-center mt-5" data-aos="fade-up">
            <div class="payment-badge-wrapper d-inline-flex align-items-center gap-2">
                <i class="ri-shield-check-fill text-success"></i>
                <span style="color: var(--text-dark-body) !important;">সব payment <strong>bKash / Nagad / Bank Transfer</strong> এ করা যাবে</span>
            </div>
        </div>
    </div>
</section>

{{-- ==================== FAQ SECTION ==================== --}}
<section class="wa-section bg-light-sec wa-faq" id="faq">
    <div class="container">
        <div class="wa-section-head text-center">
            <span class="wa-label">FAQ</span>
            <h2 class="section-title">সাধারণ প্রশ্নসমূহ</h2>
            <p class="section-sub">মেসেজ অটোমেশন ও চ্যাটবট সম্পর্কে সচরাচর জিজ্ঞাসিত প্রশ্নের উত্তরগুলো জেনে নিন।</p>
        </div>

        <div class="wa-faq-wrapper">
            <!-- FAQ 1 -->
            <div class="swd-faq-item swd-faq-item--open">
                <button class="swd-faq-item__q" onclick="this.parentElement.classList.toggle('swd-faq-item--open')">
                    <span>WhatsApp number কি ban হওয়ার risk আছে?</span>
                    <i class="ri-add-line swd-faq-item__plus"></i>
                    <i class="ri-subtract-line swd-faq-item__minus"></i>
                </button>
                <div class="swd-faq-item__a">
                    <p>না, আমরা WhatsApp Business API ব্যবহার করি যা সম্পূর্ণ official ও safe।</p>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="swd-faq-item">
                <button class="swd-faq-item__q" onclick="this.parentElement.classList.toggle('swd-faq-item--open')">
                    <span>আমি নিজে কি reply flow edit করতে পারবো?</span>
                    <i class="ri-add-line swd-faq-item__plus"></i>
                    <i class="ri-subtract-line swd-faq-item__minus"></i>
                </button>
                <div class="swd-faq-item__a">
                    <p>হ্যাঁ, আমরা আপনাকে ট্রেনিং দেবো এবং একটি simple dashboard দেবো।</p>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="swd-faq-item">
                <button class="swd-faq-item__q" onclick="this.parentElement.classList.toggle('swd-faq-item--open')">
                    <span>Monthly subscription cancel করা যাবে?</span>
                    <i class="ri-add-line swd-faq-item__plus"></i>
                    <i class="ri-subtract-line swd-faq-item__minus"></i>
                </button>
                <div class="swd-faq-item__a">
                    <p>হ্যাঁ, যেকোনো সময় cancel করা যাবে। কোনো lock-in নেই।</p>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="swd-faq-item">
                <button class="swd-faq-item__q" onclick="this.parentElement.classList.toggle('swd-faq-item--open')">
                    <span>Facebook Page ও Instagram কি একসাথে হবে?</span>
                    <i class="ri-add-line swd-faq-item__plus"></i>
                    <i class="ri-subtract-line swd-faq-item__minus"></i>
                </button>
                <div class="swd-faq-item__a">
                    <p>হ্যাঁ, Standard ও Custom package এ সব platform একসাথে।</p>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="swd-faq-item">
                <button class="swd-faq-item__q" onclick="this.parentElement.classList.toggle('swd-faq-item--open')">
                    <span>কতদিনে setup হবে?</span>
                    <i class="ri-add-line swd-faq-item__plus"></i>
                    <i class="ri-subtract-line swd-faq-item__minus"></i>
                </button>
                <div class="swd-faq-item__a">
                    <p>সাধারণত ২৪-৪৮ ঘণ্টার মধ্যে আপনার automation live হয়ে যায়।</p>
                </div>
            </div>

            <!-- FAQ 6 -->
            <div class="swd-faq-item">
                <button class="swd-faq-item__q" onclick="this.parentElement.classList.toggle('swd-faq-item--open')">
                    <span>আমার product list কি bot জানবে?</span>
                    <i class="ri-add-line swd-faq-item__plus"></i>
                    <i class="ri-subtract-line swd-faq-item__minus"></i>
                </button>
                <div class="swd-faq-item__a">
                    <p>হ্যাঁ, আপনার product/service list আমরা bot এ add করে দেবো।</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== FINAL CTA SECTION ==================== --}}
<section class="wa-section wa-cta">
    <div class="container">
        <div class="wa-cta__box" data-aos="zoom-in" data-aos-duration="800">
            <h2 class="wa-cta__title">আজই শুরু করুন — প্রথম মাস ৫০% ছাড়!</h2>
            <p class="wa-cta__desc">এখনই WhatsApp করুন, ৩০ মিনিটের মধ্যে আমরা reply দেবো</p>
            <div class="wa-cta-buttons mb-4">
                <a href="https://wa.me/8801898828248?text=Hello%20TechSeba,%20I%20want%20to%20get%20started%20with%20WhatsApp%20Automation%20Service%20(50%25%20Discount%20Offer)" target="_blank" rel="noopener noreferrer" class="btn-primary">
                    WhatsApp এ Message করুন <i class="ri-whatsapp-line"></i>
                </a>
            </div>
            <div class="wa-cta-social-proof">
                <div class="stars mb-1" style="color: #fbbf24; font-size: 16px;">
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                </div>
                <span class="proof-text text-white opacity-75" style="font-size: 14px;">150+ satisfied clients in Bangladesh</span>
            </div>
        </div>
    </div>
</section>

{{-- Sticky Bottom Mobile Bar --}}
<div class="wa-sticky-mobile-bar">
    <a href="https://wa.me/8801898828248?text=Hello%20TechSeba,%20I%20want%20to%20know%20more%20about%20your%20WhatsApp%20Automation%20Service" target="_blank" rel="noopener noreferrer" class="btn-wa-sticky-mobile">
        <i class="ri-whatsapp-line"></i> 💬 WhatsApp এ কথা বলুন
    </a>
</div>

{{-- Scripts --}}
<script>
    // Simulate chat in Hero mockup
    function simulateChatResponse(type) {
        const placeholder = document.getElementById('interactivePlaceholder');
        let responseHTML = '';
        
        // Remove previous simulated messages
        const oldMsg = document.querySelectorAll('.wa-simulated-msg');
        oldMsg.forEach(el => el.remove());
        
        if (type === 'demo') {
            responseHTML = `
                <div class="wa-msg wa-msg-incoming wa-simulated-msg">
                    <div class="wa-msg-text">1️⃣ লাইভ ডেমো ভিডিও</div>
                    <span class="wa-msg-time">Just now</span>
                </div>
                <div class="wa-msg wa-msg-outgoing wa-simulated-msg">
                    <div class="wa-msg-text">অবশ্যই! আমাদের লাইভ ডেমো ভিডিও দেখতে এখানে ক্লিক করুন: <a href="https://wa.me/8801898828248" target="_blank" rel="noopener noreferrer" style="color: var(--accent); text-decoration: underline;">Demo Video Link</a> 🎥</div>
                    <span class="wa-msg-time">Just now <i class="ri-double-check-line"></i></span>
                </div>
            `;
        } else if (type === 'price') {
            responseHTML = `
                <div class="wa-msg wa-msg-incoming wa-simulated-msg">
                    <div class="wa-msg-text">2️⃣ প্যাকেজ সমূহ</div>
                    <span class="wa-msg-time">Just now</span>
                </div>
                <div class="wa-msg wa-msg-outgoing wa-simulated-msg">
                    <div class="wa-msg-text">আমাদের ৩টি মূল প্যাকেজ রয়েছে:<br>• Starter: ৳১,৯৯৯/মাস<br>• Standard: ৳৩,৯৯৯/মাস<br>• Custom: কাস্টম এআই সলিউশন।<br><br>বিস্তারিত জানতে নিচে স্ক্রোল করুন বা <a href="#pricing" style="color: var(--accent); text-decoration: underline;">এখানে ক্লিক করুন</a>। 💳</div>
                    <span class="wa-msg-time">Just now <i class="ri-double-check-line"></i></span>
                </div>
            `;
        } else if (type === 'agent') {
            responseHTML = `
                <div class="wa-msg wa-msg-incoming wa-simulated-msg">
                    <div class="wa-msg-text">3️⃣ এজেন্টের সাথে কথা বলুন</div>
                    <span class="wa-msg-time">Just now</span>
                </div>
                <div class="wa-msg wa-msg-outgoing wa-simulated-msg">
                    <div class="wa-msg-text">আপনার রিকোয়েস্টটি আমাদের সাপোর্ট সেন্টারে পাঠানো হয়েছে। আমাদের একজন কাস্টমার রিপ্রেজেন্টেティブ খুব শীঘ্রই আপনার সাথে যোগাযোগ করবেন। অথবা সরাসরি কথা বলতে হোয়াটসঅ্যাপ লিংকে ক্লিক করুন। 📞</div>
                    <span class="wa-msg-time">Just now <i class="ri-double-check-line"></i></span>
                </div>
            `;
        }
        
        placeholder.insertAdjacentHTML('beforebegin', responseHTML);
        
        // Auto scroll to bottom of chat body
        const chatBody = document.querySelector('.wa-chat-body');
        chatBody.scrollTop = chatBody.scrollHeight;
    }
</script>
@endsection

@push('style_section')
<style>
    /* ==========================================
       WA - MESSAGE & WHATSAPP REPLY AUTOMATION
    ========================================== */
    :root {
        --wa-brand: #25D366;
        --wa-brand-dark: #128C7E;
        --wa-brand-light: #dcf8c6;
        --bg-light-sec: #f8f9ff;
        --bg-card-white: #ffffff;
        --text-dark-heading: #0f172a;
        --text-dark-body: #475569;
        --text-dark-muted: #64748b;
        --border-light: rgba(0, 0, 0, 0.06);
        --shadow-subtle: 0 10px 30px rgba(0, 0, 0, 0.03);
        --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.07);
    }

    /* Light Theme Section Overrides to ensure dark text on light backgrounds */
    .bg-light-sec {
        background: var(--bg-light-sec) !important;
        color: var(--text-dark-body) !important;
    }
    .bg-light-sec .section-title {
        color: var(--text-dark-heading) !important;
    }
    .bg-light-sec .section-sub {
        color: var(--text-dark-muted) !important;
    }
    .bg-light-sec .wa-label {
        color: var(--accent2) !important;
    }

    /* Hero Section */
    .wa-hero {
        position: relative;
        padding: 140px 0 110px;
        background: var(--bg2);
        border-bottom: 1px solid var(--border);
        overflow: hidden;
        color: var(--text);
    }
    .wa-hero__mesh {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 80% 20%, rgba(0, 212, 255, 0.06) 0%, transparent 50%),
                    radial-gradient(circle at 20% 80%, rgba(123, 79, 255, 0.04) 0%, transparent 50%);
        z-index: 1;
        pointer-events: none;
    }
    .wa-hero .container {
        position: relative;
        z-index: 2;
    }
    .wa-hero__grid-wrapper {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 50px;
        align-items: center;
    }
    .wa-hero__badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(0, 212, 255, 0.08);
        border: 1px solid rgba(0, 212, 255, 0.2);
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 12px;
        color: var(--accent);
        font-weight: 600;
        margin-bottom: 24px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .wa-hero__title {
        font-size: clamp(32px, 4.5vw, 52px);
        font-weight: 700;
        line-height: 1.25;
        letter-spacing: -1px;
        margin-bottom: 20px;
        color: var(--text) !important;
    }
    .text-gradient {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent2) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .wa-hero__actions {
        display: flex;
        gap: 16px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }
    
    /* Hero Badge strip */
    .wa-hero__badge-strip {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        border-top: 1px solid var(--border);
        padding-top: 25px;
    }
    .wa-strip-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 500;
        color: var(--muted);
    }
    .wa-strip-item i {
        color: var(--accent);
        font-size: 16px;
    }

    /* Mockup Chat Box Styling */
    .wa-hero__mockup-wrapper {
        position: relative;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border);
        padding: 12px;
        border-radius: 24px;
        backdrop-filter: blur(10px);
    }
    .wa-chat-window {
        background: #0b141a;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 480px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.4);
    }
    .wa-chat-header {
        background: #1f2c34;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .wa-chat-avatar {
        width: 40px;
        height: 40px;
        background: var(--accent2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #ffffff;
        position: relative;
    }
    .wa-active-dot {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #25d366;
        border: 2px solid #1f2c34;
        border-radius: 50%;
        bottom: 0;
        right: 0;
    }
    .wa-chat-meta h4 {
        font-size: 14.5px;
        font-weight: 700;
        color: #ffffff !important;
        margin: 0;
    }
    .wa-chat-meta span {
        font-size: 11px;
        color: #8696a0;
    }
    .wa-chat-body {
        flex: 1;
        padding: 16px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');
        background-blend-mode: overlay;
        background-color: #0b141a;
    }
    .wa-msg {
        max-width: 80%;
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 13.5px;
        line-height: 1.45;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .wa-msg-incoming {
        align-self: flex-start;
        background: #202c33;
        color: #e9edef;
    }
    .wa-msg-outgoing {
        align-self: flex-end;
        background: #005c4b;
        color: #e9edef;
    }
    .wa-msg-time {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.45);
        align-self: flex-end;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .wa-msg-time i {
        color: #53bdeb;
        font-size: 12px;
    }
    .wa-chat-options {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 10px;
        width: 100%;
    }
    .wa-opt-btn {
        background: #111b21;
        color: #e9edef;
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12px;
        text-align: left;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .wa-opt-btn:hover {
        background: #1f2c34;
        border-color: var(--accent);
    }
    .wa-chat-footer {
        background: #1f2c34;
        padding: 10px 16px;
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .wa-chat-footer input {
        flex: 1;
        background: #2a3942;
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 13.5px;
        color: #ffffff;
    }
    .wa-send-btn {
        background: transparent;
        border: none;
        color: #8696a0;
        font-size: 20px;
        cursor: pointer;
    }

    /* Sections general styles */
    .wa-section {
        padding: 100px 0;
    }
    .wa-section-head {
        margin-bottom: 60px;
    }
    .wa-label {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        color: var(--accent) !important;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }
    .section-title {
        font-size: clamp(28px, 4vw, 44px);
        font-weight: 700;
        letter-spacing: -0.5px;
        margin-bottom: 16px;
    }
    .section-sub {
        font-size: 16px;
        line-height: 1.6;
        max-width: 560px;
        margin: 0 auto;
    }

    /* Card design system: white cards with subtle shadow, rounded corners */
    .wa-feature-card, .wa-who-card, .wa-pricing-card, .swd-faq-item {
        background: var(--bg-card-white) !important;
        border: 1px solid var(--border-light) !important;
        border-radius: 16px !important;
        padding: 36px 30px !important;
        box-shadow: var(--shadow-subtle) !important;
        transition: all 0.3s ease !important;
        position: relative;
    }
    .wa-feature-card:hover, .wa-who-card:hover, .wa-pricing-card:hover {
        transform: translateY(-5px) !important;
        box-shadow: var(--shadow-hover) !important;
        border-color: rgba(0, 212, 255, 0.2) !important;
    }

    /* Card outline-style icon wrapper */
    .wa-feature-icon-wrapper, .wa-who-icon-wrapper, .wa-timeline-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: rgba(0, 212, 255, 0.06);
        border: 1px solid rgba(0, 212, 255, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--accent) !important;
        margin-bottom: 24px;
    }
    .wa-feature-icon-wrapper i, .wa-who-icon-wrapper i, .wa-timeline-icon i {
        color: var(--accent) !important;
    }

    /* Features Grid */
    .wa-features__grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .wa-feature-title, .wa-who-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 14px;
        color: var(--text-dark-heading) !important;
    }
    .wa-feature-desc, .wa-who-desc {
        font-size: 14px;
        color: var(--text-dark-body) !important;
        line-height: 1.6;
        margin: 0;
    }

    /* Who Is This For 4-column Grid */
    .wa-who-for__grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    .wa-who-card {
        padding: 28px !important;
    }

    /* How It Works horizontal Step Timeline */
    .wa-timeline-container {
        position: relative;
        margin-top: 50px;
    }
    .wa-timeline-line {
        position: absolute;
        top: 26px;
        left: 0;
        right: 0;
        height: 2px;
        background: rgba(0, 212, 255, 0.15);
        z-index: 1;
    }
    .wa-timeline-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        position: relative;
        z-index: 2;
    }
    .wa-timeline-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .wa-timeline-icon {
        margin-bottom: 16px;
        background: var(--bg-card-white);
        z-index: 5;
    }
    .wa-timeline-step {
        font-size: 11px;
        font-weight: 700;
        color: var(--accent2);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }
    .wa-timeline-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark-heading) !important;
        margin-bottom: 10px;
    }
    .wa-timeline-desc {
        font-size: 13.5px;
        color: var(--text-dark-body) !important;
        line-height: 1.5;
        margin: 0;
    }

    /* Pricing 3-column Grid */
    .wa-pricing__grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        align-items: start;
    }
    .wa-pricing-card {
        padding: 40px 30px !important;
    }
    .pricing-plan {
        font-size: 12px;
        color: var(--accent2) !important;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .pricing-price {
        font-family: 'Space Grotesk', sans-serif !important;
        font-size: 40px;
        font-weight: 700;
        margin-bottom: 6px;
        color: var(--text-dark-heading) !important;
    }
    .pricing-price span {
        font-size: 15px;
        color: var(--text-dark-muted);
        font-weight: 400;
    }
    .pricing-desc {
        font-size: 13.5px;
        color: var(--text-dark-muted) !important;
        margin-bottom: 28px;
        line-height: 1.5;
    }
    .pricing-features {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 32px;
        padding-left: 0;
    }
    .pricing-features li {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14.5px;
        color: var(--text-dark-body) !important;
    }
    .pricing-features li::before {
        content: '✓';
        color: var(--accent);
        font-weight: 700;
        width: 18px;
    }
    .pricing-features li.wa-feature-disabled {
        color: var(--text-dark-muted) !important;
        opacity: 0.65;
    }
    .pricing-features li.wa-feature-disabled::before {
        content: '✗';
        color: var(--text-dark-muted);
    }
    .btn-outline {
        display: block;
        text-align: center;
        border: 1px solid var(--accent);
        color: var(--accent) !important;
        padding: 12px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-outline:hover {
        background: var(--accent);
        color: #0A0F1E !important;
    }
    .btn-filled {
        display: block;
        text-align: center;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        color: #ffffff !important;
        padding: 12px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
        border: none;
    }
    .btn-filled:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    .wa-pricing-card.featured {
        border-color: var(--accent) !important;
        background: linear-gradient(145deg, #ffffff 0%, rgba(0, 212, 255, 0.03) 100%) !important;
        box-shadow: 0 20px 40px rgba(0, 212, 255, 0.08) !important;
    }
    .wa-pricing-card.featured::before {
        content: 'Most Popular';
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        color: #ffffff;
        font-size: 10px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 100px;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    /* FAQ accordion styles mapping to .swd-faq-item */
    .wa-faq-wrapper {
        max-width: 780px;
        margin: 0 auto;
    }
    .swd-faq-item {
        padding: 0 !important;
        margin-bottom: 16px !important;
        overflow: hidden;
        border-radius: 12px !important;
    }
    .swd-faq-item__q {
        width: 100%;
        background: transparent;
        border: none;
        padding: 20px 24px;
        text-align: left;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark-heading) !important;
        cursor: pointer;
    }
    .swd-faq-item__plus {
        display: inline-block;
        color: var(--accent);
    }
    .swd-faq-item__minus {
        display: none;
        color: var(--accent2);
    }
    .swd-faq-item__a {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }
    .swd-faq-item__a p {
        padding: 0 24px 20px;
        margin: 0;
        font-size: 14px;
        color: var(--text-dark-body) !important;
        line-height: 1.6;
    }
    .swd-faq-item--open {
        border-color: rgba(0, 212, 255, 0.3) !important;
        box-shadow: var(--shadow-hover) !important;
    }
    .swd-faq-item--open .swd-faq-item__plus {
        display: none;
    }
    .swd-faq-item--open .swd-faq-item__minus {
        display: inline-block;
    }
    .swd-faq-item--open .swd-faq-item__a {
        max-height: 200px;
    }

    /* Final CTA Section */
    .wa-cta {
        background: var(--bg);
    }
    .wa-cta__box {
        background: linear-gradient(135deg, rgba(0, 212, 255, 0.08) 0%, rgba(123, 79, 255, 0.08) 100%) !important;
        border: 1px solid var(--border) !important;
        border-radius: 24px !important;
        padding: 60px 80px !important;
        text-align: center !important;
        position: relative;
        overflow: hidden;
    }
    .wa-cta__box::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(0, 212, 255, 0.04) 0%, transparent 60%);
        pointer-events: none;
    }
    .wa-cta__title {
        font-size: clamp(24px, 3.5vw, 38px) !important;
        font-weight: 800 !important;
        color: #ffffff !important;
        margin-bottom: 16px !important;
        line-height: 1.3;
    }
    .wa-cta__desc {
        color: var(--muted) !important;
        font-size: 16.5px !important;
        margin-bottom: 30px !important;
    }

    /* Sticky Bottom Mobile Bar */
    .wa-sticky-mobile-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(10, 15, 30, 0.9);
        border-top: 1px solid var(--border);
        padding: 14px 20px;
        box-shadow: 0 -8px 24px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
        z-index: 9999;
        display: none;
    }
    .btn-wa-sticky-mobile {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #25d366;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 15px;
        padding: 12px 20px;
        border-radius: 10px;
        text-decoration: none;
        text-align: center;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.2);
        transition: all 0.2s ease;
    }
    .btn-wa-sticky-mobile i {
        font-size: 20px;
    }
    .btn-wa-sticky-mobile:hover {
        background: #20ba5a;
        box-shadow: 0 6px 16px rgba(37, 211, 102, 0.3);
    }
    .btn-wa-sticky-mobile:active {
        transform: scale(0.98);
    }

    /* Interactive Mockup Chat specific styles (Hero) */
    .p-msg {
        max-width: 80%;
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 13px;
        line-height: 1.5;
        margin-bottom: 12px;
        animation: fadeInMsg 0.3s ease-out forwards;
    }
    @keyframes fadeInMsg {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .p-msg-bot {
        align-self: flex-start;
        background: #202c33;
        color: #e9edef;
    }
    .p-msg-user {
        align-self: flex-end;
        background: #005c4b;
        color: #e9edef;
    }
    .p-reply-btn {
        background: rgba(255, 255, 255, 0.05);
        color: var(--accent);
        border: 1px solid rgba(0, 212, 255, 0.2);
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12px;
        text-align: left;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .p-reply-btn:hover {
        background: rgba(0, 212, 255, 0.08);
        border-color: var(--accent);
    }

    /* ==========================================
       RESPONSIVE DESIGN RULES
    ========================================== */
    @media (max-width: 1024px) {
        .wa-features__grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .wa-who-for__grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .wa-pricing__grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .wa-timeline-line {
            display: none;
        }
        .wa-timeline-grid {
            grid-template-columns: 1fr;
            gap: 36px;
        }
        .wa-timeline-item {
            align-items: flex-start;
            text-align: left;
            padding-left: 86px;
            position: relative;
        }
        .wa-timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            margin-bottom: 0;
        }
    }

    @media (max-width: 768px) {
        .wa-hero {
            padding: 90px 0 70px;
            text-align: center;
        }
        .wa-hero__grid-wrapper {
            grid-template-columns: 1fr;
            gap: 36px;
        }
        .wa-hero__actions {
            margin-bottom: 35px;
            justify-content: center;
        }
        .wa-hero__badge-strip {
            max-width: 480px;
            margin: 0 auto;
        }
        .wa-section {
            padding: 70px 0;
        }
        .wa-features__grid {
            grid-template-columns: 1fr;
        }
        .wa-pricing__grid {
            grid-template-columns: 1fr;
            max-width: 460px;
            margin: 0 auto;
        }
        .wa-cta__box {
            padding: 45px 24px !important;
        }
    }

    @media (max-width: 767px) {
        .wa-sticky-mobile-bar {
            display: block;
        }
        body {
            padding-bottom: 80px !important;
        }
    }

    @media (max-width: 576px) {
        .wa-who-for__grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
        }
        .wa-who-card {
            padding: 20px 12px !important;
            border-radius: 12px !important;
        }
        .wa-who-icon-wrapper {
            width: 46px;
            height: 46px;
            font-size: 20px;
            margin-bottom: 12px;
        }
        .wa-who-title {
            font-size: 13.5px !important;
            margin-bottom: 6px;
        }
        .wa-who-desc {
            font-size: 11px !important;
            line-height: 1.5;
        }
        .wa-timeline-item {
            padding-left: 70px;
        }
        .wa-timeline-icon {
            width: 54px;
            height: 54px;
            font-size: 20px;
        }
    }

    @media (max-width: 480px) {
        .wa-hero__actions {
            flex-direction: column;
            align-items: stretch;
            max-width: 280px;
            margin-left: auto;
            margin-right: auto;
        }
        .wa-hero__actions .btn-primary,
        .wa-hero__actions .btn-ghost {
            width: 100%;
            text-align: center;
            justify-content: center;
        }
        .wa-hero__badge-strip {
            grid-template-columns: 1fr;
            align-items: flex-start;
            gap: 12px;
        }
    }
</style>
@endpush
