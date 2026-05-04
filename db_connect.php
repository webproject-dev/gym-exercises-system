<?php
// Database connection file
// Change the username/password if your XAMPP MySQL uses different settings.
$host = "localhost";
$user = "root";
$password = "";
$database = "gym_system";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
