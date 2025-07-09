<?php
// Include this file at the top of all admin pages for consistent header
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
?>

<!-- Admin Header -->
<header id="header" class="header d-flex align-items-center" style="background: linear-gradient(135deg, #4CAF50, #45a049); position: relative; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
        
        <a href="dashboard_admin.php" class="logo d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="Agro Vista" style="border-radius: 50%; width: 40px; height: 40px;">
            <h1 class="sitename text-white ms-2 mb-0">Agro Vista Admin</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul class="mb-0">
                <li><a href="dashboard_admin.php" class="text-white <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard_admin.php' ? 'active' : ''; ?>">Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="text-white"><span>Products</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="add_product.php">Add Product</a></li>
                        <li><a href="view_products.php">View Products</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="text-white"><span>Sellers</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="add_seller.php">Add Seller</a></li>
                        <li><a href="view_sellers.php">View Sellers</a></li>
                    </ul>
                </li>
                <li><a href="../authentication/logout.php" class="text-white">Logout</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list text-white"></i>
        </nav>

    </div>
</header>

<style>
/* Admin Header Styles */
.header {
    padding: 10px 0;
}

.header .logo h1 {
    font-size: 24px;
    font-weight: 600;
}

.navmenu ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    align-items: center;
}

.navmenu li {
    position: relative;
    margin: 0 10px;
}

.navmenu a {
    color: white !important;
    text-decoration: none;
    font-weight: 500;
    padding: 8px 15px;
    border-radius: 20px;
    transition: all 0.3s;
}

.navmenu a:hover,
.navmenu a.active {
    background: rgba(255, 255, 255, 0.2);
    color: white !important;
}

.navmenu .dropdown ul {
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    min-width: 180px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s;
    flex-direction: column;
    z-index: 1000;
}

.navmenu .dropdown:hover ul {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.navmenu .dropdown ul a {
    color: #333 !important;
    padding: 10px 15px;
    border-radius: 0;
    display: block;
}

.navmenu .dropdown ul a:hover {
    background: #f8f9fa;
    color: #4CAF50 !important;
}

@media (max-width: 768px) {
    .mobile-nav-toggle {
        font-size: 24px;
        cursor: pointer;
    }
    
    .navmenu {
        position: fixed;
        top: 70px;
        right: -100%;
        width: 100%;
        height: calc(100vh - 70px);
        background: rgba(76, 175, 80, 0.95);
        transition: all 0.3s;
        padding: 20px;
    }
    
    .navmenu.mobile-nav-active {
        right: 0;
    }
    
    .navmenu ul {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .navmenu li {
        margin: 10px 0;
        width: 100%;
    }
    
    .navmenu .dropdown ul {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        box-shadow: none;
        background: rgba(255, 255, 255, 0.1);
        margin-top: 10px;
    }
}
</style>

<script>
// Mobile navigation toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
    const navmenu = document.querySelector('.navmenu');
    
    if (mobileNavToggle) {
        mobileNavToggle.addEventListener('click', function() {
            navmenu.classList.toggle('mobile-nav-active');
        });
    }
});
</script>
