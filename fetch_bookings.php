<?php
/*
This script retrieves and categorizes a logged-in user's car bookings into future and past bookings.  
- It includes the database connection and ensures a session is started.  
- If the user is not logged in, an error message is returned.  
- The `userid` is securely converted to an integer to prevent SQL injection.  
- The script fetches all bookings for the logged-in user by joining the `bookings` and `cars` tables.  
- The results are categorized based on the pickup date:  
  - Future bookings (pickup date is after today).  
  - Past bookings (pickup date is today or earlier).  
- Finally, the bookings are returned as a JSON response for further frontend processing.
*/
require_once('db_connection.php');

// Include the database connection file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    die("Fehler: Sie müssen eingeloggt sein, um Ihre Buchungen zu sehen.");
}

// Convert `userid` from session data to an integer
$userid = intval($_SESSION['userid']);
// Get today's date to separate past and future bookings
$today = date("Y-m-d");

// SQL query to retrieve booking details for the logged-in user
$sql = "SELECT b.booking_id, c.vendor_name, c.name AS car_name, c.img_file_name, 
               b.booking_time, b.pickup_date, b.pickup_time, b.return_date, b.return_time, c.loc_name
        FROM bookings b
        JOIN cars c ON b.car_id = c.car_id
        WHERE b.userid = ?  
        ORDER BY b.pickup_date ASC";

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL-Fehler: " . $conn->error);
}

// Bind parameters and execute the query
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

// Arrays to store past and future bookings
$futureBookings = [];
$pastBookings = [];

// Loop through the results and categorize bookings based on the pickup date
while ($row = $result->fetch_assoc()) {
    if ($row['pickup_date'] > $today) {
        $futureBookings[] = $row;
    } else {
        $pastBookings[] = $row;
    }
}

// Close the statement and database connection
$stmt->close();
$conn->close();

// Return the bookings as a JSON response
echo json_encode(["future" => $futureBookings, "past" => $pastBookings]);
?>