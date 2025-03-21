<?php
/*
This script establishes a secure connection to a MySQL database using the MySQLi extension.  
- Database connection parameters (`host`, `user`, `password`, `dbname`) are defined for local development (e.g., XAMPP).  
- Enables strict error reporting for MySQLi to throw exceptions on errors.  
- Tries to establish the connection and sets the character set to `utf8mb4` for full Unicode support.  
- If the connection fails, the script terminates with an error message.  
*/
$host = "localhost";  // or "127.0.0.1"
$user = "root";       // Standard user in XAMPP
$pass = "";           // Default password in XAMPP is empty
$dbname = "carsharing"; // Your database name (adjust if different)

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Activates exceptions for mysqli errors

try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    $conn->set_charset("utf8mb4"); // Ensures that the coding is correct
} catch (Exception $e) {
    die("Verbindungsfehler: " . $e->getMessage());
}
?>