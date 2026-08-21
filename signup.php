<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Create Account — EduTrack</title>

    <link
        rel="stylesheet"
        href="./assets/style/style.css">

    <link rel="preconnect"
        href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">

</head>


<body class="login-page">


    <main class="login-main">


        <div class="login-glow login-glow-one"></div>

        <div class="login-glow login-glow-two"></div>


        <div class="container login-container">


            <!-- LEFT SIDE -->

            <section class="login-intro">


                <span class="section-label">
                    GET STARTED
                </span>


                <h1>

                    Build your
                    <span>academic future.</span>

                </h1>


                <p>

                    Create your EduTrack account and
                    bring your academic journey into one
                    simple workspace.

                </p>


                <div class="login-feature">


                    <div class="feature-orb">

                        <a href="index.php" class="feature-orb-link">
                            <span>
                                E
                            </span>
                        </a>

                    </div>


                    <div>

                        <strong>
                            Your academic journey
                        </strong>

                        <small>
                            Stay organized, focused and
                            connected with EduTrack.
                        </small>

                    </div>

                </div>


            </section>



            <!-- SIGNUP CARD -->

            <section class="login-card">


                <div class="login-card-header">


                    <div class="login-card-icon">
                        E
                    </div>


                    <div>

                        <h2>
                            Create account
                        </h2>

                        <p>
                            Join EduTrack today.
                        </p>

                    </div>


                </div>



                <form
                    action="#"
                    method="POST"
                    id="signupForm"
                    novalidate>


                    <!-- FULL NAME -->

                    <div class="form-group">

                        <label for="fullName">
                            Full name
                        </label>


                        <div class="input-wrapper">

                            <span class="input-icon">
                                👤
                            </span>


                            <input
                                type="text"
                                id="fullName"
                                name="full_name"
                                placeholder="Enter your full name"
                                autocomplete="name"
                                required>

                        </div>


                        <small
                            class="field-error"
                            id="nameError"></small>

                    </div>



                    <!-- EMAIL -->

                    <div class="form-group">

                        <label for="signupEmail">
                            Email address
                        </label>


                        <div class="input-wrapper">

                            <span class="input-icon">
                                @
                            </span>


                            <input
                                type="email"
                                id="signupEmail"
                                name="email"
                                placeholder="you@example.com"
                                autocomplete="email"
                                required>

                        </div>


                        <small
                            class="field-error"
                            id="signupEmailError"></small>

                    </div>



                    <!-- PASSWORD -->

                    <div class="form-group">

                        <label for="signupPassword">
                            Password
                        </label>


                        <div class="input-wrapper">

                            <span class="input-icon">
                                🔒
                            </span>


                            <input
                                type="password"
                                id="signupPassword"
                                name="password"
                                placeholder="Create a password"
                                autocomplete="new-password"
                                required>


                            <button
                                type="button"
                                class="password-toggle"
                                id="toggleSignupPassword">
                                👁
                            </button>

                        </div>


                        <small
                            class="field-error"
                            id="signupPasswordError"></small>

                    </div>



                    <!-- CONFIRM PASSWORD -->

                    <div class="form-group">

                        <label for="confirmPassword">
                            Confirm password
                        </label>


                        <div class="input-wrapper">

                            <span class="input-icon">
                                🔒
                            </span>


                            <input
                                type="password"
                                id="confirmPassword"
                                name="confirm_password"
                                placeholder="Confirm your password"
                                autocomplete="new-password"
                                required>

                        </div>


                        <small
                            class="field-error"
                            id="confirmPasswordError"></small>

                    </div>



                    <!-- TERMS -->

                    <label class="remember-me">

                        <input
                            type="checkbox"
                            id="terms">

                        <span class="custom-checkbox"></span>

                        <span>
                            I agree to the terms and conditions
                        </span>

                    </label>



                    <!-- BUTTON -->

                    <button
                        type="submit"
                        class="btn btn-primary login-submit"
                        id="signupButton">

                        <span id="signupButtonText">
                            Create account
                        </span>

                        <span class="button-arrow">
                            →
                        </span>

                    </button>


                </form>



                <!-- LOGIN -->

                <div class="signup-prompt">

                    Already have an account?

                    <a href="login.php">
                        Sign in
                    </a>

                </div>


            </section>


        </div>

    </main>



    <script>
        const signupForm =
            document.getElementById("signupForm");


        const fullName =
            document.getElementById("fullName");


        const signupEmail =
            document.getElementById("signupEmail");


        const signupPassword =
            document.getElementById("signupPassword");


        const confirmPassword =
            document.getElementById("confirmPassword");


        const terms =
            document.getElementById("terms");


        const signupButton =
            document.getElementById("signupButton");


        const signupButtonText =
            document.getElementById(
                "signupButtonText"
            );


        const toggleSignupPassword =
            document.getElementById(
                "toggleSignupPassword"
            );



        // =====================================================
        // SHOW / HIDE PASSWORD
        // =====================================================

        toggleSignupPassword.addEventListener(
            "click",
            () => {

                const hidden =
                    signupPassword.type === "password";


                signupPassword.type =
                    hidden ?
                    "text" :
                    "password";


                toggleSignupPassword.textContent =
                    hidden ?
                    "🙈" :
                    "👁";

            }
        );



        // =====================================================
        // SIGNUP VALIDATION
        // =====================================================

        signupForm.addEventListener(
            "submit",
            (event) => {

                event.preventDefault();


                let valid = true;


                document.getElementById(
                    "nameError"
                ).textContent = "";


                document.getElementById(
                    "signupEmailError"
                ).textContent = "";


                document.getElementById(
                    "signupPasswordError"
                ).textContent = "";


                document.getElementById(
                    "confirmPasswordError"
                ).textContent = "";



                // NAME

                if (
                    fullName.value.trim().length < 2
                ) {

                    document.getElementById(
                            "nameError"
                        ).textContent =
                        "Please enter your full name.";

                    valid = false;

                }



                // EMAIL

                const emailPattern =
                    /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


                if (
                    !emailPattern.test(
                        signupEmail.value.trim()
                    )
                ) {

                    document.getElementById(
                            "signupEmailError"
                        ).textContent =
                        "Please enter a valid email address.";

                    valid = false;

                }



                // PASSWORD

                if (
                    signupPassword.value.length < 8
                ) {

                    document.getElementById(
                            "signupPasswordError"
                        ).textContent =
                        "Password must be at least 8 characters.";

                    valid = false;

                }



                // CONFIRM PASSWORD

                if (
                    signupPassword.value !==
                    confirmPassword.value
                ) {

                    document.getElementById(
                            "confirmPasswordError"
                        ).textContent =
                        "Passwords do not match.";

                    valid = false;

                }



                // TERMS

                if (!terms.checked) {

                    alert(
                        "Please agree to the terms and conditions."
                    );

                    valid = false;

                }



                if (!valid) {

                    return;

                }



                // UI-ONLY SUCCESS

                signupButton.disabled = true;

                signupButtonText.textContent =
                    "Creating account...";


                setTimeout(() => {

                    signupButton.disabled = false;

                    signupButtonText.textContent =
                        "Create account";


                    alert(
                        "Account interface is ready. Backend registration will be connected later."
                    );

                }, 1000);

            }
        );
    </script>


</body>

</html>