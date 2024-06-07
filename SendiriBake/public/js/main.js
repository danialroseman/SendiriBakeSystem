document.addEventListener('DOMContentLoaded', function () {
    const indexPage = document.getElementById('index-page');
    if(indexPage){
        const overlay = document.getElementById('overlay');
        const overlayImage = document.getElementById('overlay-image');
        const overlayName = document.getElementById('overlay-name');
        const overlayDesc = document.getElementById('overlay-desc');
        const overlayPrice = document.getElementById('overlay-price');
        const closeBtn = document.querySelector('.close-btn');
        const emptyCartMessage = document.getElementById('empty-cart-message');
        const cartItemsContainer = document.getElementById('cart-items');
        const cartSubtotal = document.getElementById('cart-subtotal');
        let cart = {};

        function updateCartDisplay() {
            cartItemsContainer.innerHTML = '';
            let subtotal = 0;

            for (const [name, item] of Object.entries(cart)) {
                const itemTotal = item.quantity * item.price;
                subtotal += itemTotal;

                const cartItem = document.createElement('div');
                cartItem.classList.add('cart-item');
                cartItem.innerHTML = `
                    <div class="cart-item-info">
                        <button class="quantity-decrease" data-name="${name}">-</button>
                        <span class="cart-item-quantity">${item.quantity}</span>
                        <button class="quantity-increase" data-name="${name}">+</button>
                        <span class="cart-item-name">${name}</span>
                    </div>
                    <div class="cart-item-total">RM ${itemTotal.toFixed(2)}</div>
                    <span class="cart-item-remove" data-name="${name}">&times;</span>
                `;
                cartItemsContainer.appendChild(cartItem);
            }

            cartSubtotal.textContent = `Subtotal: RM ${subtotal.toFixed(2)}`;
            checkCartEmpty();
        }

        function checkCartEmpty() {
            if (Object.keys(cart).length === 0) {
                emptyCartMessage.style.display = 'block';
            } else {
                emptyCartMessage.style.display = 'none';
            }
        }

        function addProductToCart(name, price) {
            fetch('/add-to-cart', {
                method: 'POST',
                body: JSON.stringify({ name: name, price: price }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                cart = data.cart;
                updateCartDisplay();
            })
            .catch(error => console.error('Error:', error));
        }

        function removeCartItem(name) {
            fetch('/remove-from-cart', {
                method: 'POST',
                body: JSON.stringify({ name: name }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                cart = data.cart;
                updateCartDisplay();
            })
            .catch(error => console.error('Error:', error));
        }

        function changeCartItemQuantity(name, increment) {
            if (cart[name]) {
                cart[name].quantity += increment;
                if (cart[name].quantity <= 0) {
                    delete cart[name];
                }
                updateCartDisplay();
                saveCart();
            }
        }

        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function (event) {
                if (!event.target.classList.contains('add-to-cart')) {
                    overlayImage.src = card.getAttribute('data-image');
                    overlayName.textContent = card.getAttribute('data-name');
                    overlayDesc.textContent = card.getAttribute('data-desc');
                    overlayPrice.textContent = 'Price: RM' + card.getAttribute('data-price');
                    overlay.style.display = 'flex';
                }
            });
        });

        document.addEventListener('click', function(event) {
            const name = event.target.getAttribute('data-name');
            if (event.target.classList.contains('quantity-decrease')) {
                changeCartItemQuantity(name, -1);
            } else if (event.target.classList.contains('quantity-increase')) {
                changeCartItemQuantity(name, 1);
            } else if (event.target.classList.contains('cart-item-remove')) {
                removeCartItem(name);
            }
        });

        const addToCartOverlayButton = document.getElementById('add-to-cart-overlay');
        addToCartOverlayButton.addEventListener('click', function() {
            const productName = overlayName.textContent;
            const productPrice = overlayPrice.textContent.replace('Price: RM', '').trim();
            addProductToCart(productName, productPrice);
            overlay.style.display = 'none';  
        });

        fetch('/get-cart')
        .then(response => response.json())
        .then(data => {
            cart = data.cart;
            updateCartDisplay();
        })
        .catch(error => console.error('Error:', error));

        const checkoutButton = document.getElementById('checkout');
        if(checkoutButton){
            checkoutButton.addEventListener('click', function() {
                window.location.href = '/checkout';
            });
        }
        

        function saveCart() {
            fetch('/save-cart', {
                method: 'POST',
                body: JSON.stringify({ cart: cart }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => console.log('Cart saved successfully.'))
            .catch(error => console.error('Error saving cart:', error));
        }
        return;
    }


    //place order scripts
    const checkoutPage=document.getElementById('checkout-page');
    if(checkoutPage){
        const modal = document.getElementById('orderModal');
        const placeOrderButton = document.getElementById('place-order');
        const closeModalButton = document.querySelector('.modal .close');
        const orderForm = document.getElementById('orderForm');

        if(placeOrderButton){
            placeOrderButton.addEventListener('click', function () {
                modal.style.display = 'block';
                console.log('place button clicked');
            });
        }

        closeModalButton.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        window.addEventListener('click', function (event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });

        orderForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent form submission
            const custName = document.getElementById('custName').value;
            const phoneNumber = document.getElementById('phoneNumber').value;

            fetch('/place-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ custName: custName, phoneNumber: phoneNumber })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Place order response:', data);

                if (data.success) {
                    alert('Order placed successfully!, Please Wait for you order to be confirmed.');
                    //window.location.href = '/order-success'; // Example redirect
                } else {
                    alert('Failed to place order. Please try again.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
        return;


    }


        
});



