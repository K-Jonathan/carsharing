<?php
/**
 * Bookings Overview Page
 * 
 * - Displays a user's bookings split into future and current/past using dynamic filters.
 * - Includes pagination for navigating through large numbers of bookings.
 * - Uses JavaScript to fetch, filter, and display bookings in the `#bookings-list` container.
 * - Provides a cancellation popup for users to confirm booking cancellation.
 * - Scripts:
 *   - `cancel_booking.js` handles the cancellation logic.
 *   - `bookings_filter.js` manages booking filter switching.
 *   - `bookings_paging.js` controls pagination behavior.
 * - Layout includes top navigation for filters and pagination, dynamically updated content area, and modal popup.
 * 
 * Designed to give users a clean and interactive view of all their bookings.
 */
?>
<?php 
include 'includes/header.php'; 
?>

<body class="bookings-page">
<div class="bookings-container">
    <div class="top-section">
        <!-- Filter-Buttons -->
        <div class="filter-buttons">
            <button id="future-bookings-btn" class="filter-button active">Zukünftige Buchungen</button>
            <button id="past-bookings-btn" class="filter-button">Aktuelle/Vergangene Buchungen</button>
        </div>

        
        <div class="pagination-buttons">
            <button id="prev-bookings" class="pagination-button" disabled>←</button>
            <button id="next-bookings" class="pagination-button">→</button>
        </div>
    </div>

    
    <div id="bookings-list"></div>
</div>


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

<?php include 'includes/footer.php'; ?>