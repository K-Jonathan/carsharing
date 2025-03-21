<?php
/**
 * Fetch Booking Details (AJAX Endpoint)
 * 
 * - Ensures the user is logged in and owns the requested booking.
 * - Accepts a `booking_id` via GET and verifies it against the logged-in user's ID.
 * - Retrieves the full booking record along with car details by joining `bookings` and `cars` tables.
 * - Returns a JSON response:
 *   - `status: success` with the booking data if found and owned by user.
 *   - `status: error` with appropriate message if validation or lookup fails.
 * 
 * This endpoint powers the booking details page for user-specific viewing.
 */
?>
<?php
require_once('db_connection.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "Nicht eingeloggt."]);
    exit();
}

$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : null;
$userid = $_SESSION['userid'];

if (!$booking_id) {
    echo json_encode(["status" => "error", "message" => "Ungültige Buchungs-ID."]);
    exit();
}


$stmt = $conn->prepare("
    SELECT b.*, c.vendor_name, c.name AS car_name, c.img_file_name, 
           c.gear, c.doors, c.seats, c.drive, c.min_age, c.price, 
           c.air_condition, c.gps, c.trunk 
    FROM bookings b
    JOIN cars c ON b.car_id = c.car_id
    WHERE b.booking_id = ? AND b.userid = ?
");
$stmt->bind_param("ii", $booking_id, $userid);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

$stmt->close();
$conn->close();

if (!$booking) {
    echo json_encode(["status" => "error", "message" => "Buchung nicht gefunden oder nicht erlaubt."]);
    exit();
}

echo json_encode(["status" => "success", "data" => $booking]);
exit();
?>