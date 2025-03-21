<?php
/*
🔄 refresh_session.php – Refresh User Session Data

This script updates the **user session** with the latest data from the database.

🛠 Key Steps:
1. **Check if the user is logged in**  
   - If not, return an error message in JSON format.
   
2. **Fetch updated user data** from the database (`username`, `email`, `birthdate`)  
   - Uses a prepared statement for security.

3. **Recalculate the user's age**  
   - Converts `birthdate` into a `DateTime` object.
   - Compares it with today's date.

4. **Update session variables**  
   - Stores the refreshed `username`, `email`, `birthdate`, and calculated `age`.

5. **Return a success message in JSON format**  
   - Ensures front-end applications can confirm the update.

📌 Purpose:
- Ensures session data is **up-to-date** after profile changes.
- Improves **security** and **user experience** by keeping info synchronized.

*/
?>
<?php
require_once('db_connection.php');
session_start();

if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "Sie müssen eingeloggt sein."]);
    exit;
}

$userid = intval($_SESSION['userid']);

// Get new userdata from database
$stmt = $conn->prepare("SELECT username, email, birthdate FROM users WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($new_username, $new_email, $new_birthdate);
$stmt->fetch();
$stmt->close();

// Calculate age again
$new_birthdateObj = DateTime::createFromFormat('Y-m-d', $new_birthdate);
$today = new DateTime();
$new_age = $today->diff($new_birthdateObj)->y;

// update Session
$_SESSION["username"] = $new_username;
$_SESSION["email"] = $new_email;
$_SESSION["birthdate"] = $new_birthdate;
$_SESSION["age"] = $new_age;

echo json_encode(["status" => "success", "message" => "Session aktualisiert."]);
?>