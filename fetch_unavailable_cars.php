<?php
/**
 * Booked Cars Filter – Show Fully Booked Cars by Location & Filters (AJAX Endpoint)
 * 
 * - Identifies and lists cars that are fully booked within a selected date range at a specific location.
 * 
 * Features:
 * - Requires `search-location` in session and valid pickup/return dates.
 * - Applies date conflict checks via subquery in `WHERE` clause to ensure only booked vehicles are shown.
 * - Supports additional secure filtering via `applyFilter()`:
 *   - Type, gear, vendor, doors, seats, drive, min_age, trunk.
 *   - Price ceiling, air conditioning, and GPS.
 * - Validates and applies secure sorting (`price_desc`, `price_asc`, or default).
 * - Counts availability via `COUNT(*)` and labels result rows with `status = "booked"`.
 * - Appends note to `loc_name` to indicate fully booked status and availability count.
 * 
 * Output:
 * - Returns a JSON array of cars that match all filter criteria and are currently unavailable.
 * 
 * This endpoint supports UI elements that highlight unavailable cars matching the user's search.
 */
?>
<?php
require_once('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$location = isset($_SESSION['search-location']) ? htmlspecialchars(trim($_SESSION['search-location'])) : null;
if (!$location) {
    echo json_encode(["cars" => []]);
    exit;
}

$params = [$location];
$types = "s";
$whereClauses = ["c.loc_name = ?"];


$pickupDate = isset($_SESSION['pickupDate']) ? htmlspecialchars(trim($_SESSION['pickupDate'])) : null;
$returnDate = isset($_SESSION['returnDate']) ? htmlspecialchars(trim($_SESSION['returnDate'])) : null;
$pickupDateSQL = $returnDateSQL = null;

if ($pickupDate && $returnDate && $pickupDate !== 'Datum' && $returnDate !== 'Datum') {
    if (preg_match('/(\d{2})\.(\d{2})\.(\d{2})/', $pickupDate, $matches)) {
        $pickupDateSQL = "20" . $matches[3] . "-" . $matches[2] . "-" . $matches[1];
    }
    if (preg_match('/(\d{2})\.(\d{2})\.(\d{2})/', $returnDate, $matches)) {
        $returnDateSQL = "20" . $matches[3] . "-" . $matches[2] . "-" . $matches[1];
    }

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


applyFilter("type", "type", "s");
applyFilter("gear", "gear", "s");
applyFilter("vendor", "vendor_name", "s");
applyFilter("doors", "doors", "i");
applyFilter("seats", "seats", "i");
applyFilter("drive", "drive", "s");
applyFilter("min_age", "min_age", "i");
applyFilter("trunk", "trunk", "s");

if (!empty($_GET['max_price']) && is_numeric($_GET['max_price'])) {
    $whereClauses[] = "c.price <= ?";
    $params[] = $_GET['max_price'];
    $types .= "d";
}

if (!empty($_GET['air_condition']) && $_GET['air_condition'] === "1") {
    $whereClauses[] = "c.air_condition = 1";
}

if (!empty($_GET['gps']) && $_GET['gps'] === "1") {
    $whereClauses[] = "c.gps = 1";
}


$allowedSortOptions = ["price_desc", "price_asc", "c.car_id ASC"];
$orderBy = "c.car_id ASC"; 

if (!empty($_GET['sort']) && in_array($_GET['sort'], $allowedSortOptions)) {
    $orderBy = $_GET['sort'] === "price_desc" ? "c.price DESC" : "c.price ASC";
}


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

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$cars = [];
while ($row = $result->fetch_assoc()) {
    $row['loc_name'] .= " - Ausgebucht: " . $row['availability_count'];
    $cars[] = $row;
}

header('Content-Type: application/json');
echo json_encode(["cars" => $cars]);
exit;
?>