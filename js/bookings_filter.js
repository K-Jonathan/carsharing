document.addEventListener("DOMContentLoaded", function () {
    const futureBtn = document.getElementById("future-bookings-btn");
    const pastBtn = document.getElementById("past-bookings-btn");
    const bookingsList = document.getElementById("bookings-list");
    const prevButton = document.getElementById("prev-bookings");
    const nextButton = document.getElementById("next-bookings");

    let currentPage = 0;
    const bookingsPerPage = 3;
    let currentType = "future";
    let bookingsData = { future: [], past: [] };

    function fetchBookings() {
        fetch("fetch_bookings.php")
            .then(response => response.json())
            .then(data => {
                bookingsData = data;
                currentPage = 0;
                renderBookings(currentType);
            })
            .catch(error => console.error("Fehler beim Abrufen der Buchungen:", error));
    }

    function renderBookings(type) {
        bookingsList.innerHTML = "";
        currentType = type;

        if (!bookingsData[type] || bookingsData[type].length === 0) {
            bookingsList.innerHTML = `<p class="no-bookings">Keine ${type === "future" ? "zukünftigen" : "vergangenen"} Buchungen gefunden.</p>`;
            updatePaginationButtons();
            return;
        }

        let start = currentPage * bookingsPerPage;
        let paginatedBookings = bookingsData[type].slice(start, start + bookingsPerPage);

        paginatedBookings.forEach(row => {
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
                        <button class="details-button" data-booking-id="${row.booking_id}">Details</button>
                    </div>
                </div>
            `;

            bookingsList.appendChild(bookingCard);
        });

        updatePaginationButtons();
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString("de-DE");
    }

    function updatePaginationButtons() {
        prevButton.disabled = (currentPage === 0);
        nextButton.disabled = ((currentPage + 1) * bookingsPerPage >= bookingsData[currentType].length);
    }

    prevButton.addEventListener("click", function () {
        if (currentPage > 0) {
            currentPage--;
            renderBookings(currentType);
        }
    });

    nextButton.addEventListener("click", function () {
        if ((currentPage + 1) * bookingsPerPage < bookingsData[currentType].length) {
            currentPage++;
            renderBookings(currentType);
        }
    });

    futureBtn.addEventListener("click", function () {
        futureBtn.classList.add("active");
        pastBtn.classList.remove("active");
        currentPage = 0;
        renderBookings("future");
    });

    pastBtn.addEventListener("click", function () {
        pastBtn.classList.add("active");
        futureBtn.classList.remove("active");
        currentPage = 0;
        renderBookings("past");
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

    // 🔹 Event-Delegation für "Stornieren"-Buttons
    bookingsList.addEventListener("click", function (event) {
        if (event.target.classList.contains("cancel-booking-button")) {
            const bookingId = event.target.getAttribute("data-booking-id");
            if (bookingId) {
                openCancelPopup(bookingId);
            }
        }
    });

    fetchBookings();
});