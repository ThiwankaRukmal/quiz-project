<?php
// ==========================================
// Helper Functions
// ==========================================

// Clean and sanitize user input data
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Redirect user to another page
function redirect($url) {
    header("Location: " . $url);
    exit();
}
?>
