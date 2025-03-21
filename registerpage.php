<!--
This is the "Registration" page for Flamin-Go!, where new users can create an account to access booking and profile features.

🧾 Structure:
- Standard layout with shared header and footer includes.
- Background and layout styled using `registerpage-background` and `registerpage-spacer`.

📝 Registration Form:
- Input Fields:
  - Username
  - First name (`Vorname`)
  - Last name (`Name`)
  - Date of birth (with age validation)
  - Email address
  - Password + Password confirmation
- All fields are required and styled using `registerpage-input`.
- Submits via `POST` to `register_process.php`.

📜 Privacy Consent:
- Includes a checkbox to confirm agreement with data protection policies.
- Must be checked before account creation is accepted.

🔁 Navigation:
- A link below the form allows users who already have an account to log in (`Loginpage.php`).

⚠️ Error Feedback:
- Pop-up modal (`#popupOverlay`) is triggered by JavaScript on validation failure.
- Dynamically lists issues such as invalid names, underage users, password mismatch, or duplicate usernames/emails.

🧠 JavaScript:
- Validation and AJAX submission handled via `register_validation.js`.
- Checks data formats, age restriction (18+), password match, checkbox agreement, and uniqueness via backend calls.

Overall, this page provides a secure, user-friendly, and legally compliant onboarding experience with real-time error handling.
-->
<!--Insert Header-->
<?php
include 'includes/header.php';
?>

<!-- Background for the registration page -->
<div class="registerpage-background"></div>

<!-- Invisible positioning spacer -->
<div class="registerpage-spacer">
    <!-- White rounded box for the registration form -->
    <div class="registerpage-box">
        <h2 class="loginregisterpage-title">REGISTRIERUNG</h2>
        <form id="registerForm" action="register_process.php" method="POST">
            <!-- User name -->
            <label for="Benutzername">Benutzername</label>
            <input class="registerpage-input" type="text" name="Benutzername" id="Benutzername" required>

            <!-- First name -->
            <label for="Vorname">Vorname</label>
            <input class="registerpage-input" type="text" name="Vorname" id="Vorname" required>

            <!-- Surname-->
            <label for="name">Name</label>
            <input class="registerpage-input" type="text" name="name" id="name" required>

            <!-- Date of birth -->
            <label for="birthdate">Geburtsdatum</label>
            <input class="registerpage-input" type="date" name="birthdate" id="birthdate" required>
            <span id="birthdateError" class="registerpage-error"></span>

            <!-- E-Mail -->
            <label for="email">E-Mail</label>
            <input class="registerpage-input" type="email" name="email" id="email" required>

            <!-- Passwort -->
            <label for="password">Passwort</label>
            <input class="registerpage-input" type="password" name="password" id="password" required>

            <!-- Repeat password-->
            <label for="password_repeat">Passwort wiederholen</label>
            <input class="registerpage-input" type="password" name="password_repeat" id="password_repeat" required>

            <!-- Register button -->
            <button class="loginregisterpage-button" type="submit">REGISTRIEREN</button>
        </form>

        <!-- Checkbox for privacy policy -->
        <div class="registerpage-checkbox">
            <input type="checkbox" id="meineCheckbox" class="registerpage-checkbox-input">
            <label for="meineCheckbox">Ich stimme den Datenschutzrichtlinien zu</label>
        </div>

        <!-- Link to the login page -->
        <a href="Loginpage.php" class="registerpage-link">Bereits registriert? Jetzt einloggen!</a>
    </div>
</div>

<!-- Pop-up for error display -->
<div class="popup-overlay" id="popupOverlay">
    <div class="popup-box">
        <p class="popup-title">Ihr Account konnte aufgrund der folgenden Faktoren nicht erstellt werden:</p>
        <ul class="popup-errors" id="popupErrors"></ul>
        <button class="popup-close" id="popupClose">Schließen</button>
    </div>
</div>

<!--Insert of JS for Errors and Validation-->
<script src="js/register_validation.js"></script>

<!--Insert Footer-->
<?php
include 'includes/footer.php';
?>