<!--
This is the "Car Selection" page for Flamin-Go!, allowing users to search, filter, and browse available rental vehicles based on their preferences and booking period.

🧭 Session Handling:
- Stores search location and booking dates in session variables to persist user context.

📅 Date Formatting:
- Includes a PHP function `formatDate()` to convert short German month names to standard date format (DD.MM.YY), accounting for year rollover.

🔍 Search Filter Display:
- Shows selected location, pickup/return dates and times in a compact format.
- Allows editing the search parameters via a pop-up form.

📊 Filter Options:
- Top row of filters: Sorting, Car Type, Gearbox, Price Range, and Reset.
- Additional expandable filter options: Manufacturer, Doors, Seats, Drive Type, Driver Age, Air Conditioning, GPS, and Trunk Volume.

🔍 Pop-up Search Form:
- Users can input location, select dates from a calendar, and choose times via dropdowns.
- Upon submission, values are passed via `GET` to update the car listing.

📅 Embedded Calendar:
- 3-month view with selectable days and animated transitions.
- Fully interactive and styled with weekday headers and click logic.

🚘 Car List:
- Placeholder `#car-list` is dynamically populated with available vehicles using JavaScript and filters.

🔄 Pagination:
- Navigation for browsing car result pages: "Previous" and "Next" buttons.

⚠️ Validation Modal:
- Pop-up overlay for alerting users about missing booking parameters.

📦 JavaScript Modules:
- The logic is modular and well-organized across multiple JS files:
  - Filters, Calendar handling, Dynamic car loading, Popup logic, Detail redirection, etc.

📐 UX-Focused:
- Provides a clean and responsive user interface for personalized car selection and booking.

🧩 Footer:
- Global footer is included for layout consistency.

This page is the functional and visual centerpiece of the rental experience, combining UI/UX excellence with dynamic data filtering.
-->
<?php
// Start a session if none is active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Store the search location in the session
$_SESSION['search-location'] = isset($_GET['search-location']) && !empty($_GET['search-location'])
    ? $_GET['search-location']
    : null;

// Include the page header
include 'includes/header.php';
?>

<body class="car-selection">

    <?php
    function formatDate($date)
    {
        // If no date is provided or "Datum" is passed, return "Datum"
        if (!$date || $date === 'Datum') return 'Datum';

        // Mapping of month names (short form) to numbers
        $monthMapping = [
            'Jan' => '01',
            'Feb' => '02',
            'Mär' => '03',
            'Apr' => '04',
            'Mai' => '05',
            'Jun' => '06',
            'Jul' => '07',
            'Aug' => '08',
            'Sep' => '09',
            'Okt' => '10',
            'Nov' => '11',
            'Dez' => '12'
        ];

        // Extract the day and month from the string (e.g. "15 Mar")
        $parts = explode('. ', trim($date));
        if (count($parts) !== 2) return 'Datum'; // If format is incorrect

        $day = $parts[0]; // "15"
        $monthShort = $parts[1]; // "Mär"

        // If the month is in the mapping, replace it with the number
        if (isset($monthMapping[$monthShort])) {
            $month = $monthMapping[$monthShort];

            $today = new DateTime();
            $today->setTime(0, 0); // Sets the time to midnight for exact comparisons

            $currentYear = $today->format('Y');
            $nextYear = $currentYear + 1;

            // Create the date from the selection
            $selectedDate = DateTime::createFromFormat('d.m.Y', "$day.$month.$currentYear");

            // If the date exists and is before TODAY → take next year
            $year = ($selectedDate && $selectedDate < $today) ? $nextYear : $currentYear;

            // Return with two digits for the year
            return sprintf("%02d.%02d.%02d", $day, $month, $year % 100);
        }

        return 'Datum'; // If the month was not found
    }

    // Set pickup and return date from URL or session
    $_SESSION['pickupDate'] = isset($_GET['pickup']) && !empty($_GET['pickup']) ? formatDate($_GET['pickup']) : 'Datum';
    $_SESSION['returnDate'] = isset($_GET['return']) && !empty($_GET['return']) ? formatDate($_GET['return']) : 'Datum';

    // Retrieve the pickup and return dates from the session
    $pickupDate = $_SESSION['pickupDate'];
    $returnDate = $_SESSION['returnDate'];
    ?>


    <?php
    // Retrieve the search location from the session (default: "Stadt")
    $location = isset($_SESSION['search-location']) && !empty($_SESSION['search-location']) ? $_SESSION['search-location'] : "Stadt";
    // Retrieve the pickup and return times (default to "--:--" if not provided)
    $pickupTime = isset($_GET['pickup-time']) && !empty($_GET['pickup-time']) ? htmlspecialchars($_GET['pickup-time']) : '--:--';
    $returnTime = isset($_GET['return-time']) && !empty($_GET['return-time']) ? htmlspecialchars($_GET['return-time']) : '--:--';
    ?>

    <section class="car_filter">
        <div class="filter-container">
            <!-- Location and date selection -->
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
                    <!-- 🖊 Stift-Button -->
                    <button id="edit-search-btn">
                        🖊
                    </button>
                </div>
            </div>

            <div class="filter-options">
                <button class="filter-btn reset-filter" id="reset-filters">Zurücksetzen</button>
                <button class="filter-btn" id="sort-filter">Sortierung ▼</button>

                <!-- Dropdown-Box für Sortierung -->
                <div id="sort-dropdown" class="dropdown-box hidden">
                    <button>Preis absteigend</button>
                    <button>Preis aufsteigend</button>
                </div>
                <button class="filter-btn" id="type-filter">Typ ▼</button>

                <!-- Dropdown-Box für Typ -->
                <div id="type-dropdown" class="dropdown-box hidden">
                    <button>Limousine</button>
                    <button>Combi</button>
                    <button>Coupe</button>
                    <button>Cabriolet</button>
                    <button>Mehrsitzer</button>
                    <button>SUV</button>
                </div>
                <button class="filter-btn" id="gear-filter">Getriebe ▼</button>

                <!-- Dropdown box for gearboxes-->
                <div id="gear-dropdown" class="dropdown-box hidden">
                    <button>Automatik</button>
                    <button>Manuell</button>
                </div>

                <button class="filter-btn" id="price-filter">Preis bis ▼</button>

                <!-- Dropdown-Box for "Preis bis" -->
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
        <!-- New white box that will be displayed later -->
        <div id="extra-filters-box" class="hidden">
            <div class="extra-filters">
                <!-- Manufacturer dropdown -->
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

                <!-- Doors Dropdown -->
                <button class="filter-btn" id="doors-filter">Türen ▼</button>
                <div id="doors-dropdown" class="dropdown-box hidden">
                    <button>3</button>
                    <button>4</button>
                    <button>5</button>
                </div>

                <!-- Seats Dropdown -->
                <button class="filter-btn" id="seats-filter">Sitze ▼</button>
                <div id="seats-dropdown" class="dropdown-box hidden">
                    <button>2</button>
                    <button>4</button>
                    <button>5</button>
                    <button>7</button>
                    <button>8</button>
                    <button>9</button>
                </div>
                <!-- Drive Dropdown -->
                <button class="filter-btn" id="drive-filter">Antrieb ▼</button>
                <div id="drive-dropdown" class="dropdown-box hidden">
                    <button>Verbrenner</button>
                    <button>Elektrisch</button>
                </div>
                <!-- Driver Age Dropdown -->
                <button class="filter-btn" id="age-filter">Alter Fahrer ▼</button>
                <div id="age-dropdown" class="dropdown-box hidden">
                    <button>18</button>
                    <button>21</button>
                    <button>25</button>
                </div>
                <button class="filter-btn toggle-btn" id="climate-filter">Klima</button>
                <button class="filter-btn toggle-btn" id="gps-filter">GPS</button>

                <!-- Trunk volume Dropdown -->
                <button class="filter-btn" id="trunk-filter">Kofferraumvolumen ▼</button>
                <div id="trunk-dropdown" class="dropdown-box hidden">
                    <button>Klein</button>
                    <button>Mittel</button>
                    <button>Groß</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Searchbox Pop-up -->
    <div id="search-popup" class="search-popup">
        <div class="search-container">
            <button id="close-hero-popup" class="close-btn">✖</button> <!-- Close Button -->

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

        <!-- Kalender Container -->
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
        <!-- The car IDs are inserted dynamically here -->
    </div>

    <div class="blocker"></div>

    <!-- Pop-up for missing booking period -->
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
include 'includes/footer.php'; // insert Footer
?>