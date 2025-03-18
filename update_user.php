<?php
require_once('db_connection.php');
session_start();

if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "Sie müssen eingeloggt sein, um Änderungen zu speichern."]);
    exit;
}

$userid = $_SESSION['userid'];
$email = trim($_POST["email"]);
$username = trim($_POST["username"]);
$first_name = trim($_POST["first_name"]);
$last_name = trim($_POST["last_name"]);

$errors = [];

// **🔹 1️⃣ Prüfen, ob alle Felder ausgefüllt sind**
if (empty($email) || empty($username) || empty($first_name) || empty($last_name)) {
    $errors[] = "Alle Felder müssen ausgefüllt sein.";
}

// **🔹 2️⃣ Prüfen, ob die E-Mail eine gültige Adresse ist**
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Bitte geben Sie eine gültige E-Mail-Adresse ein.";
}

// **🔹 3️⃣ Prüfen, ob der Benutzername bereits vergeben ist (außer der eigene)**
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND userid != ?");
$stmt->bind_param("si", $username, $userid);
$stmt->execute();
$stmt->bind_result($userCount);
$stmt->fetch();
$stmt->close();

if ($userCount > 0) {
    $errors[] = "Der Benutzername ist bereits vergeben.";
}

// **🔹 4️⃣ Prüfen, ob die E-Mail bereits vergeben ist (außer der eigene)**
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND userid != ?");
$stmt->bind_param("si", $email, $userid);
$stmt->execute();
$stmt->bind_result($emailCount);
$stmt->fetch();
$stmt->close();

if ($emailCount > 0) {
    $errors[] = "Diese E-Mail-Adresse ist bereits vergeben.";
}

// **🔹 Falls Fehler existieren, sende sie zurück**
if (!empty($errors)) {
    echo json_encode(["status" => "error", "errors" => $errors]);
    exit;
}

// **🔹 5️⃣ Benutzer aktualisieren**
$stmt = $conn->prepare("UPDATE users SET email = ?, username = ?, first_name = ?, last_name = ? WHERE userid = ?");
$stmt->bind_param("ssssi", $email, $username, $first_name, $last_name, $userid);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Änderungen gespeichert!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Fehler beim Speichern der Daten."]);
}
$stmt->close();
?>