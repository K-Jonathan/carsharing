<?php
require_once('db_connection.php');
session_start();

if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "Sie müssen eingeloggt sein."]);
    exit;
}

$userid = intval($_SESSION['userid']);

// 🔹 Neue Benutzerdaten aus der Datenbank abrufen
$stmt = $conn->prepare("SELECT username, email, birthdate FROM users WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($new_username, $new_email, $new_birthdate);
$stmt->fetch();
$stmt->close();

// 🔹 Alter neu berechnen
$new_birthdateObj = DateTime::createFromFormat('Y-m-d', $new_birthdate);
$today = new DateTime();
$new_age = $today->diff($new_birthdateObj)->y;

// 🔹 Session aktualisieren
$_SESSION["username"] = $new_username;
$_SESSION["email"] = $new_email;
$_SESSION["birthdate"] = $new_birthdate;
$_SESSION["age"] = $new_age;

echo json_encode(["status" => "success", "message" => "Session aktualisiert."]);
?>