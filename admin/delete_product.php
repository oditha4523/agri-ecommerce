<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include 'DBcon.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    $check = $conn->query("SELECT * FROM Products WHERE product_id = $product_id");

    if ($check->num_rows > 0) {
        // Delete vaccination records first (to maintain referential integrity)
        $conn->query("DELETE FROM Orders WHERE product_id = $product_id");

        // Now delete the child
        $conn->query("DELETE FROM Products WHERE product_id = $product_id");

        header("Location: view_products.php?success=Product_deleted");
        exit;
    } else {
        echo "Error: Unauthorized action!";
    }
} else {
    echo "Error: Invalid request!";
}
?>
