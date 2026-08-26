<?php

session_start();

require_once "config/database.php";

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if email already exists
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id FROM users WHERE email = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($stmt);

    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {

        $error = "An account with this email already exists.";

    } else {

        // Hash password
        $hashed_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        // Insert user
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO users (name, email, password)
             VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $name,
            $email,
            $hashed_password
        );

        if (mysqli_stmt_execute($stmt)) {

            header("Location: login.php?registered=1");
            exit;

        } else {

            $error = "Registration failed. Please try again.";
        }
    }

    mysqli_stmt_close($stmt);
}

require_once "includes/header.php";

?>

<section class="auth-section">

    <div class="auth-card">

        <div class="auth-header">

            <p class="eyebrow">CREATE ACCOUNT</p>

            <h1>Join AuthApp</h1>

            <p>
                Create your account to access your dashboard.
            </p>

        </div>

        <?php if ($error): ?>

            <div class="alert error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="form-group">

                <label>Name</label>

                <input
                    type="text"
                    name="name"
                    placeholder="Enter your name"
                    required
                >

            </div>

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                >

            </div>

            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Create a password"
                    required
                >

            </div>

            <!-- <div class="form-group">

                <label>Confirm Password</label>

                <input
                    type="password"
                    name="confirm_password"
                    placeholder="Confirm your password"
                    required
                >

            </div> -->

            <button class="btn full-width" type="submit">
                Create Account
            </button>

        </form>

        <p class="auth-footer">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </div>

</section>

<?php

require_once "includes/footer.php";

?>