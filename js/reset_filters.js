document.addEventListener("DOMContentLoaded", function () {
    const resetButton = document.getElementById("reset-filters"); // Get the "Reset Filters" button

    // 🔹 Add click event to reset filters
    resetButton.addEventListener("click", function () {
        // 🚀 Get the current URL
        const url = new URL(window.location.href);

        // 🗑️ Remove the `car_type` parameter from the URL
        url.searchParams.delete("car_type");

        // 🔄 Reload the page with the updated URL (without `car_type`)
        window.location.href = url.toString();
    });
});