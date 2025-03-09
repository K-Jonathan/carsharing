<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔹 Falls der Nutzer nicht eingeloggt ist, `userid` auf NULL setzen
$logged_in = isset($_SESSION["userid"]);
$userid = $logged_in ? $_SESSION["userid"] : null;
$username = $logged_in ? $_SESSION["username"] : "Gast";
?>