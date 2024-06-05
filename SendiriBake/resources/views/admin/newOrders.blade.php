@extends('admin.layout')

@section('content')
    <section> 
        <h1 style="font-size: 35px; font-weight:bold;">New Orders</h1>

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
                        <td>{{ $order->Id }}</td> <!-- Ensure this matches your column name -->
                        <td>{{ $order->orderdetails }}</td>
                        <td>{{ $order->totalprice }}</td>
                        <td>{{ $order->pickup }}</td>
                        <td>{{ $order->status }}</td>
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
