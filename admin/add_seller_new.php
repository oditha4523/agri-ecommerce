<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "INSERT INTO sellers (seller_name, phone_number, address) 
            VALUES ('$name', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard_admin.php?success=Added_Seller");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Seller | Agro Vista Admin</title>

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
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }
        
        .form-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .form-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            font-weight: 600;
            color: #2c5530;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }
        
        .form-label i {
            margin-right: 8px;
            color: #4CAF50;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 25px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-submit:hover {
            background: linear-gradient(135deg, #45a049, #3d8b40);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }
    </style>
</head>
<body class="index-page">

    <?php include 'admin_header.php'; ?>

    <main class="main">
        <div class="container">
            <div class="form-container" data-aos="fade-up">
                <div class="form-header">
                    <h2><i class="bi bi-person-plus"></i> Add New Seller</h2>
                    <p class="mb-0">Register a new seller to the marketplace</p>
                </div>
                
                <div class="form-body p-4">
                    <form method="POST">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="bi bi-person"></i> Seller Name
                            </label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   placeholder="Enter seller's full name" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">
                                <i class="bi bi-telephone"></i> Phone Number
                            </label>
                            <input type="tel" name="phone" id="phone" class="form-control" 
                                   placeholder="Enter phone number" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="address" class="form-label">
                                <i class="bi bi-geo-alt"></i> Address
                            </label>
                            <textarea name="address" id="address" class="form-control" rows="3"
                                      placeholder="Enter complete address" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-submit">
                                <i class="bi bi-check-circle"></i> Add Seller
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="view_sellers.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Sellers
                            </a>
                        </div>
                    </form>
                </div>
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
