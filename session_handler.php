<?php
/*
📝 Session Management for User Authentication

🔹 Purpose:
- **Checks if a user is logged in** and stores their session details.
- If the user is **not logged in**, their `userid` is set to `NULL`, and they are identified as "Gast" (Guest).

🔹 Key Steps:
1. **Start the Session**  
   - `session_start()` ensures the script has access to session variables.
   - Uses `session_status()` to prevent **duplicate session starts**.

2. **Check Login Status**  
   - `isset($_SESSION["userid"])` determines if a user is **logged in**.
   - If logged in:
     - `userid` is assigned from the session.
     - `username` is assigned from the session.
   - If **not logged in**:
     - `userid` is set to `NULL`.
     - `username` is set to `"Gast"` (Guest).

🔹 Security Considerations:
- Uses **session-based authentication** to track logged-in users.
- No **direct database queries**, so it's safe against SQL injection.
- Can be **included in multiple scripts** to check user authentication.

📌 Ideal Usage:
- Place this script at the **beginning of pages** that need user authentication.
- Helps in **personalizing content** (e.g., showing "Welcome, [username]").
*/
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Change userid to NULL if user is not locked in 
$logged_in = isset($_SESSION["userid"]);
$userid = $logged_in ? $_SESSION["userid"] : null;
$username = $logged_in ? $_SESSION["username"] : "Gast";
?>