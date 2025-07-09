<?php
session_start();
include '../db/DBcon.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../authentication/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Get current user data
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: ../authentication/login.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $new_user_type = isset($_POST['user_type']) ? $_POST['user_type'] : $user['user_type'];
    
    // Validate current password
    if (!password_verify($current_password, $user['password_hash'])) {
        $error = "Current password is incorrect.";
    } else {
        // Check if email already exists (and it's not the current user's email)
        if ($new_email !== $user['email']) {
            $check_email_sql = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
            $check_stmt = $conn->prepare($check_email_sql);
            $check_stmt->bind_param("si", $new_email, $user_id);
            $check_stmt->execute();
            $email_result = $check_stmt->get_result();
            
            if ($email_result->num_rows > 0) {
                $error = "Email address is already in use.";
            }
        }
        
        // Validate new password if provided
        if (!empty($new_password)) {
            if (strlen($new_password) < 6) {
                $error = "New password must be at least 6 characters long.";
            } elseif ($new_password !== $confirm_password) {
                $error = "New passwords do not match.";
            }
        }
        
        // Only admins can change user type
        if ($user['user_type'] !== 'admin' && $new_user_type !== $user['user_type']) {
            $error = "You don't have permission to change user type.";
        }
        
        // Update profile if no errors
        if (empty($error)) {
            if (!empty($new_password)) {
                // Update email, password, and user_type
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE users SET email = ?, password_hash = ?, user_type = ? WHERE user_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("sssi", $new_email, $password_hash, $new_user_type, $user_id);
            } else {
                // Update only email and user_type
                $update_sql = "UPDATE users SET email = ?, user_type = ? WHERE user_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ssi", $new_email, $new_user_type, $user_id);
            }
            
            if ($update_stmt->execute()) {
                // Update session variables
                $_SESSION['email'] = $new_email;
                $_SESSION['user_type'] = $new_user_type;
                
                // Refresh user data
                $user['email'] = $new_email;
                $user['user_type'] = $new_user_type;
                
                $message = "Profile updated successfully!";
            } else {
                $error = "Error updating profile. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Agro Vista</title>

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,0,100,300,400,500,700,900;1,100,300,400,500,700,900&family=Inter:wght@100,200,300,400,500,600,700,800,900&family=Nunito:ital,wght@0,200,300,400,500,600,700,800,900;1,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="../assets/css/main.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }
        
        .edit-profile-container {
            min-height: 100vh;
            padding: 50px 0;
        }
        
        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .profile-header h2 {
            color: #2c5530;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .profile-header p {
            color: #666;
            margin-bottom: 0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #45a049, #3d8b40);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: linear-gradient(135deg, #5a6268, #495057);
            transform: translateY(-2px);
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 25px;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }
        
        .user-type-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .badge-admin {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }
        
        .badge-user {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }
        
        .back-links {
            text-align: center;
            margin-top: 30px;
        }
        
        .back-links a {
            color: #4CAF50;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
        }
        
        .back-links a:hover {
            color: #45a049;
            text-decoration: underline;
        }

        .password-section {
            border-top: 2px solid #e9ecef;
            padding-top: 25px;
            margin-top: 25px;
        }

        .password-section h5 {
            color: #2c5530;
            margin-bottom: 20px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="edit-profile-container">
        <div class="container">
            <div class="profile-card">
                <div class="profile-header">
                    <h2>Edit Profile</h2>
                    <p>Update your account information</p>
                    <span class="user-type-badge <?php echo $user['user_type'] === 'admin' ? 'badge-admin' : 'badge-user'; ?>">
                        <?php echo ucfirst($user['user_type']); ?>
                    </span>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i><?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <?php if ($user['user_type'] === 'admin'): ?>
                    <div class="form-group">
                        <label for="user_type" class="form-label">User Type</label>
                        <select class="form-control" id="user_type" name="user_type">
                            <option value="admin" <?php echo $user['user_type'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="user" <?php echo $user['user_type'] === 'user' ? 'selected' : ''; ?>>User</option>
                        </select>
                        <small class="form-text text-muted">Only admins can change user type.</small>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <small class="form-text text-muted">Required to make any changes.</small>
                    </div>

                    <div class="password-section">
                        <h5>Change Password <small class="text-muted">(Optional)</small></h5>
                        
                        <div class="form-group">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" 
                                   minlength="6" placeholder="Leave blank to keep current password">
                            <small class="form-text text-muted">Minimum 6 characters.</small>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                   placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        <button type="submit" class="btn btn-primary me-md-2">
                            <i class="bi bi-save me-2"></i>Update Profile
                        </button>
                        <?php if ($user['user_type'] === 'admin'): ?>
                            <a href="../admin/dashboard_admin.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                            </a>
                        <?php else: ?>
                            <a href="../shared/index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Home
                            </a>
                        <?php endif; ?>
                    </div>
                </form>

                <div class="back-links">
                    <a href="../authentication/logout.php">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="../assets/js/main.js"></script>

    <script>
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;
            
            if (newPassword && confirmPassword && newPassword !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        // Clear confirm password when new password changes
        document.getElementById('new_password').addEventListener('input', function() {
            const confirmPassword = document.getElementById('confirm_password');
            if (confirmPassword.value) {
                confirmPassword.dispatchEvent(new Event('input'));
            }
        });
    </script>
</body>
</html>