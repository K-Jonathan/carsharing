document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Get popup elements for canceling a booking
    const popup = document.getElementById("cancel-booking-popup");
    const confirmButton = document.getElementById("cancel-booking-confirm");
    const closeButton = document.getElementById("cancel-booking-close");

    let bookingIdToCancel = null; // Stores the ID of the booking to be canceled

    // 🔹 Function to open the cancel confirmation popup
    function openCancelPopup(bookingId) {
        if (!popup) return;
        bookingIdToCancel = bookingId;
        popup.style.display = "flex";
    }

    // 🔹 Close the popup when the close button is clicked
    closeButton.addEventListener("click", function () {
        popup.style.display = "none";
    });

    // 🔹 Confirm and proceed with the cancellation
    confirmButton.addEventListener("click", function () {
        if (bookingIdToCancel) {
            window.location.href = `cancel_booking.php?booking_id=${bookingIdToCancel}`;
        }
    });

    // 🔹 Make the function globally accessible
    window.openCancelPopup = openCancelPopup;
});