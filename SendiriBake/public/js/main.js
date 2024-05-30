document.addEventListener('DOMContentLoaded', function () {
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

    function addProductToCart(name, price) {
        if (cart[name]) {
            cart[name].quantity += 1;
        } else {
            cart[name] = {
                price: parseFloat(price),
                quantity: 1
            };
        }
        updateCartDisplay();
        saveCart();
    }

    function removeCartItem(name) {
        if (cart[name]) {
            delete cart[name];
        }
        updateCartDisplay();
        saveCart();
    }

    function decreaseCartItemQuantity(name) {
        if (cart[name] && cart[name].quantity > 0) {
            cart[name].quantity -= 1;
            if (cart[name].quantity === 0) {
                delete cart[name];
            }
            updateCartDisplay();
            saveCart();
        }
    }

    function increaseCartItemQuantity(name) {
        if (cart[name]) {
            cart[name].quantity += 1;
            updateCartDisplay();
            saveCart();
        }
    }

    // Add event listeners for product cards
    document.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('click', function (event) {
        console.log('Product card clicked');
        if (!event.target.classList.contains('add-to-cart')) {
            overlayImage.src = card.getAttribute('data-image');
            overlayName.textContent = card.getAttribute('data-name');
            overlayDesc.textContent = card.getAttribute('data-desc');
            overlayPrice.textContent = 'Price: RM' + card.getAttribute('data-price');
            overlay.style.display = 'flex';
        }
    });
});


    // Event listener for quantity decrease, increase, and remove buttons
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

    // Add event listener for "Add to Cart" button on overlay
    const addToCartOverlayButton = document.getElementById('add-to-cart-overlay');
    addToCartOverlayButton.addEventListener('click', function() {
        const productName = overlayName.textContent;
        const productPrice = overlayPrice.textContent.replace('Price: RM', '').trim();
        addProductToCart(productName, productPrice);
        overlay.style.display = 'none';  
    });

    // Fetch cart data and update display
    fetch('/get-cart')
    .then(response => response.json())
    .then(data => {
        cart = data.cart;
        updateCartDisplay();
    })
    .catch(error => {
        console.error('Error:', error);
    });

    // Checkout button event listener
    const checkoutButton = document.getElementById('checkout');
    checkoutButton.addEventListener('click', function() {
        window.location.href = '/checkout';
    });

    // Save cart function
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
        .then(data => {
            console.log('Cart saved successfully.');
        })
        .catch(error => {
            console.error('Error saving cart:', error);
        });
    }
});
