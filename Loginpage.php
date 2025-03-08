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
        <form action="login.php" method="POST">
            <label for="Classe">E-Mail/Benutzername</label>
            <input class="loginpage-input" type="email" name="Classe" id="Classe" required>
            <label for="Classf">Passwort</label>
            <input class="loginpage-input" type="password" name="Classf" id="Classf" required>
            <button class="loginregisterpage-button" type="submit">ANMELDEN</button>
        </form>
        <a href="registerpage.php" class="loginpage-link">Neuen Account erstellen</a>
    </div>
</div>


<!--Insert Footer-->
<?php 
include 'includes/footer.php'; // Footer einfügen
?>