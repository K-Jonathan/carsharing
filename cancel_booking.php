<?php
/**
 * Booking Cancellation Handler
 * 
 * - Ensures the user is logged in before proceeding.
 * - Validates the booking ID passed via GET and checks user ownership.
 * - Prevents users from cancelling bookings that do not belong to them.
 * - Deletes the booking from the database if validation passes.
 * - Redirects to the bookings page with a success flag or returns an error on failure.
 * 
 * This script provides secure server-side logic to cancel a user’s own booking.
 */
?>
<?php
require_once('db_connection.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    die("Fehler: Sie müssen eingeloggt sein, um eine Buchung zu stornieren.");
}

if (!isset($_GET['booking_id']) || !is_numeric($_GET['booking_id'])) {
    die("Fehler: Ungültige Buchungs-ID.");
}

$userid = $_SESSION['userid'];
$booking_id = intval($_GET['booking_id']);

$sql_check = "SELECT * FROM bookings WHERE booking_id = ? AND userid = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $booking_id, $userid);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows === 0) {
    die("Fehler: Sie können nur Ihre eigenen Buchungen stornieren.");
}

$sql_delete = "DELETE FROM bookings WHERE booking_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $booking_id);

if ($stmt_delete->execute()) {
    header("Location: bookings.php?storniert=success");
    exit();
} else {
    die("Fehler: Die Buchung konnte nicht gelöscht werden.");
}

$stmt_check->close();
$stmt_delete->close();
$conn->close();
?>