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

    $sql = "SELECT c.*, 'booked' AS status
            FROM cars c
            INNER JOIN bookings b ON c.car_id = b.car_id
            WHERE c.loc_name = ?
            AND (
                (b.pickup_date <= ? AND b.return_date >= ?) 
                OR 
                (b.pickup_date BETWEEN ? AND ?) 
                OR 
                (b.return_date BETWEEN ? AND ?)
            )
            GROUP BY c.car_id";

    array_push($params, $returnDateSQL, $pickupDateSQL, $pickupDateSQL, $returnDateSQL, $pickupDateSQL, $returnDateSQL);
    $types .= "ssssss";
} else {
    // Falls kein Zeitraum gesetzt → Keine gebuchten Autos anzeigen
    echo json_encode(["cars" => []]);
    exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$cars = [];
while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

header('Content-Type: application/json');
echo json_encode(["cars" => $cars]);
exit;
?>