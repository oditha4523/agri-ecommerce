<?php
$servername = "localhost"; 
$username = "root"; 
$password = "18602"; 
$database = "agriecom";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
