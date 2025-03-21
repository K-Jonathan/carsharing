<?php
/**
 * User Session Refresh (AJAX Endpoint)
 * 
 * - Ensures the user is logged in before proceeding.
 * - Fetches the latest user data (`username`, `email`, `birthdate`) from the database.
 * - Recalculates the user's age based on the stored birthdate.
 * - Updates the session with the new values.
 * - Returns a JSON response:
 *   - `"status": "success"` if the session was updated.
 *   - `"status": "error"` if the user is not logged in.
 * 
 * This script ensures session consistency after profile updates.
 */
?>
<?php
require_once('db_connection.php');
session_start();

if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "Sie müssen eingeloggt sein."]);
    exit;
}

$userid = intval($_SESSION['userid']);


$stmt = $conn->prepare("SELECT username, email, birthdate FROM users WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($new_username, $new_email, $new_birthdate);
$stmt->fetch();
$stmt->close();


$new_birthdateObj = DateTime::createFromFormat('Y-m-d', $new_birthdate);
$today = new DateTime();
$new_age = $today->diff($new_birthdateObj)->y;


$_SESSION["username"] = $new_username;
$_SESSION["email"] = $new_email;
$_SESSION["birthdate"] = $new_birthdate;
$_SESSION["age"] = $new_age;

echo json_encode(["status" => "success", "message" => "Session aktualisiert."]);
?>