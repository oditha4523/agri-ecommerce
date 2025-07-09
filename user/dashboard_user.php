<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'user') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

$user_id = $_SESSION['user_id'];


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
            <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
        </div>

        <div class="slideshow-container">
            <div class="slides">
                <div class="slide active"><img src="../assets/img/products/tea.jpg" alt="Slide 1"></div>
                <div class="slide"><img src="../assets/img/products/cinnomon.jpg" alt="Slide 2"></div>
                <div class="slide"><img src="../assets/img/products/kithul.jpg" alt="Slide 3"></div>
                <div class="slide"><img src="../assets/img/products/dry_fish.jpg" alt="Slide 4"></div>
            </div>
            
            <!-- Navigation buttons -->
            <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
            <a class="next" onclick="changeSlide(1)">&#10095;</a>
            
            <!-- Dots indicators -->
            <div class="dots-container">
                <span class="dot active" onclick="currentSlideSet(0)"></span>
                <span class="dot" onclick="currentSlideSet(1)"></span>
                <span class="dot" onclick="currentSlideSet(2)"></span>
                <span class="dot" onclick="currentSlideSet(3)"></span>
            </div>
        </div>

        <div class="dashboard-section">
            <h3>Our Products</h3>
        </div>

        <div class="card-container">
            <div class="container">
                <img src="../assets/img/products/cinnomon.jpg" alt="" />
                <p class="title">CINNOMON</p>
                <div class="overlay"></div>
                <div class="button"><a href="#"> BUY NOW </a></div>
            </div><br>

            <div class="container">
                <img src="../assets/img/products/kithul.jpg" alt="" />
                <p class="title">KITHUL</p>
                <div class="overlay"></div>
                <div class="button"><a href="#"> BUY NOW </a></div>
            </div>
            
            <div class="container">
                <img src="../assets/img/products/tea.jpg" alt="" />
                <p class="title">HANDMADE TEA</p>
                <div class="overlay"></div>
                <div class="button"><a href="#"> BUY NOW </a></div>
            </div><br>

            <div class="container">
                <img src="../assets/img/products/dry_fish.jpg" alt="" />
                <p class="title">DRY FISH</p>
                <div class="overlay"></div>
                <div class="button"><a href="#"> BUY NOW </a></div>
            </div>
        </div>

        <div class="dashboard-footer">
            <a href="edit_profile.php" class="add-child-button">Edit Profile</a>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>

    </div>
    
    <script>
        // Slideshow functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        const totalSlides = slides.length;
        let slideInterval;

        function showSlide(index) {
            // Remove active class from all slides and dots
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            // Add active class to current slide and dot
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }

        function changeSlide(direction) {
            clearInterval(slideInterval);
            if (direction === 1) {
                nextSlide();
            } else {
                prevSlide();
            }
            // Restart auto-play
            slideInterval = setInterval(nextSlide, 3000);
        }

        function currentSlideSet(index) {
            clearInterval(slideInterval);
            currentSlide = index;
            showSlide(currentSlide);
            // Restart auto-play
            slideInterval = setInterval(nextSlide, 3000);
        }

        // Initialize slideshow
        if (slides.length > 0) {
            showSlide(0);
            slideInterval = setInterval(nextSlide, 3000); // Change slide every 3 seconds
        }
    </script>
</body>
</html>
