<?php
require_once('db_connection.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "Nicht eingeloggt."]);
    exit();
}

$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : null;
$userid = $_SESSION['userid'];

if (!$booking_id) {
    echo json_encode(["status" => "error", "message" => "Ungültige Buchungs-ID."]);
    exit();
}

// 🔹 Buchungsdetails sicher abrufen
$stmt = $conn->prepare("
    SELECT b.*, c.vendor_name, c.name AS car_name, c.img_file_name, 
           c.gear, c.doors, c.seats, c.drive, c.min_age, c.price, 
           c.air_condition, c.gps, c.trunk 
    FROM bookings b
    JOIN cars c ON b.car_id = c.car_id
    WHERE b.booking_id = ? AND b.userid = ?
");
$stmt->bind_param("ii", $booking_id, $userid);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

$stmt->close();
$conn->close();

if (!$booking) {
    echo json_encode(["status" => "error", "message" => "Buchung nicht gefunden oder nicht erlaubt."]);
    exit();
}

echo json_encode(["status" => "success", "data" => $booking]);
exit();
?>