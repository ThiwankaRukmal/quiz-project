<?php
// ==========================================
// User Login (auth/login.php)
// ==========================================
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect('../dashboard.php');
}

$error = "";
$success = "";

// Show message if just registered
if (isset($_GET['registered'])) {
    $success = "Registration successful! You can now log in.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = clean_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // Query user from database
        $sql = "SELECT id, username, email, password FROM users WHERE email = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            // Verify hashed password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['email']     = $user['email'];

                // Redirect to dashboard
                redirect('../dashboard.php');
            } else {
                $error = "Incorrect password. Please try again.";
            }
        } else {
            $error = "No account found with this email.";
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
  <title>Login - Quiz Master</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light">

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="../index.php">🎓 Quiz Master</a>
      <div class="ms-auto">
        <a href="../index.php" class="btn btn-outline-light btn-sm me-2">Home</a>
        <a href="register.php" class="btn btn-light btn-sm">Register</a>
      </div>
    </div>
  </nav>

  <!-- Login Container -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body p-4 p-md-5">
            <h3 class="card-title text-center fw-bold mb-3 text-primary">Welcome Back</h3>
            <p class="text-center text-muted mb-4 small">Log in to attempt the quiz and view your scores</p>

            <!-- Success message -->
            <?php if (!empty($success)): ?>
              <div class="alert alert-success py-2 small" role="alert"><?php echo $success; ?></div>
            <?php endif; ?>

            <!-- Client-side Error Message -->
            <div id="js-error-msg" class="alert alert-danger d-none py-2 small" role="alert"></div>

            <!-- Server-side Error Alert -->
            <?php if (!empty($error)): ?>
              <div class="alert alert-danger py-2 small" role="alert"><?php echo $error; ?></div>
            <?php endif; ?>

            <form id="loginForm" action="login.php" method="POST" novalidate>
              <div class="mb-3">
                <label for="email" class="form-label fw-semibold small">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="student@example.com" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label fw-semibold small">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
              </div>

              <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3 mt-2">Log In</button>
            </form>

            <div class="alert alert-info py-2 small mt-3 mb-0 text-center">
              💡 <strong>Demo Account:</strong><br>
              student@example.com | 123456
            </div>

            <div class="text-center mt-4">
              <span class="small text-muted">Don't have an account? </span>
              <a href="register.php" class="small fw-semibold text-decoration-none">Sign up</a>
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
