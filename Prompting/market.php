<?php
include 'db.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get user profile picture
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'profile.jpg';

// Fetch all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Marketplace</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #D5AD50;
      overflow-x: hidden; /* Prevent horizontal scroll */
    }

    /* Navbar Styles */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #0e2f1c;
      padding: 10px 20px;
      color: white;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .navbar .nav-right {
      display: flex;
      align-items: center;
      gap: 30px;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      font-size: 16px;
    }

    .navbar a:hover {
      color: #f5cc59;
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

    .navbar .sangla-btn {
      background-color: #f5cc59;
      color: #0e2f1c;
      border: none;
      padding: 8px 16px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    .navbar .sangla-btn:hover {
      background-color: #d4a437;
    }

    .top-bar {
      display: flex;
      align-items: center;
      background-color: #0F3C2C;
      padding: 10px 20px;
      /* Add this to ensure spacing between nav and the left edge */
      justify-content: flex-end;
    }

    .search-bar {
      padding: 8px 12px;
      border-radius: 20px;
      border: none;
      width: 200px;
      margin-right: auto;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 25px;
      margin-left: auto; /* Push nav to the right */
    }

    nav a {
      color: white;
      text-decoration: none;
      font-size: 18px;
    }

    nav a.active {
      border-bottom: 2px solid white;
    }

    .cart-icon {
      color: white;
      font-size: 20px;
      cursor: pointer;
    }

    .logout-btn {
      background-color: #D5AD50;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }

    main {
      display: flex;
    }

    .filter-toggle-btn {
      position: relative;
      background: #0F3C2C;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 8px 12px;
      font-size: 16px;
      cursor: pointer;
      z-index: 1;
      transition: all 0.3s;
      width: 35px;
      height: 35px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .filter-toggle-btn:hover {
      background: #1a5a3f;
      transform: scale(1.05);
    }

    .filter-panel {
      position: fixed;
      top: 70px;
      left: -270px;
      width: 250px;
      height: calc(100vh - 70px);
      background: #0F3C2C;
      padding: 24px 20px 20px 20px;
      box-shadow: 2px 0 8px rgba(0,0,0,0.08);
      transition: transform 0.3s ease;
      z-index: 1000;
      transform: translateX(0);
      visibility: hidden;
      opacity: 0;
      border-radius: 0 15px 15px 0;
    }

    .filter-panel.open {
      transform: translateX(270px);
      visibility: visible;
      opacity: 1;
    }

    .filter-panel h3 {
      margin-top: 0;
      color: #D5AD50;
    }

    .filter-group {
      margin-bottom: 18px;
      background: rgba(213, 173, 80, 0.1);
      padding: 15px;
      border-radius: 8px;
    }

    .filter-panel label {
      display: flex;
      align-items: center;
      margin: 6px 0;
      cursor: pointer;
      font-size: 16px;
      color: white;
    }

    .filter-panel input[type="radio"],
    .filter-panel input[type="checkbox"] {
      accent-color: #D5AD50;
      margin-right: 8px;
    }

    .filter-panel .close-btn {
      background: none;
      border: none;
      font-size: 22px;
      color: #D5AD50;
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: background-color 0.3s;
    }

    .filter-panel .close-btn:hover {
      background: rgba(213, 173, 80, 0.2);
    }

    .filter-panel p {
      color: #D5AD50;
      font-weight: bold;
    }

    .main-content {
      margin-left: 0;
      transition: margin-left 0.3s;
    }

    @media (min-width: 900px) {
      .main-content {
        margin-left: 0;
        transition: margin-left 0.3s;
      }
      .filter-panel.open ~ .main-content {
        margin-left: 250px;
      }
    }

    .products .product-card.filtered {
      outline: 3px solid #0F3C2C;
      background: #e7e7c7;
    }

    .marketplace {
      flex-grow: 1;
      padding: 10px;
      margin-left: 0; /* Changed from 20px to 0 */
      width: 100%;
      box-sizing: border-box;
    }

    .marketplace-header {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      padding: 10px;
      margin-top: 10px; /* Add space below navbar */
      gap: 15px;
      position: relative;
      z-index: 1;
    }

    .marketplace-header .search-bar {
      width: 250px;
      padding: 8px 12px;
      border-radius: 20px;
      border: none;
      font-size: 16px;
    }

    .marketplace-header select {
      width: 250px;
      padding: 8px 12px;
      border-radius: 20px;
      border: none;
      font-size: 16px;
      background-color: white;
      cursor: pointer;
    }

    .marketplace-header label[for="sort"] {
      margin-right: 0;
      white-space: nowrap;
      font-weight: bold;
    }

    .products {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 10px;
      padding: 15px;
      width: 100%;
      box-sizing: border-box;
    }

    .product-slide {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: repeat(2, 1fr);
      gap: 35px;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 10px;
      box-sizing: border-box;
    }

    .product-card {
      background: #f1f1f1;
      border-radius: 12px;
      padding: 5px;
      text-align: center;
      box-shadow: 0 10px 10px rgba(0,0,0,0.1);
      transition: transform 0.2s ease;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
      min-height: 100px;
      margin: 0;
      box-sizing: border-box;
    }

    .product-card img {
      max-width: 150px;
      height: 150px;
      margin: 0 auto 12px auto;
      border-radius: 5px;
      object-fit: cover;
      display: block;
    }

    .product-card p {
      margin: 6px 0;
      font-size: 14px;
      text-align: center;
    }

    .product-card strong {
      color: #0F3C2C;
      font-size: 15px;
      display: block;
      text-align: center;
    }

    .card-actions {
      display: flex;
      justify-content: center;
      gap: 10px;
      align-items: center;
      margin-top: 12px;
    }

    .card-actions button {
      background-color: #D5AD50;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      font-size: 13px;
      transition: all 0.3s ease;
    }

    .card-actions button:hover {
      background-color: #c49a3f;
      transform: translateY(-2px);
    }

    .card-actions i {
      font-size: 20px;
      cursor: pointer;
      color: #666;
      transition: color 0.2s ease;
    }

    .card-actions i:hover {
      color: #D5AD50;
      transform: scale(1.1);
    }

    .pagination {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 15px;
      font-weight: bold;
      gap: 10px;
    }

    .filter-overlay,
    .cart-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0,0,0,0.5);
      z-index: 999;
      visibility: hidden;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .filter-overlay.active,
    .cart-overlay.active {
      visibility: visible;
      opacity: 1;
    }

    body.panel-open {
      overflow: hidden;
    }

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
      padding: 15px 20px; /* Reduced top padding from 20px to 15px */
      background: #0F3C2C;
      border-top: 1px solid rgba(213, 173, 80, 0.2);
    }

    #cartItems {
      flex: 1;
      overflow-y: auto;
      padding-bottom: 20px;
      margin-bottom: 100px; /* Added margin to prevent overlap with checkout section */
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

    .nav-icons {
      display: flex;
      gap: 20px;
      margin-left: auto;
    }

    @media screen and (max-width: 1200px) {
      .product-slide {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media screen and (max-width: 768px) {
      .product-slide {
        grid-template-columns: 1fr;
        gap: 20px;
        padding: 5px;
      }
      
      .marketplace-header {
        flex-wrap: wrap;
        padding: 10px 0;
      }
      
      .marketplace-header .search-bar,
      .marketplace-header select {
        width: 100%;
        margin: 5px 0;
      }
    }

    /* Add responsive container */
    .container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 15px;
      box-sizing: border-box;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <!-- Left Logo/Brand -->
    <div style="color: #f5cc59; font-weight: bold; font-size: 1.2rem;">iPawnshop</div>

    <!-- Right Navigation -->
    <div class="nav-right">
      <!-- Text Navigation -->
      <a href="home.php">Home</a>
      <a href="market.php">Marketplace</a>
      <a href="branch.php">Branches</a>
      <a href="about.php">About Us</a>

      <!-- Cart Icon -->
      <a href="javascript:void(0)" onclick="toggleCart()" style="color: white; font-size: 20px;" title="Cart">🛒</a>

      <!-- Notification Icon -->
      <a href="notification.php" style="color: white; font-size: 20px;" title="Notification">🔔</a>

      <!-- SANGLA NOW Button -->
      <button onclick="window.location.href='market.php'" class="sangla-btn">
        SANGLA NOW
      </button>

      <!-- Profile Menu -->
      <div class="profile-menu">
        <div class="profile-icon" onclick="toggleProfileMenu()">
          <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile">
        </div>
        <div class="dropdown">
          <a href="profile.php">Profile</a>
          <a href="sangla.php">Sangla</a>
          <a href="tubo.php">Tubo</a>
          <a href="tubos.php">Tubos</a>
          <a href="sss.php">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <div class="main-content" id="mainContent">
    <main>
      <section class="marketplace">
        <div class="marketplace-header">
          <button class="filter-toggle-btn" id="filterToggleBtn" title="Filter">
            <i class="fas fa-sliders-h"></i>
          </button>
          <input type="text" placeholder="Search" class="search-bar" id="searchInput">
          <label for="sort">SORT BY:</label>
          <select id="sort">
            <option>Price Low to High</option>
            <option>Price High to Low</option>
          </select>
        </div>

        <div class="products" id="products">
          <div class="product-slide">
            <?php if ($result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-card" data-category="<?php echo htmlspecialchars($row['category']); ?>" data-karat="<?php echo htmlspecialchars($row['karat']); ?>">
                <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                  <p><strong><?php echo htmlspecialchars($row['name']); ?></strong></p>
                  <p>₱<?php echo number_format($row['price'], 2); ?></p>
                  <div class="card-actions">
                    <i class="far fa-heart"></i>
                    <form action="add_to_cart.php" method="post" style="display: inline;">
                      <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                      <button type="submit">Add to Cart</button>
                    </form>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <p>No products available.</p>
            <?php endif; ?>
          </div>
        </div>

        <div class="pagination">
          <i class="fas fa-arrow-left" id="prevPage" style="cursor: pointer;"></i>
          <span id="pageInfo">1/2</span>
          <i class="fas fa-arrow-right" id="nextPage" style="cursor: pointer;"></i>
        </div>
      </section>
    </main>
  </div>

  <aside class="filter-panel" id="filterPanel">
    <button class="close-btn" id="closeFilterPanel" title="Close">&times;</button>
    <h3>FILTER</h3>
    <div class="filter-group">
      <p style="margin-bottom: 6px;">Category:</p>
      <label><input type="radio" name="category" value="ALL" checked> ALL</label>
      <label><input type="radio" name="category" value="Necklace"> Necklace</label>
      <label><input type="radio" name="category" value="Ring"> Ring</label>
      <label><input type="radio" name="category" value="Earrings"> Earrings</label>
      <label><input type="radio" name="category" value="Bracelet"> Bracelet</label>
      <label><input type="radio" name="category" value="Wristwatch"> Wristwatch</label>
    </div>
    <div class="filter-group">
      <p style="margin-bottom: 6px;">Karat:</p>
      <label><input type="checkbox" name="karat" value="18k"> 18k Gold</label>
      <label><input type="checkbox" name="karat" value="22k"> 22k Gold</label>
      <label><input type="checkbox" name="karat" value="24k"> 24k Gold</label>
    </div>
  </aside>
  <div class="filter-overlay" id="filterOverlay"></div>

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

  <script>
    // Slide filter panel
    const filterToggleBtn = document.getElementById('filterToggleBtn');
    const filterPanel = document.getElementById('filterPanel');
    const closeFilterPanel = document.getElementById('closeFilterPanel');
    const filterOverlay = document.getElementById('filterOverlay');
    const mainContent = document.getElementById('mainContent');

    function openFilter() {
      filterPanel.style.transform = 'translateX(270px)';
      filterPanel.style.visibility = 'visible';
      filterPanel.style.opacity = '1';
      filterOverlay.classList.add('active');
      document.body.classList.add('panel-open');
      mainContent.style.marginLeft = '250px';
    }

    function closeFilter() {
      filterPanel.style.transform = 'translateX(0)';
      filterPanel.style.visibility = 'hidden';
      filterPanel.style.opacity = '0';
      filterOverlay.classList.remove('active');
      document.body.classList.remove('panel-open');
      mainContent.style.marginLeft = '0';
    }

    filterToggleBtn.addEventListener('click', openFilter);
    closeFilterPanel.addEventListener('click', closeFilter);
    filterOverlay.addEventListener('click', closeFilter);

    // Accessibility: close on Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && filterPanel.style.visibility === 'visible') {
        closeFilter();
      }
    });

    // Filtering logic
    const categoryRadios = document.querySelectorAll('input[name="category"]');
    const karatCheckboxes = document.querySelectorAll('input[name="karat"]');
    const productCards = document.querySelectorAll('.product-card');

    function filterProducts() {
      let selectedCategory = document.querySelector('input[name="category"]:checked').value;
      let selectedKarats = Array.from(karatCheckboxes)
        .filter(cb => cb.checked)
        .map(cb => cb.value);

      productCards.forEach(card => {
        let cardCategory = card.getAttribute('data-category');
        let cardKarat = card.getAttribute('data-karat');
        let show = true;

        // Category filter (only one)
        if (selectedCategory !== 'ALL' && cardCategory !== selectedCategory) {
          show = false;
        }

        // Karat filter (can select multiple or none)
        if (selectedKarats.length > 0 && !selectedKarats.includes(cardKarat)) {
          show = false;
        }

        card.style.display = show ? '' : 'none';
        card.classList.toggle('filtered', show && (selectedCategory !== 'ALL' || selectedKarats.length > 0));
      });
    }

    categoryRadios.forEach(radio => {
      radio.addEventListener('change', filterProducts);
    });
    karatCheckboxes.forEach(cb => {
      cb.addEventListener('change', filterProducts);
    });

    // Initial filter
    filterProducts();

    // Toggle profile dropdown visibility
    function toggleProfileMenu() {
      const profileMenu = document.querySelector('.profile-menu');
      profileMenu.classList.toggle('active');
    }

    // Close the dropdown if clicked outside
    document.addEventListener('click', function(event) {
      const profileMenu = document.querySelector('.profile-menu');
      if (!profileMenu.contains(event.target)) {
        profileMenu.classList.remove('active');
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
    }

    function checkout() {
      if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
      }
      // Add your checkout logic here
      alert('Proceeding to checkout...');
    }

    // Close panels when clicking outside
    document.addEventListener('click', function(event) {
      if (filterPanel.classList.contains('open') && 
          !filterPanel.contains(event.target) && 
          !filterToggleBtn.contains(event.target)) {
        closeFilter();
      }
      
      if (cartDrawer.classList.contains('open') && 
          !cartDrawer.contains(event.target) && 
          !event.target.closest('.cart-icon')) {
        toggleCart();
      }
    });

    // Close panels on escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        if (filterPanel.classList.contains('open')) {
          closeFilter();
        }
        if (cartDrawer.classList.contains('open')) {
          toggleCart();
        }
      }
    });

    // Close cart when clicking overlay
    cartOverlay.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleCart();
    });

    // Close cart when pressing escape
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && cartDrawer.classList.contains('open')) {
        toggleCart();
      }
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

    // Updated Pagination functionality
    let currentPage = 1;
    const totalPages = 2;
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    const slides = document.querySelectorAll('.product-slide');

    function updatePagination() {
      // Update page info
      pageInfo.textContent = `${currentPage}/${totalPages}`;
      
      // Show/hide slides based on current page
      slides.forEach((slide, index) => {
        slide.style.display = (index + 1 === currentPage) ? '' : 'none';
      });

      // Update button states
      prevPageBtn.style.opacity = currentPage === 1 ? '0.5' : '1';
      nextPageBtn.style.opacity = currentPage === totalPages ? '0.5' : '1';
    }

    prevPageBtn.addEventListener('click', () => {
      if (currentPage > 1) {
        currentPage--;
        updatePagination();
      }
    });

    nextPageBtn.addEventListener('click', () => {
      if (currentPage < totalPages) {
        currentPage++;
        updatePagination();
      }
    });

    // Initialize pagination
    updatePagination();

    // Sort functionality
    const sortSelect = document.getElementById('sort');
    const searchInput = document.getElementById('searchInput');

    // Search functionality
    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase().trim();
      const productCards = document.querySelectorAll('.product-card');
      
      productCards.forEach(card => {
        const productName = card.querySelector('strong').textContent.toLowerCase();
        const productPrice = card.querySelector('p:nth-of-type(2)').textContent.toLowerCase();
        
        // Check if search term matches product name or price
        const matchesSearch = productName.includes(searchTerm) || productPrice.includes(searchTerm);
        
        // Only show card if it matches search AND current filter settings
        const cardCategory = card.getAttribute('data-category');
        const cardKarat = card.getAttribute('data-karat');
        let selectedCategory = document.querySelector('input[name="category"]:checked').value;
        let selectedKarats = Array.from(document.querySelectorAll('input[name="karat"]:checked'))
          .map(cb => cb.value);
        
        const matchesCategory = selectedCategory === 'ALL' || cardCategory === selectedCategory;
        const matchesKarat = selectedKarats.length === 0 || selectedKarats.includes(cardKarat);
        
        card.style.display = (matchesSearch && matchesCategory && matchesKarat) ? '' : 'none';
      });
      
      // Update pagination to show only visible products
      updatePagination();
    });

    sortSelect.addEventListener('change', function() {
      const selectedSort = sortSelect.value;
      // Find the currently visible slide
      const visibleSlide = Array.from(document.querySelectorAll('.product-slide')).find(slide => slide.style.display !== 'none');
      if (!visibleSlide) return;
      const cards = Array.from(visibleSlide.querySelectorAll('.product-card'));
      // Extract price from each card
      cards.sort((a, b) => {
        const priceA = parseFloat(a.querySelector('p:nth-of-type(2)').textContent.replace(/[^\d.]/g, ''));
        const priceB = parseFloat(b.querySelector('p:nth-of-type(2)').textContent.replace(/[^\d.]/g, ''));
        if (selectedSort === 'Price Low to High') {
          return priceA - priceB;
        } else {
          return priceB - priceA;
        }
      });
      // Re-append sorted cards
      cards.forEach(card => visibleSlide.appendChild(card));
    });
  </script>
</body>
</html>
