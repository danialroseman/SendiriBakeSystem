@extends('admin.layout')

@section('content')
    <section> 
        <h1 style="font-size: 35px; font-weight:bold;">New Orders</h1>

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
                        <td>{{ $order->Id }}</td> <!-- Ensure this matches your column name -->
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
                        <td>RM{{ $order->totalprice }}</td>
                        <td>{{ $order->pickup }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>
                            @if ($order->receipt)
                                <a href="{{ Storage::url($order->receipt) }}" target="_blank">View Receipt</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <form method="post" action="{{ route('update.order.status') }}" class="update-status-form">
                                @csrf
                                <input type="hidden" name="orderId" value="{{ $order->Id }}"> <!-- Ensure this matches your column name -->
                                <button type="button" class="accept-btn" data-status="accept">Accept</button>
                                <button type="button" class="reject-btn" data-status="rejected">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>No new orders found.</p>
        @endif
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.accept-btn, .reject-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    let form = this.closest('form');
                    let statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'status';
                    statusInput.value = this.getAttribute('data-status');
                    form.appendChild(statusInput);
                    form.submit();
                });
            });
        });
    </script>
@endsection
