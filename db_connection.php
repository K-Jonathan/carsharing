<?php
$host = "localhost";  // oder "127.0.0.1"
$user = "root";       // Standardnutzer in XAMPP
$pass = "";           // Standardpasswort in XAMPP ist leer
$dbname = "carsharing"; // Deine Datenbankname (anpassen, falls anders)

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Aktiviert Exceptions für mysqli-Fehler

try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    $conn->set_charset("utf8mb4"); // Stellt sicher, dass die Kodierung korrekt ist
} catch (Exception $e) {
    die("Verbindungsfehler: " . $e->getMessage());
}
?>