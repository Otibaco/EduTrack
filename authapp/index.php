<?php

session_start();

require_once "includes/header.php";

?>

<section class="hero">

    <div class="hero-content">

        <p class="eyebrow">MODERN PHP AUTHENTICATION</p>

        <h1>
            Simple.
            <span>Secure.</span>
            Modern.
        </h1>

        <p class="hero-text">
            A clean PHP authentication system built with
            MySQLi, sessions, HTML, CSS and JavaScript.
        </p>

        <div class="hero-buttons">

            <?php if (isset($_SESSION['user'])): ?>

                <a href="dashboard.php" class="btn">
                    Go to Dashboard
                </a>

            <?php else: ?>

                <a href="register.php" class="btn">
                    Create Account
                </a>

                <a href="login.php" class="btn btn-outline">
                    Login
                </a>

            <?php endif; ?>

        </div>

    </div>

</section>

<section class="features">

    <div>
        <h3>Secure Authentication</h3>
        <p>
            Passwords are securely hashed before they are stored.
        </p>
    </div>

    <div>
        <h3>Session Based</h3>
        <p>
            User information is stored in a PHP session after login.
        </p>
    </div>

    <div>
        <h3>Clean Architecture</h3>
        <p>
            Database, authentication and UI logic are separated.
        </p>
    </div>

</section>

<?php

require_once "includes/footer.php";

?>