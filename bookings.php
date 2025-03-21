<!--
This is the "My Bookings" page, allowing users to view and manage their future and past car rental bookings.

📦 Page Structure:
- Includes the global header and footer for consistency.
- Uses a `<body>` tag with the class `bookings-page` for targeted styling.

🗂️ Booking Filters:
- Two buttons at the top allow users to toggle between:
  - "Zukünftige Buchungen" (Future Bookings)
  - "Aktuelle/Vergangene Buchungen" (Current/Past Bookings)

🔄 Pagination:
- "Previous" and "Next" buttons control which subset of bookings is displayed.
- Disabled/enabled dynamically via JavaScript based on available pages.

📃 Booking List:
- Bookings are loaded dynamically into the `#bookings-list` container using JavaScript (`bookings_filter.js` and `bookings_paging.js`).

❌ Booking Cancellation:
- When a user opts to cancel a booking, a confirmation popup appears.
- Buttons allow confirming or cancelling the cancellation process.
- Logic is handled in `cancel_booking.js`.

🧩 JavaScript Integration:
- `bookings_filter.js`: Handles filtering logic between future and past bookings.
- `bookings_paging.js`: Manages pagination behavior.
- `cancel_booking.js`: Handles popup display and booking cancellation.

This page provides users with a full overview of their bookings and simple controls to manage or cancel them efficiently.
-->
<?php
include 'includes/header.php'; //Insert Header
?>

<body class="bookings-page">
    <!-- Invisible positioning spacer -->
    <div class="bookings-container">
        <div class="top-section">
            <!-- Filter buttons -->
            <div class="filter-buttons">
                <button id="future-bookings-btn" class="filter-button active">Zukünftige Buchungen</button>
                <button id="past-bookings-btn" class="filter-button">Aktuelle/Vergangene Buchungen</button>
            </div>

            <!-- Paginierungs-Schaltflächen -->
            <div class="pagination-buttons">
                <button id="prev-bookings" class="pagination-button" disabled>←</button>
                <button id="next-bookings" class="pagination-button">→</button>
            </div>
        </div>

        <!--  Here the bookings are loaded via JS -->
        <div id="bookings-list"></div>
    </div>

    <!-- Cancellation pop-up -->
    <div id="cancel-booking-popup" class="cancel-popup-overlay" style="display: none;">
        <div class="cancel-popup-box">
            <p class="cancel-popup-title">Möchten Sie Ihre Buchung wirklich stornieren?</p>
            <div class="cancel-popup-buttons">
                <button id="cancel-booking-confirm" class="cancel-popup-confirm">Ja, stornieren</button>
                <button id="cancel-booking-close" class="cancel-popup-close">Nein</button>
            </div>
        </div>
    </div>

    <script src="js/cancel_booking.js"></script>
    <script src="js/bookings_filter.js"></script>
    <script src="js/bookings_paging.js"></script>
</body>
<!--Insert Footer-->
<?php include 'includes/footer.php'; ?>