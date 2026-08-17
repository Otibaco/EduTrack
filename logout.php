<?php
// logout.php - Session Destroy & Redirect

// Start session to destroy it
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();

// Set a flag to show the logout message
$loggedOut = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out — EduTrack</title>

    <!-- Main Theme Stylesheet -->
    <link rel="stylesheet" href="./assets/style/style.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
        /* =========================================================
           LOGOUT PAGE STYLES (Centered Card)
        ========================================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg);
            font-family: var(--body-font);
            padding: 20px;
        }

        .logout-card {
            max-width: 480px;
            width: 100%;
            padding: 50px 40px 45px;
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            background: var(--surface);
            text-align: center;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        /* Subtle glow behind the card */
        .logout-card::before {
            content: '';
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 300px;
            height: 300px;
            background: var(--primary);
            filter: blur(100px);
            opacity: 0.1;
            pointer-events: none;
        }

        .logout-card > * {
            position: relative;
            z-index: 2;
        }

        .logout-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 24px;
            border-radius: 50%;
            background: rgba(109, 93, 252, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
        }

        .logout-card h1 {
            font-family: var(--heading-font);
            font-size: 28px;
            margin-bottom: 10px;
            letter-spacing: -0.02em;
        }

        .logout-card h1 span {
            color: var(--primary-light);
        }

        .logout-card p {
            color: var(--text-soft);
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        /* Spinner */
        .spinner {
            display: inline-block;
            width: 36px;
            height: 36px;
            border: 3px solid var(--border);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-bottom: 16px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .redirect-text {
            color: var(--text-muted);
            font-size: 13px;
        }

        .redirect-text strong {
            color: var(--text);
            font-weight: 600;
        }

        /* Manual redirect link */
        .manual-link {
            display: inline-block;
            margin-top: 18px;
            color: var(--primary-light);
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .manual-link:hover {
            color: white;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 520px) {
            .logout-card {
                padding: 36px 24px 32px;
            }

            .logout-icon {
                width: 60px;
                height: 60px;
                font-size: 28px;
            }

            .logout-card h1 {
                font-size: 24px;
            }
        }
    </style>

    <!-- Meta refresh fallback (redirects after 3 seconds) -->
    <meta http-equiv="refresh" content="3; url=login.php">
</head>
<body>

    <div class="logout-card">

        <div class="logout-icon">👋</div>

        <h1>See you soon, <span>Samuel</span></h1>

        <p>
            You have been successfully logged out of EduTrack.
            Your session has been securely terminated.
        </p>

        <!-- Spinner -->
        <div class="spinner"></div>

        <div class="redirect-text">
            Redirecting to <strong>Login</strong> in a moment...
        </div>

        <!-- Fallback link if redirect doesn't fire -->
        <a href="login.php" class="manual-link">
            Click here if you're not redirected automatically →
        </a>

    </div>

    <!-- Optional: Smooth redirection timer (js fallback, but meta refresh already handles it) -->
    <script>
        // This ensures a smooth experience and updates the countdown if needed.
        // The meta refresh already does the heavy lifting.
        document.addEventListener('DOMContentLoaded', () => {
            // You could add a countdown timer here if desired, but meta refresh is solid.
            console.log('✅ Logged out. Redirecting to login.php');
        });
    </script>

</body>
</html>