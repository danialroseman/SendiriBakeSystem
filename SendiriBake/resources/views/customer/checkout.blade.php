<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle ?? 'Sendiri Bake' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custstyle.css') }}">
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

        <div class="cust-nav">
            <ul>
                <li><a href="#creampuffs">Creampuff and Eclairs</a></li>
                <li><a href="#cupcakes">Cupcakes</a></li>
                <li><a href="#munchies">Munchies</a></li>
                <li><a href="#cakes">Cakes</a></li>
            </ul>
        </div>
    </div>
    
    <div class="main-checkout">   
        <h1>Checkout</h1>

        @if (!empty($cart))
            <h2>Cart Items</h2>
            <ul>
                @foreach ($cart as $itemName => $item)
                    <li>{{ $itemName }} - Price: {{ $item['price'] }}</li>
                    <!-- Include other item details as needed -->
                @endforeach
            </ul>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
    
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>