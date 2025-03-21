<?php
/**
 * User Registration Handler
 * 
 * - Handles new user registrations via POST request.
 * - Sanitizes and validates user input (prevents XSS and ensures required fields).
 * - Checks if the username or email already exists in the database.
 * - Hashes the password securely using `password_hash()`.
 * - Inserts the new user into the `users` table.
 * - Redirects to the login page on success or returns an error message on failure.
 * 
 * Security Measures:
 * - Uses `password_hash()` for secure password storage.
 * - Applies `htmlspecialchars()` and `trim()` to prevent XSS.
 * - Utilizes prepared statements to prevent SQL injection.
 * 
 * This script ensures a safe and seamless user registration process.
 */
?>
<?php
require_once('db_connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST["Benutzername"]));
    $first_name = htmlspecialchars(trim($_POST["Vorname"]));
    $last_name = htmlspecialchars(trim($_POST["name"]));
    $birthdate = htmlspecialchars(trim($_POST["birthdate"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = $_POST["password"];
    $password_repeat = $_POST["password_repeat"];

    if (empty($username) || empty($first_name) || empty($last_name) || empty($birthdate) || empty($email) || empty($password) || empty($password_repeat)) {
        die("Bitte fülle alle Felder aus!");
    }

    if ($password !== $password_repeat) {
        die("Die Passwörter stimmen nicht überein!");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $stmt = $conn->prepare("SELECT userid FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Benutzername oder E-Mail existiert bereits!");
    }
    $stmt->close();


    $stmt = $conn->prepare("INSERT INTO users (username, first_name, last_name, birthdate, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $first_name, $last_name, $birthdate, $email, $hashed_password);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: loginpage.php?registered=success");
        exit();
    } else {
        die("Fehler beim Registrieren! Bitte versuche es später erneut.");
    }
}
?>