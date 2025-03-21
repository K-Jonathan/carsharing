<!--
This script generates the navigation bar, dynamically adjusting links based on user login status.

🟢 Session Handling:
- Includes `session_handler.php` to ensure `userid` is always available.
- Uses `$logged_in` to determine if a user is logged in.

🔹 Logo & Homepage Link:
- Displays the Flamin-Go logo, linking back to the homepage (`/carsharing/`).

🔵 Navigation Menu:
- "Meine Buchungen" (My Bookings):
  - If logged in: Links to `bookings.php`.
  - If not logged in: Redirects to `loginpage.php`.

- "Profil" / "Login":
  - If logged in: Displays username with a link to `user_settings.php`.
  - If not logged in: Shows a login link to `loginpage.php`.

This structure ensures a seamless user experience by adapting the navigation dynamically based on authentication status.
-->
<?php
include 'session_handler.php'; // 🔹 Ensures that `userid` is always available
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

                    

                    <!-- 🔹 If logged in: Leads to `user_settings.php` instead of `logout.php` -->
                    <?php if ($logged_in): ?>
                        <li>
                            <a href="user_settings.php" class="icon-text">
                                <img src="images/person-icon.png" alt="Person icon">
                                <span><strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> | Profil</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="loginpage.php" class="icon-text">
                                <img src="images/person-icon.png" alt="Person icon">
                                <span>Anmelden | Login</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>