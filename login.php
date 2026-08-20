<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Sign In — EduTrack</title>

    <!-- Your existing EduTrack CSS -->
    <link
        rel="stylesheet"
        href="./assets/style/style.css"
    >

    <!-- Google Fonts -->
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

</head>


<body class="login-page">


<!-- =====================================================
     LOGIN MAIN
===================================================== -->

<main class="login-main">


    <!-- Background Glow -->

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



            <!-- LOGIN FORM -->

            <form
                action="#"
                method="POST"
                id="loginForm"
                novalidate
            >


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

                        <a
                            href="#"
                            class="forgot-password"
                            onclick="return false;"
                        >
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


                    <small
                        class="field-error"
                        id="passwordError"
                    ></small>


                </div>



                <!-- REMEMBER ME -->

                <label class="remember-me">


                    <input
                        type="checkbox"
                        id="remember"
                    >


                    <span class="custom-checkbox"></span>


                    <span>
                        Remember me
                    </span>


                </label>



                <!-- SUBMIT -->

                <button
                    type="submit"
                    class="btn btn-primary login-submit"
                    id="loginButton"
                >

                    <span id="buttonText">
                        Sign in
                    </span>

                    <span class="button-arrow">
                        →
                    </span>

                </button>


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
            isPassword
                ? "text"
                : "password";


        togglePassword.textContent =
            isPassword
                ? "🙈"
                : "👁";

    }
);



// =====================================================
// FORM VALIDATION
// =====================================================

form.addEventListener(
    "submit",
    (event) => {

        event.preventDefault();


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

            return;

        }



        // UI-ONLY LOGIN

        loginButton.disabled = true;

        buttonText.textContent =
            "Signing in...";


        setTimeout(() => {

            buttonText.textContent =
                "Sign in";

            loginButton.disabled = false;


            alert(
                "Login interface is ready. Backend authentication will be connected later."
            );

        }, 1000);

    }
);


</script>


</body>

</html>