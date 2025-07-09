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
    
    // Handle image upload
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
            $video_path = 'assets/img/products/' . $file_name;
        }
    }

    // Insert product into products table
    $sql = "INSERT INTO products (seller_id, name, category, video_url, availability) 
            VALUES ('$seller_id', '$name', 'Utilized', '$video_path', '1')";

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
    <title>Add Product | Agri E-Commerce</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="../assets/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Add Product</h2>
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
                                    <option value="Cinnamon">Cinnamon</option>
                                    <option value="Kithul">Kithul</option>
                                    <option value="Tea">Tea</option>
                                    <option value="Dry Fish">Dry Fish</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description"><i class="zmdi zmdi-comment-text"></i></label>
                                <input name="description" id="description" placeholder="Product Description" rows="3" required/>
                            </div>
                            <div class="form-group">
                                <label for="price"><i class="zmdi zmdi-money"></i></label>
                                <input type="number" name="price" id="price" placeholder="Price" step="0.01" min="0" required />
                            </div>
                            <div class="form-group">
                                <label for="amount"><i class="zmdi zmdi-collection-item"></i></label>
                                <input type="number" name="amount" id="amount" placeholder="Quantity Available" min="1" required />
                            </div>
                            <div class="form-group">
                                <label for="product_image"><i class="zmdi zmdi-image"></i></label>
                                <input type="file" name="product_image" id="product_image" accept="image/*" required />
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
