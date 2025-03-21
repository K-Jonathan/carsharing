<?php
/*
This script ensures a secure user session and retrieves user details from the database.  
- It includes the database connection file.  
- It starts a session if none exists.  
- If the user is not logged in, they are redirected to the login page.  
- The user ID is retrieved from the session and securely converted to an integer.  
- A prepared SQL statement fetches the corresponding user details from the database.  
- If no user data is found, an error message is displayed.  
*/

// Include the database connection file
require_once('db_connection.php');

// Ensure the session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['userid'])) {
    header("Location: loginpage.php");
    exit();
}

// Retrieve the user ID from session and convert it to an integer for security
$userid = intval($_SESSION['userid']);

// Prepare an SQL statement to fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// If no user data is found, display an error message
if (!$user) {
    die("Fehler: Benutzerdaten konnten nicht geladen werden.");
}
?>