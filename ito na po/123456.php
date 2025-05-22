<?php
include 'db.php';
include 'navbar.php';

// Fetch all sangla requests
$stmt = $conn->prepare("SELECT * FROM sangla_items ORDER BY created_at DESC");
$stmt->execute();
$sangla_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sangla Requests</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.4;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            min-height: 100vh;
            padding: 1rem;
            margin: 0;
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .page-header {
            margin-bottom: 2rem;
            color: #1d4b0b;
        }

        .requests-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .request-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .request-card h3 {
            color: #1d4b0b;
            margin-bottom: 1rem;
        }

        .request-details {
            margin-bottom: 1rem;
        }

        .request-details p {
            margin: 0.5rem 0;
            color: #2c3e50;
        }

        .request-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-approve {
            background: #1d4b0b;
            color: white;
        }

        .btn-reject {
            background: #dc3545;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-redeemed {
            background: #cce5ff;
            color: #004085;
        }

        .status-forfeited {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
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
                    <a href="tubo.php">Tubo</a>
                    <a href="tubos.php">Tubos</a>
                    <a href="sss.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h1>Sangla Requests</h1>
        </div>

        <div class="requests-grid">
            <?php foreach($sangla_requests as $request): ?>
            <div class="request-card">
                <h3><?php echo htmlspecialchars($request['item_name']); ?></h3>
                <div class="request-details">
                    <p><strong>Type:</strong> <?php echo htmlspecialchars($request['item_type']); ?></p>
                    <p><strong>Brand:</strong> <?php echo htmlspecialchars($request['brand']); ?></p>
                    <p><strong>Karat:</strong> <?php echo htmlspecialchars($request['karat']); ?></p>
                    <p><strong>Grams:</strong> <?php echo htmlspecialchars($request['grams']); ?></p>
                    <p><strong>Estimated Value:</strong> ₱<?php echo number_format($request['estimated_value'], 2); ?></p>
                    <p><strong>Branch:</strong> <?php echo htmlspecialchars($request['branch']); ?></p>
                    <p><strong>Status:</strong> 
                        <span class="status-badge status-<?php echo strtolower($request['status']); ?>">
                            <?php echo ucfirst($request['status']); ?>
                        </span>
                    </p>
                </div>
                <?php if($request['status'] == 'active'): ?>
                <div class="request-actions">
                    <button class="btn btn-approve" onclick="updateStatus(<?php echo $request['id']; ?>, 'redeemed')">Approve</button>
                    <button class="btn btn-reject" onclick="updateStatus(<?php echo $request['id']; ?>, 'forfeited')">Reject</button>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
    function updateStatus(id, status) {
        if(confirm('Are you sure you want to ' + status + ' this request?')) {
            fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id + '&status=' + status
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error updating status: ' + error.message);
            });
        }
    }
    </script>
</body>
</html> 