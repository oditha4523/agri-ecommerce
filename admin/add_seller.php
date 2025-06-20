<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include 'DBcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "INSERT INTO sellers (seller_name, phone_number, address) 
            VALUES ('$name', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard_admin.php?success=Added_Seller");
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
    <title>Register | Baby Care System</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="assets/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Add Seller</h2>
                        <form method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name" required />
                            </div>
                            <div class="form-group">
                                <label for="phone"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="text" name="phone" id="phone" placeholder="Enter Mobile Number" required />
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="text" name="address" id="address" placeholder="Enter Mobile Number" required />
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="assets/img/ChildReg.png" alt="Sign up image"></figure>
                        <a href="login.php" class="signup-image-link">I am already a member</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

