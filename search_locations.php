<?php
/*
📝 search_locations.php – Location Autocomplete Search

This script **searches for car rental locations** based on user input for an **autocomplete feature**.

🛠 Key Steps:
1. **Include Database Connection**  
   - Uses `db_connection.php` to establish a secure connection.

2. **Check if a Search Query (`q`) is Provided**  
   - If `q` (query parameter) exists, **sanitize** the input using `htmlspecialchars(trim(...))` to prevent **XSS attacks**.
   - Appends `%` to enable **partial matches** (for SQL `LIKE` search).

3. **Execute a Prepared SQL Query**  
   - Selects **distinct locations** (`loc_name`) from the `cars` table.
   - Uses a **prepared statement** (`bind_param("s", $search)`) to prevent **SQL injection**.

4. **Fetch and Store Results**  
   - Iterates through results and **stores location names** in an array.

5. **Return Data as JSON**  
   - Encodes the array into **JSON format** for easy use in **AJAX responses**.

📌 Purpose:
- Provides **real-time search suggestions** for users selecting a car rental location.
- Uses **prepared statements** for **security**.
- Outputs **JSON**, making it easy to integrate with **JavaScript autocompletion**.

*/
?>
<?php
require_once('db_connection.php');
// Search function for car locations
if (isset($_GET['q'])) {
    $search = htmlspecialchars(trim($_GET['q'])) . '%';

    $stmt = $conn->prepare("SELECT DISTINCT loc_name FROM cars WHERE loc_name LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $locations = [];
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row['loc_name'];
    }

    echo json_encode($locations);
}
?>