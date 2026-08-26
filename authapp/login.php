<?php

session_start();

require_once "config/database.php";

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
$success = "";

if (isset($_GET["registered"])) {
    $success = "Account created successfully. You can now login.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, name, email, password
         FROM users
         WHERE email = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user["password"])) {

            session_regenerate_id(true);

            $_SESSION["user"] = [
                "id" => $user["id"],
                "name" => $user["name"],
                "email" => $user["email"]
            ];

            header("Location: dashboard.php");
            exit;

        } else {

            $error = "Invalid email or password.";
        }

    } else {

        $error = "Invalid email or password.";
    }

    mysqli_stmt_close($stmt);
}

require_once "includes/header.php";

?>

<section class="auth-section">

    <div class="auth-card">

        <div class="auth-header">

            <p class="eyebrow">WELCOME BACK</p>

            <h1>Login</h1>

            <p>
                Login to access your account.
            </p>

        </div>

        <?php if ($error): ?>

            <div class="alert error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

        <?php if ($success): ?>

            <div class="alert success">
                <?php echo htmlspecialchars($success); ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                >

            </div>

            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                >

            </div>

            <button class="btn full-width" type="submit">
                Login
            </button>

        </form>

        <p class="auth-footer">
            Don't have an account?
            <a href="register.php">Create one</a>
        </p>

    </div>

</section>

<?php

require_once "includes/footer.php";

?>