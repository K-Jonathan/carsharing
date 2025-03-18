<?php
require_once('db_connection.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// 🔹 Prüfen, ob der Nutzer eingeloggt ist
if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "Fehler: Sie müssen eingeloggt sein, um eine Buchung durchzuführen."]);
    exit();
}

// 🔹 Prüfe, ob `age` gesetzt ist, falls nicht, berechne es erneut
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

// Prüfe, ob die Fahrzeug-ID übergeben wurde
if (!isset($_POST['car_id'])) {
    echo json_encode(["status" => "error", "message" => "Fehlende Fahrzeugdaten."]);
    exit();
}

$car_id = intval($_POST['car_id']);

// 🔹 Mindestalter für das Fahrzeug abrufen
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

// 🔹 Altersprüfung
if ($age >= 25) {
    // ✅ Alles erlaubt
} elseif ($age >= 21 && $min_age <= 21) {
    // ✅ min_age 21 oder 18 erlaubt
} elseif ($age >= 18 && $min_age == 18) {
    // ✅ Nur min_age 18 erlaubt
} else {
    echo json_encode(["status" => "error", "message" => "Sie haben nicht das nötige Alter, um dieses Fahrzeug zu buchen."]);
    exit();
}

// 🔹 Eingaben aus dem Formular holen
$userid = $_SESSION['userid'];
$car_id = isset($_POST['car_id']) ? intval($_POST['car_id']) : null;
$pickup_date = isset($_POST['pickup_date']) ? date("Y-m-d", strtotime($_POST['pickup_date'])) : null;
$pickup_time = isset($_POST['pickup_time']) ? $_POST['pickup_time'] : null;
$return_date = isset($_POST['return_date']) ? date("Y-m-d", strtotime($_POST['return_date'])) : null;
$return_time = isset($_POST['return_time']) ? $_POST['return_time'] : null;
$booking_time = date("Y-m-d H:i:s");

// 🔹 Validierung
if (!$car_id || !$pickup_date || !$pickup_time || !$return_date || !$return_time) {
    echo json_encode(["status" => "error", "message" => "Fehler: Ungültige Buchungsdaten."]);
    exit();
}

// 🔹 Verfügbarkeitsprüfung
$query = "SELECT COUNT(*) AS count FROM bookings 
          WHERE car_id = ? 
          AND (
              (? BETWEEN pickup_date AND return_date) -- Neues Abholdatum liegt innerhalb einer existierenden Buchung
              OR (? BETWEEN pickup_date AND return_date) -- Neues Rückgabedatum liegt innerhalb einer existierenden Buchung
              OR (pickup_date BETWEEN ? AND ?) -- Existierende Buchung beginnt innerhalb des neuen Zeitraums
              OR (return_date BETWEEN ? AND ?) -- Existierende Buchung endet innerhalb des neuen Zeitraums
              OR (pickup_date <= ? AND return_date >= ?) -- Existierende Buchung umfasst den gesamten neuen Zeitraum
          )";

$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Fehler in der SQL-Query: " . $conn->error]);
    exit();
}

$stmt->bind_param("issssssss", $car_id, 
                  $pickup_date, $return_date, 
                  $pickup_date, $return_date, 
                  $pickup_date, $return_date, 
                  $pickup_date, $return_date);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// 🛑 Falls das Auto bereits im gewählten Zeitraum gebucht wurde, keine Buchung erlauben!
if ($row['count'] > 0) {
    echo json_encode(["status" => "error", "message" => "Dieses Auto ist im gewählten Zeitraum bereits gebucht!"]);
    exit();
}

// Falls Verfügbarkeitsprüfung erfolgreich war, Buchung speichern
$sql = "INSERT INTO bookings (userid, car_id, booking_time, pickup_date, pickup_time, return_date, return_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Fehler in der SQL-Query: " . $conn->error]);
    exit();
}

$stmt->bind_param("iisssss", $userid, $car_id, $booking_time, $pickup_date, $pickup_time, $return_date, $return_time);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Buchung erfolgreich!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Fehler: Die Buchung konnte nicht gespeichert werden."]);
}
?>