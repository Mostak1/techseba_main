<div class="dashbord_table_main">
    <table class="table">
        <thead>
        <tr>
            @if(Route::is('user.transactions'))
                <th>{{ __('translate.Transactions ID') }}</th>
            @endif
            <th>{{ __('translate.Order ID') }}</th>
            <th>{{ __('translate.Amount') }}</th>
            <th>{{ __('translate.Date') }}</th>
            @if(Route::is('user.transactions'))
                <th>{{ __('translate.Payment Gateway') }}</th>
            @endif
            @if(Route::is('user.orders'))
                <th>{{ __('translate.Payment') }}</th>
            @endif
            <th>{{ __('translate.Status') }}</th>
            <th>{{ __('translate.Action') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach($orders as $order)
            <tr>
                @if(Route::is('user.transactions'))
                    <td>
                        <a href="javascript:void(0)">
                            {{ $order->transaction_id }}
                        </a>
                    </td>
                @endif
                <td>
                    <a href="{{ route('user.order_show', $order->order_id) }}">
                        {{ $order->order_id }}
                    </a>
                </td>
                <td>{{ currency($order->total) }}</td>
                <td>{{ $order->created_at->diffForHumans() }}</td>
                @if(Route::is('user.transactions'))
                    <td>{{ $order->payment_method }}</td>
                @endif

                @if(Route::is('user.orders'))
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
                @endif
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
        @endforeach
        </tbody>
    </table>
</div>
