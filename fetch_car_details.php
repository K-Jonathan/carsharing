<?php
/*
This script defines a function `getCarDetails($car_id)` that retrieves detailed information  
about a specific car from the database using its ID.  
- It includes the database connection.  
- The car ID is typecast to an integer to prevent SQL injection.  
- If the ID is invalid or missing, the function returns `null`.  
- A prepared SQL statement is used to securely fetch car data from the `cars` table.  
- Returns an associative array with the car's details or `null` if no match is found.
*/
require_once('db_connection.php');

function getCarDetails($car_id) {
    global $conn; 

    $car_id = intval($car_id); // Protection against SQL injection

    // If the car ID is invalid
    if (!$car_id) {
        return null;
    }

    // Bind the car ID as an integer parameter
    $stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc() ?: null;
}
?>