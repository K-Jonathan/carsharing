<?php
/**
 * Car Selection Page
 * 
 * - Serves as the main interface for users to browse and filter available cars for booking.
 * - Stores selected pickup/return dates, times, and location in the session for persistence.
 * - Implements `formatDate()` to correctly parse and transform localized date strings.
 * - Displays a live filter bar with dropdowns for vehicle attributes (type, gear, price, etc.).
 * - Includes an interactive popup-based search form with autocomplete, date/time pickers, and a full calendar UI.
 * - Shows cars dynamically within the `#car-list` section, updated via JS (`car_selection_details_connection.js`).
 * - Adds advanced filters such as manufacturer, doors, seats, drive type, climate, GPS, and trunk size.
 * - Pagination controls allow users to navigate through car pages.
 * - Displays warning popups if booking input is missing or invalid.
 * - Integrates various JS scripts for filtering, calendar navigation, UI control, and filter application.
 * 
 * This page offers a rich and dynamic UX for selecting the perfect rental car based on user-defined criteria.
 */
?>
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['search-location'] = isset($_GET['search-location']) && !empty($_GET['search-location']) 
    ? $_GET['search-location'] 
    : null;

include 'includes/header.php';
?>
<body class="car-selection">

<?php
function formatDate($date) {
    if (!$date || $date === 'Datum') return 'Datum';

    
    $monthMapping = [
        'Jan' => '01', 'Feb' => '02', 'Mär' => '03', 'Apr' => '04', 'Mai' => '05', 'Jun' => '06', 
        'Jul' => '07', 'Aug' => '08', 'Sep' => '09', 'Okt' => '10', 'Nov' => '11', 'Dez' => '12'
    ];

    
    $parts = explode('. ', trim($date));
    if (count($parts) !== 2) return 'Datum'; 

    $day = $parts[0];
    $monthShort = $parts[1];

    
    if (isset($monthMapping[$monthShort])) {
        $month = $monthMapping[$monthShort];
    
        $today = new DateTime();
        $today->setTime(0, 0); 
    
        $currentYear = $today->format('Y');
        $nextYear = $currentYear + 1;
    
        
        $selectedDate = DateTime::createFromFormat('d.m.Y', "$day.$month.$currentYear");
        
        
        $year = ($selectedDate && $selectedDate < $today) ? $nextYear : $currentYear;
    
        
        return sprintf("%02d.%02d.%02d", $day, $month, $year % 100);
    }    

    return 'Datum'; 
}


$_SESSION['pickupDate'] = isset($_GET['pickup']) && !empty($_GET['pickup']) ? formatDate($_GET['pickup']) : 'Datum';
$_SESSION['returnDate'] = isset($_GET['return']) && !empty($_GET['return']) ? formatDate($_GET['return']) : 'Datum';

$pickupDate = $_SESSION['pickupDate'];
$returnDate = $_SESSION['returnDate'];
?>


<?php 
$location = isset($_SESSION['search-location']) && !empty($_SESSION['search-location']) ? $_SESSION['search-location'] : "Stadt";
$pickupTime = isset($_GET['pickup-time']) && !empty($_GET['pickup-time']) ? htmlspecialchars($_GET['pickup-time']) : '--:--';
$returnTime = isset($_GET['return-time']) && !empty($_GET['return-time']) ? htmlspecialchars($_GET['return-time']) : '--:--';
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

    <button id="edit-search-btn">
        🖊
    </button>
    </div>

    
</div>


        
        <div class="filter-options">
        <button class="filter-btn reset-filter" id="reset-filters">Zurücksetzen</button>
        <button class="filter-btn" id="sort-filter">Sortierung ▼</button>


<div id="sort-dropdown" class="dropdown-box hidden">
    <button>Preis absteigend</button>
    <button>Preis aufsteigend</button>
</div>
            <button class="filter-btn" id="type-filter">Typ ▼</button>


<div id="type-dropdown" class="dropdown-box hidden">
    <button>Limousine</button>
    <button>Combi</button>
    <button>Coupe</button>
    <button>Cabriolet</button>
    <button>Mehrsitzer</button>
    <button>SUV</button>
</div>
            <button class="filter-btn" id="gear-filter">Getriebe ▼</button>


<div id="gear-dropdown" class="dropdown-box hidden">
    <button>Automatik</button>
    <button>Manuell</button>
</div>

<button class="filter-btn" id="price-filter">Preis bis ▼</button>


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
    </div>



    
    
</section>

<section class="car_more_filter">

    <div id="extra-filters-box" class="hidden">
        <div class="extra-filters">
           
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

   
            <button class="filter-btn" id="doors-filter">Türen ▼</button>
            <div id="doors-dropdown" class="dropdown-box hidden">
                <button>3</button>
                <button>4</button>
                <button>5</button>
            </div>

        
<button class="filter-btn" id="seats-filter">Sitze ▼</button>
<div id="seats-dropdown" class="dropdown-box hidden">
    <button>2</button>
    <button>4</button>
    <button>5</button>
    <button>7</button>
    <button>8</button>
    <button>9</button>
</div>
            
<button class="filter-btn" id="drive-filter">Antrieb ▼</button>
<div id="drive-dropdown" class="dropdown-box hidden">
    <button>Verbrenner</button>
    <button>Elektrisch</button>
</div>
            
<button class="filter-btn" id="age-filter">Alter Fahrer ▼</button>
<div id="age-dropdown" class="dropdown-box hidden">
    <button>18</button>
    <button>21</button>
    <button>25</button>
</div>
<button class="filter-btn toggle-btn" id="climate-filter">Klima</button>
<button class="filter-btn toggle-btn" id="gps-filter">GPS</button>

            
<button class="filter-btn" id="trunk-filter">Kofferraumvolumen ▼</button>
<div id="trunk-dropdown" class="dropdown-box hidden">
    <button>Klein</button>
    <button>Mittel</button>
    <button>Groß</button>
</div>
        </div>
    </div>
</section>


<div id="search-popup" class="search-popup">
    <div class="search-container">
        <button id="close-hero-popup" class="close-btn">✖</button>

        <div class="search-field">
            <label for="location">Stadt</label>
            <div class="location-group">
                <div class="input-wrapper">
                    <img src="images/lupe-icon.png" class="input-icon" alt="Such-Icon">
                    <input type="text" id="search-location" placeholder="Abholung & Rückgabe">
                </div>
                <div id="autocomplete-container" class="autocomplete-suggestions"></div>
            </div>
        </div>

        <div class="search-field">
            <label for="pickup">Abholdatum</label>
            <div class="input-group">
                <input type="text" id="pickup" placeholder="Datum" readonly>
                <input type="text" id="pickup-time" placeholder="Uhrzeit" readonly>
                <div id="time-dropdown" class="time-dropdown">
                    <div id="time-grid" class="time-grid"></div>
                </div>
            </div>
        </div>

        <div class="search-field">
            <label for="return">Rückgabedatum</label>
            <div class="input-group">
                <input type="text" id="return" placeholder="Datum" readonly>
                <input type="text" id="return-time" placeholder="Uhrzeit" readonly>
                <div id="return-time-dropdown" class="time-dropdown">
                    <div id="return-time-grid" class="time-grid"></div>
                </div>
            </div>
        </div>

        <form action="car_selection.php" method="GET">
            <input type="hidden" name="search-location" id="hidden-search-location">
            <input type="hidden" name="pickup" id="hidden-pickup">
            <input type="hidden" name="pickup-time" id="hidden-pickup-time">
            <input type="hidden" name="return" id="hidden-return">
            <input type="hidden" name="return-time" id="hidden-return-time">
            <button type="submit" class="search-btn">Suchen</button>
        </form>
    </div>


    <div id="calendar-container" class="calendar-box">
        <div class="calendar-header">
            <button id="prev-month" class="calendar-nav">&lt;</button>
            <div class="calendar-months">
                <span id="month-prev" class="calendar-month"></span>
                <span id="month-current" class="calendar-month"></span>
                <span id="month-next" class="calendar-month"></span>
            </div>
            <button id="next-month" class="calendar-nav">&gt;</button>
        </div>

        <div class="calendar-grid">
            <div class="calendar-column">
                <div class="calendar-weekdays">
                    <span>MO</span><span>DI</span><span>MI</span><span>DO</span><span>FR</span><span>SA</span><span>SO</span>
                </div>
                <div class="calendar-days" id="calendar-prev"></div>
            </div>
            <div class="calendar-column">
                <div class="calendar-weekdays">
                    <span>MO</span><span>DI</span><span>MI</span><span>DO</span><span>FR</span><span>SA</span><span>SO</span>
                </div>
                <div class="calendar-days" id="calendar-current"></div>
            </div>
            <div class="calendar-column">
                <div class="calendar-weekdays">
                    <span>MO</span><span>DI</span><span>MI</span><span>DO</span><span>FR</span><span>SA</span><span>SO</span>
                </div>
                <div class="calendar-days" id="calendar-next"></div>
            </div>
        </div>
    </div>
</div>

<div class="pagination-container">
    <button id="prev-cars" class="pagination-btn" disabled>⬅ Zurück</button>
    <button id="next-cars" class="pagination-btn">Weiter ➡</button>
</div>


<div id="car-list">
  
</div>

<div class="blocker"></div>


<div class="popup-overlay" id="popupOverlay">
    <div class="popup-box">
        <p class="popup-title">Fehlende Eingabe</p>
        <p id="popupMessage" class="popup-message"></p>
        <button class="popup-close" id="popupClose">Schließen</button>
    </div>
</div>

<script src="js/car_selection_details_connection.js" defer></script>
<script src="js/car_selection_calendar.js" defer></script>
<script src="js/calendar_elements.js" defer></script>
<script src="js/calender.js" defer></script>
<script src="js/car_selection_filters.js" defer></script>
<script src="js/add_calender_details.js" defer></script>
<script src="js/reset_filters.js" defer></script>
<script src="js/apply_filter.js"></script>
<script src="js/redirect_details.js" defer></script>
</body>




<?php 
include 'includes/footer.php'; 
?>