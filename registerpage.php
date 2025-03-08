<!--Insert Header-->
<?php 
include 'includes/header.php'; // Header einfügen
?>


<!-- Hintergrund für die Registrierungsseite -->
<div class="registerpage-background"></div>

<!-- Unsichtbarer Positionierungs-Spacer -->
<div class="registerpage-spacer">
    <!-- Weiße abgerundete Box für das Registrierungsformular -->
    <div class="registerpage-box">
        <h2 class="loginregisterpage-title">REGISTRIERUNG</h2>
        <form action="/Car-rental/register.php" method="POST">
            <!-- Benutzername -->
            <label for="Benutzername">Benutzername</label>
            <input class="registerpage-input" type="text" name="Benutzername" id="Benutzername" required>

            <!-- Vorname -->
            <label for="Vorname">Vorname</label>
            <input class="registerpage-input" type="text" name="Vorname" id="Vorname" required>

            <!-- Nachname -->
            <label for="name">Name</label>
            <input class="registerpage-input" type="text" name="name" id="name" required>

            <!-- Geburtsdatum -->
            <label for="birthdate">Geburtsdatum</label>
            <input class="registerpage-input" type="date" name="birthdate" id="birthdate" required>
            <span id="birthdateError" class="registerpage-error"></span>

            <!-- E-Mail -->
            <label for="email">E-Mail</label>
            <input class="registerpage-input" type="email" name="email" id="email" required>
            <span id="emailError" class="registerpage-error"></span>

            <!-- Passwort -->
            <label for="password">Passwort</label>
            <input class="registerpage-input" type="password" name="password" id="password" required>

            <!-- Passwort wiederholen -->
            <label for="password_repeat">Passwort wiederholen</label>
            <input class="registerpage-input" type="password" name="password_repeat" id="password_repeat" required>
            <span id="passwordError" class="registerpage-error"></span>

            <!-- Registrieren-Button -->
            <button class="loginregisterpage-button" type="submit">REGISTRIEREN</button>
        </form>

        <!-- Checkbox für Datenschutzrichtlinien -->
        <div class="registerpage-checkbox">
            <input type="checkbox" id="meineCheckbox" class="registerpage-checkbox-input">
            <label for="meineCheckbox">Ich stimme den Datenschutzrichtlinien zu</label>
        </div>

        <!-- Link zur Login-Seite -->
        <a href="Loginpage.php" class="registerpage-link">Bereits registriert? Jetzt einloggen!</a>
    </div>
</div>

<!--Insert of JS for Errors and Validation-->
<script src="js/validation.js"></script>


<!--Insert Footer-->
<?php 
include 'includes/footer.php'; // Footer einfügen
?>