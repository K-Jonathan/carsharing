document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Get the booking form element
    const bookingForm = document.querySelector("form[action='bookings_process.php']");

    if (bookingForm) {
        bookingForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            let formData = new FormData(bookingForm); // Create FormData object

            // 🔹 Send the form data via AJAX to process the booking
            fetch("bookings_process.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json()) // Convert response to JSON
            .then(data => {
                if (data.status === "error") {
                    showPopup(data.message); // ❌ Display error message if age or availability fails
                } else if (data.status === "success") {
                    window.location.href = "bookings.php"; // ✅ Redirect to bookings page on success
                }
            })
            .catch(error => console.error("Error:", error));
        });
    }
});

// 🔹 Function to show error or success messages in a popup
function showPopup(message) {
    document.getElementById("popup-message").textContent = message;
    document.getElementById("booking-popup").style.display = "flex";
}

// 🔹 Function to close the popup
function closePopup() {
    document.getElementById("booking-popup").style.display = "none";
}