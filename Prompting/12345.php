<?php
// filepath: c:\xampp\htdocs\Prompting\about.php

// Include the database connection if needed
include 'db.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get user profile picture
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'profile.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #ffc300;
            --secondary-color: forestgreen;
            --accent-yellow: #ffdd57;
            --accent-green: #a0c334;
            --background-light: #f3f4f6;
            --background-gradient: linear-gradient(135deg, #a0c334, #ffc300);
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--background-light);
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0e2f1c;
            padding: 10px 20px;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 20px;
            padding: 5px 10px;
            width: 200px;
        }

        .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            padding: 5px;
            font-size: 14px;
        }

        .search-bar button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            color: #4267B2;
        }

        .nav-icons {
            display: flex;
            gap: 20px;
        }

        .nav-icons a {
            color: white;
            text-decoration: none;
            font-size: 20px;
        }

        .nav-icons a:hover {
            color: #f5b60f;
        }

        .profile-menu {
            position: relative;
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            overflow: hidden;
        }

        .profile-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background-color: white;
            color: black;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            z-index: 1000;
        }

        .dropdown a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: black;
            font-size: 14px;
        }

        .dropdown a:hover {
            background-color: #f5f5f5;
        }

        .profile-menu.active .dropdown {
            display: block;
        }

        .about-section {
            padding: 6rem 2rem;
            text-align: center;
            background-color: var(--primary-color);
            color: white;
        }

        .creators-section {
            padding: 6rem 2rem;
            text-align: center;
            background-color: var(--secondary-color);
            color: white;
        }

        .creators-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2rem;
            justify-items: center;
        }

        .creator-container {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            width: 100%;
            max-width: 300px;
        }

        .creator-container:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .creator-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .creator-container:hover img {
            opacity: 0.8;
            transform: scale(1.1);
        }

        .creator-details {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .creator-container:hover .creator-details {
            opacity: 1;
            transform: scale(1);
        }

        .creator-details h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .creator-details p {
            font-size: 1rem;
            margin: 0.2rem 0;
        }

        /* Cart Drawer Styles */
        .cart-drawer {
            position: fixed;
            top: 0;
            right: 0;
            width: 400px;
            height: 100vh;
            background: #0F3C2C;
            box-shadow: -2px 0 5px rgba(0,0,0,0.1);
            z-index: 1001;
            transition: transform 0.3s ease, visibility 0.3s ease, opacity 0.3s ease;
            padding: 20px;
            transform: translateX(100%);
            visibility: hidden;
            opacity: 0;
            overflow-y: auto;
            color: white;
            border-radius: 15px 0 0 15px;
            display: flex;
            flex-direction: column;
        }

        .cart-drawer.open {
            transform: translateX(0);
            visibility: visible;
            opacity: 1;
        }

        .cart-drawer h2 {
            color: #D5AD50;
            margin: 0;
        }

        .cart-drawer button[onclick="toggleCart()"] {
            background: none;
            border: none;
            font-size: 26px;
            cursor: pointer;
            color: #D5AD50;
            padding: 5px;
            transition: transform 0.2s ease;
        }

        .cart-drawer button[onclick="toggleCart()"]:hover {
            transform: scale(1.1);
        }

        .cart-drawer > div:last-child {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px 20px;
            background: #0F3C2C;
            border-top: 1px solid rgba(213, 173, 80, 0.2);
        }

        #cartItems {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 20px;
            margin-bottom: 100px;
        }

        #cartItems div {
            border-bottom: 1px solid rgba(213, 173, 80, 0.2);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        #cartItems h3 {
            color: #D5AD50;
            margin: 0;
            font-size: 14px;
        }

        #cartItems p {
            color: white;
            margin: 5px 0;
            font-size: 13px;
        }

        #cartItems button {
            background: none;
            border: none;
            color: #ff6b6b;
            cursor: pointer;
            font-size: 22px;
            padding: 5px;
            transition: transform 0.2s ease;
        }

        #cartItems button:hover {
            transform: scale(1.1);
        }

        .cart-drawer > div:last-child span {
            color: #D5AD50;
            font-weight: bold;
            font-size: 16px;
            display: block;
            margin-bottom: 15px;
        }

        .cart-drawer > div:last-child button {
            background: #D5AD50;
            color: #0F3C2C;
            font-weight: bold;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 14px;
            width: 100%;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .cart-drawer > div:last-child button:hover {
            background: #c49a3f;
            transform: translateY(-2px);
        }

        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .cart-overlay.active {
            visibility: visible;
            opacity: 1;
        }

        body.panel-open {
            overflow: hidden;
        }
    </style>
    <script>
        // Profile dropdown toggle
        function toggleProfileMenu() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
            }
        }

        // Close profile menu if clicked outside
        document.addEventListener('click', function (event) {
            const profileMenu = document.querySelector('.profile-menu');
            const dropdown = document.getElementById('profileDropdown');
            if (!profileMenu.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });

        // Cart functionality
        let cart = [];
        const cartDrawer = document.getElementById('cartDrawer');
        const cartOverlay = document.getElementById('cartOverlay');
        const cartItems = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        const cartCount = document.querySelector('.cart-count');
        const cartIcon = document.getElementById('cartIcon');

        // Add click event listener to cart icon
        cartIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleCart();
        });

        function toggleCart() {
            console.log('Toggling cart...'); // Debug log
            const isOpen = cartDrawer.classList.contains('open');
            console.log('Is cart open?', isOpen); // Debug log
            
            if (isOpen) {
                cartDrawer.classList.remove('open');
                cartOverlay.classList.remove('active');
                document.body.classList.remove('panel-open');
            } else {
                cartDrawer.classList.add('open');
                cartOverlay.classList.add('active');
                document.body.classList.add('panel-open');
            }
        }

        function addToCart(product) {
            console.log('Adding to cart:', product); // Debug log
            const existingItem = cart.find(item => item.id === product.id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({...product, quantity: 1});
            }
            updateCart();
            toggleCart();
        }

        function removeFromCart(productId) {
            console.log('Removing from cart:', productId); // Debug log
            cart = cart.filter(item => item.id !== productId);
            updateCart();
        }

        function updateCart() {
            console.log('Updating cart...'); // Debug log
            cartItems.innerHTML = '';
            let total = 0;
            
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                
                const itemElement = document.createElement('div');
                itemElement.style.display = 'flex';
                itemElement.style.justifyContent = 'space-between';
                itemElement.style.alignItems = 'center';
                itemElement.style.padding = '10px';
                itemElement.style.borderBottom = '1px solid #eee';
                
                itemElement.innerHTML = `
                    <div>
                        <h3 style="margin: 0;">${item.name}</h3>
                        <p style="margin: 5px 0;">₱${item.price.toFixed(2)} x ${item.quantity}</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span>₱${itemTotal.toFixed(2)}</span>
                        <button onclick="removeFromCart('${item.id}')" style="background: none; border: none; color: red; cursor: pointer;">×</button>
                    </div>
                `;
                
                cartItems.appendChild(itemElement);
            });
            
            cartTotal.textContent = `₱${total.toFixed(2)}`;
            cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        function checkout() {
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            // Add your checkout logic here
            alert('Proceeding to checkout...');
        }

        // Close cart when clicking outside
        document.addEventListener('click', function(event) {
            if (cartDrawer.classList.contains('open') && 
                !cartDrawer.contains(event.target) && 
                !event.target.closest('.cart-icon')) {
                toggleCart();
            }
        });

        // Close cart when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && cartDrawer.classList.contains('open')) {
                toggleCart();
            }
        });

        // Close cart when clicking overlay
        cartOverlay.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleCart();
        });

        // Initialize cart
        updateCart();

        // Debug check for cart elements
        console.log('Cart elements:', {
            cartDrawer: cartDrawer,
            cartOverlay: cartOverlay,
            cartItems: cartItems,
            cartTotal: cartTotal,
            cartCount: cartCount,
            cartIcon: cartIcon
        });
    </script>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <!-- Left Logo/Brand -->
        <div style="color: #f5cc59; font-weight: bold; font-size: 1.2rem;">iPawnshop</div>

        <!-- Right Navigation -->
        <div style="display: flex; align-items: center; gap: 30px;">
            <!-- Text Navigation -->
            <a href="home.php" style="color: white; text-decoration: none; font-size: 16px;">Home</a>
            <a href="market.php" style="color: white; text-decoration: none; font-size: 16px;">Marketplace</a>
            <a href="branch.php" style="color: white; text-decoration: none; font-size: 16px;">Branches</a>
            <a href="about.php" style="color: white; text-decoration: none; font-size: 16px;">About Us</a>

            <!-- Cart Icon -->
            <a href="javascript:void(0)" onclick="toggleCart()" style="color: white; font-size: 20px;" title="Cart">🛒</a>

            <!-- Notification Icon -->
            <a href="notification.php" style="color: white; font-size: 20px;" title="Notification">🔔</a>

            <!-- SANGLA NOW Button -->
            <button onclick="window.location.href='market.php'" style="background-color: #f5cc59; color: #0e2f1c; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; font-weight: bold;">
                SANGLA NOW
            </button>

            <!-- Profile Menu -->
            <div class="profile-menu">
                <div class="profile-icon" onclick="toggleProfileMenu()">
                    <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile">
                </div>
                <div class="dropdown">
                    <a href="profile.php">Profile</a>
                    <a href="transactions.php">Transactions</a>
                    <a href="loan.php">Loan</a>
                    <a href="payments.php">Payments</a>
                    <a href="sss.php">Log Out</a>
                </div>
            </div>
        </div>
    </div>

    <!-- About Us Section -->
    <section class="about-section">
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 2rem; max-width: 1200px; margin: 0 auto;">
            <!-- Description -->
            <div style="flex: 1; text-align: left;">
                <h1 class="text-5xl font-extrabold mb-6">About Us</h1>
                <p class="text-lg leading-relaxed">
                    Welcome to iPawnshop, your modern and secure digital partner in pawn transactions. We are committed to transforming traditional pawnshop operations into a seamless, transparent, and customer-friendly experience. Our system empowers both customers and staff with real-time tracking, efficient item management, secure loan processing, and easy-to-use interfaces.At iPawnshop, we value trust, security, and innovation. Whether you're pawning, redeeming, or checking transaction history, we're here to make your journey simple and secure. Let's make smart pawning accessible to everyone—digitally.
                </p>
            </div>
            <!-- Logo Image -->
            <div style="flex: 1; text-align: center; position: relative; top: -20px;">
                <img src="images/about.png" alt="iPawnshop Logo" style="max-width: 100%; height: auto; margin-left: 125px;">
            </div>
        </div>
    </section>

    <!-- Contact and Social Media Section -->
    <section class="contact-social-section" style="background-color: var(--background-light); padding: 4rem 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 2rem; max-width: 1200px; margin: 0 auto;">
            <!-- Contact Details -->
            <div style="flex: 1; text-align: left; margin-left: 50px;">
                <h2 class="text-3xl font-semibold mb-4">Contact Details</h2>
                <p><strong>Phone:</strong> +1 800 123 4567</p>
                <p><strong>Email:</strong> support@ipawnshop.com</p>
                <p><strong>Address:</strong> 123 Pawnshop Lane, Cityville, Country</p>
                <p><strong>Working Hours:</strong> Mon-Fri, 9:00 AM - 6:00 PM</p>
            </div>
            <!-- Follow Us on Social Media -->
            <div style="flex: 1; text-align: left; margin-left: 300px;">
                <h2 class="text-3xl font-semibold mb-4">Follow Us on Social Media</h2>
                <p>Stay connected with us:</p>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="https://facebook.com" target="_blank" style="color: var(--primary-color); text-decoration: none;">Facebook</a></li>
                    <li><a href="https://twitter.com" target="_blank" style="color: var(--primary-color); text-decoration: none;">Twitter</a></li>
                    <li><a href="https://instagram.com" target="_blank" style="color: var(--primary-color); text-decoration: none;">Instagram</a></li>
                    <li><a href="https://linkedin.com" target="_blank" style="color: var(--primary-color); text-decoration: none;">LinkedIn</a></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Creators Section -->
    <section class="creators-section">
        <h2 class="text-4xl font-semibold">Meet the Creators</h2>
        <div class="creators-grid">
            <!-- Creator 1 -->
            <div class="creator-container">
                <img src="images/bea2.jpg" alt="Creator 1">
                <div class="creator-details">
                    <h3>Bea Ramos</h3>
                    <p>Contact: 1234567890</p>
                    <p>Email: ramos@example.com</p>
                </div>
            </div>
            <!-- Creator 2 -->
            <div class="creator-container">
                <img src="images/jed.jpg" alt="Creator 2">
                <div class="creator-details">
                    <h3>Jed Ismael Polong</h3>
                    <p>Contact: 09292222834</p>
                    <p>Email: polong@example.com</p>
                </div>
            </div>
            <!-- Creator 3 -->
            <div class="creator-container">
                <img src="images/Cyril.jpg" alt="Creator 3">
                <div class="creator-details">
                    <h3>Cyril Bucad</h3>
                    <p>Contact: 1122334455</p>
                    <p>Email: bucad@example.com</p>
                </div>
            </div>
            <!-- Creator 4 -->
            <div class="creator-container">
                <img src="images/alex.jpg" alt="Creator 4">
                <div class="creator-details">
                    <h3>Alexa Conception</h3>
                    <p>Contact: 2233445566</p>
                    <p>Email: conception@example.com</p>
                </div>
            </div>
            <!-- Creator 5 -->
            <div class="creator-container">
                <img src="images/daisy.webp" alt="Creator 5">
                <div class="creator-details">
                    <h3>Daisy Barce</h3>
                    <p>Contact: 3344556677</p>
                    <p>Email: barce@example.com</p>
                </div>
            </div>
            <!-- Creator 6 -->
            <div class="creator-container">
                <img src="images/Jhana.jpg" alt="Creator 6">
                <div class="creator-details">
                    <h3>Jhana Raquid</h3>
                    <p>Contact: 4455667788</p>
                    <p>Email: raquid@example.com</p>
                </div>
            </div>
            <!-- Empty Slots for 3x3 Grid -->
            <div class="creator-container"></div>
            <div class="creator-container"></div>
            <div class="creator-container"></div>
        </div>
    </section>

    <!-- Cart Drawer -->
    <div class="cart-drawer" id="cartDrawer">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">Shopping Cart</h2>
            <button onclick="toggleCart()" style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
        </div>
        <div id="cartItems" style="overflow-y: auto; max-height: calc(100vh - 200px);">
            <!-- Cart items will be added here dynamically -->
        </div>
        <div style="position: absolute; bottom: 30px; left: 0; right: 0; padding: 20px; background: white; border-top: 1px solid #eee;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Total:</span>
                <span id="cartTotal">₱0.00</span>
            </div>
            <button onclick="checkout()" style="width: 100%; padding: 10px; background: #D5AD50; color: white; border: none; border-radius: 5px; cursor: pointer;">Checkout</button>
        </div>
    </div>
    <div class="cart-overlay" id="cartOverlay"></div>
</body>
</html>