<?php
// ==========================================
// User Registration (auth/register.php)
// ==========================================
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect('../dashboard.php');
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username         = clean_input($_POST['username'] ?? '');
    $email            = clean_input($_POST['email'] ?? '');
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Backend validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please provide a valid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if email already registered
        $check_sql = "SELECT id FROM users WHERE email = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "This email is already registered. Please log in.";
        } else {
            // Hash password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $insert_sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "sss", $username, $email, $hashed_password);

            if (mysqli_stmt_execute($insert_stmt)) {
                // Redirect to login page with success flag
                redirect('login.php?registered=1');
            } else {
                $error = "Registration failed! Please try again.";
            }
            mysqli_stmt_close($insert_stmt);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Quiz Master</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light">

  <!-- Simple Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="../index.php">🎓 Quiz Master</a>
      <div class="ms-auto">
        <a href="../index.php" class="btn btn-outline-light btn-sm me-2">Home</a>
        <a href="login.php" class="btn btn-light btn-sm">Login</a>
      </div>
    </div>
  </nav>

  <!-- Register Form Container -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body p-4 p-md-5">
            <h3 class="card-title text-center fw-bold mb-3 text-primary">Create Account</h3>
            <p class="text-center text-muted mb-4 small">Join Quiz Master and start testing your skills!</p>

            <!-- Client-side JS Error Container -->
            <div id="js-error-msg" class="alert alert-danger d-none py-2 small" role="alert"></div>

            <!-- Server-side Error Alert -->
            <?php if (!empty($error)): ?>
              <div class="alert alert-danger py-2 small" role="alert"><?php echo $error; ?></div>
            <?php endif; ?>

            <form id="registerForm" action="register.php" method="POST" novalidate>
              <div class="mb-3">
                <label for="username" class="form-label fw-semibold small">Full Name / Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="e.g. John Doe" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label fw-semibold small">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="e.g. student@example.com" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label fw-semibold small">Password (Min. 6 chars)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Create password" required>
              </div>

              <div class="mb-3">
                <label for="confirm_password" class="form-label fw-semibold small">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Repeat password" required>
              </div>

              <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3 mt-2">Sign Up</button>
            </form>

            <div class="text-center mt-4">
              <span class="small text-muted">Already have an account? </span>
              <a href="login.php" class="small fw-semibold text-decoration-none">Login here</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-white border-top py-3 text-center text-muted small mt-auto">
    <div class="container">
      &copy; <?php echo date('Y'); ?> Quiz Master - ICT 2209 Web Technologies Mini Project
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script src="../js/script.js"></script>
</body>
</html>
