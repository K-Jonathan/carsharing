<?php 
include 'includes/header.php'; 
require_once('fetch_bookings.php'); 
?>

<body class="bookings-page">
    <div class="bookings-container">
        <h2 class="bookings-title">Meine Buchungen</h2>

        <?php if (!empty($bookings)): ?>
            <?php foreach ($bookings as $row): ?>
                <div class="booking-card">
                    <!-- 🔹 Bildbereich -->
                    <div class="booking-image">
                        <img src="images/cars/<?php echo htmlspecialchars($row['img_file_name']); ?>" 
                             alt="<?php echo htmlspecialchars($row['vendor_name'] . ' ' . $row['car_name']); ?>">
                    </div>

                    <!-- 🔹 Infobereich -->
                    <div class="booking-info">
                    <h2 class="booking-title"><?php echo htmlspecialchars($row['vendor_name'] . ' ' . $row['car_name']); ?></h2>
<hr class="booking-divider"> <!-- Horizontale Linie -->

<!-- 🔹 Tabelle für Buchungsinformationen -->
<table class="booking-table">
    <tr class="booking-table-header">
        <th>ID</th>
        <th>Buchung</th>
        <th>Abholung</th>
        <th>Abgabe</th>
        <th>Standort</th>
    </tr>
    <tr class="booking-table-data">
        <td><?php echo $row['booking_id']; ?></td>
        <td><?php echo date("d.m.y", strtotime($row['booking_time'])); ?></td>
        <td><?php echo date("d.m.y", strtotime($row['pickup_date'])) . " - " . date("H:i", strtotime($row['pickup_time'])); ?></td>
        <td><?php echo date("d.m.y", strtotime($row['return_date'])) . " - " . date("H:i", strtotime($row['return_time'])); ?></td>
        <td><?php echo htmlspecialchars($row['loc_name']); ?></td>
    </tr>
</table>
<div class="booking-buttons">
    <button class="cancel-booking-button" data-booking-id="<?php echo $row['booking_id']; ?>">Stornieren</button>
    <button class="details-button">Details</button>
</div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-bookings">Sie haben noch keine Buchungen.</p>
        <?php endif; ?>
    </div>
    <!-- Stornierungs-Pop-up -->
<!-- Stornierungs-Pop-up -->
<div id="cancel-booking-popup" class="cancel-popup-overlay">
    <div class="cancel-popup-box">
        <p class="cancel-popup-title">Möchten Sie Ihre Buchung wirklich stornieren?</p>
        <div class="cancel-popup-buttons">
            <button id="cancel-booking-confirm" class="cancel-popup-confirm">Ja, stornieren</button>
            <button id="cancel-booking-close" class="cancel-popup-close">Nein</button>
        </div>
    </div>
</div>
<script src="js/cancel_booking.js"></script>
</body>

<?php include 'includes/footer.php'; ?>