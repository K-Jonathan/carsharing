<!--
This is the "Login" page for Flamin-Go!, where users can authenticate themselves to access personalized features like bookings and account management.

🔐 Structure:
- Includes global `header.php` and `footer.php` for consistent branding.
- Background styling and positioning via `loginpage-background` and `loginpage-spacer`.

📝 Login Form:
- Fields:
  - `Classe`: Accepts either email or username.
  - `Classf`: Password field.
- Hidden `redirect` input retains the original target page for post-login redirection (if present in the URL).
- Submit button labeled “ANMELDEN”.

👤 User Options:
- Below the form, a link allows new users to navigate to the registration page (`registerpage.php`).

⚠️ Error Handling:
- Pop-up modal (`#popupOverlay`) displays specific error messages if login validation fails.
- Triggered and populated by JavaScript (`login_validation.js`).

🧠 JavaScript:
- `login_validation.js`: Sends AJAX request to the login backend and handles client-side validation and redirection logic.

This page is optimized for secure and user-friendly authentication with real-time error feedback and seamless redirect flow.
-->
<!--Insert Header-->
<?php
include 'includes/header.php';
?>

<!-- Background for the login page -->
<div class="loginpage-background"></div>

<!-- Invisible positioning spacer -->
<div class="loginpage-spacer">
    <!-- White rounded box for the login form -->
    <div class="loginpage-box">
        <h2 class="loginregisterpage-title">LOGIN</h2>
        <form id="loginForm">
            <input type="hidden" name="redirect" id="redirect" value="<?php echo isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : ''; ?>">

            <label for="Classe">E-Mail/Benutzername</label>
            <input class="loginpage-input" type="text" name="Classe" id="Classe" required>

            <label for="Classf">Passwort</label>
            <input class="loginpage-input" type="password" name="Classf" id="Classf" required>

            <button class="loginregisterpage-button" type="submit">ANMELDEN</button>
        </form>
        <a href="registerpage.php" class="loginpage-link">Neuen Account erstellen</a>
    </div>
</div>

<!-- Pop-up for error display -->
<div class="popup-overlay" id="popupOverlay">
    <div class="popup-box">
        <p class="popup-title">Ihre Anmeldung konnte aufgrund der folgenden Faktoren nicht durchgeführt werden:</p>
        <ul class="popup-errors" id="popupErrors"></ul>
        <button class="popup-close" id="popupClose">Schließen</button>
    </div>
</div>

<!-- JS for login validation -->
<script src="js/login_validation.js"></script>

<!--Insert Footer-->
<?php
include 'includes/footer.php';
?>