<?php
/**
 * User Login Handler (AJAX Endpoint)
 * 
 * - Handles login authentication via email or username.
 * - Sanitizes user input to prevent XSS attacks.
 * - Verifies user credentials against the database using password hashing (`password_verify()`).
 * - On successful login:
 *   - Stores user session data (`userid`, `username`, `email`).
 *   - Calculates and saves user's age based on birthdate.
 *   - Returns a JSON response with a redirect URL.
 * - On failure:
 *   - Returns JSON with error messages.
 * 
 * This script is designed to be used with an asynchronous login form.
 */
?>
<?php
require_once('db_connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$errors = [];
$redirect_url = isset($_POST["redirect"]) && !empty($_POST["redirect"]) ? htmlspecialchars(trim($_POST["redirect"])) : "index.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classe = htmlspecialchars(trim($_POST["Classe"])); 
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