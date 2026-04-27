@php
    $whatsappNumber = '8801898828248';
    $whatsappMessage = 'Hello, I want to know more about your courses and services.';
    $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . rawurlencode($whatsappMessage);
@endphp

<style>
    .floating-whatsapp {
        position: fixed;
        right: 30px;
        bottom: 96px;
        z-index: 10001;
        width: 58px;
        height: 58px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #25d366;
        color: #ffffff;
        font-size: 30px;
        line-height: 1;
        text-decoration: none;
        box-shadow: 0 12px 28px rgba(37, 211, 102, 0.35);
        transition: transform 180ms ease, background-color 180ms ease, box-shadow 180ms ease;
    }

    .floating-whatsapp::before {
        content: "";
        position: absolute;
        inset: -7px;
        border-radius: inherit;
        background: rgba(37, 211, 102, 0.22);
        animation: floatingWhatsappPulse 1.8s ease-in-out infinite;
    }

    .floating-whatsapp i {
        position: relative;
        z-index: 1;
    }

    .floating-whatsapp:hover,
    .floating-whatsapp:focus {
        color: #ffffff;
        background: #20c45a;
        box-shadow: 0 14px 32px rgba(37, 211, 102, 0.42);
        transform: translateY(-3px);
    }

    @keyframes floatingWhatsappPulse {
        0% {
            opacity: 0.95;
            transform: scale(0.86);
        }

        70% {
            opacity: 0;
            transform: scale(1.22);
        }

        100% {
            opacity: 0;
            transform: scale(1.22);
        }
    }

    @media (max-width: 575.98px) {
        .floating-whatsapp {
            right: auto;
            left: max(18px, calc(100vw - 70px));
            left: max(18px, calc(100dvw - 70px));
            bottom: 88px;
            width: 52px;
            height: 52px;
            font-size: 27px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .floating-whatsapp,
        .floating-whatsapp::before {
            animation: none;
            transition: none;
        }
    }
</style>

<a class="floating-whatsapp"
   href="{{ $whatsappUrl }}"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Chat on WhatsApp"
   title="Chat on WhatsApp">
    <i class="fab fa-whatsapp" aria-hidden="true"></i>
</a>
