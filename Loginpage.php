<?php
/**
 * Login Page – User Authentication
 * 
 * - Displays a login form for users to authenticate via email or username.
 * - Includes:
 *   - Hidden input field to redirect users after login.
 *   - Input fields for credentials (email/username and password).
 *   - "Create Account" link for new users.
 * - Features an error popup (`#popupOverlay`) to display validation messages.
 * - Uses JavaScript (`login_validation.js`) for client-side validation and AJAX login handling.
 * - Includes a header and footer for consistent site design.
 * 
 * This page is designed for secure and user-friendly authentication.
 */
?>

<?php 
include 'includes/header.php'; 
?>


<div class="loginpage-background"></div>


<div class="loginpage-spacer">

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


<div class="popup-overlay" id="popupOverlay">
    <div class="popup-box">
        <p class="popup-title">Ihre Anmeldung konnte aufgrund der folgenden Faktoren nicht durchgeführt werden:</p>
        <ul class="popup-errors" id="popupErrors"></ul>
        <button class="popup-close" id="popupClose">Schließen</button>
    </div>
</div>


<script src="js/login_validation.js"></script>


<?php 
include 'includes/footer.php';
?>