<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

$user_id = $_SESSION['user_id'];

// Get sellers
$sellers = $conn->query("SELECT * FROM sellers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sellers</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-section">
            <h3>Registered Sellers</h3>
            <div class="card-container">
                <?php while ($seller = $sellers->fetch_assoc()) { ?>
                    <div class="card">
                        <h4><?php echo htmlspecialchars($seller['seller_name']); ?></h4>
                        <p>Phone: <?php echo htmlspecialchars($seller['phone_number']); ?></p>
                        <p>Address: <?php echo htmlspecialchars($seller['address']); ?></p>
                        <div class="card-actions">
                            <a href="edit_seller.php?user_id=<?php echo $seller['seller_id']; ?>" class="add-child-button">Edit</a>
                            <a href="delete_seller.php?user_id=<?php echo $seller['seller_id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this seller?');">Delete</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="dashboard-footer">
            <a href="dashboard_admin.php" class="add-child-button">Back</a>
            <a href="add_seller.php" class="add-child-button">Add Seller</a>
        </div>

    </div>
</body>
</html>
