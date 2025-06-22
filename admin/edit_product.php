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
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $seller_id = mysqli_real_escape_string($conn, $_POST['seller_id']);

    // Handle image upload if new image is provided
    $image_path = $product['image_path']; // Keep existing image by default
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
            $image_path = 'assets/img/products/' . $file_name;
        }
    }

    // Update product details
    $sql = "UPDATE products SET name='$name', category='$category', description='$description', price='$price', amount='$amount', seller_id='$seller_id', image_path='$image_path' WHERE product_id=$product_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_products.php?success=product_updated");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product | Agri E-Commerce</title>

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
                        <h2 class="form-title">Edit Product</h2>
                        <form method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="seller_id"><i class="zmdi zmdi-account-circle"></i></label>
                                <select name="seller_id" id="seller_id" required>
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
                                <label for="product_name"><i class="zmdi zmdi-shopping-basket"></i></label>
                                <input type="text" name="product_name" id="product_name" placeholder="Product Name" value="<?php echo htmlspecialchars($product['name']); ?>" required />
                            </div>
                            <div class="form-group">
                                <label for="category"><i class="zmdi zmdi-bookmark"></i></label>
                                <select name="category" id="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Seeds" <?php echo ($product['category'] == 'Seeds') ? 'selected' : ''; ?>>Seeds</option>
                                    <option value="Fertilizers" <?php echo ($product['category'] == 'Fertilizers') ? 'selected' : ''; ?>>Fertilizers</option>
                                    <option value="Tools" <?php echo ($product['category'] == 'Tools') ? 'selected' : ''; ?>>Tools</option>
                                    <option value="Pesticides" <?php echo ($product['category'] == 'Pesticides') ? 'selected' : ''; ?>>Pesticides</option>
                                    <option value="Equipment" <?php echo ($product['category'] == 'Equipment') ? 'selected' : ''; ?>>Equipment</option>
                                    <option value="Other" <?php echo ($product['category'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description"><i class="zmdi zmdi-comment-text"></i></label>
                                <input name="description" id="description" placeholder="Product Description" value="<?php echo htmlspecialchars($product['description']); ?>" required />
                            </div>
                            <div class="form-group">
                                <label for="price"><i class="zmdi zmdi-money"></i></label>
                                <input type="number" name="price" id="price" placeholder="Price" step="0.01" min="0" value="<?php echo $product['price']; ?>" required />
                            </div>
                            <div class="form-group">
                                <label for="amount"><i class="zmdi zmdi-collection-item"></i></label>
                                <input type="number" name="amount" id="amount" placeholder="Quantity Available" min="1" value="<?php echo $product['amount']; ?>" required />
                            </div>
                            <div class="form-group">
                                <label for="product_image"><i class="zmdi zmdi-image"></i></label>
                                <input type="file" name="product_image" id="product_image" accept="image/*" />
                                <?php if (!empty($product['image_path'])) { ?>
                                    <small style="color: #666; font-size: 12px; margin-top: 5px; display: block;">Current image: <?php echo basename($product['image_path']); ?></small>
                                <?php } ?>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="edit_product" id="edit_product" class="form-submit" value="Save Changes"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="../assets/img/Option.png" alt="Edit product image" style="border-radius: 50%"></figure>
                        <a href="view_products.php" class="signup-image-link">Back to Products</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>
</html>
