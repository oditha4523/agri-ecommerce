<?php
include 'session_active.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home</title>
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
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <img src="../assets/img/logo.png" alt="" style="border-radius: 50%;">
        <h1 class="sitename">BabyCare</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="team.php">About</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><?php displayUserSession(); ?></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">


      <div id="hero-carousel" class="carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <div class="container position-relative">

          <div class="carousel-item active">
            <div class="carousel-container">
              <h2>Welcome to Agro Vista</h2>
              <p>
                Discover the rich heritage and craftsmanship behind Sri Lanka’s finest agri-products. From pure Ceylon cinnamon and traditional kithul to handmade teas and dry fish delicacies, our platform connects you with passionate local producers. Explore, support, and shop directly from trusted sellers – all in one place.
                In addition, don’t miss our special segment dedicated to underutilized fruits in Sri Lanka, featuring informative videos that highlight their unique value, benefits, and potential for innovation.
              </p>
              <a href="#about" class="btn-get-started">Read More</a>
            </div>
          </div><!-- End Carousel Item -->
        </div>

      </div>

    </section><!-- /Hero Section -->

    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section">
       <div class="container section-title" data-aos="fade-up">
        <h2>Our Products</h2>
      </div>

      <div class="container">

        <div class="row gy-4">

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="container1">
              <img src="../assets/img/products/cinnomon.jpg" alt="Ceylon Cinnamon" class="image">
              <div class="middle">
                <div class="text">Ceylon Cinnamon</div>
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="container1">
              <img src="../assets/img/products/kithul.jpg" alt="Kithul Products" class="image">
              <div class="middle">
                <div class="text">Kithul Products</div>
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="container1">
              <img src="../assets/img/products/tea.jpg" alt="Handmade Tea" class="image">
              <div class="middle">
                <div class="text">Handmade Tea</div>
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
            <div class="container1">
              <img src="../assets/img/products/dry_fish.jpg" alt="Dry Fish" class="image">
              <div class="middle">
                <div class="text">Dry Fish</div>
              </div>
            </div>
          </div><!-- End Service Item -->
        </div>

      </div>

    </section><!-- /Featured Services Section -->

    <!-- About Section -->
    <section id="about" class="about section light-background">

      <div class="container">

      <div class="row gy-4">
          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
            <img src="../assets/img/about.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
            <h3>Our Mission.</h3>
            <p class="fst-italic">
              To empower Sri Lankan producers of Cinnamon, Kithul products, Handmade Tea, and Dry Fish by providing a trusted digital marketplace that enhances visibility, facilitates fair trade, and connects them directly with consumers and buyers island wide and globally, while also promoting awareness and appreciation of Sri Lanka’s underutilized fruits through dedicated video content. 
            </p>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Features Section -->
    <section id="features" class="features section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Our Vision</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4 align-items-center features-item">
          <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="100">
            <img src="assets/img/features-1.svg" class="img-fluid" alt="">
          </div>
          <div class="col-md-7" data-aos="fade-up" data-aos-delay="100">
            <p class="fst-italic">
              To create a dynamic digital platform that connects islandwide sellers and buyers of Cinnamon, Kithul products, Handmade Tea, and Dry Fish—promoting local entrepreneurship, cultural heritage, and sustainable trade across Sri Lanka and beyond, while also raising awareness on the value of underutilized fruits through dedicated video content. 
            </p>
          </div>
        </div><!-- Features Item -->

      </div>

    </section><!-- /Features Section -->

  </main>

  <footer id="footer" class="footer dark-background">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="d-flex align-items-center">
            <span class="sitename">BabyCare</span>
          </a>
          <div class="footer-contact pt-3">
            <p>74/1, </p>
            <p>Kandy Rd, Matale</p>
            <p class="mt-3"><strong>Phone:</strong> <span>(081) 5 612 850</span></p>
            <p><strong>Email:</strong> <span>Babycare@gmail.com</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="index.html">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="team.html">Team</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="vaccines.html">Vaccines</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <p>Stay connected with us and keep up with the latest updates, news, and insights. Follow us on our social media channels for a closer look at our journey, achievements, and behind-the-scenes moments.</p>
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
      <p>© <span>Copyright</span> <strong class="px-1 sitename">BabyCare</strong> <span>All Rights Reserved</span></p>
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