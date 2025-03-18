document.addEventListener("DOMContentLoaded", function () {
    const bookingForm = document.querySelector("form[action='bookings_process.php']");
    
    if (bookingForm) {
        bookingForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Standardverhalten verhindern

            let formData = new FormData(bookingForm);

            fetch("bookings_process.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "error") {
                    showPopup(data.message); // ❌ Falls das Alter oder die Verfügbarkeit nicht passt
                } else if (data.status === "success") {
                    window.location.href = "bookings.php"; // ✅ Erfolgreiche Buchung
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