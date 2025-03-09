<!--Insert Header-->
<?php 
include 'includes/header.php'; // Header einfügen
?>

<!-- Hintergrund für die Login-Seite -->
<div class="loginpage-background"></div>

<!-- Unsichtbarer Positionierungs-Spacer -->
<div class="loginpage-spacer">
    <!-- Weiße abgerundete Box für das Login-Formular -->
    <div class="loginpage-box">
        <h2 class="loginregisterpage-title">LOGIN</h2>
        <form id="loginForm">
            <label for="Classe">E-Mail/Benutzername</label>
            <input class="loginpage-input" type="text" name="Classe" id="Classe" required>
            
            <label for="Classf">Passwort</label>
            <input class="loginpage-input" type="password" name="Classf" id="Classf" required>
            
            <button class="loginregisterpage-button" type="submit">ANMELDEN</button>
        </form>

        <a href="registerpage.php" class="loginpage-link">Neuen Account erstellen</a>
    </div>
</div>

<!-- ❌ Pop-up für Fehleranzeige -->
<div class="popup-overlay" id="popupOverlay">
    <div class="popup-box">
        <p class="popup-title">Ihre Anmeldung konnte aufgrund der folgenden Faktoren nicht durchgeführt werden:</p>
        <ul class="popup-errors" id="popupErrors"></ul>
        <button class="popup-close" id="popupClose">Schließen</button>
    </div>
</div>

<!-- JS für Login-Validierung -->
<script src="js/login_validation.js"></script>

<!--Insert Footer-->
<?php 
include 'includes/footer.php'; // Footer einfügen
?>