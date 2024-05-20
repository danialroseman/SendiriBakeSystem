@extends('admin.layout')

@section('content')
    <section>
            <h1 style="font-size: 35px; font-weight:bold;">Active Orders</h1>

            @if (!empty($acceptedOrders))
                <table class="orders-table">
                    <tr>
                        <th>Order ID</th>
                        <th>Order Details</th>
                        <th>Total Price</th>
                        <th>Pickup Date</th>
                        <th>Status</th>
                    </tr>

                    @foreach ($acceptedOrders as $order)
                        <tr>
                            <td>{{ $order->Id }}</td>
                            <td>{{ $order->orderdetails }}</td>
                            <td>{{ $order->totalprice }}</td>
                            <td>{{ $order->pickup }}</td>
                            <td>{{ $order->status }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p>No active orders found.</p>
            @endif
    </section>
@endsection