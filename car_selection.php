<?php 
include 'includes/header.php'; // Header einfügen
?>
<body class="car-selection">

<?php 
$location = isset($_GET['search-location']) ? htmlspecialchars($_GET['search-location']) : 'Wesel';
$pickupDate = isset($_GET['pickup']) ? htmlspecialchars($_GET['pickup']) : '05. Feb';
$pickupTime = isset($_GET['pickup-time']) ? htmlspecialchars($_GET['pickup-time']) : '16:00';
$returnDate = isset($_GET['return']) ? htmlspecialchars($_GET['return']) : '11. Feb';
$returnTime = isset($_GET['return-time']) ? htmlspecialchars($_GET['return-time']) : '16:30';
?>

<section class="car_filter">
    <div class="filter-container">
        <div class="filter-location">
            <span class="city-label"><?php echo $location; ?></span>
            <div class="filter-dates">
                <span class="date-time"><?php echo $pickupDate; ?></span>
                <span class="divider"></span>
                <span class="date-time"><?php echo $pickupTime; ?></span>
                <span class="dash"> - </span>
                <span class="date-time"><?php echo $returnDate; ?></span>
                <span class="divider"></span>
                <span class="date-time"><?php echo $returnTime; ?></span>
            </div>
        </div>

        <!-- ✅ Filter ist jetzt innerhalb der richtigen Box -->
        <div class="filter-options">
            <button class="filter-btn">Sortierung ▼</button>
            <button class="filter-btn">Typ ▼</button>
            <button class="filter-btn">Getriebe ▼</button>
            <button class="filter-btn">Preis bis ▼</button>
            <button class="filter-btn">Mehr Filter ▼</button>
        </div>
    </div> <!-- ✅ `filter-container` schließt jetzt richtig -->
</section>








<div style="height: 500px;"></div>
</body>




<?php 
include 'includes/footer.php'; // Footer einfügen
?>