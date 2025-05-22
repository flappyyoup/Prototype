<?php
// Include the database connection
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Sangla Requests</title>
  <!-- Google Font: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    /* Navbar Styles */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #0e2f1c;
      padding: 10px 20px;
      color: white;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
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

    body {
      font-family: 'Poppins', sans-serif;
      background: #f5d789;
      margin: 0;
      padding: 20px;
      padding-top: 60px; /* Add padding to body to account for fixed navbar */
    }

    h1 {
      text-align: center;
      color: #1a4d2e;
      margin-bottom: 30px;
      font-size: 2rem;
    }

    .request-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
      max-width: 700px;
      margin: 0 auto;
    }

    .card {
      background: linear-gradient(135deg, #ffffff, #f9fff2);
      border-left: 8px solid #38b000;
      border-radius: 16px;
      padding: 18px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.08);
      display: flex;
      gap: 15px;
      align-items: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .card img {
      width: 90px;
      height: 90px;
      object-fit: cover;
      border-radius: 10px;
      border: 3px solid #38b000;
    }

    .card-content {
      flex: 1;
    }

    .item-name {
      font-size: 1.3em;
      font-weight: 700;
      color: #1a4d2e;
      margin-bottom: 4px;
    }

    .info {
      font-size: 0.95em;
      color: #444;
      margin: 3px 0;
    }

    .status {
      display: inline-block;
      padding: 5px 12px;
      border-radius: 50px;
      font-size: 0.85em;
      font-weight: bold;
      margin-top: 6px;
      letter-spacing: 0.5px;
    }

    .status.pending {
      background: #fff3cd;
      color: #b88a00;
    }

    .status.appraised {
      background: #d1ffbf;
      color: #207b00;
    }

    .actions {
      margin-top: 10px;
    }

    .actions button {
      padding: 8px 16px;
      font-size: 0.85em;
      margin-right: 8px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .view-btn {
      background-color: #ffc300; /* yellow */
      color: #3f2d00;
    }

    .view-btn:hover {
      background-color: #e6ac00;
      transform: scale(1.05);
    }

    .accept-btn {
      background-color: #38b000; /* green */
      color: #fff;
    }

    .accept-btn:hover {
      background-color: #2d8a00;
      transform: scale(1.05);
    }

    @media (max-width: 700px) {
      .card {
        flex-direction: column;
        align-items: flex-start;
      }

      .card img {
        width: 100%;
        height: auto;
      }
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
      <div class="cart-container" style="position: relative;">
        <button onclick="toggleCart()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">
          <i class="fas fa-shopping-cart"></i>
        </button>
        <span class="cart-count">0</span>
      </div>

      <!-- Notification Icon -->
      <div style="position: relative;">
        <button id="notificationBtn" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer; padding: 0;">
          <i class="fas fa-bell"></i>
          <span class="notification-badge" id="notificationBadge">0</span>
        </button>
      </div>

      <!-- SANGLA NOW Button -->
      <button onclick="window.location.href='sangla.php'" class="sangla-btn">
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
          <a href="sanglarequests.php">Sangla Requests</a>
          <a href="tubo.php">Tubo</a>
          <a href="tubos.php">Tubos</a>
          <a href="sss.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Profile dropdown toggle
    function toggleProfileMenu() {
      const profileMenu = document.querySelector('.profile-menu');
      profileMenu.classList.toggle('active');
    }

    // Close profile menu if clicked outside
    document.addEventListener('click', function (event) {
      const profileMenu = document.querySelector('.profile-menu');
      if (!profileMenu.contains(event.target)) {
        profileMenu.classList.remove('active');
      }
    });
  </script>

  <h1>My Sangla Requests</h1>
  <div class="request-container">
    
    <!-- Request 1 -->
    <div class="card">
      <img src="https://via.placeholder.com/90" alt="Gold Necklace">
      <div class="card-content">
        <div class="item-name">18K Gold Necklace</div>
        <div class="info">Ref ID: SG-20250521-001</div>
        <div class="info">Submitted: May 21, 2025</div>
        <div class="info">Appraised Value: ₱8,500</div>
        <div class="status appraised">Appraised</div>
        <div class="actions">
          <button class="view-btn">View Details</button>
          <button class="accept-btn">Accept Offer</button>
        </div>
      </div>
    </div>

    <!-- Request 2 -->
    <div class="card">
      <img src="https://via.placeholder.com/90" alt="Gold Ring">
      <div class="card-content">
        <div class="item-name">14K Gold Ring</div>
        <div class="info">Ref ID: SG-20250520-002</div>
        <div class="info">Submitted: May 20, 2025</div>
        <div class="info">Appraised Value: --</div>
        <div class="status pending">Pending</div>
        <div class="actions">
          <button class="view-btn">View Details</button>
        </div>
      </div>
    </div>

  </div>
</body>
</html>
