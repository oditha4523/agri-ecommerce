<?php
include 'session_active.php';
include '../db/DBcon.php';

// Get the category from URL parameter
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Map category URL parameters to display names
$category_names = [
    'cinnamon' => 'Ceylon Cinnamon',
    'kithul' => 'Kithul Products',
    'tea' => 'Handmade Tea',
    'dry_fish' => 'Dry Fish'
];

$page_title = isset($category_names[$category]) ? $category_names[$category] : 'Products';

// Fetch products with category "Utilized" - you can modify this query based on your needs
// For now, we'll show all products since the current database structure might not have specific subcategories
$sql = "SELECT p.*, s.seller_name 
        FROM products p 
        JOIN sellers s ON p.seller_id = s.seller_id 
        WHERE p.category = 'Utilized' 
        ORDER BY p.product_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo htmlspecialchars($page_title); ?> - Agro Vista</title>
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
    .product-category-badge {
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
      cursor: pointer;
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
    
    .member-img {
      position: relative;
      overflow: hidden;
      border-radius: 10px;
    }
    
    .member-img img {
      height: 250px;
      object-fit: cover;
      border-radius: 10px;
      width: 100%;
    }
    
    .member-img video {
      height: 250px;
      object-fit: cover;
      border-radius: 10px;
      width: 100%;
    }
    
    .video-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: opacity 0.3s ease;
    }
    
    .video-overlay:hover {
      background: rgba(0, 0, 0, 0.7);
    }
    
    .video-overlay .play-btn {
      font-size: 48px;
      color: white;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
      position: relative;
    }
    
    .video-overlay .play-btn::after {
      content: "Auto-play";
      position: absolute;
      bottom: -25px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 12px;
      background: rgba(76, 175, 80, 0.9);
      padding: 3px 8px;
      border-radius: 10px;
      white-space: nowrap;
    }
    
    .video-modal {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.9);
    }
    
    .video-modal-content {
      background-color: #000;
      margin: 5% auto;
      padding: 0;
      width: 90%;
      max-width: 800px;
      position: relative;
      border-radius: 10px;
      overflow: hidden;
    }
    
    .video-modal video,
    .video-modal iframe {
      width: 100%;
      height: 450px;
      border: none;
      border-radius: 10px;
    }
    
    .video-modal video {
      background: #000;
    }
    
    .video-autoplay-indicator {
      position: absolute;
      top: 10px;
      left: 10px;
      background: rgba(76, 175, 80, 0.9);
      color: white;
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 12px;
      font-weight: 500;
      z-index: 1000;
      animation: fadeInOut 3s ease-in-out;
    }
    
    @keyframes fadeInOut {
      0% { opacity: 0; }
      20% { opacity: 1; }
      80% { opacity: 1; }
      100% { opacity: 0; }
    }
    
    .video-close {
      color: #aaa;
      position: absolute;
      top: -40px;
      right: 0;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
      z-index: 10000;
    }
    
    .video-close:hover,
    .video-close:focus {
      color: white;
      text-decoration: none;
    }
    
    .member-info h4 {
      color: #2c5530;
      margin-bottom: 10px;
    }
    
    .member-info span {
      color: #666;
      font-style: italic;
    }
    
    .back-button {
      margin-bottom: 20px;
    }
    
    .category-header {
      background: linear-gradient(135deg, #4CAF50, #45a049);
      color: white;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
      text-align: center;
    }
    
    .category-header h2 {
      margin-bottom: 10px;
      color: white;
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
          <li><a href="ufruits.php">Underutilized Fruits</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list">          
        </i>
      </nav>
    </div>
  </header>

  <main class="main">
    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container position-relative">
        <h1><?php echo htmlspecialchars($page_title); ?></h1>
        <p>
          Discover high-quality Sri Lankan agricultural products from trusted local sellers. 
          Each product represents the rich heritage and expertise of our farming communities.
        </p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li class="current"><?php echo htmlspecialchars($page_title); ?></li>
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
                  
                  // Get video URL and determine video type
                  $video_url = $row['video_url'];
                  $video_id = '';
                  $video_type = '';
                  
                  if (!empty($video_url)) {
                      // Check if it's a YouTube video
                      if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $matches)) {
                          $video_id = $matches[1];
                          $video_type = 'youtube';
                      }
                      // Check if it's a Vimeo video
                      elseif (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
                          $video_id = $matches[1];
                          $video_type = 'vimeo';
                      }
                      // Check if it's a local video file or direct video file
                      elseif (preg_match('/\.(mp4|webm|ogg|avi|mov)$/i', $video_url)) {
                          $video_type = 'direct';
                          // Adjust path for local video files (add ../ since we're in shared/ directory)
                          if (strpos($video_url, 'assets/') === 0) {
                              $video_url = '../' . $video_url;
                          }
                      }
                      // Default to iframe for other URLs
                      else {
                          $video_type = 'iframe';
                      }
                  }
                  
                  $product_id = 'product_' . $row['product_id'];
                  
                  // Debug: Add HTML comment to show video info (remove in production)
                  if (!empty($video_url)) {
                      echo "<!-- Debug: Video URL: " . htmlspecialchars($video_url) . ", Type: " . htmlspecialchars($video_type) . " -->";
                  }
          ?>
          <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="100">
            <div class="member-img">
              <?php if (!empty($video_url)): ?>
                <img src="<?php echo htmlspecialchars($display_image); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <div class="video-overlay" onclick="openVideoModal('<?php echo $product_id; ?>')">
                  <i class="bi bi-play-circle-fill play-btn"></i>
                </div>
              <?php else: ?>
                <img src="<?php echo htmlspecialchars($display_image); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['name']); ?>">
              <?php endif; ?>
              <div class="social">
                <?php if(!empty($video_url)): ?>
                  <span class="product-category-badge">Has Video</span>
                <?php else: ?>
                  <span class="product-category-badge"><?php echo htmlspecialchars($page_title); ?></span>
                <?php endif; ?>
              </div>
            </div>
            <div class="member-info text-center">
              <h4><?php echo htmlspecialchars($row['name']); ?></h4>
              <span>Seller: <?php echo htmlspecialchars($row['seller_name']); ?></span>
              <?php if(!empty($video_url)): ?>
                <div class="product-actions mt-3">
                  <button onclick="openVideoModal('<?php echo $product_id; ?>')" class="btn btn-primary btn-sm">
                    <i class="bi bi-play-circle"></i> Watch Video
                  </button>
                </div>
              <?php endif; ?>
            </div>
            
            <?php if (!empty($video_url)): ?>
            <!-- Video Modal -->
            <div id="<?php echo $product_id; ?>_modal" class="video-modal">
              <div class="video-modal-content">
                <span class="video-close" onclick="closeVideoModal('<?php echo $product_id; ?>')">&times;</span>
                <div id="<?php echo $product_id; ?>_autoplay_indicator" class="video-autoplay-indicator" style="display: none;">
                  <i class="bi bi-play-fill"></i> Auto-playing...
                </div>
                <?php if ($video_type === 'youtube'): ?>
                  <iframe id="<?php echo $product_id; ?>_iframe" src="" 
                          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                          allowfullscreen
                          data-src="https://www.youtube.com/embed/<?php echo $video_id; ?>?autoplay=1&mute=1"></iframe>
                <?php elseif ($video_type === 'vimeo'): ?>
                  <iframe id="<?php echo $product_id; ?>_iframe" src="" 
                          allow="autoplay; fullscreen; picture-in-picture" 
                          allowfullscreen
                          data-src="https://player.vimeo.com/video/<?php echo $video_id; ?>?autoplay=1&muted=1"></iframe>
                <?php elseif ($video_type === 'direct'): ?>
                  <video id="<?php echo $product_id; ?>_video" controls muted autoplay playsinline preload="metadata" 
                         onerror="console.error('Video failed to load:', this.src)">
                    <source src="<?php echo htmlspecialchars($video_url); ?>" 
                            type="video/<?php echo pathinfo($video_url, PATHINFO_EXTENSION); ?>"
                            onerror="console.error('Video source failed to load:', this.src)">
                    <p>Your browser does not support the video tag. Video URL: <?php echo htmlspecialchars($video_url); ?></p>
                  </video>
                <?php else: ?>
                  <iframe id="<?php echo $product_id; ?>_iframe" src="" allowfullscreen
                          data-src="<?php echo htmlspecialchars($video_url); ?>"></iframe>
                <?php endif; ?>
              </div>
            </div>
            <?php endif; ?>
          </div><!-- End Product -->
          <?php
              }
          } else {
          ?>
          <div class="col-12 text-center">
            <div class="no-products">
              <h3>No Products Available</h3>
              <p>We're currently updating our inventory. Please check back soon for new <?php echo htmlspecialchars($page_title); ?> products!</p>
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
            <li><i class="bi bi-chevron-right"></i> <a href="contact.php">Contact</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <p>Stay connected with us and keep up with the latest updates, news, and insights from our agricultural community.</p>
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

  <!-- Video Modal JavaScript -->
  <script>
    function openVideoModal(productId) {
      console.log('Opening video modal for:', productId);
      var modal = document.getElementById(productId + '_modal');
      if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
        
        // Get autoplay indicator
        var indicator = document.getElementById(productId + '_autoplay_indicator');
        
        // Load and autoplay video
        var iframe = modal.querySelector('iframe');
        var video = modal.querySelector('video');
        
        console.log('Found iframe:', !!iframe, 'Found video:', !!video);
        
        if (iframe && iframe.hasAttribute('data-src')) {
          // Load iframe source to trigger autoplay
          var src = iframe.getAttribute('data-src');
          console.log('Loading iframe src:', src);
          iframe.src = src;
          
          // Show autoplay indicator for iframe videos
          if (indicator) {
            indicator.style.display = 'block';
            setTimeout(function() {
              indicator.style.display = 'none';
            }, 3000);
          }
        }
        
        if (video) {
          // For direct video files, ensure autoplay
          console.log('Video source:', video.querySelector('source') ? video.querySelector('source').src : 'No source found');
          
          // Add error handling
          video.addEventListener('error', function(e) {
            console.error('Video error:', e);
            if (indicator) {
              indicator.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Video failed to load';
              indicator.style.background = 'rgba(220, 53, 69, 0.9)';
              indicator.style.display = 'block';
            }
          });
          
          video.addEventListener('loadstart', function() {
            console.log('Video started loading');
          });
          
          video.addEventListener('canplay', function() {
            console.log('Video can start playing');
          });
          
          video.currentTime = 0;
          video.muted = true; // Ensure muted for autoplay policy compliance
          
          // Try to play the video
          var playPromise = video.play();
          
          // Handle play promise for browsers that require it
          if (playPromise !== undefined) {
            playPromise.then(function() {
              // Video started successfully - show indicator
              console.log('Video autoplay started successfully');
              if (indicator) {
                indicator.style.display = 'block';
                setTimeout(function() {
                  indicator.style.display = 'none';
                }, 3000);
              }
            }).catch(function(error) {
              // Auto-play was prevented
              console.log('Autoplay prevented:', error);
              
              // Add click listener to unmute when user interacts
              video.addEventListener('click', function() {
                video.muted = false;
                if (indicator) {
                  indicator.innerHTML = '<i class="bi bi-volume-up-fill"></i> Unmuted';
                  indicator.style.display = 'block';
                  setTimeout(function() {
                    indicator.style.display = 'none';
                  }, 2000);
                }
              }, { once: true });
            });
          }
        }
      } else {
        console.log('Modal not found for product:', productId);
      }
    }

    function closeVideoModal(productId) {
      var modal = document.getElementById(productId + '_modal');
      if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Restore scrolling
        
        // Hide autoplay indicator
        var indicator = document.getElementById(productId + '_autoplay_indicator');
        if (indicator) {
          indicator.style.display = 'none';
        }
        
        // Stop video playback
        var iframe = modal.querySelector('iframe');
        var video = modal.querySelector('video');
        
        if (iframe) {
          // Clear iframe source to stop playback
          iframe.src = '';
        }
        
        if (video) {
          video.pause();
          video.currentTime = 0;
        }
      }
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
      var modals = document.getElementsByClassName('video-modal');
      for (var i = 0; i < modals.length; i++) {
        if (event.target == modals[i]) {
          var modalId = modals[i].id.replace('_modal', '');
          closeVideoModal(modalId);
        }
      }
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        var modals = document.getElementsByClassName('video-modal');
        for (var i = 0; i < modals.length; i++) {
          if (modals[i].style.display === 'block') {
            var modalId = modals[i].id.replace('_modal', '');
            closeVideoModal(modalId);
          }
        }
      }
    });

    // Handle browser autoplay policies
    document.addEventListener('DOMContentLoaded', function() {
      // Check if autoplay is supported
      var testVideo = document.createElement('video');
      testVideo.muted = true;
      testVideo.setAttribute('autoplay', '');
      testVideo.setAttribute('playsinline', '');
      
      // If autoplay with muted video doesn't work, we'll need user interaction
      if (!testVideo.autoplay) {
        console.log('Autoplay may be restricted in this browser');
      }
    });
  </script>

</body>

</html>

<?php
// Close database connection
if(isset($conn)) {
    $conn->close();
}
?>
