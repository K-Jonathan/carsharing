document.addEventListener("DOMContentLoaded", function () {
    let allBookings = [];
    let currentPage = 0;
    const bookingsPerPage = 3;
    const bookingsList = document.getElementById("bookings-list");

    function renderBookings() {
        allBookings = document.querySelectorAll(".booking-card");

        bookingsList.innerHTML = ""; // Liste leeren, um nur relevante Buchungen anzuzeigen

        allBookings.forEach((booking, index) => {
            if (index >= currentPage * bookingsPerPage && index < (currentPage + 1) * bookingsPerPage) {
                bookingsList.appendChild(booking.cloneNode(true)); // Buchung einfügen
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

    // 🔹 Event-Delegation für "Details"-Buttons
    bookingsList.addEventListener("click", function (event) {
        if (event.target.classList.contains("details-button")) {
            const bookingId = event.target.getAttribute("data-booking-id");
            if (bookingId) {
                window.location.href = `booking_details.php?booking_id=${bookingId}`;
            }
        }
    });

    renderBookings(); // Erste Anzeige
});