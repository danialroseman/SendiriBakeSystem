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

        const pickupDateElement = document.getElementById('pickupDate');
        pickupDateElement.addEventListener('change', function () {
            // Store the pickup date in session storage
            sessionStorage.setItem('pickupDate', pickupDateElement.value);
        });

        function setMinDate(){// set constraints to pickup date input at cart.
            const pickupDate = document.getElementById('pickupDate').value;
            const today = new Date();
            today.setDate(today.getDate()+3);
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const minDate = `${year}-${month}-${day}`;
            pickupDateElement.setAttribute('min', minDate);
        }

        setMinDate();//function call

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
                event.stopPropagation(); // Stop the event from propagating to the document
                if (!event.target.classList.contains('add-to-cart')) {
                    overlayImage.src = card.getAttribute('data-image');
                    overlayName.textContent = card.getAttribute('data-name');
                    overlayDesc.textContent = card.getAttribute('data-desc');
                    overlayPrice.textContent = 'Price: RM' + card.getAttribute('data-price');
                    overlay.style.display = 'flex';
                }
            });
        });

        closeBtn.addEventListener('click', function () {
            overlay.style.display = 'none';
        });

        document.addEventListener('click', function(event) {
            // Check if the click target is not the overlay or any of its children
            if (!event.target.closest('.overlay-content')) {
                overlay.style.display = 'none';
            }
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

        fetch('/get-cart')// AJAX for getting the session cart
        .then(response => response.json())
        .then(data => {
            cart = data.cart;
            updateCartDisplay();
        })
        .catch(error => console.error('Error:', error));

        
        const checkoutButton = document.getElementById('checkout');
        if(checkoutButton){
            checkoutButton.addEventListener('click', function() {
                const pickupDate = document.getElementById('pickupDate').value;
                if (!pickupDate) {
                    alert('Please select a pickup date.');
                    event.preventDefault(); // Prevent the form from being submitted
                }else{
                    window.location.href = '/checkout';
                }
            });
        }
        

        function saveCart() { // AJAX for saving the session cart
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
    const checkoutPage = document.getElementById('checkout-page');
    if (checkoutPage) {
        const placeOrderButton = document.getElementById('place-order');
        const closeModalButton = document.querySelector('.modal .close');
        const orderModal = document.getElementById('orderModal');
        const orderForm = document.getElementById('orderForm');
        const pickupDate = sessionStorage.getItem('pickupDate') || '';
        const paymentMethodRadioButtons = document.querySelectorAll('input[name="paymentMethod"]');
        const qrTransferDiv = document.getElementById('qr-code');
        const pdfUploadDiv = document.getElementById('pdf-upload');
    
        qrTransferDiv.style.display = 'none';
        pdfUploadDiv.style.display = 'none';
    
        paymentMethodRadioButtons.forEach(radioButton => {
            radioButton.addEventListener('change', function () {
                console.log('Payment method changed:', this.value);
                const selectedValue = this.value;
                if (selectedValue === 'QrTransfer') {
                    qrTransferDiv.style.display = 'block';
                    pdfUploadDiv.style.display = 'block';
                    console.log('QR Transfer selected, showing QR code and PDF upload.');
                } else {
                    qrTransferDiv.style.display = 'none';
                    pdfUploadDiv.style.display = 'none';
                    console.log('Non-QR Transfer selected, hiding QR code and PDF upload.');
                }
            });
        });
    
        placeOrderButton.addEventListener('click', function () {
            const receiptFileInput = document.getElementById('receipt-file');
            const mainReceiptFile = receiptFileInput.files[0];
            console.log('Main receipt file:', mainReceiptFile);
            sessionStorage.setItem('mainReceiptFile', JSON.stringify(mainReceiptFile));
            console.log('Session storage:', sessionStorage.getItem('mainReceiptFile'));
            orderModal.style.display = 'block';
        });
        
      
        closeModalButton.addEventListener('click', function () {
            orderModal.style.display = 'none';
        });
    
        window.addEventListener('click', function (event) {
            if (event.target == orderModal) {
                orderModal.style.display = 'none';
            }
        });
    
        orderModal.addEventListener('click', function() {
            const receiptFileString = sessionStorage.getItem('mainReceiptFile');
            if (receiptFileString) {
                const receiptFile = JSON.parse(receiptFileString);
                console.log('Receipt file:', receiptFile);
                // Now you can use the receiptFile object as needed
            }
        });
            
        orderForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const custName = document.getElementById('custName').value;
            const phoneNumber = document.getElementById('phoneNumber').value;
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            const receiptFile = document.getElementById('receipt-file').files[0];
            
            console.log('Receipt file:', receiptFile);//debug

            const formData = new FormData();
            formData.append('custName', custName);
            formData.append('phoneNumber', phoneNumber);
            formData.append('pickupDate', pickupDate);
            formData.append('paymentMethod', paymentMethod);
            if (paymentMethod === 'QrTransfer' && receiptFile) {
                formData.append('receipt-file', receiptFile);
            }
    
            fetch('/place-order', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Place order response:', data);
                if (data.success) {
                    alert('Order placed successfully!, Please Wait for your order to be confirmed.');
                    window.location.href = '/customer';
                } else {
                    alert('Failed to place order. Please try again.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
    
});



