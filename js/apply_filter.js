document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Read URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const carType = urlParams.get("car_type"); // Extract the "car_type" filter from the URL

    if (carType) {
        // ✅ Highlight the main filter button for "Type"
        const typeFilterBtn = document.getElementById("type-filter");
        if (typeFilterBtn) {
            typeFilterBtn.classList.add("active"); // Make it visually active
        } else {
            console.error("❌ The main filter button for 'Type' was not found!");
        }

        // ✅ Check if the type filter dropdown exists
        const typeDropdown = document.getElementById("type-dropdown");
        if (!typeDropdown) {
            console.error("❌ The type dropdown was not found!");
            return;
        }

        // ✅ Iterate through all buttons in the dropdown and activate the correct one
        let found = false;
        typeDropdown.querySelectorAll("button").forEach(button => {
            // Compare button text with the filter value (case-insensitive)
            if (button.innerText.trim().toLowerCase() === carType.trim().toLowerCase()) {
                button.classList.add("active"); // Activate the correct button
                found = true;
            } else {
                button.classList.remove("active"); // Deactivate all others
            }
        });

        if (!found) {
            console.error(`❌ No matching filter found for '${carType}'.`);
        }

        // ✅ Reload cars based on updated filters
        fetchCarIds();
    }
});