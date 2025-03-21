<?php
/**
 * Location Autocomplete (AJAX Endpoint)
 * 
 * - Handles live search queries for locations.
 * - Accepts a search term (`q`) via GET request.
 * - Sanitizes input to prevent XSS attacks.
 * - Uses a prepared statement to securely query distinct locations (`loc_name`) from the `cars` table.
 * - Returns matching locations as a JSON array for autocomplete suggestions.
 * 
 * This script enables dynamic location search functionality in the booking interface.
 */
?>
<?php
require_once('db_connection.php');

if (isset($_GET['q'])) {
    $search = htmlspecialchars(trim($_GET['q'])) . '%';

    $stmt = $conn->prepare("SELECT DISTINCT loc_name FROM cars WHERE loc_name LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $locations = [];
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row['loc_name'];
    }

    echo json_encode($locations);
}
?>