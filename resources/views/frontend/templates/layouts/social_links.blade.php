<div class="optech-social-icon-box one">
    <ul>

        @if(@$footer->facebook)
        <li>
            <a href="{{ $footer->facebook }}" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
        </li>
        @endif

        @if(@$footer->twitter)
        <li>
            <a href="{{ $footer->twitter }}" target="_blank">
                <i class="fab fa-twitter"></i>
            </a>
        </li>
        @endif

        @if(@$footer->youtube)
        <li>
            <a href="{{ $footer->youtube }}" target="_blank">
                <i class="fab fa-youtube"></i>
            </a>
        </li>
        @endif

        @if(@$footer->tiktok)
        <li>
            <a href="{{ $footer->tiktok }}" target="_blank">
                <i class="fab fa-tiktok"></i>
            </a>
        </li>
        @endif

        @if(@$footer->linkedin)
        <li>
            <a href="{{ $footer->linkedin }}" target="_blank">
                <i class="fab fa-linkedin-in"></i>
            </a>
        </li>
        @endif

        @if(@$footer->instagram)
        <li>
            <a href="{{ $footer->instagram }}" target="_blank">
                <i class="fab fa-instagram"></i>
            </a>
        </li>
        @endif

    </ul>
</div>
