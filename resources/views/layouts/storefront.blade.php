<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NEXORA — Store')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/product-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/contact.css') }}">
    @stack('styles')

    <!-- flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    @include('storefront.partials.navbar')

    <main>
        @yield('content')
    </main>

    <!-- Cart JavaScript -->
    <script>
        // Update cart count in header after AJAX request
        function updateCartCount(count) {
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                if (count > 0) {
                    cartCount.textContent = count;
                    cartCount.style.display = 'flex';
                } else {
                    cartCount.style.display = 'none';
                }
            }
        }

        // Add to cart functionality
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartForms = document.querySelectorAll('.add-to-cart-form');
            
            addToCartForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateCartCount(data.cart_count);
                            
                            // Show success message
                            const message = document.createElement('div');
                            message.className = 'fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-in';
                            message.textContent = data.message || 'Added to cart!';
                            document.body.appendChild(message);
                            
                            setTimeout(() => {
                                message.remove();
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>