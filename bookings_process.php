<?php
/**
 * Booking Submission Handler
 * 
 * - Handles booking requests for logged-in users.
 * - Verifies user session and calculates age based on birthdate (if not already set).
 * - Checks if the user meets the minimum age requirement for the selected car.
 * - Validates booking input (car ID, pickup and return dates/times).
 * - Checks for booking conflicts in the specified time range.
 * - Inserts the new booking into the database if validations pass.
 * - Returns a JSON response with the booking status and message.
 * 
 * This script ensures valid and conflict-free bookings with age and session checks.
 */
?>
<?php
require_once('db_connection.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "Fehler: Sie müssen eingeloggt sein, um eine Buchung durchzuführen."]);
    exit();
}

if (!isset($_SESSION['age']) && isset($_SESSION['birthdate'])) {
    $birthdate = new DateTime($_SESSION['birthdate']);
    $currentDate = new DateTime();
    $_SESSION['age'] = $currentDate->diff($birthdate)->y;
}

if (!isset($_SESSION['age'])) {
    echo json_encode(["status" => "error", "message" => "Fehler: Altersprüfung konnte nicht durchgeführt werden."]);
    exit();
}

$age = $_SESSION['age'];

if (!isset($_POST['car_id'])) {
    echo json_encode(["status" => "error", "message" => "Fehlende Fahrzeugdaten."]);
    exit();
}

$car_id = intval($_POST['car_id']);

$stmt = $conn->prepare("SELECT min_age FROM cars WHERE car_id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

if (!$car) {
    echo json_encode(["status" => "error", "message" => "Fahrzeug nicht gefunden."]);
    exit();
}

$min_age = intval($car['min_age']);

if ($age < $min_age) {
    echo json_encode(["status" => "error", "message" => "Sie haben nicht das nötige Alter, um dieses Fahrzeug zu buchen."]);
    exit();
}


$userid = $_SESSION['userid'];
$pickup_date = isset($_POST['pickup_date']) ? htmlspecialchars(trim($_POST['pickup_date'])) : null;
$pickup_time = isset($_POST['pickup_time']) ? htmlspecialchars(trim($_POST['pickup_time'])) : null;
$return_date = isset($_POST['return_date']) ? htmlspecialchars(trim($_POST['return_date'])) : null;
$return_time = isset($_POST['return_time']) ? htmlspecialchars(trim($_POST['return_time'])) : null;
$booking_time = date("Y-m-d H:i:s");

if (!$car_id || !$pickup_date || !$pickup_time || !$return_date || !$return_time) {
    echo json_encode(["status" => "error", "message" => "Fehler: Ungültige Buchungsdaten."]);
    exit();
}


$query = "SELECT COUNT(*) AS count FROM bookings 
          WHERE car_id = ? 
          AND (
              (? BETWEEN pickup_date AND return_date)
              OR (? BETWEEN pickup_date AND return_date)
              OR (pickup_date BETWEEN ? AND ?)
              OR (return_date BETWEEN ? AND ?)
              OR (pickup_date <= ? AND return_date >= ?)
          )";

$stmt = $conn->prepare($query);
$stmt->bind_param("issssssss", $car_id, 
                  $pickup_date, $return_date, 
                  $pickup_date, $return_date, 
                  $pickup_date, $return_date, 
                  $pickup_date, $return_date);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo json_encode(["status" => "error", "message" => "Dieses Auto ist im gewählten Zeitraum bereits gebucht!"]);
    exit();
}


$sql = "INSERT INTO bookings (userid, car_id, booking_time, pickup_date, pickup_time, return_date, return_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iisssss", $userid, $car_id, $booking_time, $pickup_date, $pickup_time, $return_date, $return_time);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Buchung erfolgreich!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Fehler: Die Buchung konnte nicht gespeichert werden."]);
}
?>