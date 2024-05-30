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
    <h1>Checkout</h1>
    @if(count($cart) > 0)
        <div id="cart-items">
            @foreach($cart as $name => $item)
                <div class="cart-item">
                    <span class="cart-item-name">{{ $name }}</span>
                    <span class="cart-item-quantity">{{ $item['quantity'] }}</span>
                    <span class="cart-item-price">RM {{ number_format($item['price'], 2) }}</span>
                    <span class="cart-item-total">RM {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                </div>
            @endforeach
        </div>
        <div id="cart-subtotal">
            Subtotal: RM {{ number_format(array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart)), 2) }}
        </div>
        <button id="place-order">Place Order</button>
    @else
        <p>Your cart is empty.</p>
    @endif
    </div>
    
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>