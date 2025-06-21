<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include 'DBcon.php';

$user_id = $_SESSION['user_id'];

// Get sellers
$sellers = $conn->query("SELECT * FROM sellers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mother Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
            <img src="<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Picture" class="profile-picture">
        </div>

        <div class="dashboard-section">
            <h3>Your Children</h3>
            <div class="card-container">
                <?php while ($seller = $sellers->fetch_assoc()) { ?>
                    <div class="card">
                        <h4><?php echo $seller['seller_name']; ?></h4>
                        <p>Phone: <?php echo $seller['phone_number']; ?></p>
                        <p>Address: <?php echo $seller['address']; ?></p>
                        <a href="delete_seller.php?seller_id=<?php echo $seller['seller_id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this seller?');">Delete</a>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="dashboard-footer">
            <a href="add_seller.php" class="add-child-button">Add Seller</a>
        </div>

    </div>
</body>
</html>
