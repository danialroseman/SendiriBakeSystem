document.addEventListener('DOMContentLoaded', function() {
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
                    <button class="quantity-decrease">-</button>
                    <span class="cart-item-quantity">${item.quantity}</span>
                    <button class="quantity-increase">+</button>
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

    // Function to add product to cart
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
            if (data.success) {
                cart = data.cart;
                updateCartDisplay();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

        document.getElementById('overlay').style.display = 'none';
    }

    // Function to remove all instances of an item from cart
    function removeCartItem(name) {
        if (cart[name]) {
            delete cart[name];
            updateCartDisplay();
        }

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
            if (data.success) {
                cart = data.cart;
                updateCartDisplay();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }


    // Function to decrease cart item quantity
    function decreaseCartItemQuantity(name) {
        if (cart[name] && cart[name].quantity > 0) {
            cart[name].quantity -= 1;
            if (cart[name].quantity === 0) {
                delete cart[name];
            }
            updateCartDisplay();
        }
    }


    function increaseCartItemQuantity(name) {
        if (cart[name]) {
            cart[name].quantity += 1;
            updateCartDisplay();
        }
    }

    document.querySelectorAll('.product-card').forEach(card => {
        const addToCartButton = card.querySelector('#add-to-cart');
        if (addToCartButton) {
            addToCartButton.addEventListener('click', function() {
                const productName = card.getAttribute('data-name');
                const productPrice = card.getAttribute('data-price');
                addProductToCart(productName, productPrice);
            });
        }
    });

    // Use event delegation to handle button clicks
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('quantity-decrease')) {
            const itemName = event.target.parentElement.querySelector('.cart-item-name').textContent;
            decreaseCartItemQuantity(itemName);
        } else if (event.target.classList.contains('quantity-increase')) {
            const itemName = event.target.parentElement.querySelector('.cart-item-name').textContent;
            increaseCartItemQuantity(itemName);
        } else if (event.target.classList.contains('cart-item-remove')) {
            const itemName = event.target.getAttribute('data-name');
            removeCartItem(itemName);
        }
    });

    // Fetch initial cart data from the server
    fetch('/get-cart')
        .then(response => response.json())
        .then(data => {
            cart = data.cart;
            updateCartDisplay();
        })
        .catch(error => {
            console.error('Error:', error);
        });

    const addToCartOverlayButton = document.getElementById('add-to-cart-overlay');
    addToCartOverlayButton.addEventListener('click', function() {
        const overlayName = document.getElementById('overlay-name').innerText;
        const overlayPrice = document.getElementById('overlay-price').innerText.replace('Price: RM', '').trim();
        addProductToCart(overlayName, overlayPrice);
    });

    function redirectToCheckout() {
        const cartJson = JSON.stringify(cart);
        const encodedCartData = encodeURIComponent(cartJson);
        const checkoutUrl = '/checkout?cart=' + encodedCartData;
        window.location.href = checkoutUrl;
    }

    const checkoutButton = document.getElementById('checkout');
    checkoutButton.addEventListener('click', redirectToCheckout);
});
