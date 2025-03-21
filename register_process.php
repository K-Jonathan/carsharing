<?php
/*
📝 register_process.php – User Registration Script

This script handles **user registration**, ensuring secure data storage and validation.

🛠 Key Steps:
1. **Include Database Connection**  
   - Uses `db_connection.php` to connect to the database.
   
2. **Start a Session**  
   - Ensures session variables are available if needed later.

3. **Retrieve & Sanitize User Input**  
   - Uses `htmlspecialchars(trim(...))` to prevent **XSS attacks**.
   - Fields: `username`, `first_name`, `last_name`, `birthdate`, `email`, `password`, `password_repeat`.

4. **Validate Input Fields**  
   - Checks if all required fields are filled.
   - Ensures both passwords match.

5. **Hash the Password Securely**  
   - Uses `password_hash()` with `PASSWORD_DEFAULT` for secure password storage.

6. **Check for Existing Email or Username**  
   - Queries the database to see if the **email** or **username** is already registered.
   - Prevents duplicate accounts.

7. **Insert New User into Database**  
   - Uses a **prepared statement** (`INSERT INTO users (...) VALUES (...)`).
   - Binds user data to the statement and executes it.

8. **Redirect to Login Page on Success**  
   - If the registration is successful, the user is redirected to `loginpage.php` with a success message.

9. **Handle Errors Gracefully**  
   - If registration fails, an error message is displayed.

📌 Purpose:
- Provides **secure** and **validated** user registration.
- Uses **password hashing** for security.
- Prevents **duplicate registrations** (email/username check).

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

    // Check if Email and Username already exists
    $stmt = $conn->prepare("SELECT userid FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Benutzername oder E-Mail existiert bereits!");
    }
    $stmt->close();

    // Integrate user in database
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