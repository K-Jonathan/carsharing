document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("cancel-booking-popup");
    const confirmButton = document.getElementById("cancel-booking-confirm");
    const closeButton = document.getElementById("cancel-booking-close");

    let bookingIdToCancel = null;

    function openCancelPopup(bookingId) {
        if (!popup) return;
        bookingIdToCancel = bookingId;
        popup.style.display = "flex";
    }

    closeButton.addEventListener("click", function () {
        popup.style.display = "none";
    });

    confirmButton.addEventListener("click", function () {
        if (bookingIdToCancel) {
            window.location.href = `cancel_booking.php?booking_id=${bookingIdToCancel}`;
        }
    });

    window.openCancelPopup = openCancelPopup; // Funktion global machen
});