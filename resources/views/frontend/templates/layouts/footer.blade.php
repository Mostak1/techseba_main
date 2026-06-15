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
        <h5>{{ __('translate.Quick Links') }}</h5>
        <ul>
          @if(page_enabled('about-us'))
            <li><a href="{{ route('about-us') }}">{{ __('translate.About Us') }}</a></li>
          @endif
          @if(page_enabled('teams'))
            <li><a href="{{ route('teams') }}">{{ __('translate.Our Team') }}</a></li>
          @endif
          @if(page_enabled('blogs'))
            <li><a href="{{ route('blogs') }}">{{ __('translate.Blogs') }}</a></li>
          @endif
          @if(page_enabled('contact-us'))
            <li><a href="{{ route('contact-us') }}">{{ __('translate.Contact Us') }}</a></li>
          @endif
        </ul>
      </div>
      <div class="footer-col">
        <h5>{{ __('translate.Services') }}</h5>
        <ul>
          @foreach($services->take(5) as $service)
            <li><a href="{{ route('service', $service->slug) }}">{{ $service->translate?->title }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="footer-col">
        <h5>{{ __('translate.Newsletter') }}</h5>
        <p style="font-size:13px;color:var(--muted);margin-bottom:14px;">Get ready for better business solutions.</p>
        <form action="{{ route('store-newsletter') }}" method="POST" class="footer-newsletter">
          @csrf
          <input type="email" name="email" placeholder="Your email address" required>
          <button type="submit">Subscribe</button>
        </form>
        <div style="margin-top:16px;display:flex;flex-direction:column;gap:6px;">
          @if(page_enabled('privacy-policy'))
            <a href="{{ route('privacy-policy') }}" style="font-size:12px;color:var(--muted);text-decoration:none;">{{ __('translate.Privacy Policy') }}</a>
          @endif
          @if(page_enabled('terms-conditions'))
            <a href="{{ route('terms-conditions') }}" style="font-size:12px;color:var(--muted);text-decoration:none;">{{ __('translate.Terms & Conditions') }}</a>
          @endif
          @if(page_enabled('faq'))
            <a href="{{ route('faq') }}" style="font-size:12px;color:var(--muted);text-decoration:none;">{{ __('Faqs') }}</a>
          @endif
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>{{ $footer->copyright }}</p>
      <div class="footer-bottom-links">
        @if(page_enabled('privacy-policy'))
          <a href="{{ route('privacy-policy') }}">{{ __('translate.Privacy Policy') }}</a>
        @endif
        @if(page_enabled('terms-conditions'))
          <a href="{{ route('terms-conditions') }}">{{ __('translate.Terms & Conditions') }}</a>
        @endif
        @if(page_enabled('faq'))
          <a href="{{ route('faq') }}">{{ __('Faqs') }}</a>
        @endif
      </div>
    </div>
  </div>
</footer>
