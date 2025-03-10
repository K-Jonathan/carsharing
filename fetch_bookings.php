<?php
require_once('db_connection.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔹 Prüfen, ob der Nutzer eingeloggt ist
if (!isset($_SESSION['userid'])) {
    die("Fehler: Sie müssen eingeloggt sein, um Ihre Buchungen zu sehen.");
}

$userid = $_SESSION['userid'];

// 🔹 SQL-Abfrage: Alle Buchungen des Nutzers abrufen
$sql = "SELECT b.booking_id, c.vendor_name, c.name AS car_name, c.img_file_name, 
               b.booking_time, b.pickup_date, b.pickup_time, b.return_date, b.return_time, c.loc_name
        FROM bookings b
        JOIN cars c ON b.car_id = c.car_id
        WHERE b.userid = ?  -- 🔥 Hier wird der Nutzer-Filter korrekt angewendet
        ORDER BY b.booking_time DESC";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL-Fehler: " . $conn->error);  // 🔥 Debugging-Hilfe, falls SQL-Fehler auftreten
}

// ✅ Bind Param jetzt korrekt: 1 Platzhalter `?`, also nur 1 Variable übergeben
$stmt->bind_param("i", $userid);

$stmt->execute();
$result = $stmt->get_result();

// ✅ Speichern der Buchungen in ein Array
$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

$stmt->close();
$conn->close();
?>