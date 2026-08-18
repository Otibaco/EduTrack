<?php

// =========================================================
// DATABASE CONNECTION
// =========================================================

$host = "localhost";
$username = "root";
$password = "";
$database = "edutrack";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed.");
}


// =========================================================
// START SESSION
// =========================================================

session_start();


// =========================================================
// VARIABLES
// =========================================================

$email = "";
$error = "";


// =========================================================
// LOGIN
// =========================================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $user_password = $_POST["password"] ?? "";


    // -----------------------------------------------------
    // BASIC VALIDATION
    // -----------------------------------------------------

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";
    } elseif ($user_password === "") {

        $error = "Please enter your password.";
    } else {

        // -------------------------------------------------
        // FIND USER
        // -------------------------------------------------

        $stmt = $conn->prepare(
            "SELECT id, full_name, email, password
             FROM users
             WHERE email = ?"
        );

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();


        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();


            // ---------------------------------------------
            // VERIFY PASSWORD
            // ---------------------------------------------

            if (
                password_verify(
                    $user_password,
                    $user["password"]
                )
            ) {

                // -----------------------------------------
                // LOGIN SUCCESSFUL
                // -----------------------------------------

                session_regenerate_id(true);

                $_SESSION["user_id"] = $user["id"];

                $_SESSION["full_name"] =
                    $user["full_name"];

                $_SESSION["email"] =
                    $user["email"];


                // Temporary destination
                header("Location: dashboard.php");

                exit;
            } else {

                $error =
                    "Incorrect email or password.";
            }
        } else {

            $error =
                "Incorrect email or password.";
        }


        $stmt->close();
    }
}

$conn->close();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Sign In — EduTrack</title>


    <!-- EduTrack CSS -->

    <link
        rel="stylesheet"
       <link rel="stylesheet" href="./assets/style/style.css?v=<?php echo filemtime(__DIR__ . '/assets/style/style.css'); ?>">


    <!-- Google Fonts -->

    <link rel="preconnect"
        href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">

</head>


<body class="login-page">


    <!-- =====================================================
     NAVBAR
===================================================== -->

    <header class="navbar">

        <div class="container nav-inner">


            <a href="index.php" class="logo">

                <span class="logo-icon">
                    E
                </span>

                <span class="logo-text">
                    Edu<span>Track</span>
                </span>

            </a>


            <div class="nav-actions">

                <span class="login-nav-text">
                    New to EduTrack?
                </span>

                <a
                    href="signup.php"
                    class="btn btn-secondary">
                    Create account
                </a>

            </div>

        </div>

    </header>


    <!-- =====================================================
     LOGIN MAIN
===================================================== -->

    <main class="login-main">


        <!-- Background -->

        <div class="login-glow login-glow-one"></div>

        <div class="login-glow login-glow-two"></div>


        <div class="container login-container">


            <!-- =================================================
             LEFT SIDE
        ================================================== -->

            <section class="login-intro">


                <span class="section-label">
                    WELCOME BACK
                </span>


                <h1>

                    Your academic
                    <span>workspace awaits.</span>

                </h1>


                <p>

                    Sign in to continue managing your
                    academic journey with EduTrack.

                </p>


                <div class="login-feature">


                    <div class="feature-orb">

                        <span>
                            E
                        </span>

                    </div>


                    <div>

                        <strong>
                            Everything in one place
                        </strong>

                        <small>
                            Access your academic information
                            whenever you need it.
                        </small>

                    </div>

                </div>


            </section>



            <!-- =================================================
             LOGIN CARD
        ================================================== -->

            <section class="login-card">


                <div class="login-card-header">


                    <div class="login-card-icon">
                        E
                    </div>


                    <div>

                        <h2>
                            Welcome back
                        </h2>

                        <p>
                            Sign in to your EduTrack account.
                        </p>

                    </div>


                </div>



                <!-- PHP ERROR -->

                <?php if ($error !== ""): ?>

                    <div class="form-message error-message">

                        <span>!</span>

                        <?php
                        echo htmlspecialchars($error);
                        ?>

                    </div>

                <?php endif; ?>



                <!-- LOGIN FORM -->

                <form
                    action="login.php"
                    method="POST"
                    id="loginForm"
                    novalidate>


                    <!-- EMAIL -->

                    <div class="form-group">


                        <label for="email">
                            Email address
                        </label>


                        <div class="input-wrapper">


                            <span class="input-icon">
                                @
                            </span>


                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="you@example.com"
                                value="<?php
                                        echo htmlspecialchars($email);
                                        ?>"
                                autocomplete="email"
                                required>


                        </div>


                        <small
                            class="field-error"
                            id="emailError"></small>


                    </div>



                    <!-- PASSWORD -->

                    <div class="form-group">


                        <div class="label-row">

                            <label for="password">
                                Password
                            </label>

                            <a
                                href="#"
                                class="forgot-password">
                                Forgot password?
                            </a>

                        </div>


                        <div class="input-wrapper">


                            <span class="input-icon">
                                🔒
                            </span>


                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required>


                            <button
                                type="button"
                                class="password-toggle"
                                id="togglePassword"
                                aria-label="Show password">
                                👁
                            </button>


                        </div>


                        <small
                            class="field-error"
                            id="passwordError"></small>


                    </div>



                    <!-- REMEMBER ME -->

                    <label class="remember-me">


                        <input
                            type="checkbox"
                            id="remember">


                        <span class="custom-checkbox"></span>


                        <span>
                            Remember me
                        </span>


                    </label>



                    <!-- SUBMIT -->

                    <a href="index.php"
                        type="submit"
                        class="btn btn-primary login-submit"
                        id="loginButton">


                        <span id="buttonText">
                            Log in
                        </span>


                        <span class="button-arrow">
                            →
                        </span>


                </a>


                </form>



                <!-- SIGNUP -->

                <div class="signup-prompt">

                    Don't have an account?

                    <a href="signup.php">
                        Create one
                    </a>

                </div>


            </section>


        </div>

    </main>



    <!-- =====================================================
     JAVASCRIPT
===================================================== -->

    <script>
        const form =
            document.getElementById("loginForm");


        const emailInput =
            document.getElementById("email");


        const passwordInput =
            document.getElementById("password");


        const togglePassword =
            document.getElementById("togglePassword");


        const loginButton =
            document.getElementById("loginButton");


        const buttonText =
            document.getElementById("buttonText");



        // =====================================================
        // PASSWORD VISIBILITY
        // =====================================================

        togglePassword.addEventListener(
            "click",
            () => {

                const isPassword =
                    passwordInput.type === "password";


                passwordInput.type =
                    isPassword ?
                    "text" :
                    "password";


                togglePassword.textContent =
                    isPassword ?
                    "🙈" :
                    "👁";

            }
        );



        // =====================================================
        // FORM VALIDATION
        // =====================================================

        form.addEventListener(
            "submit",
            (event) => {


                let valid = true;


                const emailError =
                    document.getElementById(
                        "emailError"
                    );


                const passwordError =
                    document.getElementById(
                        "passwordError"
                    );


                emailError.textContent = "";

                passwordError.textContent = "";



                // EMAIL

                const emailPattern =
                    /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


                if (
                    !emailPattern.test(
                        emailInput.value.trim()
                    )
                ) {

                    emailError.textContent =
                        "Please enter a valid email address.";

                    valid = false;

                }



                // PASSWORD

                if (
                    passwordInput.value.length === 0
                ) {

                    passwordError.textContent =
                        "Please enter your password.";

                    valid = false;

                }



                if (!valid) {

                    event.preventDefault();

                    return;

                }



                // LOADING STATE

                loginButton.disabled = true;

                buttonText.textContent =
                    "Signing in...";

            }
        );
    </script>


</body>

</html>