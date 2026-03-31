@extends('user.dashboard_layout')
@section('title')
    <title>{{ __('translate.User Dashboard') }}</title>
@endsection
@section('breadcrumb')
    <h1 class="post__title">{{ __('translate.Dashboard') }}</h1>
    <nav class="breadcrumbs">
        <ul>
            <li><a href="{{ route('user.dashboard') }}">{{ __('translate.Home') }}</a></li>
            <li aria-current="page"> {{ __('translate.Dashboard') }}</li>
        </ul>
    </nav>
@endsection

@section('dashboard-content')
    <div class="row">
        <div class="col-xxl-3 col-xl-4 col-md-6 mt-3 mt-md-0">
            <div class="dashbord_item">
                <span class="dashbord_item_icon">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M26.6667 29.3337H6.66675C4.45761 29.3337 2.66675 27.5428 2.66675 25.3337V6.66699C2.66675 4.45785 4.45761 2.66699 6.66675 2.66699H20.0001C22.2092 2.66699 24.0001 4.45785 24.0001 6.66699V10.667M26.6667 29.3337C25.194 29.3337 24.0001 28.1397 24.0001 26.667V10.667M26.6667 29.3337C28.1395 29.3337 29.3334 28.1397 29.3334 26.667V13.3337C29.3334 11.8609 28.1395 10.667 26.6667 10.667H24.0001M8.00008 9.33366H18.6667M8.00008 16.0003H18.6667M8.00008 22.667H13.3334"
                            stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>

                <div class="dashbord_item_text">
                    <h5> {{ __($orders->count()) }}</h5>
                    <p class="d-item-label">
                        {{ __('translate.Total Orders') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-md-6 mt-4 mt-md-0">
            <div class="dashbord_item">
                    <span class="dashbord_item_icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <rect width="32" height="32" fill="none" />
                            <path
                                d="M16.0001 16.0003H15.2501C15.2501 16.3231 15.4567 16.6098 15.7629 16.7118L16.0001 16.0003ZM16.7501 9.33366C16.7501 8.91945 16.4143 8.58366 16.0001 8.58366C15.5859 8.58366 15.2501 8.91945 15.2501 9.33366H16.7501ZM19.7629 18.0452C20.1559 18.1762 20.5806 17.9638 20.7116 17.5708C20.8426 17.1779 20.6302 16.7531 20.2373 16.6221L19.7629 18.0452ZM16.7501 16.0003V9.33366H15.2501V16.0003H16.7501ZM15.7629 16.7118L19.7629 18.0452L20.2373 16.6221L16.2373 15.2888L15.7629 16.7118ZM28.5834 16.0003C28.5834 22.9499 22.9497 28.5837 16.0001 28.5837V30.0837C23.7781 30.0837 30.0834 23.7783 30.0834 16.0003H28.5834ZM16.0001 28.5837C9.0505 28.5837 3.41675 22.9499 3.41675 16.0003H1.91675C1.91675 23.7783 8.22207 30.0837 16.0001 30.0837V28.5837ZM3.41675 16.0003C3.41675 9.05074 9.0505 3.41699 16.0001 3.41699V1.91699C8.22207 1.91699 1.91675 8.22231 1.91675 16.0003H3.41675ZM16.0001 3.41699C22.9497 3.41699 28.5834 9.05074 28.5834 16.0003H30.0834C30.0834 8.22231 23.7781 1.91699 16.0001 1.91699V3.41699Z"
                                fill="currentcolor" />
                        </svg>
                    </span>

                <div class="dashbord_item_text">
                    <h5>{{ $pending_orders }}</h5>
                    <p class="d-item-label">
                        {{ __('translate.Pending Orders') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-md-6 mt-4 mt-lg-0">
            <div class="dashbord_item">
                <span class="dashbord_item_icon">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" fill="" />
                        <path
                            d="M8.00008 5.33366H24.0001C26.9456 5.33366 29.3334 7.72147 29.3334 10.667V17.3337C29.3334 20.2792 26.9456 22.667 24.0001 22.667H13.3334C10.3879 22.667 8.00008 20.2792 8.00008 17.3337V5.33366ZM8.00008 5.33366C8.00008 3.8609 6.80617 2.66699 5.33341 2.66699H2.66675"
                            stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M14.6667 27.333C14.6667 28.4376 13.7713 29.333 12.6667 29.333C11.5622 29.333 10.6667 28.4376 10.6667 27.333C10.6667 26.2284 11.5622 25.333 12.6667 25.333C13.7713 25.333 14.6667 26.2284 14.6667 27.333Z"
                            stroke="currentcolor" stroke-width="1.5" />
                        <path
                            d="M26.6667 27.333C26.6667 28.4376 25.7713 29.333 24.6667 29.333C23.5622 29.333 22.6667 28.4376 22.6667 27.333C22.6667 26.2284 23.5622 25.333 24.6667 25.333C25.7713 25.333 26.6667 26.2284 26.6667 27.333Z"
                            stroke="currentcolor" stroke-width="1.5" />
                        <path d="M14.6667 16C17.8083 17.7871 19.5302 17.7684 22.6667 16"
                                stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                    </svg>
                </span>

                <div class="dashbord_item_text">
                    <h5>{{ __($complete_orders) }}</h5>
                    <p class="d-item-label">
                        {{ __('translate.Complete Orders') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-md-6 mt-4  mt-lg-0 ">
            <div class="dashbord_item">
                <span class="dashbord_item_icon">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" fill="" />
                        <path
                            d="M18.6666 17.0003C18.6666 15.7117 17.4727 14.667 15.9999 14.667C14.5272 14.667 13.3333 15.7117 13.3333 17.0003C13.3333 18.289 14.5272 19.3337 15.9999 19.3337C17.4727 19.3337 18.6666 20.3783 18.6666 21.667C18.6666 22.9557 17.4727 24.0003 15.9999 24.0003C14.5272 24.0003 13.3333 22.9557 13.3333 21.667"
                            stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M16 12.667V14.667" stroke="currentcolor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M16 24V26" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        <path
                            d="M7.96587 13.4356C8.78255 10.9856 11.0754 9.33301 13.658 9.33301H18.3422C20.9248 9.33301 23.2176 10.9856 24.0343 13.4356L26.701 21.4356C27.996 25.3208 25.1042 29.333 21.0089 29.333H10.9913C6.89595 29.333 4.00414 25.3208 5.2992 21.4356L7.96587 13.4356Z"
                            stroke="currentcolor" stroke-width="1.5" stroke-linejoin="round" />
                        <path
                            d="M18.7813 9.33366L13.2189 9.33366L11.3508 7.19094C9.51954 5.09049 11.6559 1.95096 14.3295 2.81346L15.5665 3.21251C15.8482 3.30337 16.152 3.30337 16.4336 3.21251L17.6707 2.81346C20.3443 1.95096 22.4806 5.0905 20.6494 7.19094L18.7813 9.33366Z"
                            stroke="currentcolor" stroke-width="1.5" stroke-linejoin="round" />
                    </svg>
                </span>

                <div class="dashbord_item_text">
                    <h5>{{ currency($total) }}</h5>
                    <p class="d-item-label">
                       {{ __('translate.Total Transactions') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="dashbord_head">
        <h5>{{ __('translate.Recent Order Lists') }}</h5>
    </div>
    <div class="dashbord_table_main">
        <table class="table">
            <thead>
            <tr>
                <th>{{ __('translate.Order ID') }}</th>
                <th>{{ __('translate.Amount') }}</th>
                <th>{{ __('translate.Date') }}</th>
                <th>{{ __('translate.Payment') }}</th>
                <th>{{ __('translate.Status') }}</th>
                <th>{{ __('translate.Action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
            <!-- single item -->
                <tr>
                <td>
                    <a href="#">
                        {{ $order->order_id }}
                    </a>
                </td>
                <td>{{ currency($order->total) }}</td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td>
                    @if($order->payment_status == 1)
                        <span class="paid_btn">
                            {{ __('translate.PAID') }}
                        </span>
                    @else
                        <span class="paid_btn unpaid_btn">
                            {{ __('translate.UNPAID') }}
                        </span>
                    @endif
                </td>
                    <td>
                        @if($order->order_status == 0)
                            <span class="pending_status">
                            {{ __('translate.Pending') }}
                        </span>
                        @elseif($order->order_status == 1)
                            <span class="pending_status completed_status">
                            {{ __('translate.Completed') }}
                        </span>
                        @elseif($order->order_status == 2)
                            <span class="pending_status ">
                            {{ __('translate.Rejected') }}
                        </span>
                        @elseif($order->order_status == 3)
                            <span class="pending_status completed_status">
                            {{ __('translate.Processing') }}
                        </span>
                        @elseif($order->order_status == 4)
                            <span class="pending_status completed_status">
                            {{ __('translate.Shipped') }}
                        </span>
                        @else
                            <span class="pending_status completed_status">
                            {{ __('translate.Completed') }}
                        </span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('user.order_show', $order->order_id) }}" class="action_btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21.1303 9.8531C22.2899 11.0732 22.2899 12.9268 21.1303 14.1469C19.1745 16.2047 15.8155 19 12 19C8.18448 19 4.82549 16.2047 2.86971 14.1469C1.7101 12.9268 1.7101 11.0732 2.86971 9.8531C4.82549 7.79533 8.18448 5 12 5C15.8155 5 19.1745 7.79533 21.1303 9.8531Z"
                                    stroke="white" stroke-width="1.5"/>
                                <circle cx="12" cy="12" r="3" stroke="white" stroke-width="1.5"/>
                            </svg>
                        </a>
                    </td>
            </tr>
            <!-- single item -->
            @endforeach

            </tbody>
        </table>
    </div>
@endsection

