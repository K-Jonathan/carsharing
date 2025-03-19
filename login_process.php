<?php
require_once('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$errors = [];
$redirect_url = isset($_POST["redirect"]) && !empty($_POST["redirect"]) ? htmlspecialchars(trim($_POST["redirect"])) : "index.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classe = htmlspecialchars(trim($_POST["Classe"])); // XSS-Schutz
    $password = $_POST["Classf"];

    if (empty($classe) || empty($password)) {
        $errors[] = "Bitte füllen Sie alle Felder aus.";
    } else {
        $stmt = $conn->prepare("SELECT userid, username, email, password, birthdate FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $classe, $classe);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                $_SESSION["userid"] = $user["userid"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["email"] = $user["email"];
                
                // 🎯 Alter berechnen und in Session speichern
                $birthdate = new DateTime($user["birthdate"]);
                $currentDate = new DateTime();
                $age = $currentDate->diff($birthdate)->y;

                $_SESSION["age"] = $age;
                $_SESSION["birthdate"] = $user["birthdate"];

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

echo json_encode(["success" => false, "errors" => $errors]);
exit;
?>