<?php
/**
 * Database Connection Script – MySQL (mysqli)
 * 
 * - Establishes a connection to the MySQL database using `mysqli` with error reporting enabled.
 * - Uses default XAMPP credentials (localhost, root, no password).
 * - Connects to the `carsharing` database (adjustable if needed).
 * - Sets character encoding to UTF-8 (utf8mb4) for full Unicode support.
 * - Wraps the connection in a try-catch block for clean error handling via exceptions.
 * 
 * This script is required for database access throughout the application.
 */
?>
<?php
$host = "localhost";  
$user = "root";       
$pass = "";           
$dbname = "carsharing"; 

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 

try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    $conn->set_charset("utf8mb4"); 
} catch (Exception $e) {
    die("Verbindungsfehler: " . $e->getMessage());
}
?>