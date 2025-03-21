<?php
/**
 * Age Verification Endpoint for Car Booking
 * 
 * - Validates that the user is logged in and has a recorded age in session.
 * - Accepts a car ID via POST and retrieves the required minimum age for that car.
 * - Compares the user’s age with the car’s minimum age requirement.
 * - Returns a JSON response:
 *   - "success" if the age requirement is met.
 *   - "error" with a message if any condition fails (e.g. not logged in, invalid car ID, or too young).
 * 
 * This endpoint is designed for use with AJAX to pre-check age restrictions before submitting a booking.
 */
?>
<?php
session_start();
require_once('db_connection.php'); 

if (!isset($_SESSION['userid']) || !isset($_SESSION['age'])) {
    echo json_encode(["status" => "error", "message" => "Sie müssen eingeloggt sein, um zu buchen."]);
    exit;
}

$age = $_SESSION['age'];

if (!isset($_POST['car_id']) || !is_numeric($_POST['car_id'])) {
    echo json_encode(["status" => "error", "message" => "Fehlende Fahrzeugdaten."]);
    exit;
}

$car_id = intval($_POST['car_id']);

$stmt = $conn->prepare("SELECT min_age FROM cars WHERE car_id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

if (!$car) {
    echo json_encode(["status" => "error", "message" => "Fahrzeug nicht gefunden."]);
    exit;
}

$min_age = intval($car['min_age']);

if ($age < $min_age) {
    echo json_encode(["status" => "error", "message" => "Sie haben nicht das nötige Alter, um dieses Fahrzeug zu buchen."]);
    exit();
}

echo json_encode(["status" => "success"]);
exit;
?>