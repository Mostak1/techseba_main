@extends('user.dashboard_layout')
@section('title')
    <title>{{ __('translate.Single Order') }}</title>
@endsection
@section('breadcrumb')
    <h1 class="post__title">{{ __('translate.Order') }}</h1>
    <nav class="breadcrumbs">
        <ul>
            <li><a href="{{ route('user.dashboard') }}">{{ __('translate.Home') }}</a></li>
            <li><a href="{{ route('user.orders') }}">{{ __('translate.Orders') }}</a></li>
            <li aria-current="page"> {{ __('translate.Order ') }} {{ $order->order_id }} </li>
        </ul>
    </nav>
@endsection
@section('dashboard-content')
    <!-- End breadcrumb -->
    <div class="d_order_details_main">
        <div class="d_order_details_main_top">
            <a href="{{ route('home') }}" class="d_order_details_main_top_logo">
                <img src="{{ asset($general_setting->logo) }}" alt="logo">
            </a>

            <a class="optech-default-btn" href="{{ route('user.orders') }}" data-text="Back"><span
                    class="btn-wraper">{{ __('translate.Back') }}</span></a>
        </div>

        <div class="d_order_details_address_df">
            <div class="d_order_details_address">
                <h5>{{ __('translate.Billing Address') }}</h5>

                <ul>
                    <li> <span>{{ __('translate.Name:') }}</span> {{ __($order->address['name']) }}</li>
                    <li> <span>{{ __('translate.Phone:') }}</span> {{ __($order->address['phone']) }}</li>
                    <li> <span>{{ __('translate.Email:') }}</span> {{ __($order->address['email']) }}</li>
                    <li> <span>{{ __('translate.Address:') }}</span> {{ __($order->address['address']) }}</li>
                </ul>
            </div>
            <div class="d_order_details_address">
                <h5>{{ __('translate.Order Details') }}</h5>
                <ul>
                    <li> <span>{{ __('translate.Transaction Id :') }}</span>{{ $order->transaction_id }}</li>
                    <li> <span>{{ __('translate.Order Id :') }}</span> {{ $order->order_id }}</li>
                    <li> <span>{{ __('translate.Order Date :') }}</span>{{ $order->created_at->format('d M Y') }} </li>
                    <li> <span>{{ __('translate.Payment Status :') }}</span>
                        @if($order->payment_status == 1)
                            <span class="paid ">{{ __('translate.Paid') }}</span>
                        @else
                            <span class="paid un_paid">{{ __('translate.Un Paid') }}</span>
                        @endif
                    </li>
                    <li> <span> {{ __('translate.Payment Method :') }} </span>
                        {{ $order->payment_method }}
                    </li>
                    <li> <span>{{ __('translate.Order Status: ') }}</span>

                        @if($order->order_status == 0)
                        <span class="paid un_paid">
                            {{ __('translate.Pending') }}
                        </span>
                    @elseif($order->order_status == 1)
                        <span class="paid">
                            {{ __('translate.Completed') }}
                        </span>
                    @elseif($order->order_status == 2)
                        <span class="paid un_paid">
                            {{ __('translate.Rejected') }}
                        </span>
                    @elseif($order->order_status == 3)
                        <span class="paid">
                            {{ __('translate.Processing') }}
                        </span>
                    @elseif($order->order_status == 4)
                        <span class="paid ">
                            {{ __('translate.Shipped') }}
                        </span>
                    @else
                        <span class="paid ">
                            {{ __('translate.Completed') }}
                        </span>
                    @endif

                    </li>
                </ul>
            </div>
        </div>

        <div class="dashbord_table_main">
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('translate.Product Name') }}</th>
                    <th>{{ __('translate.Price') }}</th>
                    <th>{{ __('translate.Quantity') }}</th>
                    <th>{{ __('translate.Amount') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->order_detail as $detail)
                    <!-- single item -->
                    <tr>
                        <td>{{ __($detail->singleProduct->translate->name) }}</td>
                        <td>{{ __(currency($detail->singleProduct->finalPrice)) }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ __(currency($detail->price)) }}</td>
                    </tr>
                    <!-- single item -->
                @endforeach
                </tbody>
            </table>
        </div>

        <ul class="subtotal_item">
            <li>{{ __('translate.Subtotal') }} <span>{{ currency($order->subtotal) }}</span></li>
            <li>{{ __('translate.Shipping Cost') }} <span>{{ currency($order->shipping_charge) }}</span></li>
            <li>{{ __('translate.Total') }} <span>{{ currency($order->total) }}</span></li>
        </ul>
    </div>
    <!-- End section -->
@endsection
