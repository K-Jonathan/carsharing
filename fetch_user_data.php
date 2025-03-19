<?php
require_once('db_connection.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    header("Location: loginpage.php");
    exit();
}

$userid = intval($_SESSION['userid']);

$stmt = $conn->prepare("SELECT * FROM users WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Fehler: Benutzerdaten konnten nicht geladen werden.");
}
?>