/**
 * This script handles asynchronous booking form submission via `bookings_process.php`.
 * 
 * - Intercepts form submission to send data using `fetch()` without reloading the page.
 * - Sends form data via POST and processes the JSON response.
 *    ❌ On error (e.g., invalid age or unavailable car): shows a popup with the message.
 *    ✅ On success: redirects the user to `bookings.php`.
 * - Includes helper functions:
 *    - `showPopup(message)`: Displays the popup with a custom message.
 *    - `closePopup()`: Closes the message popup.
 */
document.addEventListener("DOMContentLoaded", function () {
    const bookingForm = document.querySelector("form[action='bookings_process.php']");
    
    if (bookingForm) {
        bookingForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent default behavior

            let formData = new FormData(bookingForm);

            fetch("bookings_process.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "error") {
                    showPopup(data.message); // ❌ If the age or availability does not match
                } else if (data.status === "success") {
                    window.location.href = "bookings.php"; // ✅ Successful booking
                }
            })
            .catch(error => console.error("Fehler:", error));
        });
    }
});

function showPopup(message) {
    document.getElementById("popup-message").textContent = message;
    document.getElementById("booking-popup").style.display = "flex";
}

function closePopup() {
    document.getElementById("booking-popup").style.display = "none";
}