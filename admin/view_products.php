<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

$user_id = $_SESSION['user_id'];

// Get filter parameter
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Build query based on filter
$query = "
    SELECT p.*, s.seller_name 
    FROM products p 
    LEFT JOIN sellers s ON p.seller_id = s.seller_id 
";

if ($category_filter) {
    $query .= " WHERE p.category = '" . mysqli_real_escape_string($conn, $category_filter) . "'";
}

$query .= " ORDER BY p.product_id DESC";

$products = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css"/>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-section">
            <h3>Posted Products</h3>
            
            <!-- Filter Section -->
            <div class="filter-section" style="margin-bottom: 20px;">
                <form method="GET" style="display: inline-block;">
                    <select name="category" onchange="this.form.submit()" style="padding: 8px; margin-right: 10px;">
                        <option value="">All Categories</option>
                        <option value="Utilized" <?php echo ($category_filter == 'Utilized') ? 'selected' : ''; ?>>Utilized Products</option>
                        <option value="UnderUtilized" <?php echo ($category_filter == 'UnderUtilized') ? 'selected' : ''; ?>>UnderUtilized Fruits</option>
                    </select>
                </form>
                <a href="add_product.php" class="add-child-button" style="margin-left: 10px;">Add New Product</a>
            </div>
            
            <div class="card-container">
                <?php while ($product = $products->fetch_assoc()) { ?>
                    <div class="card">
                        <div class="card-content">
                            <div class="product-details">
                                <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                                <?php if (!empty($product['video_url'])): ?>
                                    <p><strong>Video:</strong> <a href="<?php echo htmlspecialchars($product['video_url']); ?>" target="_blank">Watch Video</a></p>
                                <?php endif; ?>
                                <div class="seller-info">
                                    <strong>Seller:</strong> <?php echo htmlspecialchars($product['seller_name'] ?? 'Unknown'); ?>
                                </div>
                            </div>
                            <div class="card-actions">
                                <a href="edit_product.php?product_id=<?php echo $product['product_id']; ?>" class="add-child-button">Edit</a>
                                <a href="delete_product.php?product_id=<?php echo $product['product_id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this Product?');">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="dashboard-footer">
            <a href="dashboard_admin.php" class="add-child-button">Back</a>
            <a href="add_product.php" class="add-child-button">Add Product</a>
        </div>

    </div>
</body>
</html>
