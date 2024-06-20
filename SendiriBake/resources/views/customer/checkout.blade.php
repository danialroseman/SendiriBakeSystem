<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle ?? 'Sendiri Bake' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custstyle.css') }}">
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

            <div id="payment-method">
                <h2>Select Payment Method:</h2>
                <label>
                    <input type="radio" name="paymentMethod" value="COD" checked> Cash On Delivery
                </label>
                <label>
                    <input type="radio" name="paymentMethod" value="QrTransfer"> QR Transfer
                </label>
            </div>
            <div id="qr-code">
                <img id="qr-code-image" src="{{ asset('images/qrpaycropped.jpeg') }}" alt="QR Code">
            </div>
            <div id="pdf-upload">
                <h2>Upload PDF Receipt:</h2>
                <input type="file" id="receipt-file" accept="application/pdf">
            </div>
            <button id="place-order">Place Order</button>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>

    


    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Register Your Order</h2>
            <form id="orderForm" enctype="multipart/form-data">
                <label for="custName">Customer Name:</label>
                <input type="text" id="custName" name="custName" required><br>
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" id="phoneNumber" name="phoneNumber" required><br>
                <input type="file" id="order-receipt-file" accept="application/pdf" style="display:none;"> <!-- Hidden receipt upload for order modal -->
                <input type="hidden" name="paymentMethod" id="paymentMethod">
                <button type="submit">Submit Order</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
