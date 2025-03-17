<?php
require_once('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔹 Standort aus Session holen
$location = isset($_SESSION['search-location']) ? $_SESSION['search-location'] : null;
if (!$location) {
    echo json_encode(["cars" => []]);
    exit;
}

$params = [$location];
$types = "s";
$whereClauses = ["c.loc_name = ?"];

// 🔹 Falls Datum gesetzt wurde → Buchungsprüfung machen
$pickupDate = isset($_SESSION['pickupDate']) && $_SESSION['pickupDate'] !== 'Datum' ? $_SESSION['pickupDate'] : null;
$returnDate = isset($_SESSION['returnDate']) && $_SESSION['returnDate'] !== 'Datum' ? $_SESSION['returnDate'] : null;
$pickupDateSQL = $returnDateSQL = null;

if ($pickupDate && $returnDate) {
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

// ✅ **WICHTIG: Die Filter müssen hier genauso angewendet werden wie für verfügbare Autos!**
function applyFilter($paramName, $columnName, $typeChar) {
    global $whereClauses, $params, $types;
    
    if (!empty($_GET[$paramName])) {
        $values = explode(",", $_GET[$paramName]);
        $placeholders = implode(",", array_fill(0, count($values), "?"));
        $whereClauses[] = "c.$columnName IN ($placeholders)";
        $params = array_merge($params, $values);
        $types .= str_repeat($typeChar, count($values));
    }
}

// 🔹 Filter anwenden (GENAU WIE IN `fetch_cars.php`)
applyFilter("type", "type", "s");
applyFilter("gear", "gear", "s");
applyFilter("vendor", "vendor_name", "s");
applyFilter("doors", "doors", "i");
applyFilter("seats", "seats", "i");
applyFilter("drive", "drive", "s");
applyFilter("min_age", "min_age", "i");
applyFilter("trunk", "trunk", "s");

if (!empty($_GET['max_price'])) {
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

// ✅ **Sortierung einfügen**
$orderBy = "c.car_id ASC"; // Standardmäßig nach ID sortieren (wie verfügbare Autos)
if (!empty($_GET['sort'])) {
    if ($_GET['sort'] === "price_desc") {
        $orderBy = "c.price DESC";
    } elseif ($_GET['sort'] === "price_asc") {
        $orderBy = "c.price ASC";
    }
}

// 🔹 SQL-Abfrage für ausgebuchte Autos mit **Filter + Gruppierung + Sortierung**
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
        ORDER BY $orderBy"; // **🔹 Hier wird die Sortierung angewendet!**

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$cars = [];
while ($row = $result->fetch_assoc()) {
    // Standort um "- Ausgebucht: X" erweitern
    $row['loc_name'] .= " - Ausgebucht: " . $row['availability_count'];
    $cars[] = $row;
}

header('Content-Type: application/json');
echo json_encode(["cars" => $cars]);
exit;
?>