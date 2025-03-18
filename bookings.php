<?php 
include 'includes/header.php'; 
?>

<body class="bookings-page">
<div class="bookings-container">
    <div class="filter-buttons">
        <button id="future-bookings-btn" class="filter-button active">Zukünftige Buchungen</button>
        <button id="past-bookings-btn" class="filter-button">Aktuelle/Vergangene Buchungen</button>
    </div>

    <!-- 🔹 Hier werden die Buchungen per JS geladen -->
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
<script src="js/bookings_filter.js"></script>
</body>

<?php include 'includes/footer.php'; ?>