<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include 'DBcon.php';

$user_id = $_SESSION['user_id'];

// Get products
$products = $conn->query("SELECT * FROM products where availability = '1'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
        </div>

        <div class="dashboard-section">
            <h3>Your Children</h3>
            <div class="card-container">
                <?php while ($product = $products->fetch_assoc()) { ?>
                    <div class="card">
                        <h4><?php echo $product['name']; ?></h4>
                        <p>Price: <?php echo $product['price']; ?></p>
                        <p>Amount: <?php echo $product['amount']; ?></p>
                        <a href="delete_product.php?product_id=<?php echo $product['product_id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this Product?');">Delete</a>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="dashboard-footer">
            <a href="add_product.php" class="add-child-button">Add Product</a>
        </div>

    </div>
</body>
</html>
