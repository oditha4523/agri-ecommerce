<?php
// PHP Upload Settings Test
echo "<h2>PHP Upload Settings Test</h2>";

echo "<h3>Current PHP Settings:</h3>";
echo "<ul>";
echo "<li><strong>upload_max_filesize:</strong> " . ini_get('upload_max_filesize') . "</li>";
echo "<li><strong>post_max_size:</strong> " . ini_get('post_max_size') . "</li>";
echo "<li><strong>max_execution_time:</strong> " . ini_get('max_execution_time') . " seconds</li>";
echo "<li><strong>memory_limit:</strong> " . ini_get('memory_limit') . "</li>";
echo "<li><strong>file_uploads:</strong> " . (ini_get('file_uploads') ? 'Enabled' : 'Disabled') . "</li>";
echo "<li><strong>upload_tmp_dir:</strong> " . (ini_get('upload_tmp_dir') ?: 'Default') . "</li>";
echo "</ul>";

echo "<h3>Videos Directory Status:</h3>";
$video_dir = '../assets/videos/';
echo "<ul>";
echo "<li><strong>Directory exists:</strong> " . (is_dir($video_dir) ? 'Yes' : 'No') . "</li>";
echo "<li><strong>Directory writable:</strong> " . (is_writable($video_dir) ? 'Yes' : 'No') . "</li>";
echo "<li><strong>Directory path:</strong> " . realpath($video_dir) . "</li>";
echo "</ul>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>Upload Test Results:</h3>";
    
    if (isset($_FILES['test_video'])) {
        echo "<h4>File Upload Details:</h4>";
        echo "<pre>";
        print_r($_FILES['test_video']);
        echo "</pre>";
        
        $error_messages = [
            UPLOAD_ERR_OK => 'No error',
            UPLOAD_ERR_INI_SIZE => 'File too large (php.ini limit)',
            UPLOAD_ERR_FORM_SIZE => 'File too large (form limit)',
            UPLOAD_ERR_PARTIAL => 'File partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'No temporary directory',
            UPLOAD_ERR_CANT_WRITE => 'Cannot write to disk',
            UPLOAD_ERR_EXTENSION => 'PHP extension stopped upload'
        ];
        
        $error_code = $_FILES['test_video']['error'];
        echo "<p><strong>Upload Status:</strong> " . $error_messages[$error_code] . " (Code: $error_code)</p>";
        
        if ($error_code === UPLOAD_ERR_OK) {
            echo "<p style='color: green;'>✅ File upload successful!</p>";
        } else {
            echo "<p style='color: red;'>❌ File upload failed!</p>";
        }
    }
}
?>

<h3>Test File Upload:</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="test_video" accept="video/*" required>
    <button type="submit">Test Upload</button>
</form>

<p><a href="add_product.php">← Back to Add Product</a></p>
