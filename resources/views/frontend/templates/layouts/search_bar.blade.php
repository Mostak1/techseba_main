<div class="optech-header-search-section">
    <div class="container">
        <div class="optech-header-search-box">
            <form id="searchForm" action="{{ route('product.search') }}" method="GET">
                <input type="search" name="query" placeholder="Search here..." id="searchInput">
                <button id="header-search" type="button"><i class="ri-search-line"></i></button>
                <p>{{ __('translate.Type above and press Enter to search. Press Close to cancel.') }}</p>
            </form>
        </div>
    </div>
    <div class="optech-header-search-close">
        <i class="ri-close-line"></i>
    </div>
</div>
