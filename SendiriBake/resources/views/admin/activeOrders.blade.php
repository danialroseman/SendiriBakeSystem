@extends('admin.layout')

@section('content')
    <section> 
        <h1 style="font-size: 35px; font-weight:bold;">Active Orders</h1>

        @if ($orders->isNotEmpty())
            <table class="orders-table">
                <tr>
                    <th>Order ID</th>
                    <th>Order Details</th>
                    <th>Total Price</th>
                    <th>Pickup Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->Id }}</td>
                        <td>{{ $order->orderdetails }}</td>
                        <td>{{ $order->totalprice }}</td>
                        <td>{{ $order->pickup }}</td>
                        <td>{{ $order->status }}</td>
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
