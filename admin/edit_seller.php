<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

$seller_id = $_GET['user_id']; // Changed to match the parameter from view_sellers.php
$user_id = $_SESSION['user_id'];

// Fetch seller's details from sellers table
$sellers_result = $conn->query("SELECT * FROM sellers WHERE seller_id = $seller_id");
$seller = $sellers_result->fetch_assoc();

if (!$seller) {
    header("Location: view_sellers.php?error=seller_not_found");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Update seller's details in sellers table
    $sql = "UPDATE sellers SET seller_name='$name', phone_number='$phone', address='$address' WHERE seller_id=$seller_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_sellers.php?success=seller_updated");
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
    <title>Edit Seller | Agri E-Commerce</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="../assets/fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Seller</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name"><i class="zmdi zmdi-account"></i></label>
                <input type="text" name="name" placeholder="Seller Name" value="<?php echo htmlspecialchars($seller['seller_name']); ?>" required />
            </div>
            <div class="form-group">
                <label for="phone"><i class="zmdi zmdi-phone"></i></label>
                <input type="tel" name="phone" placeholder="Phone Number" value="<?php echo htmlspecialchars($seller['phone_number']); ?>" required />
            </div>
            <div class="form-group">
                <label for="address"><i class="zmdi zmdi-home"></i></label>
                <input type="text" name="address" placeholder="Address" value="<?php echo htmlspecialchars($seller['address']); ?>" required />
            </div>
            <div class="form-group form-button">
                <button type="submit" class="form-submit">Save Changes</button>
            </div>
        </form>

        <!-- Back Button -->
        <a href="view_sellers.php" class="back-button">Back to Sellers</a>
    </div>
</body>
</html>
