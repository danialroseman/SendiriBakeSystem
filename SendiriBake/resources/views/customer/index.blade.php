<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle ?? 'Sendiri Bake' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custstyle.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body id="index-page">
    <div class="header">   
        <div class="logo">
            <img src="{{ asset('images/sendiribakelogo.png') }}" alt="Logo">
            <h1>Sendiri Bake</h1>
        </div>
        <div class="menu">
            <ul>
                <li><button onclick="window.location.href='{{ route('customer.home') }}'">Home</button></li>
                <li><button onclick="window.location.href='{{ route('customer.order') }}'">Order</button></li>
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

    <div class="main-container">
        <div class="content-area">

            <div class="cart">
                <!-- Add Pickup Date Input -->
                <label for="pickupDate">Pickup Date:</label>
                <input type="date" id="pickupDate" name="pickupDate" required><br>

                <h2 style="padding-top:10px">Your Cart</h2>
                <div id="cart-items" class="cart-items">
                    <p id="empty-cart-message" class="empty-cart-message">Your cart is empty</p>
                </div>
                <hr>
                <p id="cart-subtotal">Subtotal: RM 0</p>
                <button id="checkout">Checkout</button>
            </div>

            <div class="product-display">
                @foreach(['creampuffs', 'cupcakes', 'munchies', 'cakes'] as $category)
                    <section id="{{ $category }}">
                        <h2>{{ ucfirst($category) }}</h2>
                        <div class="main" style="padding-top: 40px;">
                            @foreach($$category as $product)
                                <div class="product-card" data-name="{{ $product->Pname }}" data-desc="{{ $product->Pdesc }}" data-price="{{ $product->price }}" data-image="{{ asset($product->Pimage) }}">
                                    <img src="{{ asset($product->Pimage) }}" alt="{{ $product->Pname }}">
                                    <h3>{{ $product->Pname }}</h3>
                                    <!--<p>{{ $product->Pdesc }}</p>-->
                                    <p>Price: RM{{ $product->price }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>

        </div>
    </div>

    <!-- Overlay Element -->
    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <span class="close-btn">&times;</span>
            <img id="overlay-image" src="" alt="">
            <h3 id="overlay-name"></h3>
            <p id="overlay-desc"></p>
            <p id="overlay-price"></p>
            <button id="add-to-cart-overlay">Add to Cart</button>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/scroll.js') }}"></script>
</body>
</html>