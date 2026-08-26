<?php

require_once "includes/auth.php";

requireLogin();

require_once "includes/header.php";

$user = $_SESSION["user"];

?>

<section class="dashboard">

    <div class="dashboard-header">

        <div>

            <p class="eyebrow">
                USER DASHBOARD
            </p>

            <h1>
                Welcome, <?php echo htmlspecialchars($user["name"]); ?>
            </h1>

            <p>
                You are successfully logged in.
            </p>

        </div>

        <a href="logout.php" class="btn btn-danger">
            Logout
        </a>

    </div>


    <div class="profile-section">

        <div class="profile-title">

            <p class="eyebrow">
                ACCOUNT INFORMATION
            </p>

            <h2>Your Details</h2>

        </div>


        <div class="profile-details">

            <div class="detail">

                <span>User ID</span>

                <strong>
                    <?php echo htmlspecialchars($user["id"]); ?>
                </strong>

            </div>


            <div class="detail">

                <span>Name</span>

                <strong>
                    <?php echo htmlspecialchars($user["name"]); ?>
                </strong>

            </div>


            <div class="detail">

                <span>Email</span>

                <strong>
                    <?php echo htmlspecialchars($user["email"]); ?>
                </strong>

            </div>

        </div>

    </div>

</section>

<?php

require_once "includes/footer.php";

?>