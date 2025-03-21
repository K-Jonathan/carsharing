<?php
/*
This script returns a list of available cars as a JSON response based on search parameters stored in the session and filters passed via GET.  
- Starts session and includes the database connection.  
- Filters cars by location and excludes those already booked during the selected pickup and return period.  
- Converts German date formats (DD.MM.YY) to SQL format (YYYY-MM-DD) for accurate date comparisons.  
- Applies optional filters (type, gear, vendor, doors, seats, drive, min_age, trunk, air_condition, GPS, and max_price)  
  securely using prepared statements to prevent SQL injection.  
- Supports safe sorting by allowed options (price ascending/descending or car_id).  
- Retrieves grouped car data from the database and returns a JSON object including car availability counts.
*/

require_once('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$whereClauses = [];
$params = [];
$types = "";

// Location filter (if set)
$location = isset($_SESSION['search-location']) ? htmlspecialchars(trim($_SESSION['search-location'])) : null;

if ($location) {
    $whereClauses[] = "loc_name = ?";
    $params[] = $location;
    $types .= "s"; 
}

// Availability check (new logic)
$pickupDate = isset($_SESSION['pickupDate']) ? htmlspecialchars(trim($_SESSION['pickupDate'])) : null;
$returnDate = isset($_SESSION['returnDate']) ? htmlspecialchars(trim($_SESSION['returnDate'])) : null;

if ($pickupDate && $returnDate && $pickupDate !== 'Datum' && $returnDate !== 'Datum') {
    if (preg_match('/(\d{2})\.(\d{2})\.(\d{2})/', $pickupDate, $matches)) {
        $pickupDateSQL = "20" . $matches[3] . "-" . $matches[2] . "-" . $matches[1];
    }
    if (preg_match('/(\d{2})\.(\d{2})\.(\d{2})/', $returnDate, $matches)) {
        $returnDateSQL = "20" . $matches[3] . "-" . $matches[2] . "-" . $matches[1];
    }

    $whereClauses[] = "car_id NOT IN (
        SELECT DISTINCT car_id FROM bookings
        WHERE 
            (STR_TO_DATE(pickup_date, '%Y-%m-%d') <= ? AND STR_TO_DATE(return_date, '%Y-%m-%d') >= ?) 
            OR 
            (STR_TO_DATE(pickup_date, '%Y-%m-%d') BETWEEN ? AND ?) 
            OR 
            (STR_TO_DATE(return_date, '%Y-%m-%d') BETWEEN ? AND ?)
    )";
    
    $params[] = $returnDateSQL;
    $params[] = $pickupDateSQL;
    $params[] = $pickupDateSQL;
    $params[] = $returnDateSQL;
    $params[] = $pickupDateSQL;
    $params[] = $returnDateSQL;
    
    $types .= "ssssss";
}

// Sorting (only allow permitted values)
$allowedSortOptions = ["price_desc", "price_asc", "car_id ASC"];
$orderBy = "car_id ASC"; // Standard

if (!empty($_GET['sort']) && in_array($_GET['sort'], $allowedSortOptions)) {
    $orderBy = $_GET['sort'] === "price_desc" ? "price DESC" : "price ASC";
}

// Filter with SQL protection
function applyFilter($paramName, $columnName, $typeChar) {
    global $whereClauses, $params, $types;
    
    if (!empty($_GET[$paramName])) {
        $values = explode(",", htmlspecialchars(trim($_GET[$paramName])));
        $placeholders = implode(",", array_fill(0, count($values), "?"));
        $whereClauses[] = "$columnName IN ($placeholders)";
        $params = array_merge($params, $values);
        $types .= str_repeat($typeChar, count($values));
    }
}

// Use all filters safely
applyFilter("type", "type", "s");
applyFilter("gear", "gear", "s");
applyFilter("vendor", "vendor_name", "s");
applyFilter("doors", "doors", "i");
applyFilter("seats", "seats", "i");
applyFilter("drive", "drive", "s");
applyFilter("min_age", "min_age", "i");
applyFilter("trunk", "trunk", "s");

if (!empty($_GET['max_price']) && is_numeric($_GET['max_price'])) {
    $whereClauses[] = "price <= ?";
    $params[] = $_GET['max_price'];
    $types .= "d";
}

if (!empty($_GET['air_condition']) && $_GET['air_condition'] === "1") {
    $whereClauses[] = "air_condition = 1";
}

if (!empty($_GET['gps']) && $_GET['gps'] === "1") {
    $whereClauses[] = "gps = 1";
}

// Create SQL query
$sql = "SELECT 
            MIN(car_id) as car_id, 
            vendor_name, 
            vendor_name_abbr, 
            name_extension,
            name, 
            loc_name, 
            gear, 
            doors, 
            seats, 
            drive, 
            min_age, 
            price, 
            air_condition, 
            gps, 
            trunk, 
            img_file_name,
            COUNT(*) as availability_count 
        FROM cars";

if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}

$sql .= " GROUP BY vendor_name, vendor_name_abbr, name, loc_name";
$sql .= " ORDER BY $orderBy";

// Prepare and execute the query
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch results and store in an array
$cars = [];
while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode([
    "cars" => $cars
]);
exit;
?>