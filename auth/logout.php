<?php
// ==========================================
// Logout Script (auth/logout.php)
// ==========================================
require_once '../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset all session variables
$_SESSION = array();

// Destroy session
session_destroy();

// Redirect to home page
redirect('../index.php');
?>
