<?php
/**
 * User Settings Page
 * 
 * - Ensures the user is logged in; redirects to login page if not.
 * - Fetches user data and pre-fills a form for updating user settings.
 * - Excludes sensitive fields (user ID, password, created_at) from being editable.
 * - Uses appropriate input types (e.g., 'date' for birthdate).
 * - Provides a logout button for user session termination.
 * - Includes a popup to display errors if the update fails.
 * - Loads a JavaScript file for client-side validation.
 * 
 * Dependencies:
 * - Requires 'fetch_user_data.php' to retrieve user details.
 * - Includes 'header.php' and 'footer.php' for consistent layout.
 * - Uses 'settings_validation.js' for frontend validation.
 */
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    header("Location: loginpage.php");
    exit;
}
require_once('fetch_user_data.php'); 
include 'includes/header.php';
?>

<body class="user-settings">
    <div class="settings-container">
        <div class="settings-box">
            <h2 class="settings-title">Benutzereinstellungen</h2>
            <form id="settingsForm" action="update_user.php" method="POST">
                <?php
                foreach ($user as $column => $value):
                    if ($column === 'userid' || $column === 'password' || $column === 'created_at') {
                        continue;
                    }

                    // Chage type to "date" if column is 'birthdate' 
                    $inputType = ($column === "birthdate") ? "date" : "text";
                ?>
                    <label for="<?php echo htmlspecialchars($column); ?>">
                        <?php echo ucfirst(str_replace("_", " ", $column)); ?>
                    </label>
                    <input class="registerpage-input" type="<?php echo $inputType; ?>" name="<?php echo htmlspecialchars($column); ?>" 
                           id="<?php echo htmlspecialchars($column); ?>" 
                           value="<?php echo htmlspecialchars($value); ?>" required>
                <?php endforeach; ?>

                <button class="loginregisterpage-button" type="submit">Änderungen speichern</button>
            </form>

            <!-- Logout-Button -->
            <form action="logout.php" method="POST">
                <button class="logout-button" type="submit">Abmelden | Logout</button>
            </form>
        </div>
    </div>

    <!-- Pop-up for Error-Message -->
    <div class="popup-overlay" id="popupOverlay">
        <div class="popup-box">
            <p class="popup-title">Fehler bei der Aktualisierung:</p>
            <ul class="popup-errors" id="popupErrors"></ul>
            <button class="popup-close" id="popupClose">Schließen</button>
        </div>
    </div>

    <script src="js/settings_validation.js"></script>
</body>
<?php
include 'includes/footer.php';
?>