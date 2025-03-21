<?php
/**
 * Get Car Details by ID
 * 
 * - Retrieves all available information for a car from the `cars` table using its `car_id`.
 * - Uses a prepared statement to protect against SQL injection.
 * - Returns an associative array with car data if found, or `null` otherwise.
 * - Requires an active database connection (`$conn`).
 * 
 * This utility function is used across pages where car-specific information is needed.
 */
?>
<?php
require_once('db_connection.php');

function getCarDetails($car_id) {
    global $conn; 

    $car_id = intval($car_id); 

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