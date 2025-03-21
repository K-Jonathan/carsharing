<?php
/**
 * User Session Check
 * 
 * - Starts the session if not already active.
 * - Checks if a user is logged in by verifying the `userid` session variable.
 * - Defines:
 *   - `$logged_in`: Boolean flag indicating login status.
 *   - `$userid`: User ID if logged in, otherwise `null`.
 *   - `$username`: Username if logged in, otherwise "Gast".
 * 
 * This script is useful for determining authentication status in various pages.
 */
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$logged_in = isset($_SESSION["userid"]);
$userid = $logged_in ? $_SESSION["userid"] : null;
$username = $logged_in ? $_SESSION["username"] : "Gast";
?>