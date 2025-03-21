/**
 * This script reads the "car_type" parameter from the URL and updates the UI accordingly.
 * 
 * - Activates the main filter button (with ID "type-filter") if "car_type" is present.
 * - Searches for a matching button in the dropdown (with ID "type-dropdown"):
 *    - Activates the button that matches the car type (case-insensitive).
 *    - Deactivates all others.
 * - Logs helpful error messages if elements are missing or no match is found.
 * - Triggers `fetchCarIds()` to refresh the car list based on the selected type.
 */
document.addEventListener("DOMContentLoaded", function () {
    // Read URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const carType = urlParams.get("car_type"); // Get `car_type` from URL

    if (carType) {
        // ✅ Set main button for “Type” active
        const typeFilterBtn = document.getElementById("type-filter");
        if (typeFilterBtn) {
            typeFilterBtn.classList.add("active");
        } else {
            console.error("❌ Der Hauptfilter-Button für Typ wurde nicht gefunden!");
        }

        // ✅ Check whether the type filter exists
        const typeDropdown = document.getElementById("type-dropdown");
        if (!typeDropdown) {
            console.error("❌ Das Typ-Dropdown wurde nicht gefunden!");
            return;
        }

        // ✅ Search all buttons in the type dropdown
        let found = false;
        typeDropdown.querySelectorAll("button").forEach(button => {
            if (button.innerText.trim().toLowerCase() === carType.trim().toLowerCase()) {
                button.classList.add("active"); // Activate!
                found = true;
            } else {
                button.classList.remove("active"); // If another was active, deactivate
            }
        });

        if (!found) {
            console.error(`❌ Kein passender Filter für '${carType}' gefunden.`);
        }

        
        // ✅ Load cars with updated filters
        fetchCarIds();
    }
});