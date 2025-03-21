<!--
🚪 logout.php – User Logout Script

This script handles **user logout** by terminating the session and clearing all stored session data.

🛠 Key Steps:
1. **Check if a session is active** → `session_status()`
2. **Delete all session variables** → `session_unset()`
3. **Destroy the session** → `session_destroy()`
4. Render a **logout confirmation page** with:
   - A background image
   - A farewell message
   - A handwave icon
   - A message informing users their bookings are saved

🔄 Automatic Redirection:
- Includes `redirect.js`, which handles automatic forwarding after logout.

📌 UI/UX:
- Encourages users to return and reassures them their bookings are saved.
-->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Delete Session Data
session_unset();
session_destroy();
?>
 
<!-- Insert Header -->
<?php include("includes/header.php"); ?>
 
<!-- Background for page -->
<div class="background-static Logout-bg-image"></div>
 
<!-- Invisible Positioning Spacer -->
<div class="static-spacer">
    <!-- Box for Logout-Text -->
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
 
<!-- JavaScript automatic forwarding -->
<script src="js/redirect.js"></script>