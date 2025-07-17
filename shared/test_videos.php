<!DOCTYPE html>
<html>
<head>
    <title>Video Test</title>
</head>
<body>
    <h2>Video Access Test</h2>
    
    <h3>Test 1: Video Access Test</h3>
    <p>Testing access to videos in the organized directory structure:</p>
    <video controls width="400" style="border: 1px solid #ccc;">
        <source src="../assets/videos/products/utilized/cinnamon/Cylon Spices.mp4" type="video/mp4">
        Video not found or not supported
    </video>
    <p><small>Testing: Cylon Spices.mp4 in cinnamon category</small></p>
    
    <h3>Test 2: Video Directory Structure</h3>
    <p>Testing organized video directory structure:</p>
    <?php
    $base_video_dir = '../assets/videos/products/';
    $categories = ['utilized', 'underutilized'];
    $subcategories = ['cinnamon', 'kithul', 'tea', 'dry_fish'];
    
    if (is_dir($base_video_dir)) {
        echo "<div style='margin-left: 20px;'>";
        foreach ($categories as $category) {
            $category_dir = $base_video_dir . $category . '/';
            echo "<h4>$category/</h4>";
            
            if (is_dir($category_dir)) {
                foreach ($subcategories as $subcategory) {
                    $sub_dir = $category_dir . $subcategory . '/';
                    echo "<h5 style='margin-left: 20px;'>$subcategory/</h5>";
                    
                    if (is_dir($sub_dir)) {
                        $files = scandir($sub_dir);
                        $has_files = false;
                        echo "<ul style='margin-left: 40px;'>";
                        
                        foreach ($files as $file) {
                            if ($file != '.' && $file != '..' && !is_dir($sub_dir . $file)) {
                                $file_path = $sub_dir . $file;
                                $file_size = file_exists($file_path) ? filesize($file_path) : 0;
                                echo "<li>$file (" . number_format($file_size) . " bytes)</li>";
                                $has_files = true;
                            }
                        }
                        
                        if (!$has_files) {
                            echo "<li><em>No videos found</em></li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p style='margin-left: 40px; color: red;'>Directory not found!</p>";
                    }
                }
            } else {
                echo "<p style='margin-left: 20px; color: red;'>Category directory not found!</p>";
            }
        }
        echo "</div>";
    } else {
        echo "<p>Base video directory not found!</p>";
    }
    ?>
    
    <h3>Test 3: Database Products with Videos</h3>
    <?php
    include '../db/DBcon.php';
    
    $sql = "SELECT name, video_url FROM products WHERE video_url IS NOT NULL AND video_url != '' LIMIT 10";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            $video_url = $row['video_url'];
            $display_path = $video_url;
            
            // Test different types of video URLs
            if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                $status = "🎥 YouTube Video";
            } elseif (strpos($video_url, 'vimeo.com') !== false) {
                $status = "🎥 Vimeo Video";
            } elseif (strpos($video_url, 'assets/videos/') !== false) {
                // Local video - check if file exists
                $full_path = '../' . $video_url;
                $exists = file_exists($full_path);
                $status = $exists ? "✅ Local Video Found" : "❌ Local Video Missing";
                if ($exists) {
                    $file_size = filesize($full_path);
                    $status .= " (" . number_format($file_size) . " bytes)";
                }
            } else {
                $status = "🔗 External URL";
            }
            
            echo "<li><strong>{$row['name']}</strong><br>";
            echo "<small>Path: $display_path</small><br>";
            echo "<span>$status</span></li><br>";
        }
        echo "</ul>";
    } else {
        echo "<p>No products with videos found in database.</p>";
    }
    ?>
    
    <h3>Test 4: Video Player Test</h3>
    <p>Testing video playback with the categorized video:</p>
    <?php
    $test_video = "../assets/videos/products/utilized/cinnamon/Cylon Spices.mp4";
    if (file_exists($test_video)) {
        echo "<video controls width='500' style='border: 1px solid #ccc;'>";
        echo "<source src='$test_video' type='video/mp4'>";
        echo "Your browser does not support the video tag.";
        echo "</video>";
        echo "<p><small>✅ Video file found and player loaded</small></p>";
    } else {
        echo "<p>❌ Test video not found at: $test_video</p>";
    }
    ?>
</body>
</html>
