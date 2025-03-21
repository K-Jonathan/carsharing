<!--  * This script checks whether a given username or email already exists in the database.
 * It validates the requested field to prevent SQL injection, then queries the database securely.
 * The response is either "exists" if the value is taken or "available" if it is free.-->
<?php
require_once('db_connection.php');

if (isset($_GET['field']) && isset($_GET['value'])) {
    $field = $_GET['field'];
    $value = trim($_GET['value']);

    // only allow `username` or `email` in order to avoid SQL-Injections
    if (!in_array($field, ["email", "username"])) {
        die("Ungültige Anfrage!");
    }

    // secure dynamic use of field 
    $stmt = $conn->prepare("SELECT userid FROM users WHERE " . $field . " = ?");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $stmt->store_result();

    echo ($stmt->num_rows > 0) ? "exists" : "available";

    $stmt->close();
    $conn->close();
}
?>