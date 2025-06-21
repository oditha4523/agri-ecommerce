<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include 'DBcon.php';

$seller_id = $_GET['seller_id'];
$mother_id = $_SESSION['user_id'];

// Fetch sellers's details
$baby_result = $conn->query("SELECT * FROM sellers WHERE seller_id = $seller_id");
$baby = $baby_result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Update child's details
    $sql = "UPDATE Babies SET name='$name', phone_number='$phone', address='$address' WHERE seller_id=$seller_id";

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
    <title>Edit Child</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="../assets/fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Child</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name"><i class="zmdi zmdi-account"></i></label>
                <input type="text" name="name" value="<?php echo $seller_id['name']; ?>" required />
            </div>
            <div class="form-group">
                <label for="phone"><i class="zmdi zmdi-calendar"></i></label>
                <input type="phone" name="phone" value="<?php echo $seller_id['phone']; ?>" required />
            </div>
            <div class="form-group">
                <label for="address"><i class="zmdi zmdi-calendar"></i></label>
                <input type="address" name="address" value="<?php echo $seller_id['address']; ?>" required />
            </div>
            <div class="form-group form-button">
                <button type="submit" class="form-submit">Save Changes</button>
            </div>
        </form>

        <!-- Back Button Always Goes to Parent Dashboard -->
        <a href="view_sellers.php" class="back-button">Back</a>
    </div>
</body>
</html>
