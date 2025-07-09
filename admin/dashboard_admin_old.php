<?php
session_start();
include '../db/DBcon.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Agro Vista</title>
    
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    
    <!-- Main CSS File -->
    <link href="../assets/css/main.css" rel="stylesheet">
    
    <!-- Custom Admin CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }
        
        .dashboard-container {
            padding: 40px 0;
        }
        
        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        
        .dashboard-card h3 {
            color: #2c5530;
            margin-bottom: 20px;
        }
        
        .btn-admin {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: all 0.3s;
        }
        
        .btn-admin:hover {
            background: linear-gradient(135deg, #45a049, #3d8b40);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
            text-decoration: none;
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #4CAF50;
        }
        
        .stat-label {
            color: #666;
            font-weight: 500;
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .welcome-banner h1 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="index-page">

    <?php include 'admin_header.php'; ?>

    <main class="main">
        <div class="container dashboard-container">
            
            <!-- Welcome Banner -->
            <div class="welcome-banner" data-aos="fade-up">
                <h1>Welcome to Admin Dashboard</h1>
                <p class="mb-0">Hello, <?php echo htmlspecialchars($_SESSION['name'] ?? 'Administrator'); ?>! Manage your agri-ecommerce platform efficiently.</p>
            </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="../authentication/logout.php" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Admin Navigation -->
    <nav class="admin-nav">
        <div class="container">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard_admin.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_products.php">
                        <i class="bi bi-box-seam"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_sellers.php">
                        <i class="bi bi-people"></i> Sellers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../shared/index.php">
                        <i class="bi bi-house"></i> View Site
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="dashboard-container">
        <div class="container">
            
            <!-- Stats Cards -->
            <div class="stats-grid">
                <?php
                // Get statistics
                $total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
                $total_sellers = $conn->query("SELECT COUNT(*) as count FROM sellers")->fetch_assoc()['count'];
                $utilized_products = $conn->query("SELECT COUNT(*) as count FROM products WHERE category = 'Utilized'")->fetch_assoc()['count'];
                $underutilized_products = $conn->query("SELECT COUNT(*) as count FROM products WHERE category = 'UnderUtilized'")->fetch_assoc()['count'];
                ?>
                
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_products; ?></div>
                    <div class="stat-label">Total Products</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_sellers; ?></div>
                    <div class="stat-label">Total Sellers</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number"><?php echo $utilized_products; ?></div>
                    <div class="stat-label">Utilized Products</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number"><?php echo $underutilized_products; ?></div>
                    <div class="stat-label">UnderUtilized Fruits</div>
                </div>
            </div>

            <!-- Action Cards -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="dashboard-card">
                        <h3><i class="bi bi-box-seam"></i> Product Management</h3>
                        <p>Manage all products including both utilized and underutilized categories.</p>
                        <div class="mt-3">
                            <a href="view_products.php" class="btn-admin">
                                <i class="bi bi-eye"></i> View All Products
                            </a>
                            <a href="add_product.php" class="btn-admin">
                                <i class="bi bi-plus-circle"></i> Add New Product
                            </a>
                        </div>
                        <div class="mt-3">
                            <a href="view_products.php?category=Utilized" class="btn-admin btn-secondary">
                                <i class="bi bi-filter"></i> View Utilized Products
                            </a>
                            <a href="view_products.php?category=UnderUtilized" class="btn-admin btn-secondary">
                                <i class="bi bi-filter"></i> View UnderUtilized Fruits
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="dashboard-card">
                        <h3><i class="bi bi-people"></i> Seller Management</h3>
                        <p>Manage seller accounts and their information.</p>
                        <div class="mt-3">
                            <a href="view_sellers.php" class="btn-admin">
                                <i class="bi bi-eye"></i> View All Sellers
                            </a>
                            <a href="add_seller.php" class="btn-admin">
                                <i class="bi bi-person-plus"></i> Add New Seller
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="dashboard-card">
                <h3><i class="bi bi-lightning"></i> Quick Actions</h3>
                <div class="row">
                    <div class="col-md-3">
                        <a href="../shared/index.php" class="btn-admin w-100">
                            <i class="bi bi-house"></i> View Frontend
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="../shared/edit_profile.php" class="btn-admin btn-secondary w-100">
                            <i class="bi bi-person-gear"></i> Edit Profile
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="view_products.php" class="btn-admin btn-secondary w-100">
                            <i class="bi bi-graph-up"></i> View Reports
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="../authentication/logout.php" class="btn-admin btn-danger w-100">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
