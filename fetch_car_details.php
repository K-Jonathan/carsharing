<?php
require_once('db_connection.php');

function getCarDetails($car_id) {
    global $conn; 

    $car_id = intval($car_id); // Absicherung gegen SQL-Injection

    if (!$car_id) {
        return null;
    }

    $stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc() ?: null;
}
?>