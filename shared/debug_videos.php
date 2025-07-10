<?php
// Simple test script to check products with videos
include '../db/DBcon.php';

echo "<h2>Products with Videos Debug</h2>";

$sql = "SELECT p.product_id, p.name, p.video_url, s.seller_name 
        FROM products p 
        LEFT JOIN sellers s ON p.seller_id = s.seller_id 
        WHERE p.video_url IS NOT NULL AND p.video_url != ''";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Product ID</th><th>Name</th><th>Video URL</th><th>Seller</th><th>File Exists?</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        $video_path = '../' . $row['video_url'];
        $file_exists = file_exists($video_path) ? "✅ Yes" : "❌ No";
        
        echo "<tr>";
        echo "<td>" . $row['product_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['video_url']) . "</td>";
        echo "<td>" . htmlspecialchars($row['seller_name']) . "</td>";
        echo "<td>$file_exists</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No products with videos found in database.</p>";
    echo "<p>You need to add products with videos through the admin panel first.</p>";
}

$conn->close();
?>
