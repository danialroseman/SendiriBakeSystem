document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('overlay');
    const overlayImage = document.getElementById('overlay-image');
    const overlayName = document.getElementById('overlay-name');
    const overlayDesc = document.getElementById('overlay-desc');
    const overlayPrice = document.getElementById('overlay-price');
    const closeBtn = document.querySelector('.close-btn');

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

    closeBtn.addEventListener('click', function () {
        overlay.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === overlay) {
            overlay.style.display = 'none';
        }
    });

    const addToCartOverlayButton = document.getElementById('add-to-cart-overlay');
    addToCartOverlayButton.addEventListener('click', function() {
        const productName = overlayName.textContent;
        const productPrice = overlayPrice.textContent.replace('Price: RM', '').trim();
        addProductToCart(productName, productPrice);
    });

    /*function addProductToCart(name, price) {
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
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });

        document.getElementById('overlay').style.display = 'none';
    }*/
});
