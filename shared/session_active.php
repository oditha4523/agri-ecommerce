<?php
function displayUserSession() {
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check if user is logged in and session is valid
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        $user_type = $_SESSION['user_type'];
        
        if ($user_type == 'admin') {
            echo "<a href=\"../admin/dashboard_admin.php\">Dashboard</a>";
        } else {
            echo "<a href=\"../user/dashboard_user.php\">Dashboard</a>";
        }
    } else {
        echo "<a href=\"../authentication/register.php\"><u>Get Started</u></a>";
    }
}
?>