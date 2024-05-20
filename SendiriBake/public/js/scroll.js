document.addEventListener('DOMContentLoaded', function() {
    // Get all navigation links
    const navLinks = document.querySelectorAll('.cust-nav a');

    // Add click event listener to each navigation link
    navLinks.forEach(function(navLink) {
        navLink.addEventListener('click', function(event) {
            // Prevent default anchor behavior
            event.preventDefault();

            // Get the target section ID from the href attribute
            const targetId = navLink.getAttribute('href');

            // Get the offset top of the target section
            const targetOffsetTop = document.querySelector(targetId).offsetTop;

            // Scroll to the target section with smooth behavior
            window.scrollTo({
                top: targetOffsetTop - 100, // Adjusted value to account for the fixed header
                behavior: 'smooth'
            });
        });
    });
});

