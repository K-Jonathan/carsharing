<?php
/**
 * Username/Email Availability Checker (AJAX Endpoint)
 * 
 * - Accepts `field` (either "email" or "username") and `value` via GET parameters.
 * - Sanitizes and validates the input to prevent SQL injection.
 * - Queries the `users` table to check if the value already exists.
 * - Returns plain text response:
 *   - "exists" if the value is already in use.
 *   - "available" if the value is free.
 * - Only allows checking of "username" and "email" fields.
 * 
 * Intended to be used asynchronously for real-time validation in registration or settings forms.
 */
?>
<?php
require_once('db_connection.php');

if (isset($_GET['field']) && isset($_GET['value'])) {
    $field = $_GET['field'];
    $value = trim($_GET['value']);

    
    if (!in_array($field, ["email", "username"])) {
        die("Ungültige Anfrage!");
    }

   
    $stmt = $conn->prepare("SELECT userid FROM users WHERE " . $field . " = ?");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $stmt->store_result();

    echo ($stmt->num_rows > 0) ? "exists" : "available";

    $stmt->close();
    $conn->close();
}
?>