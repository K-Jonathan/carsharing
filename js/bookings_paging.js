document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Select all booking cards (each represents a single booking)
    let allBookings = document.querySelectorAll(".booking-card");

    // 🔹 Tracks the current page in pagination
    let currentPage = 0;

    // 🔹 Defines how many bookings should be displayed per page
    const bookingsPerPage = 3;

    // 🔹 Function to display only the bookings that belong to the current page
    function renderBookings() {
        allBookings.forEach((booking, index) => {
            // If the booking is within the range of the current page, show it
            if (index >= currentPage * bookingsPerPage && index < (currentPage + 1) * bookingsPerPage) {
                booking.style.display = "flex"; // Ensure it maintains its original layout
            } else {
                booking.style.display = "none"; // Hide all other bookings
            }
        });

        updatePaginationButtons(); // Update navigation button states
    }

    // 🔹 Function to enable or disable pagination buttons based on current page
    function updatePaginationButtons() {
        // Disable "Previous" button if on the first page
        document.getElementById("prev-bookings").disabled = (currentPage === 0);

        // Disable "Next" button if there are no more pages left
        document.getElementById("next-bookings").disabled = ((currentPage + 1) * bookingsPerPage >= allBookings.length);
    }

    // 🔹 Event listener for the "Previous" button
    document.getElementById("prev-bookings").addEventListener("click", function () {
        if (currentPage > 0) {
            currentPage--; // Move to the previous page
            renderBookings(); // Re-render the visible bookings
        }
    });

    // 🔹 Event listener for the "Next" button
    document.getElementById("next-bookings").addEventListener("click", function () {
        if ((currentPage + 1) * bookingsPerPage < allBookings.length) {
            currentPage++; // Move to the next page
            renderBookings(); // Re-render the visible bookings
        }
    });

    renderBookings(); // Initial render to display the first set of bookings
});