@php
    if (auth()->check()) {
        $userId = auth()->id();
        $totalCart = Modules\Ecommerce\Entities\Cart::where('user_id', $userId)->count();
    } else {
        $sessionId = session()->get('session_id');
        $totalCart = Modules\Ecommerce\Entities\Cart::where('session_id', $sessionId)->count();
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
      <li><a href="{{ route('home') }}">Home</a></li>
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
