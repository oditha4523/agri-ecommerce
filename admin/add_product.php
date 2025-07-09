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
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $seller_id = mysqli_real_escape_string($conn, $_POST['seller_id']);
    $video_url = mysqli_real_escape_string($conn, $_POST['video_url']);
    
    // Handle image upload (keeping existing logic for compatibility)
    $image_path = null;
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../assets/img/products/';
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_extension;
        $target_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_path)) {
            $image_path = $file_name; // Store just the filename
        }
    }

    // Insert product into products table with the selected category
    $sql = "INSERT INTO products (seller_id, name, category, video_url) 
            VALUES ('$seller_id', '$name', '$category', '$video_url')";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_products.php?success=product_added");
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
    <title>Add Product | Agro Vista Admin</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="../assets/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <!-- Custom CSS for category selection -->
    <style>
        .category-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            font-size: 12px;
            color: #6c757d;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #6c757d;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Add Product</h2>
                        <div class="category-info">
                            <strong>Category Information:</strong><br>
                            • <strong>Utilized Products:</strong> Traditional Sri Lankan products like Cinnamon, Kithul, Tea, and Dry Fish<br>
                            • <strong>UnderUtilized Fruits:</strong> Indigenous and rare fruits that are underutilized in the market
                        </div>
                        <form method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="seller_id"><i class="zmdi zmdi-account-circle"></i></label>
                                <select name="seller_id" id="seller_id" required>
                                    <option value="">Select Seller</option>
                                    <?php while ($seller = $sellers_result->fetch_assoc()) { ?>
                                        <option value="<?php echo $seller['seller_id']; ?>">
                                            <?php echo htmlspecialchars($seller['seller_name']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_name"><i class="zmdi zmdi-shopping-basket"></i></label>
                                <input type="text" name="product_name" id="product_name" placeholder="Product Name" required />
                            </div>
                            <div class="form-group">
                                <label for="category"><i class="zmdi zmdi-bookmark"></i></label>
                                <select name="category" id="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Utilized">Utilized Products (Cinnamon, Kithul, Tea, Dry Fish)</option>
                                    <option value="UnderUtilized">UnderUtilized Fruits</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="video_url"><i class="zmdi zmdi-videocam"></i></label>
                                <input type="url" name="video_url" id="video_url" placeholder="Video URL (optional)" />
                            </div>
                            <div class="form-group">
                                <label for="product_image"><i class="zmdi zmdi-image"></i></label>
                                <input type="file" name="product_image" id="product_image" accept="image/*" />
                                <small>Note: Image upload is optional. Default images will be used for display.</small>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="add_product" id="add_product" class="form-submit" value="Add Product"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="../assets/img/Option.png" alt="Add product image" style="border-radius: 50%"></figure>
                        <a href="view_products.php" class="signup-image-link">Back to Products</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>
</html>
