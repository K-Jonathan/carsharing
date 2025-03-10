<?php
require_once('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$errors = [];
$redirect_url = isset($_POST["redirect"]) && !empty($_POST["redirect"]) ? $_POST["redirect"] : "index.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classe = trim($_POST["Classe"]);
    $password = $_POST["Classf"];

    if (empty($classe) || empty($password)) {
        $errors[] = "Bitte füllen Sie alle Felder aus.";
    } else {
        $stmt = $conn->prepare("SELECT userid, username, email, password FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $classe, $classe);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                $_SESSION["userid"] = $user["userid"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["email"] = $user["email"];

                echo json_encode(["success" => true, "redirect" => $redirect_url]);
                exit;
            } else {
                $errors[] = "Das eingegebene Passwort ist nicht korrekt.";
            }
        } else {
            $errors[] = "Es existiert kein Account zu dieser E-Mail.";
        }
    }
}

// ❌ Falls Fehler vorhanden sind, sende sie zurück
echo json_encode(["success" => false, "errors" => $errors]);
exit;