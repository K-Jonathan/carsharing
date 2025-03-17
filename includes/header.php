<?php
include 'session_handler.php'; // 🔹 Stellt sicher, dass `userid` immer verfügbar ist
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/css/stylesheet.css">
</head>

<body>
    <header class="navbar">
        <div class="container">
            <a href="/carsharing/" class="logo img">
                <img src="images/flamin-go-logo.png" alt="Flamin-Go Car Rental Logo">
            </a>
            
            <nav>
                <ul>
                <?php if ($logged_in): ?>
    <li>
        <a href="bookings.php" class="icon-text">
            <img src="images/car-icon.png" alt="My bookings icon">
            <span>Meine Buchungen</span>
        </a>
    </li>
<?php else: ?>
    <li>
        <a href="loginpage.php" class="icon-text">
            <img src="images/car-icon.png" alt="My bookings icon">
            <span>Meine Buchungen</span>
        </a>
    </li>
<?php endif; ?>

                    <li><a href="#" class="icon-text"><img src="images/world-icon.png" alt="World icon"><span>DE</span></a></li>

                    <!-- 🔹 Anmelden/Login oder Abmelden/Logout abhängig vom Status -->
                    <?php if ($logged_in): ?>
                        <li>
    <a href="logout.php" class="icon-text">
        <img src="images/person-icon.png" alt="Person icon">
        <span><strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> | Logout</span>
    </a>
</li>

                    <?php else: ?>
                        <li><a href="loginpage.php" class="icon-text"><img src="images/person-icon.png" alt="Person icon"><span>Anmelden | Login</span></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>