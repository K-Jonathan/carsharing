<?php
require_once('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔹 Prüfen, ob der Nutzer eingeloggt ist
if (!isset($_SESSION['userid'])) {
    die("Fehler: Sie müssen eingeloggt sein, um eine Buchung durchzuführen.");
}

// 🔹 Eingaben aus dem Formular holen
$userid = $_SESSION['userid'];
$car_id = isset($_POST['car_id']) ? intval($_POST['car_id']) : null;
$pickup_date = isset($_POST['pickup_date']) ? date("Y-m-d", strtotime($_POST['pickup_date'])) : null;
$pickup_time = isset($_POST['pickup_time']) ? $_POST['pickup_time'] : null;
$return_date = isset($_POST['return_date']) ? date("Y-m-d", strtotime($_POST['return_date'])) : null;
$return_time = isset($_POST['return_time']) ? $_POST['return_time'] : null;
$booking_time = date("Y-m-d H:i:s"); // 🔥 Aktuelles Datum & Uhrzeit

// 🔹 Validierung: Alle Werte müssen vorhanden sein
if (!$car_id || !$pickup_date || !$pickup_time || !$return_date || !$return_time) {
    die("Fehler: Ungültige Buchungsdaten.");
}

// 🔹 SQL-Abfrage zur Speicherung der Buchung
$sql = "INSERT INTO bookings (userid, car_id, booking_time, pickup_date, pickup_time, return_date, return_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisssss", $userid, $car_id, $booking_time, $pickup_date, $pickup_time, $return_date, $return_time);

if ($stmt->execute()) {
    // ✅ Buchung erfolgreich → Weiterleitung zur Buchungsseite
    header("Location: bookings.php");
    exit();
} else {
    die("Fehler: Die Buchung konnte nicht gespeichert werden.");
}
?>