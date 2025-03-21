/**
 * This script handles client-side pagination and interaction for a static list of booking cards.
 * 
 * Features:
 * - Selects all `.booking-card` elements already present in the DOM.
 * - Paginates the bookings list to show 3 cards per page.
 * - Re-renders the visible booking cards when "Previous" or "Next" buttons are clicked.
 * - Updates pagination buttons' disabled state based on the current page.
 * - Uses event delegation to handle "Details" button clicks:
 *    🔹 Navigates to `booking_details.php` with the selected booking ID.
 * 
 * Note: It clones booking cards into the visible area to avoid altering the original elements.
 */
document.addEventListener("DOMContentLoaded", function () {
    let allBookings = [];
    let currentPage = 0;
    const bookingsPerPage = 3;
    const bookingsList = document.getElementById("bookings-list");

    function renderBookings() {
        allBookings = document.querySelectorAll(".booking-card");

        bookingsList.innerHTML = ""; // Clear list to display only relevant bookings

        allBookings.forEach((booking, index) => {
            if (index >= currentPage * bookingsPerPage && index < (currentPage + 1) * bookingsPerPage) {
                bookingsList.appendChild(booking.cloneNode(true)); // Insert booking
            }
        });

        updatePaginationButtons();
    }

    function updatePaginationButtons() {
        document.getElementById("prev-bookings").disabled = (currentPage === 0);
        document.getElementById("next-bookings").disabled = ((currentPage + 1) * bookingsPerPage >= allBookings.length);
    }

    document.getElementById("prev-bookings").addEventListener("click", function () {
        if (currentPage > 0) {
            currentPage--;
            renderBookings();
        }
    });

    document.getElementById("next-bookings").addEventListener("click", function () {
        if ((currentPage + 1) * bookingsPerPage < allBookings.length) {
            currentPage++;
            renderBookings();
        }
    });

    // 🔹 Event delegation for “Details” buttons
    bookingsList.addEventListener("click", function (event) {
        if (event.target.classList.contains("details-button")) {
            const bookingId = event.target.getAttribute("data-booking-id");
            if (bookingId) {
                window.location.href = `booking_details.php?booking_id=${bookingId}`;
            }
        }
    });

    renderBookings(); // First display
});