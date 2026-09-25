# Quiz Master - Interactive Quiz Web Application

**Course:** ICT 2209 – Web Technologies  
**Assignment:** Mini Project – Individual Submission  
**Institution:** Faculty of Technology, Rajarata University of Sri Lanka  

---

## 📌 Project Overview
**Quiz Master** is an interactive, beginner-friendly web application developed using **HTML, CSS, Bootstrap 5, JavaScript, PHP, and MySQL**. The platform allows students to create an account, take timed or untimed multiple-choice quizzes, receive real-time feedback and scores, and track their past performance history.

---

## 🚀 Key Features

### 1. Frontend & Design
- **Responsive Layout:** Built with Bootstrap 5 and custom CSS for mobile, tablet, and desktop screens.
- **Interactive Image Slider:** Manual and automatic carousel controls displaying quiz highlights on the homepage.
- **Dynamic Content Updates:** Live progress bar as students answer questions, question counter, and instant score evaluation.
- **Form Validation:** Client-side JavaScript validation for registration, login, and contact forms.
- **Smooth Scrolling & Event Handling:** Polished hover animations, confirmation alerts, and toggleable score history.

### 2. Backend & Database (PHP & MySQL)
- **User Authentication:** 
  - Registration with secure password hashing (`password_hash`).
  - Session-based Login and Logout functionality with credential verification (`password_verify`).
- **Quiz Management & Scoring:**
  - Dynamic loading of quiz questions from MySQL database.
  - Automatic answer checking, score calculation, and performance feedback.
  - User score history tracking saved to the database.
- **Contact Inquiries:**
  - Contact form storing student inquiries in a MySQL database table.

---

## 📂 Folder Structure

```text
Quiz_Project/
│── css/
│   └── style.css            # Custom styling & animations
│── js/
│   └── script.js            # JavaScript validations & interactivity
│── images/
│   ├── banner1.jpg          # Homepage slider banner 1
│   └── banner2.jpg          # Homepage slider banner 2
│── includes/
│   ├── db.php               # MySQL database connection file
│   └── functions.php        # Sanitization & session helper functions
│── auth/
│   ├── register.php         # User registration form & logic
│   ├── login.php            # User login form & logic
│   └── logout.php           # User logout script
│── contact.php              # Contact form & message submission
│── index.php                # Main landing page with slider & features
│── dashboard.php            # Quiz taking & score history dashboard
│── README.md                # Project documentation & setup guide
│── database.sql             # Exported MySQL database dump file
```

---

## 🛠️ Step-by-Step Setup Guide (XAMPP)

Follow these easy steps to run the project locally on your machine using XAMPP:

### Step 1: Copy Project to XAMPP htdocs
1. Copy or move the `Quiz_Project` folder into your XAMPP web directory:
   - Default Windows Path: `C:\xampp\htdocs\Quiz_Project`

### Step 2: Start XAMPP Services
1. Open the **XAMPP Control Panel**.
2. Click **Start** for both **Apache** and **MySQL**.
3. Ensure both modules turn green.

### Step 3: Import the Database
1. Open your web browser and go to:  
   👉 `http://localhost/phpmyadmin`
2. Click on **New** in the left sidebar to create a database.
3. Database name: **`quiz_db`** (Collation: `utf8mb4_general_ci`) and click **Create**.
4. Click on the **Import** tab at the top.
5. Click **Choose File** and select the `database.sql` file located inside the `Quiz_Project` folder.
6. Scroll down and click **Import** (or **Go**).
7. You should see a success message and four tables created:
   - `users`
   - `questions`
   - `scores`
   - `messages`

### Step 4: Run the Application
1. Open your browser and navigate to:  
   👉 `http://localhost/Quiz_Project/`
2. You can test the app immediately using the pre-configured demo account:
   - **Email:** `student@example.com`
   - **Password:** `123456`
3. Or click **Register** to create your own account!

---

## 🗄️ Database Tables Overview

| Table | Description |
| :--- | :--- |
| `users` | Stores student user credentials with hashed passwords and registration timestamp. |
| `questions` | Stores quiz questions, multiple-choice options (A, B, C, D), and correct answers. |
| `scores` | Records each user's quiz attempt, score, total questions, and date. |
| `messages` | Stores submissions received from the contact us form. |

---
