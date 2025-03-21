<?php
/**
 * Registration Page – User Signup
 * 
 * - Displays a registration form for new users.
 * - Includes input fields for:
 *   - Username, first name, last name, birthdate, email, and password.
 * - Features:
 *   - A password confirmation field for verification.
 *   - A checkbox for agreeing to the privacy policy.
 *   - A styled error popup (`#popupOverlay`) for form validation messages.
 *   - A link to the login page for existing users.
 * - Uses JavaScript (`register_validation.js`) for client-side validation and error handling.
 * - Submits data securely to `register_process.php` for backend processing.
 * - Includes a header and footer for a consistent page layout.
 * 
 * This page ensures a smooth and user-friendly registration experience.
 */
?>

<?php 
include 'includes/header.php';
?>


<div class="registerpage-background"></div>


<div class="registerpage-spacer">

    <div class="registerpage-box">
        <h2 class="loginregisterpage-title">REGISTRIERUNG</h2>
        <form id="registerForm" action="register_process.php" method="POST">

            <label for="Benutzername">Benutzername</label>
            <input class="registerpage-input" type="text" name="Benutzername" id="Benutzername" required>


            <label for="Vorname">Vorname</label>
            <input class="registerpage-input" type="text" name="Vorname" id="Vorname" required>


            <label for="name">Name</label>
            <input class="registerpage-input" type="text" name="name" id="name" required>


            <label for="birthdate">Geburtsdatum</label>
            <input class="registerpage-input" type="date" name="birthdate" id="birthdate" required>
            <span id="birthdateError" class="registerpage-error"></span>


            <label for="email">E-Mail</label>
            <input class="registerpage-input" type="email" name="email" id="email" required>


            <label for="password">Passwort</label>
            <input class="registerpage-input" type="password" name="password" id="password" required>


            <label for="password_repeat">Passwort wiederholen</label>
            <input class="registerpage-input" type="password" name="password_repeat" id="password_repeat" required>


            <button class="loginregisterpage-button" type="submit">REGISTRIEREN</button>
        </form>


        <div class="registerpage-checkbox">
            <input type="checkbox" id="meineCheckbox" class="registerpage-checkbox-input">
            <label for="meineCheckbox">Ich stimme den Datenschutzrichtlinien zu</label>
        </div>


        <a href="Loginpage.php" class="registerpage-link">Bereits registriert? Jetzt einloggen!</a>
    </div>
</div>


<div class="popup-overlay" id="popupOverlay">
    <div class="popup-box">
        <p class="popup-title">Ihr Account konnte aufgrund der folgenden Faktoren nicht erstellt werden:</p>
        <ul class="popup-errors" id="popupErrors"></ul>
        <button class="popup-close" id="popupClose">Schließen</button>
    </div>
</div>


<script src="js/register_validation.js"></script>


<?php 
include 'includes/footer.php';
?>