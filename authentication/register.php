<?php
session_start();
include '../db/DBcon.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['pass'];
    $confirm_password = $_POST['re_pass'];
    
    // Validation
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        // Check if email already exists
        $check_sql = "SELECT * FROM users WHERE email = '$email'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            $error = "Email already exists. Please use a different email.";
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : 'admin'; // Default to admin for this registration
            
            $sql = "INSERT INTO users (email, password_hash, user_type) 
                    VALUES ('$email', '$password_hash', '$user_type')";

            if ($conn->query($sql) === TRUE) {
                header("Location: login.php?success=registered");
                exit;
            } else {
                $error = "Error: " . $conn->error;
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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Registration | Agro Vista</title>

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
            min-height: 600px;
        }
        
        .register-image {
            flex: 1;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            padding: 40px;
            position: relative;
        }
        
        .register-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('../assets/img/logo.png') center/100px no-repeat;
            opacity: 0.1;
        }
        
        .register-image h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .register-image p {
            font-size: 1.1rem;
            text-align: center;
            opacity: 0.9;
            margin-bottom: 10px;
        }
        
        .register-form {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-title {
            font-size: 2rem;
            font-weight: 600;
            color: #2c5530;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .form-subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 40px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-control {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #4CAF50;
            background: white;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
        
        .form-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #4CAF50;
            font-size: 18px;
        }
        
        .btn-register {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s;
            margin-top: 20px;
        }
        
        .btn-register:hover {
            background: linear-gradient(135deg, #45a049, #3d8b40);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        .back-link {
            text-align: center;
            margin-top: 30px;
        }
        
        .back-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-link a:hover {
            color: #45a049;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                margin: 20px;
            }
            
            .register-image {
                padding: 30px 20px;
            }
            
            .register-form {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

    <div class="register-container">
        <!-- Register Image/Branding Side -->
        <div class="register-image">
            <h2>Agro Vista</h2>
            <p>Join the Agricultural E-Commerce Platform</p>
            <p>Create an account to access the marketplace</p>
            <p>Choose your role: Administrator or Regular User</p>
        </div>

        <!-- Register Form Side -->
        <div class="register-form">
            <h2 class="form-title">User Registration</h2>
            <p class="form-subtitle">Create your account to access Agro Vista</p>
            
            <?php if (isset($_GET['success']) && $_GET['success'] == 'registered') { ?>
                <div class="success-message">
                    <i class="bi bi-check-circle"></i> Registration successful! You can now login.
                </div>
            <?php } ?>
            
            <?php if (!empty($error)) { ?>
                <div class="error-message">
                    <i class="bi bi-exclamation-triangle"></i> <?php echo $error; ?>
                </div>
            <?php } ?>
            
            <form method="POST" id="register-form">
                <div class="form-group">
                    <i class="bi bi-envelope form-icon"></i>
                    <input type="email" name="email" id="email" class="form-control" 
                           placeholder="Enter your email address" required />
                </div>
                
                <div class="form-group">
                    <i class="bi bi-lock form-icon"></i>
                    <input type="password" name="pass" id="pass" class="form-control" 
                           placeholder="Create a password" required minlength="6" />
                </div>
                
                <div class="form-group">
                    <i class="bi bi-lock-fill form-icon"></i>
                    <input type="password" name="re_pass" id="re_pass" class="form-control" 
                           placeholder="Confirm your password" required />
                </div>
                
                <div class="form-group">
                    <i class="bi bi-person-badge form-icon"></i>
                    <select name="user_type" id="user_type" class="form-control" style="padding-left: 50px;" required>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                
                <button type="submit" name="signup" class="btn-register">
                    <i class="bi bi-person-plus"></i> Create Account
                </button>
            </form>
            
            <div class="login-link">
                <p>Already have an account? 
                   <a href="login.php">Sign in here</a>
                </p>
            </div>
            
            <div class="back-link">
                <a href="../shared/index.php">
                    <i class="bi bi-arrow-left"></i> Back to Main Site
                </a>
            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- Password Confirmation Script -->
    <script>
        document.getElementById('register-form').addEventListener('submit', function(e) {
            const password = document.getElementById('pass').value;
            const confirmPassword = document.getElementById('re_pass').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long!');
                return false;
            }
        });
    </script>

</body>
</html>
