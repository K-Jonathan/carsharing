<!--* This script validates if a logged-in user meets the age requirement to book a specific car.
 * It checks if the user session is valid and the car ID is provided,
 * fetches the car's minimum age requirement from the database,
 * and compares it with the user's age from the session.
 * Returns a JSON response indicating success or an appropriate error message.-->
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