// ========================================================
// JavaScript Features for Quiz Web Application
// ICT 2209 - Web Technologies Mini Project
// Features implemented:
// 1. Dynamic Content Updates (live progress bar, section toggling)
// 2. Form Validation (registration, login, contact form)
// 3. Smooth Scrolling & Event Handling (alerts, button clicks)
// ========================================================

document.addEventListener("DOMContentLoaded", function () {

  // --------------------------------------------------------
  // 1. Form Validation for Registration Form
  // --------------------------------------------------------
  const registerForm = document.getElementById("registerForm");
  if (registerForm) {
    registerForm.addEventListener("submit", function (e) {
      const username = document.getElementById("username").value.trim();
      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("confirm_password").value;
      const errorDiv = document.getElementById("js-error-msg");

      // Simple regex for email format
      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

      if (username === "" || email === "" || password === "") {
        e.preventDefault();
        showError(errorDiv, "All fields are required!");
        return false;
      }

      if (!email.match(emailPattern)) {
        e.preventDefault();
        showError(errorDiv, "Please enter a valid email address!");
        return false;
      }

      if (password.length < 6) {
        e.preventDefault();
        showError(errorDiv, "Password must be at least 6 characters long!");
        return false;
      }

      if (password !== confirmPassword) {
        e.preventDefault();
        showError(errorDiv, "Passwords do not match!");
        return false;
      }
    });
  }

  // --------------------------------------------------------
  // 2. Form Validation for Login Form
  // --------------------------------------------------------
  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value;
      const errorDiv = document.getElementById("js-error-msg");

      if (email === "" || password === "") {
        e.preventDefault();
        showError(errorDiv, "Please enter both email and password!");
        return false;
      }
    });
  }

  // --------------------------------------------------------
  // 3. Form Validation for Contact Form
  // --------------------------------------------------------
  const contactForm = document.getElementById("contactForm");
  if (contactForm) {
    contactForm.addEventListener("submit", function (e) {
      const name = document.getElementById("name").value.trim();
      const email = document.getElementById("email").value.trim();
      const message = document.getElementById("message").value.trim();
      const errorDiv = document.getElementById("js-error-msg");

      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

      if (name === "" || email === "" || message === "") {
        e.preventDefault();
        showError(errorDiv, "Please fill in all the contact fields!");
        return false;
      }

      if (!email.match(emailPattern)) {
        e.preventDefault();
        showError(errorDiv, "Please provide a valid email address!");
        return false;
      }

      if (message.length < 10) {
        e.preventDefault();
        showError(errorDiv, "Message must be at least 10 characters long!");
        return false;
      }
    });
  }

  // --------------------------------------------------------
  // 4. Dynamic Quiz Progress Update & Answer Tracking
  // --------------------------------------------------------
  const quizForm = document.getElementById("quizForm");
  if (quizForm) {
    const radioButtons = quizForm.querySelectorAll("input[type='radio']");
    const totalQuestions = document.querySelectorAll(".question-block").length;
    const progressBar = document.getElementById("quizProgressBar");
    const answeredCountEl = document.getElementById("answeredCount");

    function updateProgress() {
      // Find count of answered unique question groups
      const answered = new Set();
      radioButtons.forEach(radio => {
        if (radio.checked) {
          answered.add(radio.name);
        }
      });

      const count = answered.size;
      const percentage = totalQuestions > 0 ? Math.round((count / totalQuestions) * 100) : 0;

      if (progressBar) {
        progressBar.style.width = percentage + "%";
        progressBar.setAttribute("aria-valuenow", percentage);
      }
      if (answeredCountEl) {
        answeredCountEl.innerText = count + " of " + totalQuestions + " answered (" + percentage + "%)";
      }
    }

    radioButtons.forEach(radio => {
      radio.addEventListener("change", updateProgress);
    });

    // Confirmation on Quiz Submit
    quizForm.addEventListener("submit", function (e) {
      const answered = new Set();
      radioButtons.forEach(radio => {
        if (radio.checked) answered.add(radio.name);
      });

      if (answered.size < totalQuestions) {
        const confirmSubmit = confirm("You have unanswered questions. Do you still want to submit your quiz?");
        if (!confirmSubmit) {
          e.preventDefault();
        }
      }
    });
  }

  // --------------------------------------------------------
  // 5. Dynamic Content Toggle (e.g., Toggle Score History)
  // --------------------------------------------------------
  const toggleHistoryBtn = document.getElementById("toggleHistoryBtn");
  const historySection = document.getElementById("historySection");
  if (toggleHistoryBtn && historySection) {
    toggleHistoryBtn.addEventListener("click", function () {
      if (historySection.style.display === "none" || historySection.style.display === "") {
        historySection.style.display = "block";
        toggleHistoryBtn.innerText = "Hide Score History";
      } else {
        historySection.style.display = "none";
        toggleHistoryBtn.innerText = "View Score History";
      }
    });
  }

  // Helper function to display error message nicely
  function showError(el, msg) {
    if (el) {
      el.innerText = msg;
      el.classList.remove("d-none");
      el.scrollIntoView({ behavior: "smooth", block: "center" });
    } else {
      alert(msg);
    }
  }

  // --------------------------------------------------------
  // 6. Smooth Scrolling for Navigation Anchor Links
  // --------------------------------------------------------
  const scrollLinks = document.querySelectorAll('a[href^="#"]');
  scrollLinks.forEach(anchor => {
    anchor.addEventListener("click", function (e) {
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: "smooth" });
      }
    });
  });

});
