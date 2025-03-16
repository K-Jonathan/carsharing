document.addEventListener("DOMContentLoaded", function () {
    const bookingForm = document.querySelector("form[action='bookings_process.php']");
    if (bookingForm) {
        bookingForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Standardformularverhalten verhindern

            let formData = new FormData(bookingForm);

            fetch("bookings_process.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "error") {
                    showPopup(data.message);
                } else if (data.status === "success") {
                    window.location.href = "bookings.php"; // Weiterleitung bei Erfolg
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