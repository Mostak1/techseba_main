<div class="optech-shop-wrap" id="wishlist-item-{{ $product->id }}">
    <div class="optech-shop-thumb">
        <a href="{{ route('product.view', $product->slug) }}">
            <img src="{{ asset($product->thumbnail_image) }}" alt="Image0">
        </a>
            <button class="optech-shop-btn cart-add-btn"
                    data-product-id="{{ $product->id }}"
                    data-text="{{ __('translate.Add to Cart') }}">
                <span class="btn-wraper">
                    {{ __('translate.Add to Cart') }}
                </span>
            </button>

        <a href="javascript:void(0)"
           class="wishlist_icon {{ auth()->check() && in_array($product->id, auth()->user()->wishlists->pluck('product_id')->toArray()) ? 'active' : '' }}"
           data-url="{{ route('user.wishlist.store') }}"
           onclick="addToWishlist({{ $product->id }}, this)">

            <span>
              <svg width="22" height="20" viewBox="0 0 22 20" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.765 2.70229L11 3.52422L10.235 2.70229C8.12233 0.432572 4.69709 0.43257 2.58447 2.70229C0.471845 4.972 0.471844 8.65194 2.58447 10.9217L9.4699 18.3191C10.315 19.227 11.685 19.227 12.5301 18.3191L19.4155 10.9217C21.5282 8.65194 21.5282 4.972 19.4155 2.70229C17.3029 0.432571 13.8777 0.432571 11.765 2.70229Z"
                    stroke-width="1.3" stroke-linejoin="round"/>
              </svg>
            </span>
        </a>
    </div>
    <div class="optech-shop-data">
        <a href="{{ route('product.view', $product->slug) }}">
            <h5>{{ __($product->translate?->name) }}</h5>
        </a>
        <h6>
            {!! $product->price_display !!}
        </h6>
    </div>
</div>

