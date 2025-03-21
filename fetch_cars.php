<?php
/**
 * Car Selection Filtering & Availability Check (AJAX Endpoint)
 * 
 * - Filters available cars based on user-defined criteria from GET and session data.
 * 
 * Core Features:
 * - Location filter (based on `search-location` stored in session).
 * - Date range filter (pickup/return), ensuring cars are not double-booked.
 * - Multiple filter options applied securely via `applyFilter()`:
 *   - Vehicle type, gear type, vendor, doors, seats, drive, age restriction, trunk size.
 *   - Optional boolean filters for air condition and GPS.
 *   - Price ceiling filter via `max_price`.
 * - Sorting support for ascending/descending price.
 * 
 * SQL Safety:
 * - Uses prepared statements and parameterized queries to prevent SQL injection.
 * - Dynamically builds the `WHERE` clause and binds filter values safely.
 * 
 * Output:
 * - Returns a JSON object with a filtered list of cars and their availability.
 * 
 * This endpoint powers the live filter functionality on the car selection page.
 */
?>
<?php
require_once('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$whereClauses = [];
$params = [];
$types = "";


$location = isset($_SESSION['search-location']) ? htmlspecialchars(trim($_SESSION['search-location'])) : null;

if ($location) {
    $whereClauses[] = "loc_name = ?";
    $params[] = $location;
    $types .= "s"; 
}


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


$allowedSortOptions = ["price_desc", "price_asc", "car_id ASC"];
$orderBy = "car_id ASC"; 

if (!empty($_GET['sort']) && in_array($_GET['sort'], $allowedSortOptions)) {
    $orderBy = $_GET['sort'] === "price_desc" ? "price DESC" : "price ASC";
}


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

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$cars = [];
while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

header('Content-Type: application/json');
echo json_encode([
    "cars" => $cars
]);
exit;
?>