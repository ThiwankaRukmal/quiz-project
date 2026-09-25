<?php
// ==========================================
// Contact Us Page (contact.php)
// ==========================================
require_once 'includes/db.php';
require_once 'includes/functions.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = clean_input($_POST['name'] ?? '');
    $email   = clean_input($_POST['email'] ?? '');
    $message = clean_input($_POST['message'] ?? '');

    // Server-side validation
    if (empty($name) || empty($email) || empty($message)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (strlen($message) < 10) {
        $error = "Message must be at least 10 characters long.";
    } else {
        // Insert message into database
        $sql = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

        if (mysqli_stmt_execute($stmt)) {
            $success = "Thank you, " . htmlspecialchars($name) . "! Your message has been received.";
            // Clear input fields
            $name = $email = $message = "";
        } else {
            $error = "Failed to send message. Please try again.";
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
  <title>Contact Us - Quiz Master</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="index.php">🎓 Quiz Master</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Quiz Dashboard</a></li>
          <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
        </ul>
        <div class="d-flex align-items-center">
          <?php if (is_logged_in()): ?>
            <span class="text-white-50 me-3 small">Logged in as: <strong class="text-white"><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
            <a href="auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
          <?php else: ?>
            <a href="auth/login.php" class="btn btn-outline-light btn-sm me-2">Login</a>
            <a href="auth/register.php" class="btn btn-light btn-sm">Register</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-md-9">

        <div class="text-center mb-4">
          <h2 class="fw-bold text-primary">Get In Touch</h2>
          <p class="text-muted">Have a question or feedback regarding the quiz? Send us a message!</p>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body p-4 p-md-5">

            <!-- JS Error Container -->
            <div id="js-error-msg" class="alert alert-danger d-none py-2 small" role="alert"></div>

            <!-- Server Notifications -->
            <?php if (!empty($success)): ?>
              <div class="alert alert-success py-2 small" role="alert"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger py-2 small" role="alert"><?php echo $error; ?></div>
            <?php endif; ?>

            <form id="contactForm" action="contact.php" method="POST" novalidate>
              <div class="mb-3">
                <label for="name" class="form-label fw-semibold small">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label fw-semibold small">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
              </div>

              <div class="mb-3">
                <label for="message" class="form-label fw-semibold small">Your Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Write your message here (min. 10 characters)..." required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
              </div>

              <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3">Send Message</button>
            </form>

          </div>
        </div>

        <!-- Extra Info Cards -->
        <div class="row mt-4 text-center g-3">
          <div class="col-md-4">
            <div class="p-3 bg-white rounded-3 shadow-sm border">
              <div class="fs-4">📍</div>
              <div class="fw-semibold small mt-1">Location</div>
              <div class="text-muted small">RUSL, Sri Lanka</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3 bg-white rounded-3 shadow-sm border">
              <div class="fs-4">✉️</div>
              <div class="fw-semibold small mt-1">Support Email</div>
              <div class="text-muted small">quiz@example.com</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3 bg-white rounded-3 shadow-sm border">
              <div class="fs-4">⚡</div>
              <div class="fw-semibold small mt-1">Course</div>
              <div class="text-muted small">ICT 2209 Web Tech</div>
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
  <script src="js/script.js"></script>
</body>
</html>
