<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - TechSeba Portfolio Demo</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Remix Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
    <!-- Lottie Files Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    
    <style>
        :root {
            --primary: @yield('primary-color', '#2563eb');
            --primary-rgb: @yield('primary-rgb', '37, 99, 235');
            --bg: @yield('bg-color', '#0f172a');
            --card: @yield('card-color', '#1e293b');
            --text: #f8fafc;
            --muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.08);
            --glow: rgba(@yield('primary-rgb', '37, 99, 235'), 0.15);
        }

        /* Timeline Styles */
        .timeline-container {
            position: relative;
            padding-left: 32px;
            border-left: 2px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 40px;
            margin-top: 30px;
        }
        .timeline-item {
            position: relative;
        }
        .timeline-dot {
            position: absolute;
            left: -42px;
            top: 4px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--primary);
            border: 4px solid var(--bg);
            box-shadow: 0 0 10px var(--glow);
        }
        .timeline-date {
            font-size: 13px;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 6px;
        }
        .timeline-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .timeline-desc {
            color: var(--muted);
            font-size: 14.5px;
        }

        /* FAQ Accordion Styles */
        .faq-item {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 16px;
            overflow: hidden;
            transition: all 0.3s;
        }
        .faq-question {
            padding: 20px 24px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }
        .faq-answer {
            padding: 0 24px 20px;
            color: var(--muted);
            font-size: 14.5px;
            line-height: 1.6;
            display: none;
        }
        .faq-item.active .faq-answer {
            display: block;
        }
        .faq-item.active {
            border-color: rgba(var(--primary-rgb), 0.3);
            box-shadow: 0 10px 20px var(--glow);
        }
        .faq-icon {
            transition: transform 0.3s;
        }
        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            background: rgba(var(--primary-rgb), 0.1);
            color: var(--primary);
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }

        /* Gallery / Project Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }
        .gallery-item {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s;
        }
        .gallery-item:hover {
            transform: translateY(-5px);
            border-color: rgba(var(--primary-rgb), 0.3);
            box-shadow: 0 20px 40px var(--glow);
        }
        .gallery-img-wrapper {
            position: relative;
            height: 200px;
            background: rgba(255,255,255,0.02);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .gallery-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .gallery-item:hover .gallery-img-wrapper img {
            transform: scale(1.05);
        }
        .gallery-content {
            padding: 30px;
        }
        .gallery-tag {
            font-size: 12px;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .gallery-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
        }
        .gallery-desc {
            color: var(--muted);
            font-size: 14.5px;
            line-height: 1.6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* --- Header / Nav --- */
        header {
            padding: 20px 0;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            z-index: 100;
        }
        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-weight: 800;
            font-size: 20px;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .logo span {
            color: var(--primary);
        }
        .nav-links {
            display: flex;
            gap: 24px;
            list-style: none;
            align-items: center;
        }
        .nav-links a {
            color: var(--muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: var(--primary);
        }
        .btn-cta {
            background: var(--primary);
            color: #fff !important;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600 !important;
            box-shadow: 0 4px 15px var(--glow);
            transition: all 0.3s;
        }
        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px var(--glow);
        }

        /* --- TechSeba Demo Bar --- */
        .techseba-bar {
            background: linear-gradient(90deg, #1e1b4b 0%, #311042 100%);
            padding: 12px 0;
            text-align: center;
            font-size: 13.5px;
            color: #f1f5f9;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            position: relative;
            z-index: 200;
        }
        .techseba-bar a {
            color: #38bdf8;
            font-weight: 700;
            text-decoration: none;
            margin-left: 8px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .techseba-bar a:hover {
            text-decoration: underline;
        }

        /* --- Sections --- */
        section {
            padding: 80px 0;
        }
        .section-title {
            font-size: 32px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }
        .section-desc {
            text-align: center;
            color: var(--muted);
            max-width: 600px;
            margin: 0 auto 50px;
            font-size: 15px;
        }

        /* --- Hero --- */
        .hero {
            padding: 100px 0 80px;
            position: relative;
        }
        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 60px;
            align-items: center;
        }
        .hero-title {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }
        .hero-title span {
            color: var(--primary);
        }
        .hero-desc {
            font-size: 16px;
            color: var(--muted);
            margin-bottom: 30px;
            line-height: 1.7;
        }
        .hero-buttons {
            display: flex;
            gap: 16px;
        }
        .hero-img-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 320px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            font-size: 64px;
            color: var(--primary);
        }

        /* --- Grid layouts --- */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 30px;
            transition: all 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            border-color: rgba(var(--primary-rgb), 0.3);
            box-shadow: 0 15px 30px var(--glow);
        }
        .card-icon {
            font-size: 32px;
            color: var(--primary);
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .card-desc {
            color: var(--muted);
            font-size: 14.5px;
            line-height: 1.6;
        }

        /* --- Testimonials --- */
        .testimonial-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 30px;
            position: relative;
        }
        .quote-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 40px;
            color: rgba(var(--primary-rgb), 0.1);
        }
        .testimonial-text {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
            font-style: italic;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            font-size: 14px;
        }
        .user-details h5 {
            font-size: 14.5px;
            font-weight: 600;
        }
        .user-details span {
            font-size: 12px;
            color: var(--muted);
        }

        /* --- Footer --- */
        footer {
            padding: 40px 0;
            border-top: 1px solid var(--border);
            text-align: center;
            color: var(--muted);
            font-size: 14px;
        }

        /* --- Modal (General Simple Booking Form) --- */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.85);
            backdrop-filter: blur(8px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal-content {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            max-width: 480px;
            width: 100%;
            padding: 40px;
            position: relative;
            box-shadow: 0 30px 60px rgba(0,0,0,0.6);
        }
        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            color: var(--muted);
            font-size: 24px;
            cursor: pointer;
        }
        .modal-close:hover {
            color: #fff;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 13.5px;
            color: var(--muted);
            margin-bottom: 8px;
            font-weight: 500;
        }
        .form-control {
            width: 100%;
            background: rgba(15,23,42,0.5);
            border: 1px solid var(--border);
            padding: 12px 16px;
            border-radius: 8px;
            color: #fff;
            font-family: inherit;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: var(--primary);
            outline: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }
            .hero-title {
                font-size: 36px;
            }
            .hero-buttons {
                justify-content: center;
            }
            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- TechSeba Demo Banner -->
    <div class="techseba-bar">
        <span>This is a live portfolio website template demo.</span>
        <a href="https://wa.me/8801898828248?text=I%20want%20to%20create%20a%20website%20similar%20to%20the%20@yield('demo_slug')%20demo." target="_blank">
            <i class="ri-whatsapp-line"></i> Order Website Like This
        </a>
    </div>

    <!-- Nav -->
    <header>
        <div class="container nav-wrapper">
            <a href="#" class="logo">
                <i class="@yield('logo-icon', 'ri-heart-line')"></i> @yield('logo-text', 'Portfolio')<span>.</span>
            </a>
            <ul class="nav-links">
                @yield('nav-items')
                <li><a href="javascript:void(0)" onclick="openModal()" class="btn-cta">@yield('cta-text', 'Contact')</a></li>
            </ul>
        </div>
    </header>

    @yield('main-content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2026 @yield('logo-text'). All rights reserved. Created by TechSeba Team.</p>
        </div>
    </footer>

    <!-- Contact Modal -->
    <div class="modal" id="contactModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <h3 style="font-size: 22px; margin-bottom: 8px;">Let's Connect</h3>
            <p style="color: var(--muted); font-size: 14px; margin-bottom: 24px;">Submit the form below or chat directly on WhatsApp.</p>
            <form onsubmit="submitForm(event)">
                <div class="form-group">
                    <label>Your Name</label>
                    <input type="text" id="modalName" required class="form-control" placeholder="e.g. John Doe">
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="modalEmail" required class="form-control" placeholder="e.g. john@example.com">
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea id="modalMsg" rows="3" required class="form-control" placeholder="Tell us about your requirements..."></textarea>
                </div>
                <button type="submit" class="btn-cta" style="width: 100%; border: none; cursor: pointer; padding: 14px;">Send Message</button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('contactModal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('contactModal').style.display = 'none';
        }
        function submitForm(e) {
            e.preventDefault();
            const name = document.getElementById('modalName').value;
            const msg = document.getElementById('modalMsg').value;
            const waUrl = `https://wa.me/8801898828248?text=Hi%20TechSeba%2C%20my%20name%20is%20${encodeURIComponent(name)}.%20I%20visited%20your%20@yield('demo_slug')%20demo%20and%20want%20to%20submit%20this%20request%3A%20${encodeURIComponent(msg)}`;
            window.open(waUrl, '_blank');
            closeModal();
        }

        // FAQ Toggle functionality
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.faq-question').forEach(item => {
                item.addEventListener('click', () => {
                    const parent = item.parentElement;
                    parent.classList.toggle('active');
                });
            });
        });
    </script>
</body>
</html>
