<?php
require_once('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json'); // JSON als Antwort-Format setzen

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classe = trim($_POST["Classe"]); // E-Mail oder Benutzername
    $password = $_POST["Classf"]; // Passwort

    if (empty($classe) || empty($password)) {
        $errors[] = "Bitte füllen Sie alle Felder aus.";
    } else {
        // 🔹 Prüfen, ob die E-Mail oder der Benutzername existiert
        $stmt = $conn->prepare("SELECT userid, username, email, password FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $classe, $classe);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // 🔹 Prüfen, ob das Passwort korrekt ist
            if (password_verify($password, $user["password"])) {
                // ✅ Erfolgreich: Session setzen & weiterleiten
                $_SESSION["userid"] = $user["userid"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["email"] = $user["email"];

                echo json_encode(["success" => true, "redirect" => "index.php"]); // ⬅ Weiterleitung zur Homepage
                exit;
            } else {
                $errors[] = "Das eingegebene Passwort ist nicht korrekt.";
            }
        } else {
            $errors[] = "Es existiert kein Account zu dieser E-Mail.";
        }
    }
}

// 🔹 Falls Fehler vorhanden sind → JSON-Antwort mit Fehlern zurückgeben
echo json_encode(["success" => false, "errors" => $errors]);
exit;
?>