document.addEventListener("DOMContentLoaded", function () {
    let allBookings = document.querySelectorAll(".booking-card"); // Alle Buchungen erfassen
    let currentPage = 0;
    const bookingsPerPage = 3;

    function renderBookings() {
        // Alle Buchungen per CSS ausblenden (NICHT aus dem DOM entfernen!)
        allBookings.forEach((booking, index) => {
            booking.style.display = (index >= currentPage * bookingsPerPage && index < (currentPage + 1) * bookingsPerPage)
                ? "flex" // Buchung sichtbar machen (Original-Formatierung beibehalten!)
                : "none"; // Unsichtbar schalten
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

    renderBookings(); // Erste Anzeige
});