/**
 * This script enables category-based car filtering by clicking on category images.
 * 
 * Features:
 * 
 * 🚗 Category Selection:
 * - Listens for clicks on `.category-image` elements.
 * - Extracts the selected car type from the `data-type` attribute.
 * 
 * 🔄 Search Parameter Handling:
 * - Retrieves existing search parameters from the form (`car_selection.php`).
 * - Converts form data into a URL query string.
 * - Appends the selected `car_type` parameter.
 * 
 * 🔗 Redirection:
 * - Constructs a new URL with all parameters and redirects the user to `car_selection.php`.
 * - Ensures the search query structure is maintained while adding the selected category.
 * 
 * This allows users to refine their search by clicking on car category images without
 * manually selecting the type in filters.
 */
document.addEventListener("DOMContentLoaded", function () {
    const categoryImages = document.querySelectorAll(".category-image");

    categoryImages.forEach(image => {
        image.addEventListener("click", function () {
            const carType = this.getAttribute("data-type");

            // Read URL from the form
            const searchForm = document.querySelector("form[action='car_selection.php']");
            if (!searchForm) {
                console.error("Suchformular nicht gefunden!");
                return;
            }

            const params = new URLSearchParams(new FormData(searchForm));

            // Add new parameter for car_type
            params.set("car_type", carType);

            // Forwarding with the same structure + car_type
            window.location.href = `car_selection.php?${params.toString()}`;
        });
    });
});