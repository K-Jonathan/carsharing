<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// 🔹 Alle Session-Daten löschen
session_unset();
session_destroy();
?>
 
<!-- Insert Header -->
<?php include("includes/header.php"); ?>
 
<!-- Hintergrundbild für die Logout-Seite -->
<div class="background-static Logout-bg-image"></div>
 
<!-- Unsichtbarer Positionierungs-Spacer -->
<div class="static-spacer">
    <!-- Box für den Logout-Text -->
    <div class="Logout-box">
        <!-- Logout-Container -->
        <div class="Logout-container">
            <!-- Handwave Icon -->
            <img src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/images/Handwave.png" alt="Handwave" class="logout-icon">
 
            <!-- Text -->
            <h1 class="logout-title">Bis bald!</h1>
            <p class="logout-text">
                Du wurdest erfolgreich ausgeloggt. Komm jederzeit zurück, deine Buchungen warten auf dich!
            </p>
        </div>
    </div>  
</div>
 
<!-- Insert Footer -->
<?php include("includes/footer.php"); ?>
 
<!-- JavaScript für die automatische Weiterleitung -->
<script src="js/redirect.js"></script>