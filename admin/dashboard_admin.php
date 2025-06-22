<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
        </div>

        <div class="dashboard-section">
            <a href="view_sellers.php" class="add-child-button">Sellers</a>
            <a href="view_products.php" class="add-child-button">Products</a>
        </div>

        <div class="dashboard-footer">
            <a href="../shared/edit_profile.php" class="add-child-button">Edit Profile</a>
            <a href="../authentication/logout.php" class="logout-button">Logout</a>
        </div>

    </div>
</body>
</html>
