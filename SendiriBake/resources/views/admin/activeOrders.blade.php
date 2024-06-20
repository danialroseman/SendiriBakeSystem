@extends('admin.layout')

@section('content')
    <section> 
        <h1 style="font-size: 35px; font-weight:bold;">Active Orders</h1>

        @if ($orders->isNotEmpty())
            <table class="orders-table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Order Details</th>
                    <th>Total Price</th>
                    <th>Pickup Date</th>
                    <th>Status</th>
                    <th>Method</th>
                    <th>Receipt</th>
                    <th>Action</th>
                </tr>

                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->Id }}</td>
                        <td>{{ $order->custName}}</td>
                        <td>{{ $order->phoneNum}}</td>
                        <td>
                            @php
                                $orderDetails = json_decode($order->orderdetails, true);
                            @endphp
                            @foreach ($orderDetails as $name => $item)
                                {{ $name }}: x {{ $item['quantity'] }} (RM{{ number_format($item['price'], 2) }})<br>
                            @endforeach                       
                         </td>
                        <td>{{ $order->totalprice }}</td>
                        <td>{{ $order->pickup }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>
                            @if ($order->receipt)
                                <a href="{{ asset('storage/' . $order->receipt) }}" target="_blank">View Receipt</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <form method="post" action="{{ route('complete.order') }}">
                                @csrf
                                <input type="hidden" name="orderId" value="{{ $order->Id }}">
                                <button type="submit">Complete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>No active orders found.</p>
        @endif
    </section>
@endsection
