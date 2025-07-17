<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

// Get all sellers from the database
$sellers_query = "SELECT seller_id, seller_name FROM sellers";
$sellers_result = $conn->query($sellers_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debug: Log file upload info
    error_log("File upload debug - POST received");
    if (isset($_FILES['video_file'])) {
        error_log("File info: " . print_r($_FILES['video_file'], true));
    }
    
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $seller_id = mysqli_real_escape_string($conn, $_POST['seller_id']);
    
    // Validate required fields
    if (empty($name) || empty($category) || empty($seller_id)) {
        $error_message = "Product name, category, and seller are required.";
    } else {
        // Handle video file upload
        $video_url = null;
        
        // Check if a file was uploaded
        if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
            // Determine the upload directory based on category
            $category_path = strtolower($category); // 'Utilized' or 'UnderUtilized'
            
            if ($category_path === 'utilized') {
                // For utilized products, determine subcategory based on product name
                $subcategory = 'general'; // default
                $product_name_lower = strtolower($name);
                
                if (preg_match('/cinnamon|spice|bark/', $product_name_lower)) {
                    $subcategory = 'cinnamon';
                } elseif (preg_match('/kithul|palm|treacle|jaggery/', $product_name_lower)) {
                    $subcategory = 'kithul';
                } elseif (preg_match('/tea|ceylon|black tea|green tea/', $product_name_lower)) {
                    $subcategory = 'tea';
                } elseif (preg_match('/fish|dried|seafood|maldive/', $product_name_lower)) {
                    $subcategory = 'dry_fish';
                }
                
                $upload_dir = "../assets/videos/products/utilized/{$subcategory}/";
            } else {
                // For underutilized products
                $upload_dir = '../assets/videos/products/underutilized/';
            }
            
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
                    // Store relative path for database (without ../)
                    $video_url = str_replace('../', '', $target_path);
                } else {
                    $error_message = "Error uploading video file. Please try again.";
                }
            } else {
                $error_message = "Invalid video format. Please upload MP4, WebM, OGG, AVI, or MOV files.";
            }
        } else {
            // Check for upload errors
            if (isset($_FILES['video_file'])) {
                switch ($_FILES['video_file']['error']) {
                    case UPLOAD_ERR_NO_FILE:
                        $error_message = "Please select a video file to upload.";
                        break;
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $error_message = "Video file is too large. Please choose a smaller file.";
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $error_message = "Video file upload was interrupted. Please try again.";
                        break;
                    default:
                        $error_message = "Error uploading video file. Please try again.";
                        break;
                }
            } else {
                $error_message = "Please select a video file to upload.";
            }
        }
        
        // Insert product if no errors
        if (!isset($error_message)) {
            $sql = "INSERT INTO products (seller_id, name, category, video_url) 
                    VALUES ('$seller_id', '$name', '$category', '$video_url')";

            if ($conn->query($sql) === TRUE) {
                header("Location: view_products.php?success=product_added");
                exit;
            } else {
                $error_message = "Error: " . $conn->error;
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
    <title>Add Product | Agro Vista Admin</title>

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
        
        .form-body {
            padding: 40px;
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
        
        .btn-secondary {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }
        
        .form-help {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
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
    </style>
</head>
<body class="index-page">

    <?php include 'admin_header.php'; ?>

    <main class="main">
        <div class="container">
            <div class="form-container" data-aos="fade-up">
                <div class="form-header">
                    <h2><i class="bi bi-plus-circle"></i> Add New Product</h2>
                    <p class="mb-0">Add products with video files to your agricultural marketplace</p>
                </div>
                
                <div class="form-body">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> <?php echo $error_message; ?>
                        </div>
                        
                        <!-- Debug info (remove in production) -->
                        <?php if (isset($_FILES['video_file'])): ?>
                            <div class="alert alert-info" role="alert">
                                <strong>Debug Info:</strong><br>
                                File Error Code: <?php echo $_FILES['video_file']['error']; ?><br>
                                File Name: <?php echo htmlspecialchars($_FILES['video_file']['name'] ?? 'None'); ?><br>
                                File Size: <?php echo $_FILES['video_file']['size'] ?? 0; ?> bytes<br>
                                File Type: <?php echo htmlspecialchars($_FILES['video_file']['type'] ?? 'Unknown'); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <div class="category-info">
                        <h5><i class="bi bi-info-circle"></i> Category Information</h5>
                        <ul class="mb-0">
                            <li><strong>Utilized Products:</strong> Traditional Sri Lankan products like Cinnamon, Kithul, Tea, and Dry Fish</li>
                            <li><strong>UnderUtilized Fruits:</strong> Indigenous and rare fruits that are underutilized in the market</li>
                        </ul>
                    </div>
                    
                    <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seller_id" class="form-label">
                                    <i class="bi bi-person"></i> Select Seller
                                </label>
                                <select name="seller_id" id="seller_id" class="form-select" required>
                                    <option value="">Choose a seller...</option>
                                    <?php while ($seller = $sellers_result->fetch_assoc()) { ?>
                                        <option value="<?php echo $seller['seller_id']; ?>">
                                            <?php echo htmlspecialchars($seller['seller_name']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category" class="form-label">
                                    <i class="bi bi-tag"></i> Product Category
                                </label>
                                <select name="category" id="category" class="form-select" required>
                                    <option value="">Select category...</option>
                                    <option value="Utilized">Utilized Products (Cinnamon, Kithul, Tea, Dry Fish)</option>
                                    <option value="UnderUtilized">UnderUtilized Fruits</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="product_name" class="form-label">
                            <i class="bi bi-box-seam"></i> Product Name
                        </label>
                        <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name..." required />
                    </div>
                    
                    <div class="form-group">
                        <label for="video_file" class="form-label">
                            <i class="bi bi-camera-video"></i> Video File
                        </label>
                        <input type="file" name="video_file" id="video_file" class="form-control" 
                               accept=".mp4,.webm,.ogg,.avi,.mov" required />
                        <div class="form-help">
                            Upload a video file. Supported formats: MP4, WebM, OGG, AVI, MOV (Max size: depends on server settings)
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" name="add_product" class="btn-submit">
                            <i class="bi bi-plus-circle"></i> Add Product
                        </button>
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
