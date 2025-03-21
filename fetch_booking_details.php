<?php
/*
This script retrieves detailed information about a specific booking for a logged-in user.  
- Includes the database connection and ensures a session is started.  
- Verifies that the user is logged in; otherwise, returns a JSON error response.  
- Retrieves the `booking_id` from the GET request and ensures it's a valid integer.  
- Performs a secure SQL query (using prepared statements) to fetch the booking details,  
  joining the `bookings` and `cars` tables to include car-related data.  
- Ensures the booking belongs to the logged-in user (authorization check).  
- Returns the booking information as a JSON object if successful, or a structured error message if not.  
*/
//Include the database connection file (this file must establish a database connection)
require_once('db_connection.php');

// Ensure the session is started if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "Nicht eingeloggt."]);
    exit();
}
// Get the booking ID from the GET request and convert it to an integer
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : null;
$userid = $_SESSION['userid'];

// Validate the booking ID
if (!$booking_id) {
    echo json_encode(["status" => "error", "message" => "Ungültige Buchungs-ID."]);
    exit();
}

// Retrieve booking details securely
$stmt = $conn->prepare("
    SELECT b.*, c.vendor_name, c.name AS car_name, c.img_file_name, 
           c.gear, c.doors, c.seats, c.drive, c.min_age, c.price, 
           c.air_condition, c.gps, c.trunk 
    FROM bookings b
    JOIN cars c ON b.car_id = c.car_id
    WHERE b.booking_id = ? AND b.userid = ?
");
// Bind the parameters: both `booking_id` and `userid` should be integers
$stmt->bind_param("ii", $booking_id, $userid);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

// Close the statement and database connection
$stmt->close();
$conn->close();

// Check if a valid booking record was retrieved
if (!$booking) {
    echo json_encode(["status" => "error", "message" => "Buchung nicht gefunden oder nicht erlaubt."]);
    exit();
}

// Return the booking details as a JSON response
echo json_encode(["status" => "success", "data" => $booking]);
exit();
?>