<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'user') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

$user_id = $_SESSION['user_id'];

<<<<<<< Updated upstream
=======
// Get mother's babies
//$babies = $conn->query("SELECT * FROM Babies WHERE mother_id = $user_id");
>>>>>>> Stashed changes
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
            <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2></div>

        <div class="dashboard-section">
            <div class="slideshow-container">
  <div class="slides">
    <div class="slide"><img src="https://via.placeholder.com/800x450?text=Slide+1" alt="Slide 1"></div>
    <div class="slide"><img src="https://via.placeholder.com/800x450?text=Slide+2" alt="Slide 2"></div>
    <div class="slide"><img src="https://via.placeholder.com/800x450?text=Slide+3" alt="Slide 3"></div>
    <div class="slide"><img src="https://via.placeholder.com/800x450?text=Slide+4" alt="Slide 4"></div>
  </div>
</div>
            <h3>Our Products</h3>
            <div class="card-container">
<div class="container">
  <img src="https://images.unsplash.com/photo-1488628075628-e876f502d67a?dpr=1&auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=&bg=" alt="" />
  <p class="title">card title</p>
  <div class="overlay"></div>
  <div class="button"><a href="#"> BUY NOW </a></div>
</div>

<div class="container">
  <img src="https://images.unsplash.com/photo-1488628075628-e876f502d67a?dpr=1&auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=&bg=" alt="" />
  <p class="title">card title</p>
  <div class="overlay"></div>
  <div class="button"><a href="#"> BUY NOW </a></div>
</div>
      
<div class="container">
  <img src="https://images.unsplash.com/photo-1488628075628-e876f502d67a?dpr=1&auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=&bg=" alt="" />
  <p class="title">card title</p>
  <div class="overlay"></div>
  <div class="button"><a href="#"> BUY NOW </a></div>
</div>

<div class="container">
  <img src="https://images.unsplash.com/photo-1488628075628-e876f502d67a?dpr=1&auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=&bg=" alt="" />
  <p class="title">card title</p>
  <div class="overlay"></div>
  <div class="button"><a href="#"> BUY NOW </a></div>
</div>
            </div>
        </div>

        <div class="dashboard-footer">
            <a href="edit_profile.php" class="add-child-button">Edit Profile</a>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>

    </div>
</body>
</html>
