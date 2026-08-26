<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AuthApp</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<header class="navbar">

    <div class="logo">
        Auth<span>App</span>
    </div>

    <nav>
        <a href="index.php">Home</a>

        <?php if (isset($_SESSION['user'])): ?>

            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>

        <?php else: ?>

            <a href="login.php">Login</a>
            <a href="register.php">Register</a>

        <?php endif; ?>
    </nav>

</header>

<main class="container">