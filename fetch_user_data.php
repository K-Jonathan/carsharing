<?php
/**
 * Fetch Logged-In User Data
 * 
 * - Ensures the user is logged in via session.
 * - Retrieves the current user's data from the `users` table using their session `userid`.
 * - Uses a prepared statement to prevent SQL injection.
 * - Stores the result as an associative array in `$user`.
 * - Redirects to login page if user is not authenticated.
 * - Stops execution with error message if no user record is found.
 * 
 * This script is typically included to pre-fill user settings or profile pages.
 */
?>
<?php
require_once('db_connection.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    header("Location: loginpage.php");
    exit();
}

$userid = intval($_SESSION['userid']);

$stmt = $conn->prepare("SELECT * FROM users WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Fehler: Benutzerdaten konnten nicht geladen werden.");
}
?>