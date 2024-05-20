document.addEventListener('DOMContentLoaded', function() {
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const cartItemsContainer = document.getElementById('cart-items');
    const cartSubtotal = document.getElementById('cart-subtotal');
    const cart = {};

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
                <div class="cart-item-total">RM ${itemTotal} </div>
                <span class="cart-item-remove" data-name="${name}"> &times;</span>
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
        document.getElementById('overlay').style.display = 'none';
    }

    function removeCartItem(name) {
        if (cart[name]) {
            cart[name].quantity -= 1;
            if (cart[name].quantity <= 0) {
                delete cart[name];
            }
        }
        updateCartDisplay();
    }

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

    const addToCartOverlayButton = document.getElementById('add-to-cart-overlay');
    addToCartOverlayButton.addEventListener('click', function() {
        const overlayName = document.getElementById('overlay-name').innerText;
        const overlayPrice = document.getElementById('overlay-price').innerText.replace('Price: RM', '').trim();
        addProductToCart(overlayName, overlayPrice);
    });
});
