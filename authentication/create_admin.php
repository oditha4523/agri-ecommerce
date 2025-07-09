<?php
include 'db/DBcon.php';

// Configuration - Change these as needed
$admin_email = "admin@agrovista.com";
$admin_password = "admin123";

// Check if admin already exists
$check_sql = "SELECT * FROM users WHERE email = '$admin_email'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows > 0) {
    echo "Admin user with email '$admin_email' already exists.\n";
} else {
    // Hash the password
    $password_hash = password_hash($admin_password, PASSWORD_DEFAULT);
    
    // Insert new admin user
    $insert_sql = "INSERT INTO users (email, password_hash, user_type) VALUES ('$admin_email', '$password_hash', 'admin')";
    
    if ($conn->query($insert_sql) === TRUE) {
        echo "Admin user created successfully!\n";
        echo "Email: $admin_email\n";
        echo "Password: $admin_password\n";
        echo "You can now login at: authentication/login.php\n";
    } else {
        echo "Error creating admin user: " . $conn->error . "\n";
    }
}

$conn->close();
?>
