<?php
require_once('db_connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST["Benutzername"]));
    $first_name = htmlspecialchars(trim($_POST["Vorname"]));
    $last_name = htmlspecialchars(trim($_POST["name"]));
    $birthdate = htmlspecialchars(trim($_POST["birthdate"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = $_POST["password"];
    $password_repeat = $_POST["password_repeat"];

    if (empty($username) || empty($first_name) || empty($last_name) || empty($birthdate) || empty($email) || empty($password) || empty($password_repeat)) {
        die("Bitte fülle alle Felder aus!");
    }

    if ($password !== $password_repeat) {
        die("Die Passwörter stimmen nicht überein!");
    }

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
        header("Location: loginpage.php?registered=success");
        exit();
    } else {
        die("Fehler beim Registrieren! Bitte versuche es später erneut.");
    }
}
?>