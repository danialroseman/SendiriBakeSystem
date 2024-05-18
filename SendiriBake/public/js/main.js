// /project-root/js/main.js
document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('overlay');
    const overlayImage = document.getElementById('overlay-image');
    const overlayName = document.getElementById('overlay-name');
    const overlayDesc = document.getElementById('overlay-desc');
    const overlayPrice = document.getElementById('overlay-price');
    const closeBtn = document.querySelector('.close-btn');
    
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function () {
            overlayImage.src = card.getAttribute('data-image');
            overlayName.textContent = card.getAttribute('data-name');
            overlayDesc.textContent = card.getAttribute('data-desc');
            overlayPrice.textContent = 'Price: $' + card.getAttribute('data-price');
            overlay.style.display = 'flex'; // Show overlay
        });
    });

    closeBtn.addEventListener('click', function () {
        overlay.style.display = 'none'; // Hide overlay
    });

    window.addEventListener('click', function (event) {
        if (event.target === overlay) {
            overlay.style.display = 'none'; // Hide overlay when clicking outside of the content
        }
    });
});
