@extends('admin.layout')

@section('content')
    <section> 
            <h1 style="font-size: 35px; font-weight:bold;">New Orders</h1>

            @if (!empty($orders))
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
                                <form method="post" action="{{ route('update.order.status') }}">
                                    @csrf
                                    <input type="hidden" name="orderId" value="{{ $order->Id }}">
                                    <!-- Displaying accept and reject buttons -->
                                    <input type="submit" name="accept" value="Accept">
                                    <input type="submit" name="reject" value="Reject">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p>No new orders found.</p>
            @endif
    </section>
@endsection
