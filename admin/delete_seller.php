<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

if (isset($_GET['seller_id'])) {
    $seller_id = $_GET['seller_id'];

    if ($check->num_rows > 0) {
        $conn->query("DELETE FROM products WHERE seller_id = $seller_id");

        $conn->query("DELETE FROM sellers WHERE seller_id = $seller_id");

        header("Location: dashboard_mother.php?success=child_deleted");
        exit;
    } else {
        echo "Error: Unauthorized action!";
    }
} else {
    echo "Error: Invalid request!";
}
?>
