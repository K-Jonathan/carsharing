<?php
require_once('db_connection.php');

if (isset($_GET['field']) && isset($_GET['value'])) {
    $field = $_GET['field'];
    $value = trim($_GET['value']);

    // Nur `username` oder `email` erlauben, um SQL-Injections zu verhindern
    if ($field !== "email" && $field !== "username") {
        die("Ungültige Anfrage!");
    }

    $stmt = $conn->prepare("SELECT userid FROM users WHERE $field = ?");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $stmt->store_result();

    echo ($stmt->num_rows > 0) ? "exists" : "available";

    $stmt->close();
    $conn->close();
}
?>