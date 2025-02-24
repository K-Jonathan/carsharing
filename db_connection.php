<?php
$host = "localhost";  // oder "127.0.0.1"
$user = "root";       // Standardnutzer in XAMPP
$pass = "";           // Standardpasswort in XAMPP ist leer
$dbname = "carsharing"; // Deine Datenbankname (anpassen, falls anders)

$conn = new mysqli($host, $user, $pass, $dbname);

// Prüfen, ob die Verbindung klappt
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}
?>