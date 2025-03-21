<?php
/**
 * This script updates a user's profile information in a MySQL database.
 * 
 * - Requires an active session with a logged-in user.
 * - Validates and sanitizes user input (email, username, first name, last name, and optional birthdate).
 * - Checks if the username or email is already taken by another user.
 * - Ensures the birthdate (if provided) follows the YYYY-MM-DD format.
 * - Updates the user's profile in the database if all validations pass.
 * - Returns a JSON response indicating success or errors.
 * 
 * Dependencies:
 * - Requires 'db_connection.php' for database access.
 */
?>
<?php
require_once('db_connection.php');
session_start();

if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "Sie müssen eingeloggt sein, um Änderungen zu speichern."]);
    exit;
}

$userid = intval($_SESSION['userid']);
$email = htmlspecialchars(trim($_POST["email"]));
$username = htmlspecialchars(trim($_POST["username"]));
$first_name = htmlspecialchars(trim($_POST["first_name"]));
$last_name = htmlspecialchars(trim($_POST["last_name"]));
$birthdate = isset($_POST["birthdate"]) ? trim($_POST["birthdate"]) : null;

$errors = [];

// Check mandatory fields
if (empty($email) || empty($username) || empty($first_name) || empty($last_name)) {
    $errors[] = "Alle Felder müssen ausgefüllt sein.";
}

// validate E-Mail-Adress
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Bitte geben Sie eine gültige E-Mail-Adresse ein.";
}

// If Birthdate is set, check correct formating 
if (!empty($birthdate)) {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthdate)) {
        $errors[] = "Das Geburtsdatum muss im Format YYYY-MM-DD eingegeben werden.";
    } else {
        $dateObj = DateTime::createFromFormat('Y-m-d', $birthdate);
        if (!$dateObj) {
            $errors[] = "Ungültiges Datumsformat für das Geburtsdatum.";
        }
    }
}

// Check if Username is existent
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND userid != ?");
$stmt->bind_param("si", $username, $userid);
$stmt->execute();
$stmt->bind_result($userCount);
$stmt->fetch();
$stmt->close();

if ($userCount > 0) {
    $errors[] = "Der Benutzername ist bereits vergeben.";
}

// Check if Email is already existent
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND userid != ?");
$stmt->bind_param("si", $email, $userid);
$stmt->execute();
$stmt->bind_result($emailCount);
$stmt->fetch();
$stmt->close();

if ($emailCount > 0) {
    $errors[] = "Diese E-Mail-Adresse ist bereits vergeben.";
}

// If error is present, is back
if (!empty($errors)) {
    echo json_encode(["status" => "error", "errors" => $errors]);
    exit;
}

// Update User 
$stmt = $conn->prepare("UPDATE users SET email = ?, username = ?, first_name = ?, last_name = ?, birthdate = ? WHERE userid = ?");
$stmt->bind_param("sssssi", $email, $username, $first_name, $last_name, $birthdate, $userid);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Änderungen gespeichert!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Fehler beim Speichern der Daten."]);
}
$stmt->close();
?>