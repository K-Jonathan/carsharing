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

                    // Falls die Spalte `birthdate` ist, dann type="text" setzen und Format-Validierung einfügen
                    $inputType = ($column === "birthdate") ? "text" : "text";
                    $placeholder = ($column === "birthdate") ? "YYYY-MM-DD" : "";
                ?>
                    <label for="<?php echo htmlspecialchars($column); ?>">
                        <?php echo ucfirst(str_replace("_", " ", $column)); ?>
                    </label>
                    <input class="registerpage-input" type="<?php echo $inputType; ?>" name="<?php echo htmlspecialchars($column); ?>" 
                           id="<?php echo htmlspecialchars($column); ?>" 
                           value="<?php echo htmlspecialchars($value); ?>"
                           placeholder="<?php echo $placeholder; ?>">
                <?php endforeach; ?>

                <button class="loginregisterpage-button" type="submit">Änderungen speichern</button>
            </form>

            <!-- 🔴 Logout-Button -->
            <form action="logout.php" method="POST">
                <button class="logout-button" type="submit">Abmelden | Logout</button>
            </form>
        </div>
    </div>

    <!-- ❌ Pop-up für Fehleranzeige -->
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