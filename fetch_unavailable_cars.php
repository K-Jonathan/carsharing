<?php
/*
This script retrieves available cars based on user-selected search criteria and session data.  
- It includes the database connection file and ensures a session is started.  
- The search location is retrieved from the session; if unavailable, an empty JSON response is returned.  
- The script converts German date formats (DD.MM.YY) to SQL-compatible "YYYY-MM-DD" format.  
- It checks for car availability by filtering out already booked cars for the selected time period.  
- Various filters (car type, gear, vendor, doors, seats, drive type, minimum age, trunk size, price, air conditioning, GPS)  
  are applied securely through prepared statements.  
- Sorting options for price are validated and applied safely.  
- The SQL query retrieves filtered car data, groups results by car model, and marks fully booked cars.  
- Finally, the data is returned as a JSON response for use in frontend applications.  
*/

// Include the database connection file
require_once('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get location from session
$location = isset($_SESSION['search-location']) ? htmlspecialchars(trim($_SESSION['search-location'])) : null;
if (!$location) {
    echo json_encode(["cars" => []]);
    exit;
}

// Initialize query parameters
$params = [$location];
$types = "s";
$whereClauses = ["c.loc_name = ?"];

// If date has been set Perform booking check
$pickupDate = isset($_SESSION['pickupDate']) ? htmlspecialchars(trim($_SESSION['pickupDate'])) : null;
$returnDate = isset($_SESSION['returnDate']) ? htmlspecialchars(trim($_SESSION['returnDate'])) : null;
$pickupDateSQL = $returnDateSQL = null;

// Convert dates from DD.MM.YY to YYYY-MM-DD format
if ($pickupDate && $returnDate && $pickupDate !== 'Datum' && $returnDate !== 'Datum') {
    if (preg_match('/(\d{2})\.(\d{2})\.(\d{2})/', $pickupDate, $matches)) {
        $pickupDateSQL = "20" . $matches[3] . "-" . $matches[2] . "-" . $matches[1];
    }
    if (preg_match('/(\d{2})\.(\d{2})\.(\d{2})/', $returnDate, $matches)) {
        $returnDateSQL = "20" . $matches[3] . "-" . $matches[2] . "-" . $matches[1];
    }
    
    // Exclude cars that are already booked during the selected period
    $whereClauses[] = "
        c.car_id IN (
            SELECT DISTINCT b.car_id FROM bookings b
            WHERE 
                (b.pickup_date <= ? AND b.return_date >= ?) 
                OR 
                (b.pickup_date BETWEEN ? AND ?) 
                OR 
                (b.return_date BETWEEN ? AND ?)
        )";
    
    array_push($params, $returnDateSQL, $pickupDateSQL, $pickupDateSQL, $returnDateSQL, $pickupDateSQL, $returnDateSQL);
    $types .= "ssssss";
} else {
    echo json_encode(["cars" => []]);
    exit;
}

//Filter function with protection
function applyFilter($paramName, $columnName, $typeChar) {
    global $whereClauses, $params, $types;
    
    if (!empty($_GET[$paramName])) {
        $values = explode(",", htmlspecialchars(trim($_GET[$paramName])));
        $placeholders = implode(",", array_fill(0, count($values), "?"));
        $whereClauses[] = "c.$columnName IN ($placeholders)";
        $params = array_merge($params, $values);
        $types .= str_repeat($typeChar, count($values));
    }
}

// Use filters safely
applyFilter("type", "type", "s");
applyFilter("gear", "gear", "s");
applyFilter("vendor", "vendor_name", "s");
applyFilter("doors", "doors", "i");
applyFilter("seats", "seats", "i");
applyFilter("drive", "drive", "s");
applyFilter("min_age", "min_age", "i");
applyFilter("trunk", "trunk", "s");

// Price filter
if (!empty($_GET['max_price']) && is_numeric($_GET['max_price'])) {
    $whereClauses[] = "c.price <= ?";
    $params[] = $_GET['max_price'];
    $types .= "d";
}

// Additional filters for air conditioning and GPS
if (!empty($_GET['air_condition']) && $_GET['air_condition'] === "1") {
    $whereClauses[] = "c.air_condition = 1";
}

if (!empty($_GET['gps']) && $_GET['gps'] === "1") {
    $whereClauses[] = "c.gps = 1";
}

// Secure sorting
$allowedSortOptions = ["price_desc", "price_asc", "c.car_id ASC"];
$orderBy = "c.car_id ASC"; // Standard-Sortierung

if (!empty($_GET['sort']) && in_array($_GET['sort'], $allowedSortOptions)) {
    $orderBy = $_GET['sort'] === "price_desc" ? "c.price DESC" : "c.price ASC";
}

// SQL query for fully booked cars with filter & sorting
$sql = "SELECT 
            c.vendor_name, 
            c.vendor_name_abbr, 
            c.name, 
            c.name_extension, 
            c.loc_name,
            c.gear, 
            c.doors, 
            c.seats, 
            c.drive, 
            c.min_age, 
            c.price, 
            c.air_condition, 
            c.gps, 
            c.trunk, 
            c.img_file_name,
            COUNT(*) AS availability_count, 
            'booked' AS status
        FROM cars c
        WHERE " . implode(" AND ", $whereClauses) . "
        GROUP BY c.vendor_name, c.vendor_name_abbr, c.name, c.name_extension, c.loc_name
        ORDER BY $orderBy"; 
// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Fetch results and store in an array
$cars = [];
while ($row = $result->fetch_assoc()) {
    $row['loc_name'] .= " - Ausgebucht: " . $row['availability_count'];
    $cars[] = $row;
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode(["cars" => $cars]);
exit;
?>