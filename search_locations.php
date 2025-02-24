<?php
require_once('db_connection.php');

if (isset($_GET['q'])) {
    $search = $_GET['q'] . '%'; // Für die LIKE-Suche

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