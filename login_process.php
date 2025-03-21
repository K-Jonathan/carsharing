<?php
/*
🔐 login_process.php

This backend script handles **user authentication** for the Flamin-Go! login system.
It performs secure verification of credentials and sets session data on successful login.

🛠 Key Features:
- Accepts POST requests with `Classe` (email or username) and `Classf` (password).
- XSS protection via `htmlspecialchars()` and `trim()`.
- Database lookup using **prepared statements** to prevent SQL injection.
- Matches input against both email and username fields.

🔍 Verification:
- If a user is found and `password_verify()` succeeds:
  - Stores user info (`userid`, `username`, `email`, `birthdate`, `age`) in the session.
  - Returns JSON with `success: true` and a redirect URL (defaults to index page).
- If login fails:
  - Responds with detailed error messages in JSON.

⚠️ Error Conditions:
- Missing fields
- Incorrect credentials
- Non-existent account

🧠 Session Data Set:
- `userid`, `username`, `email`
- `birthdate`, `age` (calculated from birthdate)

📦 Response Format:
- ✅ Success: `{ success: true, redirect: "..." }`
- ❌ Failure: `{ success: false, errors: [ ... ] }`

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
    $classe = htmlspecialchars(trim($_POST["Classe"])); // XSS-Security
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
                
                //  Calculate Age and save in session
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