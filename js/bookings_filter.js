document.addEventListener("DOMContentLoaded", function () {
    const futureBtn = document.getElementById("future-bookings-btn");
    const pastBtn = document.getElementById("past-bookings-btn");
    const bookingsList = document.getElementById("bookings-list");
    
    const popup = document.getElementById("cancel-booking-popup");
    const confirmButton = document.getElementById("cancel-booking-confirm");
    const closeButton = document.getElementById("cancel-booking-close");

    let bookingIdToCancel = null;
    let bookingsData = { future: [], past: [] };

    function fetchBookings() {
        fetch("fetch_bookings.php")
            .then(response => response.json())
            .then(data => {
                bookingsData = data;
                renderBookings("future"); // Standard: Zukünftige Buchungen anzeigen
            })
            .catch(error => console.error("Fehler beim Abrufen der Buchungen:", error));
    }

    function renderBookings(type) {
        bookingsList.innerHTML = "";

        if (!bookingsData[type] || bookingsData[type].length === 0) {
            bookingsList.innerHTML = `<p class="no-bookings">Keine ${type === "future" ? "zukünftigen" : "vergangenen"} Buchungen gefunden.</p>`;
            return;
        }

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
                            <th>ID</th><th>Buchung</th><th>Abholung</th><th>Abgabe</th><th>Standort</th>
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
                        ${type === "future" ? `<button class="cancel-booking-button" data-booking-id="${row.booking_id}">Stornieren</button>` : ""}
                        <button class="details-button">Details</button>
                    </div>
                </div>
            `;

            bookingsList.appendChild(bookingCard);
        });
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString("de-DE");
    }

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

    // 🔹 **Event-Delegation für Stornieren-Buttons**
    bookingsList.addEventListener("click", function (event) {
        if (event.target.classList.contains("cancel-booking-button")) {
            bookingIdToCancel = event.target.getAttribute("data-booking-id");
            popup.style.display = "flex";
        }
    });

    closeButton.addEventListener("click", function () {
        popup.style.display = "none";
    });

    confirmButton.addEventListener("click", function () {
        if (bookingIdToCancel) {
            window.location.href = `cancel_booking.php?booking_id=${bookingIdToCancel}`;
        }
    });

    fetchBookings();
});