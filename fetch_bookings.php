<?php
require_once('db_connection.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    die("Fehler: Sie müssen eingeloggt sein, um Ihre Buchungen zu sehen.");
}

$userid = intval($_SESSION['userid']);
$today = date("Y-m-d");

$sql = "SELECT b.booking_id, c.vendor_name, c.name AS car_name, c.img_file_name, 
               b.booking_time, b.pickup_date, b.pickup_time, b.return_date, b.return_time, c.loc_name
        FROM bookings b
        JOIN cars c ON b.car_id = c.car_id
        WHERE b.userid = ?  
        ORDER BY b.pickup_date ASC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL-Fehler: " . $conn->error);
}

$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

$futureBookings = [];
$pastBookings = [];

while ($row = $result->fetch_assoc()) {
    if ($row['pickup_date'] > $today) {
        $futureBookings[] = $row;
    } else {
        $pastBookings[] = $row;
    }
}

$stmt->close();
$conn->close();

echo json_encode(["future" => $futureBookings, "past" => $pastBookings]);
?>