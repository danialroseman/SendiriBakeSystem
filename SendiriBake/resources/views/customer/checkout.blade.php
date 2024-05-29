<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle ?? 'Sendiri Bake' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custstyle.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div class="header">   
        <div class="logo">
            <img src="{{ asset('images/sendiribakelogo.png') }}" alt="Logo">
            <h1>Sendiri Bake</h1>
        </div>

        <div class="menu">
            <ul>
                <li><button onclick="window.location.href='{{ route('home') }}'">Home</button></li>
                <li><a href="#Orders">Orders</a></li>
            </ul>
        </div>

        
    </div>
    
    <div class="main-checkout">   
        <h1>Order Summary</h1>

        @if (!empty($cart))
            <h2>Order Summary</h2>
            <table class="cart-items">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price (RM)</th>
                        <th>Quantity</th>
                        <th>Total (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $itemName => $item)
                        <tr>
                            <td>{{ $itemName }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="cart-total">Grand Total: RM {{ number_format(array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart)), 2) }}</p>
        @else
            <p>Your cart is empty.</p>
        @endif

        <button id="proceed-btn">Proceed</button>
    </div>
    
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>