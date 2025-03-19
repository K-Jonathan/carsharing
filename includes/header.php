<?php
// Include session handler to manage user authentication and maintain session data
include 'session_handler.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Dynamically linked stylesheet to ensure that the correct CSS file is loaded,
         even if the file structure changes. This prevents styling issues caused by
         incorrect relative paths. -->
    <link rel="stylesheet" type="text/css" href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/css/stylesheet.css">
</head>

<body>
    <!-- Main navigation bar -->
    <header class="navbar">
        <div class="container">
            <!-- Company logo linking to the homepage -->
            <a href="/carsharing/" class="logo img">
                <!-- The logo uses a dynamically generated path to ensure it remains accessible 
                     regardless of the current directory structure. -->
                <img src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/images/flamin-go-logo.png" 
                     alt="Flamin-Go Car Rental Logo">
            </a>

            <!-- Navigation menu -->
            <nav>
                <ul>
                    <!-- Booking link (visible for both logged-in and non-logged-in users) -->
                    <?php if ($logged_in): ?>
                        <li>
                            <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/bookings.php" class="icon-text">
                                <!-- Booking icon with a dynamic image path -->
                                <img src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/images/car-icon.png" 
                                     alt="My bookings icon">
                                <span>Meine Buchungen</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/loginpage.php" class="icon-text">
                                <!-- Redirects to login page if the user is not logged in -->
                                <img src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/images/car-icon.png" 
                                     alt="My bookings icon">
                                <span>Meine Buchungen</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Profile settings or login link (depends on user's login status) -->
                    <?php if ($logged_in): ?>
                        <li>
                            <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/user_settings.php" class="icon-text">
                                <!-- User profile icon with a dynamic image path -->
                                <img src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/images/person-icon.png" 
                                     alt="Person icon">
                                <!-- The username is securely escaped using `htmlspecialchars()` to prevent XSS attacks -->
                                <span>
                                    <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> | Profil
                                </span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/loginpage.php" class="icon-text">
                                <!-- Redirects to login page if the user is not logged in -->
                                <img src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/images/person-icon.png" 
                                     alt="Person icon">
                                <span>Anmelden | Login</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>