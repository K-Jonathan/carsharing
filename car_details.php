<!--
This is the "Car Details" page where users can view specific information about a selected vehicle and initiate a booking.

🧩 Page Setup:
- Starts session if not already active.
- Includes header and footer templates for consistent layout.
- Fetches vehicle data using `fetch_car_details.php` and utility functions from `helpers.php`.

🚗 Car Details Display:
- Car image and title (brand + model).
- Specifications include:
  - Seats, Doors, Trunk size
  - Gear type, Air conditioning, GPS, Drive type
  - Minimum driver age

💶 Price Section:
- Displays rental price in €/day.
- If the user is not logged in, a login button is shown (with redirect to current URL after login).

📋 Booking Form:
- Sends a POST request to `bookings_process.php`.
- Hidden inputs pass selected `car_id`, `pickup/return dates`, and `times` (converted using `convertDate()`).
- Submit button is disabled for non-logged-in users.

❌ Popup Modal:
- Displays an error message if booking fails (controlled via JS in `car_details_popup.js`).

🧠 UX Enhancements:
- Proper validation for logged-in state.
- Secure and user-friendly booking process.
- Graceful fallback if the car is not found.

This page merges dynamic PHP logic with structured HTML and JS to deliver a seamless car selection and booking experience.
-->
<?php 
// Start a session if none is active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Include the necessary PHP files
require_once('fetch_car_details.php'); // Fetches car details from the database
require_once('helpers.php'); // Integrate help functions

// Include the page header
include 'includes/header.php';

// Check if the user is logged in
$logged_in = isset($_SESSION['userid']);
// Get the current URL
$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// Retrieve the car ID from the GET parameter and convert it to an integer
$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : null;
// Fetch car details using the helper function
$car = getCarDetails($car_id);

// If the car does not exist, show an error message
if (!$car) {
    die("Fehler: Das Auto wurde nicht gefunden.");
}
?>

<body class="car-details-page">
<div class="blocker"></div>
<!-- Car details section -->
<div class="car-details-wrapper">
    <div class="car-details-container">
        <!-- Car image -->
        <div class="car-image-section">
            <img src="images/cars/<?php echo htmlspecialchars($car['img_file_name'] ?? 'default.jpg'); ?>" 
                 alt="<?php echo htmlspecialchars($car['vendor_name'] . ' ' . $car['name']); ?>">
        </div>

        <!-- Car information -->
        <div class="car-info-section">
            <h2 class="car-title">Details – <?php echo htmlspecialchars($car['vendor_name'] . ' ' . $car['name']); ?></h2>
            <hr class="car-title-divider">
            <!-- Car specifications -->
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

            <!-- Booking section -->
            <div class="car-booking">
                <h3 class="car-price">Preis – <?php echo number_format($car['price'], 2); ?>€/Tag</h3>

                <!-- If not logged in, show login button -->
                <?php if (!$logged_in): ?>
                    <a href="loginpage.php?redirect=<?php echo urlencode($current_url); ?>" class="login-button">Login</a>
                <?php endif; ?>

                <!-- Booking form  -->
                <form action="bookings_process.php" method="POST"> 
    <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car['car_id']); ?>">
    <input type="hidden" name="pickup_date" value="<?php echo convertDate($_GET['pickup'] ?? ''); ?>">
    <input type="hidden" name="pickup_time" value="<?php echo htmlspecialchars($_GET['pickup-time'] ?? ''); ?>">
    <input type="hidden" name="return_date" value="<?php echo convertDate($_GET['return'] ?? ''); ?>">
    <input type="hidden" name="return_time" value="<?php echo htmlspecialchars($_GET['return-time'] ?? ''); ?>">

    <button type="submit" class="book-button <?php echo !$logged_in ? 'disabled' : ''; ?>" <?php echo !$logged_in ? 'disabled' : ''; ?>>
        Buchen
    </button>
</form>
            </div>
        </div>
    </div>
</div>
<div id="booking-popup" class="popup-overlay">
    <div class="popup-box">
        <h2 class="popup-title">Buchungsfehler</h2> 
        <p id="popup-message"></p>
        <button class="popup-close" onclick="closePopup()">Schließen</button>
    </div>
</div>
<script src="js/car_details_popup.js" defer></script>
</body>

<?php include 'includes/footer.php'; ?>