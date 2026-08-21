
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Student — EduTrack</title>

    <link rel="stylesheet" href="assets/style/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">

</head>

<body>

    <header class="navbar">

        <div class="container nav-inner">

            <a href="index.php" class="logo">

                <span class="logo-icon">E</span>

                <span class="logo-text">
                    Edu<span>Track</span>
                </span>

            </a>

            <nav class="nav-links">

                <a href="index.php">Home</a>

                <a href="students.php">Students</a>

                <a href="Pages/about-us.php">About</a>

            </nav>

            <div class="nav-actions">

                <a href="Pages/login.php" class="login-link">
                    Sign in
                </a>

            </div>

        </div>

    </header>


    <main>

        <section class="section">

            <div class="container">

                <div class="section-heading">

                    <div>

                        <span class="section-label">
                            STUDENT MANAGEMENT
                        </span>

                        <h1>
                            Add a new
                            <span>student.</span>
                        </h1>

                    </div>

                    <p>
                        Enter the student's information below
                        to add a new student record to EduTrack.
                    </p>

                </div>


                <?php if ($message != ""): ?>

                    <div class="student-success">
                        <?php echo $message; ?>
                    </div>

                <?php endif; ?>


                <div class="student-form-card">

                    <form method="POST" action="">

                        <div class="form-grid">

                            <div class="form-group">

                                <label for="student_id">
                                    Student ID
                                </label>

                                <input
                                    type="text"
                                    id="student_id"
                                    name="student_id"
                                    placeholder="e.g. EDU001"
                                    required>

                            </div>


                            <div class="form-group">

                                <label for="first_name">
                                    First Name
                                </label>

                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    placeholder="Enter first name"
                                    required>

                            </div>


                            <div class="form-group">

                                <label for="last_name">
                                    Last Name
                                </label>

                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    placeholder="Enter last name"
                                    required>

                            </div>


                            <div class="form-group">

                                <label for="email">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="student@example.com"
                                    required>

                            </div>


                            <div class="form-group">

                                <label for="phone">
                                    Phone Number
                                </label>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    placeholder="08012345678"
                                    required>

                            </div>


                            <div class="form-group">

                                <label for="department">
                                    Department
                                </label>

                                <select
                                    id="department"
                                    name="department"
                                    required>

                                    <option value="">
                                        Select department
                                    </option>

                                    <option value="Computer Science">
                                        Computer Science
                                    </option>

                                    <option value="Software Engineering">
                                        Software Engineering
                                    </option>

                                    <option value="Information Technology">
                                        Information Technology
                                    </option>

                                    <option value="Cybersecurity">
                                        Cybersecurity
                                    </option>

                                    <option value="Other">
                                        Other
                                    </option>

                                </select>

                            </div>


                            <div class="form-group">

                                <label for="level">
                                    Level
                                </label>

                                <select
                                    id="level"
                                    name="level"
                                    required>

                                    <option value="">
                                        Select level
                                    </option>

                                    <option value="100">
                                        100 Level
                                    </option>

                                    <option value="200">
                                        200 Level
                                    </option>

                                    <option value="300">
                                        300 Level
                                    </option>

                                    <option value="400">
                                        400 Level
                                    </option>

                                </select>

                            </div>


                            <div class="form-group">

                                <label for="gender">
                                    Gender
                                </label>

                                <select
                                    id="gender"
                                    name="gender"
                                    required>

                                    <option value="">
                                        Select gender
                                    </option>

                                    <option value="Male">
                                        Male
                                    </option>

                                    <option value="Female">
                                        Female
                                    </option>

                                </select>

                            </div>


                            <div class="form-group">

                                <label for="date_of_birth">
                                    Date of Birth
                                </label>

                                <input
                                    type="date"
                                    id="date_of_birth"
                                    name="date_of_birth"
                                    required>

                            </div>

                        </div>


                        <div class="form-actions">

                            <a
                                href="students.php"
                                class="btn btn-secondary">
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary">
                                Add Student
                                <span>→</span>
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </section>

    </main>


    <footer class="footer">

        <div class="container footer-bottom">

            <span>
                © 2026 EduTrack. All rights reserved.
            </span>

            <span>
                Student Management System
            </span>

        </div>

    </footer>
<?php

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = $_POST["student_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $department = $_POST["department"];
    $level = $_POST["level"];
    $gender = $_POST["gender"];
    $date_of_birth = $_POST["date_of_birth"];

    $message = "Student added successfully!";
}

?>

</body>

</html>