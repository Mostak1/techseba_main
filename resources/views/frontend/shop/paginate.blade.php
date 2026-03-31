@if($products->hasPages())
    <div class="optech-navigation">
        <nav class="navigation pagination center" aria-label="Posts">
            <div class="nav-links">
                @if($products->onFirstPage())
                    <span class="next page-numbers disabled">
                                <i class="ri-arrow-left-s-line"></i>
                            </span>
                @else
                    <a class="next page-numbers" href="{{ $products->previousPageUrl() }}">
                        <i class="ri-arrow-left-s-line"></i>
                    </a>
                @endif

                @php
                    $start = max($products->currentPage() - 2, 1);
                    $end = min($start + 4, $products->lastPage());
                    $start = max(min($start, $products->lastPage() - 4), 1);
                @endphp

                @if($start > 1)
                    <a class="page-numbers" href="{{ $products->url(1) }}">1</a>
                    @if($start > 2)
                        <span class="page-numbers dots">...</span>
                    @endif
                @endif

                @for($i = $start; $i <= $end; $i++)
                    @if($i == $products->currentPage())
                        <span aria-current="page"
                              class="page-numbers current">{{ $i }}</span>
                    @else
                        <a class="page-numbers" href="{{ $products->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor

                @if($end < $products->lastPage())
                    @if($end < $products->lastPage() - 1)
                        <span class="page-numbers dots">...</span>
                    @endif
                    <a class="page-numbers"
                       href="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a>
                @endif

                @if($products->hasMorePages())
                    <a class="next page-numbers" href="{{ $products->nextPageUrl() }}">
                        <i class="ri-arrow-right-s-line"></i>
                    </a>
                @else
                    <span class="next page-numbers disabled">
                                <i class="ri-arrow-right-s-line"></i>
                            </span>
                @endif
            </div>
        </nav>
    </div>
@endif
