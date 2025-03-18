<?php
session_start();
require_once('db_connection.php'); 

// Prüfe, ob der Nutzer eingeloggt ist
if (!isset($_SESSION['userid']) || !isset($_SESSION['age'])) {
    echo json_encode(["status" => "error", "message" => "Sie müssen eingeloggt sein, um zu buchen."]);
    exit;
}

$age = $_SESSION['age']; // Alter aus der Session holen

// Prüfe, ob die Fahrzeug-ID übergeben wurde
if (!isset($_POST['car_id'])) {
    echo json_encode(["status" => "error", "message" => "Fehlende Fahrzeugdaten."]);
    exit;
}

$car_id = intval($_POST['car_id']);

// Mindestalter für das Fahrzeug aus der Datenbank abrufen
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

// Altersprüfung
if ($age >= 25) {
    echo json_encode(["status" => "success"]); // ✅ Alles erlaubt
} elseif ($age >= 21 && $min_age <= 21) {
    echo json_encode(["status" => "success"]); // ✅ 21-24 Jahre -> min_age 21 oder 18 erlaubt
} elseif ($age >= 18 && $min_age == 18) {
    echo json_encode(["status" => "success"]); // ✅ 18-20 Jahre -> nur min_age 18 erlaubt
} else {
    echo json_encode(["status" => "error", "message" => "Sie haben nicht das nötige Alter, um dieses Fahrzeug zu buchen."]);
}
exit;
?>