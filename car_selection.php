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
        <button class="filter-btn" id="sort-filter">Sortierung ▼</button>

<!-- 🔹 Dropdown-Box für Sortierung -->
<div id="sort-dropdown" class="dropdown-box hidden">
    <button>Preis absteigend</button>
    <button>Preis aufsteigend</button>
</div>
            <button class="filter-btn" id="type-filter">Typ ▼</button>

<!-- 🔹 Dropdown-Box für Typ -->
<div id="type-dropdown" class="dropdown-box hidden">
    <button>Limousine</button>
    <button>Combi</button>
    <button>Coupe</button>
    <button>Cabriolet</button>
    <button>Mehrsitzer</button>
    <button>SUV</button>
</div>
            <button class="filter-btn" id="gear-filter">Getriebe ▼</button>

<!-- 🔹 Dropdown-Box für Getriebe -->
<div id="gear-dropdown" class="dropdown-box hidden">
    <button>Automatik</button>
    <button>Manuell</button>
</div>

<button class="filter-btn" id="price-filter">Preis bis ▼</button>

<!-- 🔹 Dropdown-Box für "Preis bis" -->
<div id="price-dropdown" class="dropdown-box hidden">
    <button>150</button>
    <button>300</button>
    <button>450</button>
    <button>600</button>
    <button>750</button>
    <button>900</button>
</div>

<button class="filter-btn" id="more-filters-btn">Mehr Filter ▼</button>


</div>
    </div> <!-- ✅ `filter-container` schließt jetzt richtig -->



    
    
</section>

<section class="car_more_filter">
    <!-- 🔹 Neuer weißer Kasten, der später eingeblendet wird -->
    <div id="extra-filters-box" class="hidden">
        <div class="extra-filters">
            <!-- Hersteller Dropdown -->
            <button class="filter-btn" id="manufacturer-filter">Hersteller ▼</button>
            <div id="manufacturer-dropdown" class="dropdown-box hidden">
                <button>BMW</button>
                <button>Audi</button>
                <button>Mini</button>
                <button>Ford</button>
                <button>Mercedes-AMG</button>
                <button>Volkswagen</button>
                <button>Mercedes-Benz</button>
                <button>Range Rover</button>
                <button>Maserati</button>
                <button>Opel</button>
                <button>Jaguar</button>
                <button>Skoda</button>
            </div>

            <!-- Türen Dropdown -->
            <button class="filter-btn" id="doors-filter">Türen ▼</button>
            <div id="doors-dropdown" class="dropdown-box hidden">
                <button>3</button>
                <button>4</button>
                <button>5</button>
            </div>

            <!-- Sitze Dropdown -->
<button class="filter-btn" id="seats-filter">Sitze ▼</button>
<div id="seats-dropdown" class="dropdown-box hidden">
    <button>2</button>
    <button>4</button>
    <button>5</button>
    <button>7</button>
    <button>8</button>
    <button>9</button>
</div>
            <!-- Antrieb Dropdown -->
<button class="filter-btn" id="drive-filter">Antrieb ▼</button>
<div id="drive-dropdown" class="dropdown-box hidden">
    <button>Verbrenner</button>
    <button>Elektrisch</button>
</div>
            <!-- Alter Fahrer Dropdown -->
<button class="filter-btn" id="age-filter">Alter Fahrer ▼</button>
<div id="age-dropdown" class="dropdown-box hidden">
    <button>18</button>
    <button>21</button>
    <button>25</button>
</div>
<button class="filter-btn toggle-btn" id="climate-filter">Klima</button>
<button class="filter-btn toggle-btn" id="gps-filter">GPS</button>

            <!-- Kofferraumvolumen Dropdown -->
<button class="filter-btn" id="trunk-filter">Kofferraumvolumen ▼</button>
<div id="trunk-dropdown" class="dropdown-box hidden">
    <button>Klein</button>
    <button>Mittel</button>
    <button>Groß</button>
</div>
        </div>
    </div>
</section>



<div id="car-list">
    <!-- 🚗 Hier werden die Car-IDs dynamisch eingefügt -->
</div>




<div style="height: 500px;"></div>
</body>




<?php 
include 'includes/footer.php'; // Footer einfügen
?>