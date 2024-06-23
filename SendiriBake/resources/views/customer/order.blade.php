<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle ?? 'Sendiri Bake' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custstyle.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/sendiribakelogo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playwrite+NG+Modern:wght@100..400&family=ZCOOL+XiaoWei&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body id="checkout-page">
    <div class="header">
        <div class="logo">
            <img src="{{ asset('images/sendiribakelogo.png') }}" alt="Logo">
            <h1>Sendiri Bake</h1>
        </div>
        <div class="menu">
            <ul>
                <li><button onclick="window.location.href = '/customer'">Home</button></li>
                <li><button onclick="window.location.href='{{ route('customer.order') }}'">Order</button></li>
            </ul>
        </div>
    </div>
    <div class="main-track-container">
        <form method="POST" action="{{ route('customer.trackOrder') }}">
            @csrf
            <label for="phoneNum">Enter your phone number:</label>
            <input type="text" id="phoneNum" name="phoneNum" required>
            <button type="submit">Track Order</button>
        </form>

        @if(isset($orders))
            <h2>Your Orders:</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Order Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->Id }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                @php
                                    $orderDetails = json_decode($order->orderdetails, true);
                                @endphp
                                <ul>
                                    @foreach($orderDetails as $itemName => $itemData)
                                        <li>{{ $itemName }} - Price: RM{{ $itemData['price'] }} - Quantity: {{ $itemData['quantity'] }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>    
</html>
