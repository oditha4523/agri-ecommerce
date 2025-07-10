<!DOCTYPE html>
<html>
<head>
    <title>Video Test</title>
</head>
<body>
    <h2>Video Access Test</h2>
    
    <h3>Test 1: Direct Video Access</h3>
    <p>This tests if videos in the assets/videos/ directory can be accessed:</p>
    <video controls width="400" style="border: 1px solid #ccc;">
        <source src="../assets/videos/test.mp4" type="video/mp4">
        Video not found or not supported
    </video>
    
    <h3>Test 2: Directory Listing</h3>
    <p>Videos currently in assets/videos/:</p>
    <?php
    $video_dir = '../assets/videos/';
    if (is_dir($video_dir)) {
        $files = scandir($video_dir);
        echo "<ul>";
        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && !is_dir($video_dir . $file)) {
                $file_path = $video_dir . $file;
                $file_size = file_exists($file_path) ? filesize($file_path) : 0;
                echo "<li>$file (" . number_format($file_size) . " bytes)</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>Videos directory not found!</p>";
    }
    ?>
    
    <h3>Test 3: Database Check</h3>
    <?php
    include '../db/DBcon.php';
    
    $sql = "SELECT name, video_url FROM products WHERE video_url IS NOT NULL AND video_url != '' LIMIT 5";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            $full_path = '../' . $row['video_url'];
            $exists = file_exists($full_path) ? "✅" : "❌";
            echo "<li>{$row['name']}: {$row['video_url']} $exists</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No products with videos found.</p>";
    }
    ?>
</body>
</html>
