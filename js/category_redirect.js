document.addEventListener("DOMContentLoaded", function () {
    const categoryImages = document.querySelectorAll(".category-image");

    // 🔹 Add click event listener to all category images
    categoryImages.forEach(image => {
        image.addEventListener("click", function () {
            const carType = this.getAttribute("data-type"); // Extract car type from data attribute

            // 🔹 Locate the search form (this contains the current search parameters)
            const searchForm = document.querySelector("form[action='car_selection.php']");
            if (!searchForm) {
                console.error("Error: Search form not found!");
                return;
            }

            // 🔹 Get existing search parameters from the form
            const params = new URLSearchParams(new FormData(searchForm));

            // 🔹 Add the selected car type to the parameters
            params.set("car_type", carType);

            // 🔹 Redirect to car selection page with the updated search parameters
            window.location.href = `car_selection.php?${params.toString()}`;
        });
    });
});