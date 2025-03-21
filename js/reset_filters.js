/**
 * This script handles resetting the car type filter by removing the `car_type` parameter from the URL.
 * 
 * Features:
 * 
 * 🗑️ Filter Reset:
 * - Listens for clicks on the "Reset Filters" button.
 * - Retrieves the current page URL and removes the `car_type` parameter.
 * 
 * 🔄 Page Reload:
 * - Updates the URL without `car_type` and reloads the page.
 * - Ensures the user sees an unfiltered car selection.
 * 
 * This provides a quick way to reset the car type filter without affecting other search parameters.
 */
document.addEventListener("DOMContentLoaded", function () {
    const resetButton = document.getElementById("reset-filters");

    resetButton.addEventListener("click", function () {
        // 🚀 Get current URL
        const url = new URL(window.location.href);

        // 🗑️ Remove the `car_type` parameter
        url.searchParams.delete("car_type");

        // 🔄 Reload page without `car_type`
        window.location.href = url.toString();
    });
});