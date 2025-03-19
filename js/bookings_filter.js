document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Select buttons and booking list
    const futureBtn = document.getElementById("future-bookings-btn");
    const pastBtn = document.getElementById("past-bookings-btn");
    const bookingsList = document.getElementById("bookings-list");
    
    // 🔹 Popup elements for booking cancellation
    const popup = document.getElementById("cancel-booking-popup");
    const confirmButton = document.getElementById("cancel-booking-confirm");
    const closeButton = document.getElementById("cancel-booking-close");

    let bookingIdToCancel = null; // Stores the ID of the booking to be canceled
    let bookingsData = { future: [], past: [] }; // Holds booking data for both categories

    // 🔹 Fetch booking data from the server
    function fetchBookings() {
        fetch("fetch_bookings.php")
            .then(response => response.json()) // Convert response to JSON
            .then(data => {
                bookingsData = data;
                renderBookings("future"); // Default: Show future bookings first
            })
            .catch(error => console.error("Error fetching bookings:", error));
    }

    // 🔹 Function to render bookings based on category (future/past)
    function renderBookings(type) {
        bookingsList.innerHTML = ""; // Clear the list before rendering new data

        if (!bookingsData[type] || bookingsData[type].length === 0) {
            bookingsList.innerHTML = `<p class="no-bookings">No ${type === "future" ? "upcoming" : "past"} bookings found.</p>`;
            return;
        }

        // 🔹 Generate booking cards dynamically
        bookingsData[type].forEach(row => {
            const bookingCard = document.createElement("div");
            bookingCard.classList.add("booking-card");

            bookingCard.innerHTML = `
                <div class="booking-image">
                    <img src="images/cars/${row.img_file_name}" alt="${row.vendor_name} ${row.car_name}">
                </div>
                <div class="booking-info">
                    <h2 class="booking-title">${row.vendor_name} ${row.car_name}</h2>
                    <hr class="booking-divider">
                    <table class="booking-table">
                        <tr class="booking-table-header">
                            <th>ID</th><th>Booking</th><th>Pickup</th><th>Return</th><th>Location</th>
                        </tr>
                        <tr class="booking-table-data">
                            <td>${row.booking_id}</td>
                            <td>${formatDate(row.booking_time)}</td>
                            <td>${formatDate(row.pickup_date)} - ${row.pickup_time}</td>
                            <td>${formatDate(row.return_date)} - ${row.return_time}</td>
                            <td>${row.loc_name}</td>
                        </tr>
                    </table>
                    <div class="booking-buttons">
                        ${type === "future" ? `<button class="cancel-booking-button" data-booking-id="${row.booking_id}">Cancel</button>` : ""}
                        <button class="details-button" data-booking-id="${row.booking_id}">Details</button>
                    </div>
                </div>
            `;

            bookingsList.appendChild(bookingCard); // Append the booking card to the list
        });

        // 🔹 Add event listeners for "Details" buttons
        document.querySelectorAll(".details-button").forEach(button => {
            button.addEventListener("click", function () {
                const bookingId = this.getAttribute("data-booking-id");
                if (bookingId) {
                    window.location.href = `booking_details.php?booking_id=${bookingId}`;
                }
            });
        });
    }

    // 🔹 Format date strings for display
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString("de-DE"); // Convert to German date format
    }

    // 🔹 Toggle between future and past bookings
    futureBtn.addEventListener("click", function () {
        futureBtn.classList.add("active");
        pastBtn.classList.remove("active");
        renderBookings("future");
    });

    pastBtn.addEventListener("click", function () {
        pastBtn.classList.add("active");
        futureBtn.classList.remove("active");
        renderBookings("past");
    });

    // 🔹 Event Delegation: Handle cancellation buttons dynamically
    bookingsList.addEventListener("click", function (event) {
        if (event.target.classList.contains("cancel-booking-button")) {
            bookingIdToCancel = event.target.getAttribute("data-booking-id");
            popup.style.display = "flex";
        }
    });

    // 🔹 Close the cancellation popup
    closeButton.addEventListener("click", function () {
        popup.style.display = "none";
    });

    // 🔹 Confirm and process the booking cancellation
    confirmButton.addEventListener("click", function () {
        if (bookingIdToCancel) {
            window.location.href = `cancel_booking.php?booking_id=${bookingIdToCancel}`;
        }
    });

    fetchBookings(); // Load bookings when the page loads
});