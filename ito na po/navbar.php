<?php
include 'db.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get user profile picture
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'profile.jpg';
?>
<nav class="navbar">
    <div class="nav-brand">
        <a href="home.php">Sangla System</a>
    </div>
    <div class="nav-icons">
        <a href="home.php" data-tooltip="Home">
            <i class="fas fa-home"></i>
        </a>
        <a href="estimator.php" data-tooltip="Sangla Estimator">
            <i class="fas fa-calculator"></i>
        </a>
        <a href="sangla.php" data-tooltip="Pawned Items">
            <i class="fas fa-box"></i>
        </a>
        <a href="market.php" data-tooltip="Market">
            <i class="fas fa-store"></i>
        </a>
        <a href="branch.php" data-tooltip="Branches">
            <i class="fas fa-building"></i>
        </a>
        <a href="about.php" data-tooltip="About">
            <i class="fas fa-info-circle"></i>
        </a>
        <div class="profile-menu">
            <div class="profile-icon">
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile">
            </div>
            <div class="dropdown">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="profile.php">Profile</a>
                    <a href="settings.php">Settings</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="sss.php">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<style>
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

.nav-brand a {
    color: white;
    text-decoration: none;
    font-size: 1.5rem;
    font-weight: bold;
    transition: color 0.3s ease;
}

.nav-brand a:hover {
    color: #f5cc59;
}

.nav-icons {
    display: flex;
    gap: 20px;
    align-items: center;
}

.nav-icons a {
    color: white;
    text-decoration: none;
    font-size: 20px;
    position: relative;
    transition: color 0.3s ease;
}

.nav-icons a:hover::after {
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
    z-index: 1001;
}

.nav-icons a:hover {
    color: #f5cc59;
}

.profile-menu {
    position: relative;
}

.profile-menu .profile-icon {
    width: 40px;
    height: 40px;
    background-color: white;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.profile-menu .profile-icon:hover {
    transform: scale(1.1);
}

.profile-menu .profile-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.profile-menu .dropdown {
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
    min-width: 150px;
}

.profile-menu .dropdown a {
    display: block;
    padding: 10px 20px;
    text-decoration: none;
    color: black;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.profile-menu .dropdown a:hover {
    background-color: #f5f5f5;
}

.profile-menu.active .dropdown {
    display: block;
}

@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        padding: 1rem;
    }

    .nav-icons {
        flex-direction: column;
        gap: 1rem;
        margin: 1rem 0;
    }

    .profile-menu {
        margin-top: 1rem;
    }
}
</style>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileMenu = document.querySelector('.profile-menu');
    profileMenu.addEventListener('click', function() {
        this.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!profileMenu.contains(event.target)) {
            profileMenu.classList.remove('active');
        }
    });
});
</script> 