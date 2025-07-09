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
            background: #f8f9fa;
        }
        
        .admin-content {
            padding: 40px 0;
        }
        
        .page-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .seller-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .seller-card:hover {
            transform: translateY(-5px);
        }
        
        .seller-info h4 {
            color: #2c5530;
            margin-bottom: 15px;
        }
        
        .seller-details {
            color: #666;
            margin-bottom: 20px;
        }
        
        .seller-details p {
            margin-bottom: 8px;
        }
        
        .seller-details i {
            width: 20px;
            color: #4CAF50;
            margin-right: 8px;
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
            margin: 5px;
            transition: all 0.3s;
            font-size: 14px;
        }
        
        .btn-admin:hover {
            background: linear-gradient(135deg, #45a049, #3d8b40);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
            text-decoration: none;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        .action-buttons {
            margin-top: 30px;
            text-align: center;
        }
        
        .no-sellers {
            text-align: center;
            padding: 50px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .no-sellers h4 {
            color: #666;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="index-page">

    <?php include 'admin_header.php'; ?>

    <main class="main">
        <div class="container admin-content">
            
            <!-- Page Header -->
            <div class="page-header" data-aos="fade-up">
                <h1><i class="bi bi-people"></i> Seller Management</h1>
                <p class="mb-0">Manage registered sellers and their information</p>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons" data-aos="fade-up" data-aos-delay="100">
                <a href="add_seller.php" class="btn-admin">
                    <i class="bi bi-person-plus"></i> Add New Seller
                </a>
                <a href="dashboard_admin.php" class="btn-admin" style="background: linear-gradient(135deg, #6c757d, #5a6268);">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <!-- Sellers List -->
            <div class="row" data-aos="fade-up" data-aos-delay="200">
                <?php if ($sellers && $sellers->num_rows > 0) { ?>
                    <?php while ($seller = $sellers->fetch_assoc()) { ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="seller-card">
                                <div class="seller-info">
                                    <h4><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($seller['seller_name']); ?></h4>
                                    <div class="seller-details">
                                        <p><i class="bi bi-telephone"></i> <strong>Phone:</strong> <?php echo htmlspecialchars($seller['phone_number']); ?></p>
                                        <p><i class="bi bi-geo-alt"></i> <strong>Address:</strong> <?php echo htmlspecialchars($seller['address']); ?></p>
                                        <p><i class="bi bi-calendar"></i> <strong>Seller ID:</strong> #<?php echo $seller['seller_id']; ?></p>
                                    </div>
                                    <div class="seller-actions">
                                        <a href="edit_seller.php?seller_id=<?php echo $seller['seller_id']; ?>" class="btn-admin">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="delete_seller.php?seller_id=<?php echo $seller['seller_id']; ?>" 
                                           class="btn-admin btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this seller? This action cannot be undone.');">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="col-12">
                        <div class="no-sellers">
                            <i class="bi bi-people" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                            <h4>No Sellers Found</h4>
                            <p>There are currently no registered sellers in the system.</p>
                            <a href="add_seller.php" class="btn-admin">
                                <i class="bi bi-person-plus"></i> Add First Seller
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </main>

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
