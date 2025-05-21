<?php
// Include the database connection
include 'db.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get user profile picture
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'profile.jpg';

// Handle search functionality
$search_results = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql = "SELECT * FROM homepage_content WHERE section = 'items' AND title LIKE '%$search_query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iPawnshop - Home</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fdfdfd;
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0e2f1c; /* Updated color */
            padding: 10px 20px;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .search-bar {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 20px;
            padding: 5px 10px;
            width: 200px;
        }

        .navbar .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            padding: 5px;
            font-size: 14px;
        }

        .navbar .search-bar button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            color: #4267B2;
        }

        .navbar .nav-icons {
            display: flex;
            gap: 20px;
        }

        .navbar .nav-icons a {
            color: white;
            text-decoration: none;
            font-size: 20px;
            position: relative;
        }

        .navbar .nav-icons a:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        .navbar .nav-icons a:hover {
            color: #f5cc59; /* Highlight on hover */
        }

        .navbar .profile-menu {
            position: relative;
        }

        .navbar .profile-menu .profile-icon {
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

        .navbar .profile-menu .profile-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .navbar .profile-menu .dropdown {
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

        .navbar .profile-menu .dropdown a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: black;
            font-size: 14px;
        }

        .navbar .profile-menu .dropdown a:hover {
            background-color: #f5f5f5;
        }

        .navbar .profile-menu.active .dropdown {
            display: block;
        }

        /* Slider Section */
        .slider {
            position: relative;
            width: 100%;
            height: 500px; /* Keep the slider height */
            overflow: hidden;
            background-color: #fdfdfd; /* Background color for empty space */
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            width: 100%;
            flex-shrink: 0;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fdfdfd; /* Background color for empty space */
        }

        .slide img {
            width: 100%; /* Stretch the image to fill the width of the slide */
            height: 100%; /* Stretch the image to fill the height of the slide */
            object-fit: cover; /* Ensure the image fills the slide while maintaining aspect ratio */
            object-position: center; /* Center the image within the slide */
        }

        .slider .button {
            position: absolute;
            bottom: 20px; /* Position the button inside the slider */
            left: 50%;
            transform: translateX(-50%);
            background-color: #f5cc59;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            z-index: 2; /* Ensure the button is above the image */
        }

        .slider .button:hover {
            background-color: #d4a437;
        }

        /* Remove any margin or padding between sections */
        body, html {
            margin: 0;
            padding: 0;
        }

        .slider, .slides, .slide {
            margin: 0;
            padding: 0;
        }

        /* Navigation Arrows */
        .slider .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            z-index: 1000;
        }

        .slider .arrow.left {
            left: 10px;
        }

        .slider .arrow.right {
            right: 10px;
        }

        .slider .arrow:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        /* Items Section */
        .items-section {
            padding: 4rem 2rem;
            text-align: center;
            background-color: #d6af58;
        }

        .items-section h2 {
            font-size: 2rem;
            color: white;
            margin-bottom: 2rem;
        }

        .items-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 200px;
            cursor: pointer;
        }

        .item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .item p {
            margin: 1rem 0;
            font-size: 1.1rem;
            color: #333;
            font-weight: bold;
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
        // Toggle profile dropdown visibility
        function toggleProfileMenu() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
            }
        }

        // Close the dropdown if clicked outside
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

        let currentSlide = 0;
        let isDragging = false;
        let startPos = 0;
        let currentTranslate = 0;
        let prevTranslate = 0;
        let animationID;
        const slides = document.querySelectorAll('.slide');

        function showSlide(index) {
            const slidesContainer = document.querySelector('.slides');
            const totalSlides = slidesContainer.children.length;
            currentSlide = (index + totalSlides) % totalSlides;
            slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }

        function touchStart(index) {
            return function (event) {
                isDragging = true;
                startPos = getPositionX(event);
                animationID = requestAnimationFrame(animation);
                slides[index].classList.add('grabbing');
            };
        }

        function touchEnd() {
            isDragging = false;
            cancelAnimationFrame(animationID);
            const movedBy = currentTranslate - prevTranslate;

            if (movedBy < -100 && currentSlide < slides.length - 1) nextSlide();
            if (movedBy > 100 && currentSlide > 0) prevSlide();

            setPositionByIndex();
            slides.forEach(slide => slide.classList.remove('grabbing'));
        }

        function touchMove(event) {
            if (isDragging) {
                const currentPosition = getPositionX(event);
                currentTranslate = prevTranslate + currentPosition - startPos;
            }
        }

        function getPositionX(event) {
            return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
        }

        function animation() {
            const slidesContainer = document.querySelector('.slides');
            slidesContainer.style.transform = `translateX(${currentTranslate}px)`;
            if (isDragging) requestAnimationFrame(animation);
        }

        function setPositionByIndex() {
            currentTranslate = currentSlide * -window.innerWidth;
            prevTranslate = currentTranslate;
            const slidesContainer = document.querySelector('.slides');
            slidesContainer.style.transform = `translateX(${currentTranslate}px)`;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const slidesContainer = document.querySelector('.slides');
            slidesContainer.addEventListener('mousedown', touchStart(0));
            slidesContainer.addEventListener('mouseup', touchEnd);
            slidesContainer.addEventListener('mousemove', touchMove);
            slidesContainer.addEventListener('mouseleave', touchEnd);

            slidesContainer.addEventListener('touchstart', touchStart(0));
            slidesContainer.addEventListener('touchend', touchEnd);
            slidesContainer.addEventListener('touchmove', touchMove);

            setInterval(nextSlide, 5000); // Auto-slide every 5 seconds
        });
    </script>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar" style="display: flex; justify-content: space-between; align-items: center; background: #0e2f1c; padding: 10px 20px; color: white; position: sticky; top: 0; z-index: 1000;">
        <!-- Navigation Icons -->
        <div class="nav-icons" style="display: flex; gap: 20px; margin-left: 1000px;">
            <a href="home.php" data-tooltip="Home" style="color: white; text-decoration: none; font-size: 20px; border-bottom: 2px solid #f5b60f;">Home</a>
            <a href="market.php" data-tooltip="Marketplace" style="color: white; text-decoration: none; font-size: 20px;">Marketplace</a>
            <a href="branch.php" data-tooltip="Branches" style="color: white; text-decoration: none; font-size: 20px;">Branch</a>
            <a href="about.php" data-tooltip="About" style="color: white; text-decoration: none; font-size: 20px;">About Us</a>
        </div>
        <!-- Cart Icon -->
        <div class="cart-container" style="position: relative; margin-right: 20px;">
            <a href="javascript:void(0)" onclick="toggleCart()" style="color: white; font-size: 24px; cursor: pointer;" id="cartIcon">🛒</a>
            <span class="cart-count" style="position: absolute; top: -8px; right: -8px; background: #D5AD50; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 12px;">0</span>
        </div>
        <!-- Profile Menu -->
        <div class="profile-menu" style="position: relative;">
            <div class="profile-icon" onclick="toggleProfileMenu()" style="width: 40px; height: 40px; background-color: white; border-radius: 50%; display: flex; justify-content: center; align-items: center; cursor: pointer; overflow: hidden;">
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="dropdown" id="profileDropdown" style="display: none; position: absolute; top: 50px; right: 0; background: white; color: black; box-shadow: 0 2px 5px rgba(0,0,0,0.2); border-radius: 5px; overflow: hidden; z-index: 1000;">
                <a href="profile.php" style="display: block; padding: 10px 20px; text-decoration: none; color: black; font-size: 14px;">Profile</a>
                <a href="transactions.php" style="display: block; padding: 10px 20px; text-decoration: none; color: black; font-size: 14px;">Transactions</a>
                <a href="loan.php" style="display: block; padding: 10px 20px; text-decoration: none; color: black; font-size: 14px;">Loan</a>
                <a href="payments.php" style="display: block; padding: 10px 20px; text-decoration: none; color: black; font-size: 14px;">Payments</a>
                <a href="sss.php" style="display: block; padding: 10px 20px; text-decoration: none; color: black; font-size: 14px;">Log Out</a>
            </div>
        </div>
    </div>

    <!-- First Section: Slider -->
    <div class="slider">
        <div class="slides">
            <div class="slide">
                <img src="images/slider.png" alt="Slide 1">
            </div>
            <div class="slide">
                <img src="Slider1.png" alt="Slide 2">
            </div>
            <div class="slide">
                <img src="https://via.placeholder.com/1200x400.png?text=Slide+3" alt="Slide 3">
            </div>
        </div>
        <button class="button" onclick="window.location.href='marketplace.php'">SANGLA NOW</button>
        <button class="arrow left" onclick="prevSlide()">&#10094;</button>
        <button class="arrow right" onclick="nextSlide()">&#10095;</button>
    </div>

    <!-- Second Section: Items We Accept -->
    <section class="items-section" id="items-section">
        <h2>Items We Accept</h2>
        <div class="items-container">
            <div class="item" onclick="window.location.href='marketplace.php?category=necklace'">
                <img src="images/necklace.jpg" alt="Necklace">
                <p>Necklace</p>
            </div>
            <div class="item" onclick="window.location.href='marketplace.php?category=earrings'">
                <img src="images/earrings.jpg" alt="Earrings">
                <p>Earrings</p>
            </div>
            <div class="item" onclick="window.location.href='marketplace.php?category=ring'">
                <img src="images/ring.jpg" alt="Ring">
                <p>Ring</p>
            </div>
            <div class="item" onclick="window.location.href='marketplace.php?category=watch'">
                <img src="images/watch.jpg" alt="Watch">
                <p>Watch</p>
            </div>
            <div class="item" onclick="window.location.href='marketplace.php?category=bracelet'">
                <img src="images/bracelet.jpg" alt="Bracelet">
                <p>Bracelet</p>
            </div>
        </div>
    </section>


    <!-- Search Results Section -->
    <?php if (!empty($search_results)): ?>
        <div class="search-results">
            <h2>Search Results</h2>
            <div class="items-container">
                <?php foreach ($search_results as $item): ?>
                    <div class="item">
                        <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['title']; ?>" onclick="window.location.href='<?php echo $item['link_url']; ?>'">
                        <p><?php echo $item['title']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

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