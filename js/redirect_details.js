document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".book-button").forEach(button => {
        button.addEventListener("click", function () {
            const carId = this.getAttribute("data-car-id");
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set("car_id", carId);

            // Weiterleitung zur car_details.php mit der gewählten ID
            window.location.href = "car_details.php?" + urlParams.toString();
        });
    });
});