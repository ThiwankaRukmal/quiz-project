<?php
// ==========================================
// Home Page (index.php)
// ==========================================
require_once 'includes/db.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Master - Test Your Knowledge</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <span class="me-2">🎓</span> Quiz Master
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Quiz Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
          <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
        </ul>
        <div class="d-flex align-items-center">
          <?php if (is_logged_in()): ?>
            <span class="text-white-50 me-3 small">Hi, <strong class="text-white"><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
            <a href="dashboard.php" class="btn btn-warning btn-sm me-2 fw-semibold">Play Quiz</a>
            <a href="auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
          <?php else: ?>
            <a href="auth/login.php" class="btn btn-outline-light btn-sm me-2">Login</a>
            <a href="auth/register.php" class="btn btn-light btn-sm fw-semibold">Register</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Container -->
  <main class="container py-4">

    <!-- Interactive Image Slider (Bootstrap Carousel) -->
    <div id="quizCarousel" class="carousel slide shadow rounded-4 overflow-hidden mb-5" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#quizCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#quizCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="4000">
          <img src="images/banner1.jpg" class="d-block w-100" alt="Students taking online quiz">
          <div class="carousel-caption d-none d-md-block text-start">
            <h3 class="fw-bold text-white">Interactive Web Learning</h3>
            <p class="mb-0 text-white-50">Master Web Technologies through fun, dynamic multiple-choice quizzes.</p>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="4000">
          <img src="images/banner2.jpg" class="d-block w-100" alt="Students celebrating high score">
          <div class="carousel-caption d-none d-md-block text-start">
            <h3 class="fw-bold text-white">Track Your High Scores</h3>
            <p class="mb-0 text-white-50">Instant grading, score history tracking, and performance feedback.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#quizCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-label="Previous"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#quizCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-label="Next"></span>
      </button>
    </div>

    <!-- Hero Callout -->
    <div class="p-5 mb-5 bg-white rounded-4 shadow-sm border text-center">
      <h1 class="display-6 fw-bold text-primary mb-3">Welcome to Quiz Master</h1>
      <p class="lead text-muted col-lg-8 mx-auto mb-4">
        A simple and beginner-friendly quiz platform designed for students. Test your fundamental knowledge in HTML, CSS, JavaScript, and PHP with instant results!
      </p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <?php if (is_logged_in()): ?>
          <a href="dashboard.php" class="btn btn-primary btn-lg px-4 gap-3 fw-semibold">Start Quiz Now &rarr;</a>
        <?php else: ?>
          <a href="auth/login.php" class="btn btn-primary btn-lg px-4 gap-3 fw-semibold">Login to Start Quiz</a>
          <a href="auth/register.php" class="btn btn-outline-secondary btn-lg px-4">Create Account</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="mb-5">
      <div class="text-center mb-4">
        <h2 class="fw-bold text-dark">Why Choose Quiz Master?</h2>
        <p class="text-muted">Built with core web technologies for a smooth student learning experience.</p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100 card-hover p-4 text-center bg-white">
            <div class="fs-1 mb-3">🧠</div>
            <h5 class="fw-bold">Dynamic Questions</h5>
            <p class="text-muted small">Questions loaded straight from MySQL database with clean interactive selection options.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100 card-hover p-4 text-center bg-white">
            <div class="fs-1 mb-3">⚡</div>
            <h5 class="fw-bold">Instant Evaluation</h5>
            <p class="text-muted small">Scores are calculated automatically with personalized feedback on your overall performance.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100 card-hover p-4 text-center bg-white">
            <div class="fs-1 mb-3">📈</div>
            <h5 class="fw-bold">Score Tracking</h5>
            <p class="text-muted small">Attempts are saved in your personal dashboard so you can monitor your learning progress over time.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- How it works -->
    <div class="p-4 bg-light rounded-4 border mb-5">
      <h4 class="fw-bold text-center mb-4">How to Use the App</h4>
      <div class="row text-center g-3">
        <div class="col-md-4">
          <div class="fw-bold text-primary fs-5 mb-1">Step 1</div>
          <p class="small text-muted mb-0">Register with your name, email, and password or use the demo account.</p>
        </div>
        <div class="col-md-4">
          <div class="fw-bold text-primary fs-5 mb-1">Step 2</div>
          <p class="small text-muted mb-0">Head to the Quiz Dashboard, answer the questions, and watch the live progress bar.</p>
        </div>
        <div class="col-md-4">
          <div class="fw-bold text-primary fs-5 mb-1">Step 3</div>
          <p class="small text-muted mb-0">Submit to see your score, feedback, and review all previous attempts in your history.</p>
        </div>
      </div>
    </div>

  </main>

  <!-- Footer -->
  <footer class="bg-white border-top py-3 text-center text-muted small mt-auto">
    <div class="container">
      &copy; <?php echo date('Y'); ?> Quiz Master - ICT 2209 Web Technologies Mini Project | Rajarata University of Sri Lanka
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script src="js/script.js"></script>
</body>
</html>
