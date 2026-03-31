@extends('master_layout')
@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}">
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}">
@endsection

@section('new-layout')

<div class="optech-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
    <div class="container">
        <h1 class="post__title">{{ __('translate.Checkout') }}</h1>
        <nav class="breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                <li aria-current="page">{{ __('translate.Checkout') }}</li>
            </ul>
        </nav>
    </div>
</div>
<!-- End breadcrumb -->

<div class="section optech-section-padding">
    <div class="container">
        <div class="row">
            @if(!auth()->guard('web')->user())
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <p class="deception-medium">{{ __('translate.Place your Order you must be Login') }}</p>
                    </div>
                </div>
            @else
                <form action="{{ route('checkout.process-to-payment') }}" method="GET">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="optech-checkout-form">
                            <h5>{{ __('translate.Shipping Details') }}</h5>
                                <div class="optech-checkout-field">
                                    <label>{{ __('translate.Full Name') }}</label>
                                    <input type="text" value="{{ auth()->user()->name ?? '' }}" name="name" placeholder="Full Name">
                                </div>

                                <div class="optech-checkout-field">
                                    <label>{{ __('translate.Email') }}</label>
                                    <input type="email" value="{{ auth()->user()->email ?? '' }}" name="email" placeholder="Email">
                                </div>

                                <div class="optech-checkout-field">
                                    <label>{{ __('translate.WhatsApp Number') }}</label>
                                    <input type="text" value="{{ auth()->user()->phone ?? '' }}" name="phone" placeholder="WhatsApp Phone">
                                </div>

                                <div class="optech-checkout-field dropdown">
                                    <label>{{ __('translate.Shipping Method') }}</label>
                                    <select name="shipping_method_id" class="form-select">
                                        <option value="" selected disabled>{{ __('translate.Select One') }}</option>
                                        @foreach($methods as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }} - {{ currency($method->price) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="optech-checkout-field">
                                    <label>{{ __('translate.Full Address') }}</label>
                                    <input class="house-number" name="address" type="text" placeholder="{{ __('translate.House number and Street name') }}">
                                </div>

                        </div>
                        </div>

                        <div class="col-lg-5 offset-lg-1">
                            <div class="optech-checkuot-sidebar-column">
                            <div class="optech-checkuot-sidebar">
                                <h5>{{ __('translate.Your Order') }}</h5>
                                <ul>
                                    <li>{{ __('translate.Products') }}<span>{{ __('translate.Subtotal') }}</span></li>

                                    @foreach($carts as $cart)
                                    <li>{{ Str::limit($cart->product->translate?->name, 35) }} <b> X </b>  {{ $cart->quantity }} <span>{{ currency($cart->product->finalPrice * $cart->quantity) }}</span> </li>
                                    @endforeach

                                    <li class="sub_total">
                                        {{ __('translate.Subtotal') }}<span class="sub_total">{{ currency($sub_total) }}</span>
                                        <input type="hidden" name="subtotal" value="{{$sub_total}}">
                                    </li>
                                    <li class="shipping_cost">
                                        {{ __('translate.Delivery Fee') }}<span class="shipping_charge">(+){{ currency(0) }}</span>
                                        <input type="hidden" name="shipping_charge" value="">
                                    </li>

                                    <li class="total">
                                        {{ __('translate.Total') }}<span class="total-amount">{{ currency($sub_total) }}</span>
                                        <input type="hidden" name="total" value="">
                                    </li>
                                </ul>
                            </div>
                                @if($carts->isNotEmpty())
                                    <button class="optech-default-btn shop-order-btn" type="submit" data-text="{{ __('translate.Place Order') }}">
                                        <span class="btn-wraper">{{ __('translate.Place Order') }}</span>
                                    </button>
                                @endif
                        </div>
                    </div>
                    </div>
                </form>

            @endif
        </div>
    </div>
</div>
<!-- End section -->
@endsection
@push('js_section')
<script>
    $(document).ready(function() {
        // Function to parse currency string to number
        function parseCurrency(currencyStr) {
            return parseFloat(currencyStr.replace(/[^0-9.-]+/g, '')); // Removing non-numeric characters
        }

        // Function to format number into currency format (e.g., $10.00)
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2);
        }

        // Function to update prices and hidden form fields
        function updatePrices() {
            // Get the subtotal value
            const subTotal = parseCurrency($('.sub_total span').text());

            // Get the shipping cost from the displayed value
            const shippingCost = parseCurrency($('.shipping_cost span').text().replace('(+)', '').trim());

            // Calculate the total price
            const total = subTotal + shippingCost;

            // Update the total span with the formatted total price
            $('.total span').text(formatCurrency(total));

            // If you are showing this price for Stripe payment, update it
            $('.stripe_price_here').text(formatCurrency(total));

            // Update the hidden form inputs for subtotal, shipping cost, and total
            $('input[name="subtotal"]').val(subTotal);
            $('input[name="shipping_charge"]').val(shippingCost);
            $('input[name="total"]').val(total);
        }

        // Event listener for when the shipping method is changed
        $('select[name="shipping_method_id"]').on('change', function() {
            // Get the selected option's shipping cost (splitting the price part)
            const selectedOption = $(this).find('option:selected');
            const priceText = selectedOption.text().split('-')[1].trim();
            const shippingCost = parseCurrency(priceText);

            // Update the shipping cost display and the input field
            $('.shipping_cost span').text('(+)' + formatCurrency(shippingCost));

            // Recalculate and update all prices
            updatePrices();
        });

        // Optional: If you want to initially set the values correctly when the page loads, you can call updatePrices()
        updatePrices();
    });
</script>
@endpush
