<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle ?? 'Sendiri Bake' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custstyle.css') }}">
</head>
<body>
    <div class="header">   
        <h1>Sendiri Bake</h1>
        
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
            <h2>Your Cart</h2>
            <div id="cart-items" class="cart-items">
                <p id="empty-cart-message" class="empty-cart-message">Your cart is empty</p>
            </div>
        </div>

        <section id="creampuffs"> 
            <h2>Creampuffs</h2>
            <div class="main" style="padding-top: 40px;">
                @foreach($creampuffs as $creampuff)
                    <div class="product-card" data-name="{{ $creampuff->Pname }}" data-desc="{{ $creampuff->Pdesc }}" data-price="{{ $creampuff->price }}" data-image="data:image/jpeg;base64,{{ base64_encode($creampuff->Pimage) }}">
                        <img src="data:image/jpeg;base64,{{ base64_encode($creampuff->Pimage) }}" alt="{{ $creampuff->Pname }}">
                        <h3>{{ $creampuff->Pname }}</h3>
                        <p>{{ $creampuff->Pdesc }}</p>
                        <p>Price: ${{ $creampuff->price }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="cupcakes"> 
            <h2>Cupcakes</h2>
            <div class="main" style="padding-top: 50px;">
                @foreach($cupcakes as $cupcake)
                    <div class="product-card" data-name="{{ $cupcake->Pname }}" data-desc="{{ $cupcake->Pdesc }}" data-price="{{ $cupcake->price }}" data-image="data:image/jpeg;base64,{{ base64_encode($cupcake->Pimage) }}">
                        <img src="data:image/jpeg;base64,{{ base64_encode($cupcake->Pimage) }}" alt="{{ $cupcake->Pname }}">
                        <h3>{{ $cupcake->Pname }}</h3>
                        <p>{{ $cupcake->Pdesc }}</p>
                        <p>Price: ${{ $cupcake->price }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="munchies"> 
            <h2>Munchies</h2>
            <div class="main" style="padding-top: 50px;">
                @foreach($munchies as $munchie)
                    <div class="product-card" data-name="{{ $munchie->Pname }}" data-desc="{{ $munchie->Pdesc }}" data-price="{{ $munchie->price }}" data-image="data:image/jpeg;base64,{{ base64_encode($munchie->Pimage) }}">
                        <img src="data:image/jpeg;base64,{{ base64_encode($munchie->Pimage) }}" alt="{{ $munchie->Pname }}">
                        <h3>{{ $munchie->Pname }}</h3>
                        <p>{{ $munchie->Pdesc }}</p>
                        <p>Price: ${{ $munchie->price }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="cakes"> 
            <h2>Cakes</h2>
            <div class="main" style="padding-top: 50px;">
                @foreach($cakes as $cake)
                    <div class="product-card" data-name="{{ $cake->Pname }}" data-desc="{{ $cake->Pdesc }}" data-price="{{ $cake->price }}" data-image="data:image/jpeg;base64,{{ base64_encode($cake->Pimage) }}">
                        <img src="data:image/jpeg;base64,{{ base64_encode($cake->Pimage) }}" alt="{{ $cake->Pname }}">
                        <h3>{{ $cake->Pname }}</h3>
                        <p>{{ $cake->Pdesc }}</p>
                        <p>Price: ${{ $cake->price }}</p>
                    </div>
                @endforeach
            </div>
        </section>
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
            <button id="add-to-cart">Add to Cart</button>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
