<?php
/**
 * Logout Page – Session Termination
 * 
 * - Destroys the user session, logging them out.
 * - Displays a confirmation message with a friendly "Goodbye" design.
 * - Includes:
 *   - A background image for branding.
 *   - A styled message box with a waving hand icon.
 *   - A footer and header for consistent layout.
 * - Uses JavaScript (`redirect.js`) to handle automatic redirection after logout.
 * 
 * This page ensures a smooth logout experience while keeping users engaged.
 */
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

session_unset();
session_destroy();
?>
 

<?php include("includes/header.php"); ?>
 

<div class="background-static Logout-bg-image"></div>


<div class="static-spacer">

    <div class="Logout-box">

        <div class="Logout-container">

            <img src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/images/Handwave.png" alt="Handwave" class="logout-icon">
 

            <h1 class="logout-title">Bis bald!</h1>
            <p class="logout-text">
                Du wurdest erfolgreich ausgeloggt. Komm jederzeit zurück, deine Buchungen warten auf dich!
            </p>
        </div>
    </div>  
</div>
 

<?php include("includes/footer.php"); ?>
 

<script src="js/redirect.js"></script>