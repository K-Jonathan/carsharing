<?php
require_once('db_connection.php');

function getCarDetails($car_id) {
    global $conn; // Verbindung zur Datenbank

    if (!$car_id) {
        return null;
    }

    // 🔹 Auto-Details aus der Datenbank abrufen
    $stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc() ?: null;
}
?>