document.addEventListener('DOMContentLoaded', function() {
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const cartItemsContainer = document.getElementById('cart-items');

    function checkCartEmpty() {
        const cartItems = document.querySelectorAll('.cart-item');
        
        // If no cart items, display "Your cart is empty" message
        if (cartItems.length === 0) {
            emptyCartMessage.style.display = 'block'; // Show the message
        } else {
            emptyCartMessage.style.display = 'none'; // Hide the message
        }
    }

    function addProductToCart(name, price) {
        // Extract price value from the string (remove 'Price: RM')
        const actualPrice = price.replace('Price: RM', '').trim();
        
        // Create cart item element
        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.innerHTML = `
            <p>${name} - RM${actualPrice}</p>
            <span class="cart-item-remove">&times;</span>
        `;
        cartItemsContainer.appendChild(cartItem);

        // Remove item from cart when remove button is clicked
        const removeButton = cartItem.querySelector('.cart-item-remove');
        removeButton.addEventListener('click', function() {
            cartItem.remove();
            checkCartEmpty(); // Check if cart is empty after removing item
        });

        // Close the overlay
        document.getElementById('overlay').style.display = 'none';

        checkCartEmpty(); // Check if cart is empty after adding item
    }

    // The product card 'Add to Cart' button is within the overlay now
    const addToCartOverlayButton = document.getElementById('add-to-cart-overlay');

    addToCartOverlayButton.addEventListener('click', function() {
        const overlayName = document.getElementById('overlay-name').innerText;
        const overlayPrice = document.getElementById('overlay-price').innerText;

        // Add product to cart
        addProductToCart(overlayName, overlayPrice);
    });
});