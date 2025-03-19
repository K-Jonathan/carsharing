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

$errors = [];

if (empty($email) || empty($username) || empty($first_name) || empty($last_name)) {
    $errors[] = "Alle Felder müssen ausgefüllt sein.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Bitte geben Sie eine gültige E-Mail-Adresse ein.";
}

// 🔹 Benutzername prüfen
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND userid != ?");
$stmt->bind_param("si", $username, $userid);
$stmt->execute();
$stmt->bind_result($userCount);
$stmt->fetch();
$stmt->close();

if ($userCount > 0) {
    $errors[] = "Der Benutzername ist bereits vergeben.";
}

// 🔹 E-Mail prüfen
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND userid != ?");
$stmt->bind_param("si", $email, $userid);
$stmt->execute();
$stmt->bind_result($emailCount);
$stmt->fetch();
$stmt->close();

if ($emailCount > 0) {
    $errors[] = "Diese E-Mail-Adresse ist bereits vergeben.";
}

if (!empty($errors)) {
    echo json_encode(["status" => "error", "errors" => $errors]);
    exit;
}

// 🔹 Benutzer aktualisieren
$stmt = $conn->prepare("UPDATE users SET email = ?, username = ?, first_name = ?, last_name = ? WHERE userid = ?");
$stmt->bind_param("ssssi", $email, $username, $first_name, $last_name, $userid);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Änderungen gespeichert!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Fehler beim Speichern der Daten."]);
}
$stmt->close();
?>