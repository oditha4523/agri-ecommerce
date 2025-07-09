<?php
include 'session_active.php';
include '../db/DBcon.php';

// Fetch products with category "UnderUtilized"
$sql = "SELECT p.*, s.seller_name 
        FROM products p 
        JOIN sellers s ON p.seller_id = s.seller_id 
        WHERE p.category = 'UnderUtilized' 
        ORDER BY p.product_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Underutilized Fruits</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">

  <!-- Custom CSS for Products -->
  <style>
    .product-category {
      background: #28a745;
      color: white;
      padding: 4px 8px;
      border-radius: 10px;
      font-size: 12px;
      font-weight: bold;
      margin-left: 10px;
    }
    
    .social .bi-play-circle-fill {
      font-size: 24px;
      color: #dc3545;
      transition: color 0.3s ease;
    }
    
    .social .bi-play-circle-fill:hover {
      color: #c82333;
    }
    
    .product-actions .btn {
      padding: 8px 15px;
      font-size: 14px;
      border-radius: 20px;
    }
    
    .no-products {
      padding: 50px 20px;
      color: #666;
    }
    
    .no-products h3 {
      color: #333;
      margin-bottom: 20px;
    }
    
    .member-img img {
      height: 250px;
      object-fit: cover;
      border-radius: 10px;
    }
    
    .member-info h4 {
      color: #2c5530;
      margin-bottom: 10px;
    }
    
    .member-info span {
      color: #666;
      font-style: italic;
    }
  </style>
</head>

<body class="team-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <img src="../assets/img/logo.png" alt="" style="border-radius: 50%;">
        <h1 class="sitename">Agro Vista</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="ufruits.php" class="active">Underutilized Fruits</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container position-relative">
        <h1>Underutilized Fruits</h1>
        <p>
          This Digital Trade Fair is organized by the undergraduates of the Faculty of Agricultural Sciences, Sabaragamuwa University of Sri Lanka. It is a part of our academic initiative to promote and support local agricultural industries by introducing high-quality Sri Lankan products such as kithul, cinnamon, dry fish, and tea to both local and international markets.
        </p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Underutilized Fruits</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Products Section -->
    <section id="products" class="team section">

      <div class="container">

        <div class="row gy-5">

          <?php
          if ($result && $result->num_rows > 0) {
              $default_images = ['685799f1d8046.jpg', '68579a602c35c.jpg']; // Available images
              $image_index = 0;
              
              while($row = $result->fetch_assoc()) {
                  // Use available images in rotation or a default
                  $display_image = "../assets/img/products/" . $default_images[$image_index % count($default_images)];
                  $image_index++;
                  
                  // If there's a video URL, we could show a video thumbnail or play button
                  $video_url = $row['video_url'];
          ?>
          <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="100">
            <div class="member-img">
              <img src="<?php echo htmlspecialchars($display_image); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['name']); ?>">
              <div class="social">
                <?php if(!empty($video_url)): ?>
                  <a href="<?php echo htmlspecialchars($video_url); ?>" target="_blank" title="Watch Video">
                    <i class="bi bi-play-circle-fill"></i>
                  </a>
                <?php endif; ?>
                <span class="product-category">Underutilized Fruit</span>
              </div>
            </div>
            <div class="member-info text-center">
              <h4><?php echo htmlspecialchars($row['name']); ?></h4>
              <span>Seller: <?php echo htmlspecialchars($row['seller_name']); ?></span>
              <?php if(!empty($video_url)): ?>
                <div class="product-actions mt-3">
                  <a href="<?php echo htmlspecialchars($video_url); ?>" target="_blank" class="btn btn-primary btn-sm">
                    <i class="bi bi-play-circle"></i> Watch Video
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div><!-- End Product -->
          <?php
              }
          } else {
          ?>
          <div class="col-12 text-center">
            <div class="no-products">
              <h3>No Underutilized Fruits Available</h3>
              <p>We're currently updating our inventory. Please check back soon for new underutilized fruit products!</p>
            </div>
          </div>
          <?php } ?>

        </div>

      </div>

    </section><!-- /Products Section -->

  </main>

  <footer id="footer" class="footer dark-background">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.php" class="d-flex align-items-center">
            <span class="sitename">Agro Vista</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Faculty of Agricultural Sciences</p>
            <p>Sabaragamuwa University of Sri Lanka</p>
            <p class="mt-3"><strong>Email:</strong> <span>agribizdigitaltradefair@gmail.com</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="index.php">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="products.php">Products</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="ufruits.php">Underutilized Fruits</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <p>Stay connected with us and keep up with the latest updates, news, and insights from our agricultural community and discover unique underutilized fruits from Sri Lanka.</p>
          <div class="social-links d-flex">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Agro Vista</strong> <span>All Rights Reserved</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>

<?php
// Close database connection
if(isset($conn)) {
    $conn->close();
}
?>