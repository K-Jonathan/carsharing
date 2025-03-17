<?php
require_once('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$whereClauses = [];
$params = [];
$types = "";

// 🔹 Standort-Filter (Falls gesetzt)
$location = isset($_SESSION['search-location']) ? $_SESSION['search-location'] : null;

if ($location) {
    $whereClauses[] = "loc_name = ?";
    $params[] = $location;
    $types .= "s"; 
}

// 🔹 Verfügbarkeitsprüfung (neue Logik)
$pickupDate = isset($_SESSION['pickupDate']) ? $_SESSION['pickupDate'] : null;
$returnDate = isset($_SESSION['returnDate']) ? $_SESSION['returnDate'] : null;

if ($pickupDate && $returnDate && $pickupDate !== 'Datum' && $returnDate !== 'Datum') {
    // DD.MM. -> YYYY-MM-DD Umwandlung
    if (preg_match('/(\d{2})\.(\d{2})\.(\d{2})/', $pickupDate, $matches)) {
        $pickupDateSQL = "20" . $matches[3] . "-" . $matches[2] . "-" . $matches[1]; // YYYY-MM-DD
    }
    if (preg_match('/(\d{2})\.(\d{2})\.(\d{2})/', $returnDate, $matches)) {
        $returnDateSQL = "20" . $matches[3] . "-" . $matches[2] . "-" . $matches[1]; // YYYY-MM-DD
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

// 🔹 Sortierung
$orderBy = "car_id ASC";
if (!empty($_GET['sort'])) {
    if ($_GET['sort'] === "price_desc") {
        $orderBy = "price DESC";
    } elseif ($_GET['sort'] === "price_asc") {
        $orderBy = "price ASC";
    }
}

// 🔹 Fahrzeugtyp-Filter (Mehrfachauswahl)
if (!empty($_GET['type'])) {
    $typeArray = explode(",", $_GET['type']);
    $placeholders = implode(",", array_fill(0, count($typeArray), "?"));
    $whereClauses[] = "type IN ($placeholders)";
    $params = array_merge($params, $typeArray);
    $types .= str_repeat("s", count($typeArray));
}

// 🔹 Getriebe-Filter (Mehrfachauswahl)
if (!empty($_GET['gear'])) {
    $gearArray = explode(",", $_GET['gear']);
    $placeholders = implode(",", array_fill(0, count($gearArray), "?"));
    $whereClauses[] = "gear IN ($placeholders)";
    $params = array_merge($params, $gearArray);
    $types .= str_repeat("s", count($gearArray));
}

// 🔹 Preis bis Filter (Nur eine Auswahl möglich)
if (!empty($_GET['max_price'])) {
    $whereClauses[] = "price <= ?";
    $params[] = $_GET['max_price'];
    $types .= "d"; 
}

// 🔹 Hersteller-Filter (Mehrfachauswahl)
if (!empty($_GET['vendor'])) {
    $vendorArray = explode(",", $_GET['vendor']);
    $placeholders = implode(",", array_fill(0, count($vendorArray), "?"));
    $whereClauses[] = "vendor_name IN ($placeholders)";
    $params = array_merge($params, $vendorArray);
    $types .= str_repeat("s", count($vendorArray));
}

// 🔹 Türen-Filter (Mehrfachauswahl)
if (!empty($_GET['doors'])) {
    $doorsArray = explode(",", $_GET['doors']);
    $placeholders = implode(",", array_fill(0, count($doorsArray), "?"));
    $whereClauses[] = "doors IN ($placeholders)";
    $params = array_merge($params, $doorsArray);
    $types .= str_repeat("i", count($doorsArray));
}

// 🔹 Sitze-Filter (Mehrfachauswahl)
if (!empty($_GET['seats'])) {
    $seatsArray = explode(",", $_GET['seats']);
    $placeholders = implode(",", array_fill(0, count($seatsArray), "?"));
    $whereClauses[] = "seats IN ($placeholders)";
    $params = array_merge($params, $seatsArray);
    $types .= str_repeat("i", count($seatsArray));
}

// 🔹 Antriebs-Filter (Mehrfachauswahl)
if (!empty($_GET['drive'])) {
    $driveArray = explode(",", $_GET['drive']);
    $placeholders = implode(",", array_fill(0, count($driveArray), "?"));
    $whereClauses[] = "drive IN ($placeholders)";
    $params = array_merge($params, $driveArray);
    $types .= str_repeat("s", count($driveArray)); 
}

// 🔹 Mindestalter-Filter (Mehrfachauswahl)
if (!empty($_GET['min_age'])) {
    $ageArray = explode(",", $_GET['min_age']);
    $placeholders = implode(",", array_fill(0, count($ageArray), "?"));
    $whereClauses[] = "min_age IN ($placeholders)";
    $params = array_merge($params, $ageArray);
    $types .= str_repeat("i", count($ageArray)); 
}

// 🔹 Klima-Filter
if (!empty($_GET['air_condition']) && $_GET['air_condition'] === "1") {
    $whereClauses[] = "air_condition = 1";
}

// 🔹 GPS-Filter
if (!empty($_GET['gps']) && $_GET['gps'] === "1") {
    $whereClauses[] = "gps = 1";
}

// 🔹 Kofferraumvolumen-Filter
if (!empty($_GET['trunk'])) {
    $trunkArray = explode(",", $_GET['trunk']);
    $placeholders = implode(",", array_fill(0, count($trunkArray), "?"));
    $whereClauses[] = "trunk IN ($placeholders)";
    $params = array_merge($params, $trunkArray);
    $types .= str_repeat("s", count($trunkArray)); 
}

// 🔹 SQL-Abfrage erstellen
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

// Falls Filter aktiv sind, wende sie an
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}

$sql .= " GROUP BY vendor_name, vendor_name_abbr, name, loc_name";
$sql .= " ORDER BY $orderBy";

$stmt = $conn->prepare($sql);

// ✅ Bind Param nur ausführen, wenn Parameter existieren
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