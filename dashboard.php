<?php
// ==========================================
// User Dashboard & Quiz (dashboard.php)
// ==========================================
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Protect page: user must be logged in
if (!is_logged_in()) {
    redirect('auth/login.php');
}

$user_id  = $_SESSION['user_id'];
$username = $_SESSION['username'];

$submitted = false;
$score = 0;
$total_questions = 0;
$percentage = 0;
$feedback = "";
$user_answers = [];

// Fetch questions from MySQL database
$questions_query = "SELECT * FROM questions ORDER BY id ASC";
$questions_result = mysqli_query($conn, $questions_query);
$questions = [];
while ($row = mysqli_fetch_assoc($questions_result)) {
    $questions[] = $row;
}
$total_questions = count($questions);

// Process quiz submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_quiz'])) {
    $submitted = true;

    foreach ($questions as $q) {
        $qid = $q['id'];
        $selected = isset($_POST['q_' . $qid]) ? clean_input($_POST['q_' . $qid]) : '';
        $user_answers[$qid] = $selected;

        if ($selected === $q['correct_option']) {
            $score++;
        }
    }

    $percentage = ($total_questions > 0) ? round(($score / $total_questions) * 100) : 0;

    // Performance Feedback
    if ($percentage === 100) {
        $feedback = "🌟 Outstanding! Perfect score!";
    } elseif ($percentage >= 80) {
        $feedback = "🎉 Great job! Excellent understanding!";
    } elseif ($percentage >= 50) {
        $feedback = "👍 Good effort! Review your answers and try again.";
    } else {
        $feedback = "📚 Keep practicing! Don't give up, try again to improve your score.";
    }

    // Save score to database
    $save_sql = "INSERT INTO scores (user_id, score, total_questions) VALUES (?, ?, ?)";
    $save_stmt = mysqli_prepare($conn, $save_sql);
    mysqli_stmt_bind_param($save_stmt, "iii", $user_id, $score, $total_questions);
    mysqli_stmt_execute($save_stmt);
    mysqli_stmt_close($save_stmt);
}

// Fetch user's score history
$history_sql = "SELECT score, total_questions, created_at FROM scores WHERE user_id = ? ORDER BY id DESC";
$history_stmt = mysqli_prepare($conn, $history_sql);
mysqli_stmt_bind_param($history_stmt, "i", $user_id);
mysqli_stmt_execute($history_stmt);
$history_result = mysqli_stmt_get_result($history_stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Dashboard - Quiz Master</title>
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
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="dashboard.php">Quiz Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
        </ul>
        <div class="d-flex align-items-center">
          <span class="text-white-50 me-3 small">Logged in as: <strong class="text-white"><?php echo htmlspecialchars($username); ?></strong></span>
          <a href="auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <main class="container py-4">

    <!-- Welcome Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
      <div>
        <h2 class="fw-bold text-primary mb-1">Student Dashboard</h2>
        <p class="text-muted small mb-0">Welcome back, <strong><?php echo htmlspecialchars($username); ?></strong>! Ready for today's quiz challenge?</p>
      </div>
      <div class="mt-2 mt-md-0">
        <button id="toggleHistoryBtn" class="btn btn-outline-primary btn-sm">View Score History</button>
      </div>
    </div>

    <!-- Toggleable Score History Section (Dynamic JS toggle) -->
    <div id="historySection" class="card shadow-sm border-0 rounded-4 mb-4" style="display: none;">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">📊 Your Past Attempts</h5>
        <?php if (mysqli_num_rows($history_result) > 0): ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Score</th>
                  <th>Percentage</th>
                  <th>Date & Time</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $count = 1;
                while ($h = mysqli_fetch_assoc($history_result)): 
                  $pct = round(($h['score'] / $h['total_questions']) * 100);
                ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><span class="fw-bold"><?php echo $h['score']; ?></span> / <?php echo $h['total_questions']; ?></td>
                    <td>
                      <span class="badge <?php echo $pct >= 80 ? 'bg-success' : ($pct >= 50 ? 'bg-primary' : 'bg-danger'); ?>">
                        <?php echo $pct; ?>%
                      </span>
                    </td>
                    <td class="text-muted small"><?php echo date('M d, Y - h:i A', strtotime($h['created_at'])); ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="text-muted mb-0 small">No previous attempts found. Complete your first quiz below!</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Quiz Result Announcement (if submitted) -->
    <?php if ($submitted): ?>
      <div class="card shadow-sm border-0 rounded-4 mb-4 bg-white fade-in">
        <div class="card-body p-4 text-center">
          <div class="display-5 mb-2"><?php echo $percentage >= 80 ? '🏆' : ($percentage >= 50 ? '🎉' : '📖'); ?></div>
          <h3 class="fw-bold text-dark mb-1">You Scored <?php echo $score; ?> out of <?php echo $total_questions; ?> (<?php echo $percentage; ?>%)</h3>
          <p class="lead text-primary fw-semibold mb-3"><?php echo $feedback; ?></p>
          <a href="dashboard.php" class="btn btn-primary px-4 fw-semibold">Try Quiz Again</a>
        </div>
      </div>
    <?php endif; ?>

    <!-- Interactive Quiz Card -->
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-header bg-white py-3 border-bottom">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="fw-bold mb-0 text-primary">Web Technologies Knowledge Quiz</h5>
          <span id="answeredCount" class="badge bg-secondary badge-custom">0 of <?php echo $total_questions; ?> answered</span>
        </div>
        <!-- Dynamic JS Progress Bar -->
        <div class="progress mt-3" style="height: 8px;">
          <div id="quizProgressBar" class="progress-bar bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>

      <div class="card-body p-4">
        <form id="quizForm" action="dashboard.php" method="POST">
          
          <?php foreach ($questions as $index => $q): 
            $qid = $q['id'];
            $selected_val = $user_answers[$qid] ?? '';
          ?>
            <div class="question-block mb-4 p-3 rounded-3 bg-light border">
              <p class="fw-bold mb-3 fs-6">
                <span class="badge bg-primary me-2">Q<?php echo ($index + 1); ?></span>
                <?php echo htmlspecialchars($q['question']); ?>
              </p>

              <div class="row g-2">
                <!-- Option A -->
                <div class="col-md-6">
                  <input type="radio" class="option-radio" name="q_<?php echo $qid; ?>" id="q<?php echo $qid; ?>_a" value="A" <?php echo ($selected_val === 'A') ? 'checked' : ''; ?> <?php echo $submitted ? 'disabled' : ''; ?>>
                  <label class="option-label" for="q<?php echo $qid; ?>_a">
                    <strong>A.</strong> <?php echo htmlspecialchars($q['option_a']); ?>
                  </label>
                </div>

                <!-- Option B -->
                <div class="col-md-6">
                  <input type="radio" class="option-radio" name="q_<?php echo $qid; ?>" id="q<?php echo $qid; ?>_b" value="B" <?php echo ($selected_val === 'B') ? 'checked' : ''; ?> <?php echo $submitted ? 'disabled' : ''; ?>>
                  <label class="option-label" for="q<?php echo $qid; ?>_b">
                    <strong>B.</strong> <?php echo htmlspecialchars($q['option_b']); ?>
                  </label>
                </div>

                <!-- Option C -->
                <div class="col-md-6">
                  <input type="radio" class="option-radio" name="q_<?php echo $qid; ?>" id="q<?php echo $qid; ?>_c" value="C" <?php echo ($selected_val === 'C') ? 'checked' : ''; ?> <?php echo $submitted ? 'disabled' : ''; ?>>
                  <label class="option-label" for="q<?php echo $qid; ?>_c">
                    <strong>C.</strong> <?php echo htmlspecialchars($q['option_c']); ?>
                  </label>
                </div>

                <!-- Option D -->
                <div class="col-md-6">
                  <input type="radio" class="option-radio" name="q_<?php echo $qid; ?>" id="q<?php echo $qid; ?>_d" value="D" <?php echo ($selected_val === 'D') ? 'checked' : ''; ?> <?php echo $submitted ? 'disabled' : ''; ?>>
                  <label class="option-label" for="q<?php echo $qid; ?>_d">
                    <strong>D.</strong> <?php echo htmlspecialchars($q['option_d']); ?>
                  </label>
                </div>
              </div>

              <!-- Answer Feedback after submission -->
              <?php if ($submitted): ?>
                <div class="mt-3 p-2 rounded small <?php echo ($selected_val === $q['correct_option']) ? 'bg-success-subtle text-success fw-semibold' : 'bg-danger-subtle text-danger'; ?>">
                  <?php if ($selected_val === $q['correct_option']): ?>
                    ✅ Correct! (Option <?php echo $q['correct_option']; ?>)
                  <?php else: ?>
                    ❌ Incorrect. Correct Answer is Option <strong><?php echo $q['correct_option']; ?></strong>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

            </div>
          <?php endforeach; ?>

          <?php if (!$submitted): ?>
            <div class="text-end">
              <button type="submit" name="submit_quiz" class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm">
                Submit Quiz &rarr;
              </button>
            </div>
          <?php endif; ?>

        </form>
      </div>
    </div>

  </main>

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
