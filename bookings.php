<?php 
include 'includes/header.php'; // Header einfügen
require_once('fetch_bookings.php'); // Buchungen abrufen
?>

<body class="bookings-page">
    <div class="bookings-container">
        <h2 class="bookings-title">Meine Buchungen</h2>

        <!-- 🔹 Labels-Zeile -->
        <div class="booking-row booking-labels">
            <span>ID</span>
            <span>Buchungsdatum</span>
            <span>Abholung</span>
            <span>Rückgabe</span>
            <span>Standort</span>
            <span>Auswahl</span>
        </div>

        <!-- 🔹 Buchungen -->
        <?php if (!empty($bookings)): ?>
            <?php foreach ($bookings as $row): ?>
                <div class="booking-row booking-card">
                    <span><?php echo $row['booking_id']; ?></span>
                    <span><?php echo $row['booking_time']; ?></span>
                    <span><?php echo $row['pickup_date'] . ' ' . $row['pickup_time']; ?></span>
                    <span><?php echo $row['return_date'] . ' ' . $row['return_time']; ?></span>
                    <span><?php echo htmlspecialchars($row['loc_name']); ?></span>
                    <span class="car-name"><?php echo htmlspecialchars($row['vendor_name'] . ' ' . $row['car_name']); ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-bookings">Sie haben noch keine Buchungen.</p>
        <?php endif; ?>
    </div>

    <div style="height: 150px;"></div>
</body>

<?php include 'includes/footer.php'; ?>