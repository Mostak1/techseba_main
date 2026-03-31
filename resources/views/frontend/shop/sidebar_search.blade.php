<div class="col-xl-3 col-lg-4 col-md-5">
    <div class="shop_sidebar">
        <!-- Search -->
        <form id="filterForm" action="{{ route('product.search') }}" method="GET">
            <!-- Search Box -->
            <div class="shop_sidebar_item mt-0 pt-0 border-0">
                <div class="shop_sidebar_text">
                    <h6>{{ __('translate.Search') }}</h6>
                </div>
                <div class="shop_sidebar_search_box">
                    <input type="text" name="query" placeholder="Search" value="{{ request('query') }}">
                    <button type="submit" class="search_btn">
                        <span>
                            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.031 14.6168L20.3137 18.8995L18.8995 20.3137L14.6168 16.031C13.0769 17.263 11.124 18 9 18C4.032 18 0 13.968 0 9C0 4.032 4.032 0 9 0C13.968 0 18 4.032 18 9C18 11.124 17.263 13.0769 16.031 14.6168ZM14.0247 13.8748C15.2475 12.6146 16 10.8956 16 9C16 5.1325 12.8675 2 9 2C5.1325 2 2 5.1325 2 9C2 12.8675 5.1325 16 9 16C10.8956 16 12.6146 15.2475 13.8748 14.0247L14.0247 13.8748Z" fill="#0A165E"/>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Brand Filter -->
            <div class="shop_sidebar_item">
                <div class="shop_sidebar_text">
                    <h6>{{ __('translate.Select Your Brand') }}</h6>
                </div>
                <select class="form-select" name="brand" onchange="this.form.submit()">
                    <option value="">{{ __('translate.Select any brand') }}</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->translate?->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Categories Filter -->
            <div class="shop_sidebar_item">
                <div class="shop_sidebar_text">
                    <h6>{{ __('translate.Select Your Categories') }}</h6>
                </div>
                <div class="shop_sidebar_item_box_main fst">
                    @foreach($categories as $category)
                        <div class="shop_sidebar_item_box">
                            <input class="form-check-input" type="checkbox"
                                   name="categories[]"
                                   value="{{ $category->id }}"
                                   id="category_{{ $category->id }}"
                                {{ in_array($category->id, (array)request('categories', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category_{{ $category->id }}">
                                {{ $category->translate->name }} ({{ $category->products_count }})
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>


            <button type="submit" class="optech-default-btn" data-text="Apply Now">
                <span class="btn-wraper">{{ __('translate.Apply Now') }}</span>
            </button>
        </form>
    </div>
</div>
