<?php

// =========================================================
// DATABASE CONNECTION
// =========================================================

$host = "localhost";
$username = "root";
$password = "";
$database = "edutrack";

$conn = new mysqli($host, $username, $password, $database);

// Check database connection
if ($conn->connect_error) {
    die("Database connection failed.");
}


// =========================================================
// FORM VARIABLES
// =========================================================

$full_name = "";
$email = "";

$error = "";
$success = "";


// =========================================================
// FORM SUBMISSION
// =========================================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $user_password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";


    // -------------------------
    // Validate full name
    // -------------------------

    if ($full_name === "") {

        $error = "Please enter your full name.";

    }

    // -------------------------
    // Validate email
    // -------------------------

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    }

    // -------------------------
    // Validate password
    // -------------------------

    elseif (strlen($user_password) < 8) {

        $error = "Password must contain at least 8 characters.";

    }

    // -------------------------
    // Confirm password
    // -------------------------

    elseif ($user_password !== $confirm_password) {

        $error = "Passwords do not match.";

    }

    else {

        // =================================================
        // CHECK IF EMAIL ALREADY EXISTS
        // =================================================

        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);

        $check->execute();

        $check->store_result();


        if ($check->num_rows > 0) {

            $error = "An account with this email already exists.";

        } else {

            // =================================================
            // HASH PASSWORD
            // =================================================

            $hashed_password = password_hash(
                $user_password,
                PASSWORD_DEFAULT
            );


            // =================================================
            // INSERT USER
            // =================================================

            $stmt = $conn->prepare(
                "INSERT INTO users (full_name, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->bind_param(
                "sss",
                $full_name,
                $email,
                $hashed_password
            );


            if ($stmt->execute()) {

                $success = "Account created successfully!";

                // Clear fields after successful registration
                $full_name = "";
                $email = "";

            } else {

                $error = "Something went wrong. Please try again.";

            }

            $stmt->close();
        }

        $check->close();
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
        content="width=device-width, initial-scale=1.0"
    >

    <title>Create Account — EduTrack</title>

    <!-- Existing EduTrack CSS -->
    <link rel="stylesheet" href="./assets/style/style.css?v=<?php echo filemtime(__DIR__ . '/assets/style/style.css'); ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

</head>


<body class="signup-page">

<!-- =====================================================
     NAVBAR
===================================================== -->

<header class="navbar">

    <div class="container nav-inner">

        <a href="index.php" class="logo">

            <span class="logo-icon">E</span>

            <span class="logo-text">
                Edu<span>Track</span>
            </span>

        </a>


        <div class="nav-actions">

            <span class="signup-nav-text">
                Already have an account?
            </span>

            <a href="login.php" class="btn btn-secondary">
                Sign in
            </a>

        </div>

    </div>

</header>


<!-- =====================================================
     SIGNUP SECTION
===================================================== -->

<main class="signup-main">

    <!-- Background glow -->

    <div class="signup-glow signup-glow-one"></div>

    <div class="signup-glow signup-glow-two"></div>


    <div class="container signup-container">


        <!-- LEFT SIDE -->

        <section class="signup-intro">

            <span class="section-label">
                JOIN EDUTRACK
            </span>

            <h1>
                Your academic journey,
                <span>organized.</span>
            </h1>

            <p>
                Create your EduTrack account and get started
                with a simpler way to manage your academic
                information.
            </p>


            <div class="signup-benefits">

                <div class="benefit">

                    <span class="benefit-icon">✓</span>

                    <div>
                        <strong>Simple to use</strong>

                        <small>
                            Everything organized in one place.
                        </small>
                    </div>

                </div>


                <div class="benefit">

                    <span class="benefit-icon">✓</span>

                    <div>
                        <strong>Secure account</strong>

                        <small>
                            Your password is securely protected.
                        </small>
                    </div>

                </div>


                <div class="benefit">

                    <span class="benefit-icon">✓</span>

                    <div>
                        <strong>Built for students</strong>

                        <small>
                            Designed around a modern student experience.
                        </small>
                    </div>

                </div>

            </div>

        </section>


        <!-- SIGNUP CARD -->

        <section class="signup-card">

            <div class="signup-card-header">

                <div class="signup-card-icon">
                    E
                </div>

                <div>

                    <h2>
                        Create your account
                    </h2>

                    <p>
                        It only takes a minute to get started.
                    </p>

                </div>

            </div>


            <!-- PHP ERROR -->

            <?php if ($error !== ""): ?>

                <div class="form-message error-message">
                    <span>!</span>
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <!-- PHP SUCCESS -->

            <?php if ($success !== ""): ?>

                <div class="form-message success-message">
                    <span>✓</span>
                    <?php echo htmlspecialchars($success); ?>
                </div>

            <?php endif; ?>


            <!-- FORM -->

            <form
                action="signup.php"
                method="POST"
                id="signupForm"
                novalidate
            >


                <!-- FULL NAME -->

                <div class="form-group">

                    <label for="full_name">
                        Full name
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            👤
                        </span>

                        <input
                            type="text"
                            id="full_name"
                            name="full_name"
                            placeholder="Enter your full name"
                            value="<?php echo htmlspecialchars($full_name); ?>"
                            autocomplete="name"
                            required
                        >

                    </div>

                    <small
                        class="field-error"
                        id="nameError"
                    ></small>

                </div>


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
                            value="<?php echo htmlspecialchars($email); ?>"
                            autocomplete="email"
                            required
                        >

                    </div>

                    <small
                        class="field-error"
                        id="emailError"
                    ></small>

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <div class="label-row">

                        <label for="password">
                            Password
                        </label>

                        <span id="strengthText">
                            Enter a password
                        </span>

                    </div>


                    <div class="input-wrapper">

                        <span class="input-icon">
                            🔒
                        </span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Create a password"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                            aria-label="Show password"
                        >
                            👁
                        </button>

                    </div>


                    <!-- PASSWORD STRENGTH -->

                    <div class="strength-bar">

                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>

                    </div>


                    <div class="password-rules">

                        <span id="lengthRule">
                            ○ 8+ characters
                        </span>

                        <span id="numberRule">
                            ○ Number
                        </span>

                        <span id="upperRule">
                            ○ Uppercase
                        </span>

                        <span id="specialRule">
                            ○ Special character
                        </span>

                    </div>

                </div>


                <!-- CONFIRM PASSWORD -->

                <div class="form-group">

                    <label for="confirm_password">
                        Confirm password
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            🔐
                        </span>

                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="Repeat your password"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="toggleConfirmPassword"
                            aria-label="Show password"
                        >
                            👁
                        </button>

                    </div>

                    <small
                        class="field-error"
                        id="confirmError"
                    ></small>

                </div>


                <!-- TERMS -->

                <label class="terms">

                    <input
                        type="checkbox"
                        id="terms"
                        required
                    >

                    <span class="custom-checkbox"></span>

                    <span>
                        I agree to the
                        <a href="#">
                            Terms of Service
                        </a>
                        and
                        <a href="#">
                            Privacy Policy
                        </a>.
                    </span>

                </label>


                <!-- SUBMIT -->

                <button
                    type="submit"
                    class="btn btn-primary signup-submit"
                    id="submitButton"
                >

                    <span id="buttonText">
                        Create account
                    </span>

                    <span class="button-arrow">
                        →
                    </span>

                </button>


            </form>


            <div class="login-prompt">

                Already have an account?

                <a href="login.php">
                    Sign in
                </a>

            </div>


        </section>

    </div>

</main>


<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>

const form = document.getElementById("signupForm");

const nameInput = document.getElementById("full_name");
const emailInput = document.getElementById("email");

const passwordInput = document.getElementById("password");
const confirmInput = document.getElementById("confirm_password");

const togglePassword =
    document.getElementById("togglePassword");

const toggleConfirmPassword =
    document.getElementById("toggleConfirmPassword");

const strengthText =
    document.getElementById("strengthText");

const strengthBars =
    document.querySelectorAll(".strength-bar span");


// =====================================================
// PASSWORD VISIBILITY
// =====================================================

togglePassword.addEventListener("click", () => {

    const isPassword =
        passwordInput.type === "password";

    passwordInput.type =
        isPassword ? "text" : "password";

    togglePassword.textContent =
        isPassword ? "🙈" : "👁";

});


toggleConfirmPassword.addEventListener("click", () => {

    const isPassword =
        confirmInput.type === "password";

    confirmInput.type =
        isPassword ? "text" : "password";

    toggleConfirmPassword.textContent =
        isPassword ? "🙈" : "👁";

});


// =====================================================
// PASSWORD STRENGTH
// =====================================================

passwordInput.addEventListener("input", () => {

    const password = passwordInput.value;

    let score = 0;


    const hasLength =
        password.length >= 8;

    const hasNumber =
        /\d/.test(password);

    const hasUppercase =
        /[A-Z]/.test(password);

    const hasSpecial =
        /[^A-Za-z0-9]/.test(password);


    if (hasLength) score++;
    if (hasNumber) score++;
    if (hasUppercase) score++;
    if (hasSpecial) score++;


    updateRule(
        "lengthRule",
        hasLength
    );

    updateRule(
        "numberRule",
        hasNumber
    );

    updateRule(
        "upperRule",
        hasUppercase
    );

    updateRule(
        "specialRule",
        hasSpecial
    );


    strengthBars.forEach(bar => {

        bar.classList.remove(
            "active",
            "weak",
            "medium",
            "strong"
        );

    });


    if (password.length === 0) {

        strengthText.textContent =
            "Enter a password";

        return;

    }


    if (score <= 1) {

        strengthText.textContent =
            "Weak";

        strengthBars[0].classList.add(
            "active",
            "weak"
        );

    }

    else if (score <= 2) {

        strengthText.textContent =
            "Medium";

        strengthBars.forEach((bar, index) => {

            if (index < 2) {

                bar.classList.add(
                    "active",
                    "medium"
                );

            }

        });

    }

    else if (score === 3) {

        strengthText.textContent =
            "Good";

        strengthBars.forEach((bar, index) => {

            if (index < 3) {

                bar.classList.add(
                    "active",
                    "strong"
                );

            }

        });

    }

    else {

        strengthText.textContent =
            "Strong";

        strengthBars.forEach(bar => {

            bar.classList.add(
                "active",
                "strong"
            );

        });

    }

});


// =====================================================
// UPDATE PASSWORD RULE
// =====================================================

function updateRule(id, passed) {

    const rule =
        document.getElementById(id);

    if (passed) {

        rule.textContent =
            "✓ " + rule.textContent.substring(2);

        rule.classList.add("passed");

    } else {

        rule.textContent =
            "○ " + rule.textContent.substring(2);

        rule.classList.remove("passed");

    }

}


// =====================================================
// CONFIRM PASSWORD
// =====================================================

confirmInput.addEventListener("input", checkPasswords);

passwordInput.addEventListener("input", () => {

    if (confirmInput.value !== "") {
        checkPasswords();
    }

});


function checkPasswords() {

    const error =
        document.getElementById("confirmError");


    if (confirmInput.value === "") {

        error.textContent = "";

        confirmInput.parentElement
            .classList.remove("valid", "invalid");

        return;

    }


    if (
        passwordInput.value ===
        confirmInput.value
    ) {

        error.textContent =
            "✓ Passwords match";

        error.classList.remove("error");

        error.classList.add("success");

        confirmInput.parentElement
            .classList.remove("invalid");

        confirmInput.parentElement
            .classList.add("valid");

    }

    else {

        error.textContent =
            "Passwords do not match";

        error.classList.remove("success");

        error.classList.add("error");

        confirmInput.parentElement
            .classList.remove("valid");

        confirmInput.parentElement
            .classList.add("invalid");

    }

}


// =====================================================
// FORM VALIDATION
// =====================================================

form.addEventListener("submit", (event) => {

    let valid = true;


    // Name

    if (nameInput.value.trim().length < 2) {

        document.getElementById("nameError")
            .textContent =
            "Please enter your full name.";

        valid = false;

    } else {

        document.getElementById("nameError")
            .textContent = "";

    }


    // Email

    const emailPattern =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


    if (!emailPattern.test(emailInput.value)) {

        document.getElementById("emailError")
            .textContent =
            "Please enter a valid email address.";

        valid = false;

    } else {

        document.getElementById("emailError")
            .textContent = "";

    }


    // Password

    if (passwordInput.value.length < 8) {

        valid = false;

    }


    // Confirm password

    if (
        passwordInput.value !==
        confirmInput.value
    ) {

        document.getElementById("confirmError")
            .textContent =
            "Passwords do not match.";

        valid = false;

    }


    // Terms

    const terms =
        document.getElementById("terms");

    if (!terms.checked) {

        alert(
            "Please agree to the Terms of Service and Privacy Policy."
        );

        valid = false;

    }


    if (!valid) {

        event.preventDefault();

        return;

    }


    // Button loading state

    const button =
        document.getElementById("submitButton");

    const buttonText =
        document.getElementById("buttonText");

    button.disabled = true;

    buttonText.textContent =
        "Creating account...";

        

});

</script>

</body>

</html>