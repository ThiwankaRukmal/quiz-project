<?php
// ==========================================
// Database Connection File
// ==========================================

$host     = "localhost";
$username = "root";
$password = "";
$database = "quiz_db";

// Create MySQL connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error() . "<br>Please make sure MySQL is started in XAMPP and quiz_db is imported.");
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
