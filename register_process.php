<?php
require_once('db_connection.php'); // Stellt die Verbindung zur Datenbank her
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 🔹 Formulardaten abrufen & sicher machen
    $username = trim($_POST["Benutzername"]);
    $first_name = trim($_POST["Vorname"]);
    $last_name = trim($_POST["name"]);
    $birthdate = trim($_POST["birthdate"]); // Format: YYYY-MM-DD
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $password_repeat = $_POST["password_repeat"];

    // 🔹 Validierung: Prüfen, ob alle Felder ausgefüllt sind
    if (empty($username) || empty($first_name) || empty($last_name) || empty($birthdate) || empty($email) || empty($password) || empty($password_repeat)) {
        die("Bitte fülle alle Felder aus!");
    }

    // 🔹 Validierung: Prüfen, ob das Passwort übereinstimmt
    if ($password !== $password_repeat) {
        die("Die Passwörter stimmen nicht überein!");
    }

    // 🔹 Passwort sicher verschlüsseln
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 🔹 Überprüfung, ob E-Mail oder Benutzername bereits existiert
    $stmt = $conn->prepare("SELECT userid FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Benutzername oder E-Mail existiert bereits!");
    }
    $stmt->close();

    // 🔹 User in die Datenbank einfügen
    $stmt = $conn->prepare("INSERT INTO users (username, first_name, last_name, birthdate, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $first_name, $last_name, $birthdate, $email, $hashed_password);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: loginpage.php?registered=success"); // Erfolgreich → Zur Loginpage umleiten
        exit();
    } else {
        die("Fehler beim Registrieren! Bitte versuche es später erneut.");
    }
}
?>