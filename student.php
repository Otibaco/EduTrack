<?php

$students = [
    [
        "id" => "EDU001",
        "first_name" => "Amaka",
        "last_name" => "Michael",
        "email" => "amaka@example.com",
        "phone" => "08012345678",
        "department" => "Computer Science",
        "level" => "200",
        "gender" => "Female"
    ],
    [
        "id" => "EDU002",
        "first_name" => "David",
        "last_name" => "Okafor",
        "email" => "david@example.com",
        "phone" => "08123456789",
        "department" => "Software Engineering",
        "level" => "300",
        "gender" => "Male"
    ],
    [
        "id" => "EDU003",
        "first_name" => "Chisom",
        "last_name" => "Nwosu",
        "email" => "chisom@example.com",
        "phone" => "09012345678",
        "department" => "Information Technology",
        "level" => "100",
        "gender" => "Female"
    ],
    [
        "id" => "EDU004",
        "first_name" => "Emeka",
        "last_name" => "Adeyemi",
        "email" => "emeka@example.com",
        "phone" => "07012345678",
        "department" => "Cybersecurity",
        "level" => "400",
        "gender" => "Male"
    ]
];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Students — EduTrack</title>

    <link rel="stylesheet" href="assets/style/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

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

            <a href="add-student.php" class="btn btn-primary">
                Add Student
                <span>+</span>
            </a>

        </div>

    </div>

</header>


<main>

<section class="section">

    <div class="container">


        <!-- PAGE HEADING -->

        <div class="section-heading">

            <div>

                <span class="section-label">
                    STUDENT RECORDS
                </span>

                <h1>
                    Manage your
                    <span>students.</span>
                </h1>

            </div>

            <p>
                View and manage student records
                from one organized dashboard.
            </p>

        </div>


        <!-- STUDENT TOOLBAR -->

        <div class="student-toolbar">

            <div class="student-count">

                <strong>
                    <?php echo count($students); ?>
                </strong>

                <span>
                    Students
                </span>

            </div>


            <div class="student-search">

                <input
                    type="text"
                    id="studentSearch"
                    placeholder="Search students..."
                    onkeyup="searchStudents()"
                >

            </div>


            <a
                href="add-student.php"
                class="btn btn-primary"
            >
                Add Student
                <span>+</span>
            </a>

        </div>


        <!-- STUDENT TABLE -->

        <div class="student-table-card">

            <div class="student-table-wrapper">

                <table class="student-table">

                    <thead>

                        <tr>

                            <th>Student ID</th>

                            <th>Student</th>

                            <th>Department</th>

                            <th>Level</th>

                            <th>Gender</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody id="studentTableBody">

                        <?php foreach ($students as $student): ?>

                            <tr>

                                <td>

                                    <span class="student-id">
                                        <?php echo $student["id"]; ?>
                                    </span>

                                </td>


                                <td>

                                    <div class="student-name">

                                        <span class="student-avatar">
                                            <?php
                                                echo strtoupper(
                                                    substr(
                                                        $student["first_name"],
                                                        0,
                                                        1
                                                    ) .
                                                    substr(
                                                        $student["last_name"],
                                                        0,
                                                        1
                                                    )
                                                );
                                            ?>
                                        </span>


                                        <div>

                                            <strong>
                                                <?php
                                                    echo $student["first_name"]
                                                        . " "
                                                        . $student["last_name"];
                                                ?>
                                            </strong>

                                            <small>
                                                <?php echo $student["email"]; ?>
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                <td>
                                    <?php echo $student["department"]; ?>
                                </td>


                                <td>
                                    <?php echo $student["level"]; ?> Level
                                </td>


                                <td>
                                    <?php echo $student["gender"]; ?>
                                </td>


                                <td>

                                    <div class="student-actions">

                                        <a
                                            href="view-student.php?id=<?php echo $student["id"]; ?>"
                                            class="table-action"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="edit-student.php?id=<?php echo $student["id"]; ?>"
                                            class="table-action"
                                        >
                                            Edit
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

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


<script>

function searchStudents() {

    const input =
        document.getElementById("studentSearch");

    const filter =
        input.value.toLowerCase();

    const rows =
        document.querySelectorAll(
            "#studentTableBody tr"
        );

    rows.forEach(function(row) {

        const text =
            row.textContent.toLowerCase();

        if (text.includes(filter)) {

            row.style.display = "";

        } else {

            row.style.display = "none";

        }

    });

}

</script>

</body>

</html>