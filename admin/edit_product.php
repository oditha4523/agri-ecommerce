<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

$product_id = $_GET['product_id'];
$admin_id = $_SESSION['user_id'];

// Fetch product details
$product_result = $conn->query("SELECT * FROM products WHERE product_id = $product_id");
$product = $product_result->fetch_assoc();

if (!$product) {
    header("Location: view_products.php?error=product_not_found");
    exit;
}

// Get all sellers for dropdown
$sellers_query = "SELECT seller_id, seller_name FROM sellers";
$sellers_result = $conn->query($sellers_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $seller_id = mysqli_real_escape_string($conn, $_POST['seller_id']);

    // Validate required fields
    if (empty($name) || empty($category) || empty($seller_id)) {
        $error_message = "Product name, category, and seller are required.";
    } else {
        // Handle video file upload if new video is provided
        $video_url = $product['video_url']; // Keep existing video URL
        
        if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/videos/';
            
            // Create directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_extension = strtolower(pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['mp4', 'webm', 'ogg', 'avi', 'mov'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $file_name = uniqid() . '.' . $file_extension;
                $target_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['video_file']['tmp_name'], $target_path)) {
                    // Delete old video file if it exists
                    if (!empty($product['video_url']) && file_exists('../' . $product['video_url'])) {
                        unlink('../' . $product['video_url']);
                    }
                    $video_url = 'assets/videos/' . $file_name; // New video URL
                } else {
                    $error_message = "Error uploading video file.";
                }
            } else {
                $error_message = "Invalid video format. Please upload MP4, WebM, OGG, AVI, or MOV files.";
            }
        }
        
        // Update product if no errors
        if (!isset($error_message)) {
            $sql = "UPDATE products SET name='$name', category='$category', video_url='$video_url', seller_id='$seller_id' WHERE product_id=$product_id";

            if ($conn->query($sql) === TRUE) {
                header("Location: view_products.php?success=product_updated");
                exit;
            } else {
                $error_message = "Error updating record: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product | Agro Vista Admin</title>

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
        
        .category-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
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
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
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
        
        .form-control[type="file"] {
            padding: 8px 12px;
        }
        
        .form-control[type="file"]::-webkit-file-upload-button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            margin-right: 10px;
            cursor: pointer;
        }
        
        .form-control[type="file"]::-webkit-file-upload-button:hover {
            background: #45a049;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #6c757d;
            font-size: 12px;
        }
    </style>
</head>
<body class="index-page">

    <?php include 'admin_header.php'; ?>

    <main class="main">
        <div class="container">
            <div class="form-container" data-aos="fade-up">
                <div class="form-header">
                    <h2><i class="bi bi-pencil-square"></i> Edit Product</h2>
                    <p class="mb-0">Update product information and video files</p>
                </div>
                
                <div class="form-body p-4">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="category-info">
                        <h5><i class="bi bi-info-circle"></i> Category Information</h5>
                        <ul class="mb-0">
                            <li><strong>Utilized Products:</strong> Traditional Sri Lankan products like Cinnamon, Kithul, Tea, and Dry Fish</li>
                            <li><strong>UnderUtilized Fruits:</strong> Indigenous and rare fruits that are underutilized in the market</li>
                        </ul>
                    </div>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="seller_id" class="form-label">
                                <i class="bi bi-person-circle"></i> Select Seller
                            </label>
                            <select name="seller_id" id="seller_id" class="form-select" required>
                                <option value="">Select Seller</option>
                                <?php while ($seller = $sellers_result->fetch_assoc()) { ?>
                                    <option value="<?php echo $seller['seller_id']; ?>" 
                                            <?php echo ($seller['seller_id'] == $product['seller_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($seller['seller_name']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="product_name" class="form-label">
                                <i class="bi bi-box-seam"></i> Product Name
                            </label>
                            <input type="text" name="product_name" id="product_name" class="form-control" 
                                   placeholder="Enter product name" value="<?php echo htmlspecialchars($product['name']); ?>" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="category" class="form-label">
                                <i class="bi bi-bookmark"></i> Product Category
                            </label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="Utilized" <?php echo ($product['category'] == 'Utilized') ? 'selected' : ''; ?>>Utilized Products</option>
                                <option value="UnderUtilized" <?php echo ($product['category'] == 'UnderUtilized') ? 'selected' : ''; ?>>UnderUtilized Fruits</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="video_file" class="form-label">
                                <i class="bi bi-camera-video"></i> Video File
                            </label>
                            <input type="file" name="video_file" id="video_file" class="form-control" 
                                   accept=".mp4,.webm,.ogg,.avi,.mov" />
                            <small>Optional: Upload a new video file to replace the current one. Supported formats: MP4, WebM, OGG, AVI, MOV</small>
                            <?php if (!empty($product['video_url'])): ?>
                                <div class="mt-2">
                                    <small class="text-muted">Current video: <?php echo htmlspecialchars(basename($product['video_url'])); ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" name="edit_product" class="btn btn-submit">
                                <i class="bi bi-check-circle"></i> Save Changes
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="view_products.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Products
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
    </div>

</body>
</html>
