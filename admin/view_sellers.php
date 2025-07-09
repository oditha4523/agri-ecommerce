<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

$user_id = $_SESSION['user_id'];

// Get sellers
$sellers = $conn->query("SELECT * FROM sellers ORDER BY seller_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sellers - Agro Vista Admin</title>
    
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,909&display=swap" rel="stylesheet">
    
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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .admin-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .admin-nav {
            background: #2c5530;
            padding: 10px 0;
        }
        
        .admin-nav .nav-link {
            color: white;
            font-weight: 500;
            margin: 0 15px;
            transition: color 0.3s;
        }
        
        .admin-nav .nav-link:hover,
        .admin-nav .nav-link.active {
            color: #4CAF50;
        }
        
        .main-content {
            padding: 30px 0;
        }
        
        .page-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-3px);
        }
        
        .btn-admin {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            margin: 3px;
            transition: all 0.3s;
        }
        
        .btn-admin:hover {
            background: linear-gradient(135deg, #45a049, #3d8b40);
            color: white;
            transform: translateY(-1px);
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
    </style>
</head>
<body class="index-page">

    <?php include 'admin_header.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2><i class="bi bi-people"></i> Seller Management</h2>
                        <p class="mb-0 text-muted">Manage all sellers in the system</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="add_seller.php" class="btn-admin">
                            <i class="bi bi-person-plus"></i> Add New Seller
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Sellers Grid -->
            <div class="row">
                <?php while ($seller = $sellers->fetch_assoc()) { ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title"><?php echo htmlspecialchars($seller['seller_name']); ?></h5>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="card-text">
                                        <strong><i class="bi bi-telephone"></i> Phone:</strong> 
                                        <?php echo htmlspecialchars($seller['phone_number']); ?>
                                    </p>
                                    
                                    <p class="card-text">
                                        <strong><i class="bi bi-geo-alt"></i> Address:</strong> 
                                        <?php echo htmlspecialchars($seller['address']); ?>
                                    </p>
                                    
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> Seller ID: <?php echo $seller['seller_id']; ?>
                                    </small>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="edit_seller.php?seller_id=<?php echo $seller['seller_id']; ?>" class="btn-admin btn-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="delete_seller.php?seller_id=<?php echo $seller['seller_id']; ?>" 
                                       class="btn-admin btn-delete" 
                                       onclick="return confirm('Are you sure you want to delete this seller? This action cannot be undone.');">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            
            <?php if ($sellers->num_rows == 0): ?>
                <div class="text-center py-5">
                    <div class="card">
                        <div class="card-body">
                            <i class="bi bi-people" style="font-size: 3rem; color: #ccc;"></i>
                            <h4 class="mt-3">No Sellers Found</h4>
                            <p class="text-muted">No sellers have been added yet.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    
    <!-- Main JS File -->
    <script src="../assets/js/main.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'slide'
        });
    </script>

</body>
</html>
