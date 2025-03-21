/**
 * This script manages the "Cancel Booking" confirmation popup.
 * 
 * - `openCancelPopup(bookingId)` displays the popup and stores the ID of the booking to cancel.
 * - Clicking the ❌ close button hides the popup.
 * - Clicking the ✅ confirm button redirects to `cancel_booking.php` with the booking ID as a URL parameter.
 * - The `openCancelPopup` function is exposed globally so it can be triggered from other scripts (e.g., booking list).
 */
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

    window.openCancelPopup = openCancelPopup; // Make function global
});