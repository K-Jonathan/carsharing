<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'includes/header.php';
require_once('helpers.php'); // ✅ Hilfsfunktionen einbinden

$logged_in = isset($_SESSION['userid']);
$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : null;

if (!$logged_in) {
    header("Location: loginpage.php?redirect=" . urlencode($current_url));
    exit();
}
?>

<body class="booking-details-page">
<div class="blocker"></div>
<a href="bookings.php" class="back-button-details">← Zurück</a>

<div class="car-details-wrapper">
    <div class="car-details-container">
    <div class="car-image-section">
    <img id="car-image" src="images/cars/default.jpg" alt="Fahrzeugbild">
</div>



        <div class="car-info-section">
            <h2 class="car-title" id="car-title">Buchungsdetails</h2>
            <hr class="car-title-divider">
            
            <div class="car-specs">
                <div class="spec"><img src="images/icons/seats.png" alt="Sitze"><span id="seats"></span></div>
                <div class="spec"><img src="images/icons/doors.png" alt="Türen"><span id="doors"></span></div>
                <div class="spec"><img src="images/icons/trunk.png" alt="Kofferraum"><span id="trunk"></span></div>
                <div class="spec"><img src="images/icons/gear.png" alt="Getriebe"><span id="gear"></span></div>
                <div class="spec"><img src="images/icons/air-condition.png" alt="Klimaanlage"><span id="air_condition"></span></div>
                <div class="spec"><img src="images/icons/gps.png" alt="GPS"><span id="gps"></span></div>
                <div class="spec"><img src="images/icons/drive.png" alt="Antrieb"><span id="drive"></span></div>
                <div class="spec"><img src="images/icons/age.png" alt="Mindestalter"><span id="min_age"></span></div>
            </div>

            <div class="car-booking">
                <h3 class="car-price" id="total-price">Gesamtpreis: -</h3>
                <p><strong>Abholung:</strong> <span id="pickup"></span></p>
                <p><strong>Rückgabe:</strong> <span id="return"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const bookingId = <?php echo json_encode($booking_id); ?>;
    
    if (!bookingId) {
        alert("Fehler: Keine Buchungs-ID angegeben.");
        window.location.href = "bookings.php";
        return;
    }

    fetch("fetch_booking_details.php?booking_id=" + bookingId)
        .then(response => response.json())
        .then(data => {
            if (data.status !== "success") {
                alert("Fehler: " + data.message);
                window.location.href = "bookings.php";
                return;
            }

            const booking = data.data;
            document.getElementById("car-image").src = "images/cars/" + (booking.img_file_name || "default.jpg");
            document.getElementById("car-title").textContent = "Buchungsdetails – " + booking.vendor_name + " " + booking.car_name;
            document.getElementById("seats").textContent = booking.seats + " Sitzplätze";
            document.getElementById("doors").textContent = booking.doors + " Türen";
            document.getElementById("trunk").textContent = "Kofferraum: " + booking.trunk;
            document.getElementById("gear").textContent = "Getriebe: " + booking.gear;
            document.getElementById("air_condition").textContent = "Klimaanlage: " + (booking.air_condition ? "Ja" : "Nein");
            document.getElementById("gps").textContent = "GPS: " + (booking.gps ? "Ja" : "Nein");
            document.getElementById("drive").textContent = "Antrieb: " + booking.drive;
            document.getElementById("min_age").textContent = "Mindestalter: " + booking.min_age;

            const totalDays = (new Date(booking.return_date) - new Date(booking.pickup_date)) / (1000 * 60 * 60 * 24);
            const totalPrice = totalDays * booking.price;
            document.getElementById("total-price").textContent = "Gesamtpreis: " + totalPrice.toFixed(2) + "€";

            document.getElementById("pickup").textContent = booking.pickup_date + " um " + booking.pickup_time;
            document.getElementById("return").textContent = booking.return_date + " um " + booking.return_time;
        })
        .catch(error => {
            console.error("Fehler beim Abrufen der Buchungsdetails:", error);
            alert("Ein Fehler ist aufgetreten.");
            window.location.href = "bookings.php";
        });
});
</script>

</body>

<?php include 'includes/footer.php'; ?>