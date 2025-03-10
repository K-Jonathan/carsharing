<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('fetch_car_details.php');

include 'includes/header.php';

$logged_in = isset($_SESSION['userid']);
$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : null;
$car = getCarDetails($car_id);

if (!$car) {
    die("Fehler: Das Auto wurde nicht gefunden.");
}
?>

<body class="car-details-page">
<div class="car-details-wrapper">
    <div class="car-details-container">
        <div class="car-image-section">
            <img src="images/cars/<?php echo htmlspecialchars($car['img_file_name'] ?? 'default.jpg'); ?>" 
                 alt="<?php echo htmlspecialchars($car['vendor_name'] . ' ' . $car['name']); ?>">
        </div>

        <div class="car-info-section">
            <h2 class="car-title">Details – <?php echo htmlspecialchars($car['vendor_name'] . ' ' . $car['name']); ?></h2>
            <hr class="car-title-divider">

            <div class="car-specs">
                <div class="spec">
                    <img src="images/icons/seats.png" alt="Sitze">
                    <span><?php echo htmlspecialchars($car['seats']); ?> Sitzplätze</span>
                </div>
                <div class="spec">
                    <img src="images/icons/doors.png" alt="Türen">
                    <span><?php echo htmlspecialchars($car['doors']); ?> Türen</span>
                </div>
                <div class="spec">
                    <img src="images/icons/trunk.png" alt="Kofferraum">
                    <span>Kofferraum: <?php echo htmlspecialchars($car['trunk']); ?></span>
                </div>
                <div class="spec">
                    <img src="images/icons/gear.png" alt="Getriebe">
                    <span>Getriebe: <?php echo htmlspecialchars($car['gear']); ?></span>
                </div>
                <div class="spec">
                    <img src="images/icons/air-condition.png" alt="Klimaanlage">
                    <span>Klimaanlage: <?php echo $car['air_condition'] ? 'Ja' : 'Nein'; ?></span>
                </div>
                <div class="spec">
                    <img src="images/icons/gps.png" alt="GPS">
                    <span>GPS: <?php echo $car['gps'] ? 'Ja' : 'Nein'; ?></span>
                </div>
                <div class="spec">
                    <img src="images/icons/drive.png" alt="Antrieb">
                    <span>Antrieb: <?php echo htmlspecialchars($car['drive']); ?></span>
                </div>
                <div class="spec">
                    <img src="images/icons/age.png" alt="Mindestalter">
                    <span>Mindestalter: <?php echo htmlspecialchars($car['min_age']); ?></span>
                </div>
            </div>

            <div class="car-booking">
                <h3 class="car-price">Preis – <?php echo number_format($car['price'], 2); ?>€/Tag</h3>

                <!-- Falls nicht eingeloggt, Login-Button anzeigen -->
                <?php if (!$logged_in): ?>
                    <a href="loginpage.php?redirect=<?php echo urlencode($current_url); ?>" class="login-button">Login</a>
                <?php endif; ?>

                <button class="book-button <?php echo !$logged_in ? 'disabled' : ''; ?>" <?php echo !$logged_in ? 'disabled' : ''; ?>>Buchen</button>
            </div>
        </div>
    </div>
</div>
</body>

<?php include 'includes/footer.php'; ?>