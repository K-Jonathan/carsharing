<?php
/**
 * Homepage – FLAMIN-GO! Carsharing
 * 
 * - Provides an interactive search and booking interface for car rentals.
 * - Features:
 *   - Location-based search with date & time selection.
 *   - Interactive calendar for easier date picking.
 *   - Car category selection with direct filtering.
 *   - Key benefits section highlighting reliability, service, and sustainability.
 *   - Customer testimonials in a dynamic review slider.
 *   - Company mission section linking to brand philosophy.
 *   - Visualized map with rental locations.
 * - Includes multiple JavaScript functionalities:
 *   - `calendar_elements.js`, `calender.js` → Date & time selection.
 *   - `quote.js` → Testimonial slider.
 *   - `category_redirect.js` → Redirects for car category selection.
 *   - `map_interaction.js` → Interactive rental location map.
 * 
 * This homepage serves as the central entry point, combining functionality and branding.
 */
?>
<?php

include("includes/header.php");
?>

<section class="hero">
    <div class="search-container">
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
</section>










<section class="pink-text">
    <h1>MIETE PINK - FAHR GRÜN</h1>
    <h2>Nachhaltige Autovermietung einfach gemacht</h2>
 </section>

 <section class="car-categories">
    <div class="category">
        <h3>Limousine</h3>
        <img src="images/categories/limousine.jpg" alt="Limousine" class="category-image" data-type="Limousine"> 
    </div>
    <div class="category">
        <h3>Combi</h3>
        <img src="images/categories/combi.jpg" alt="Combi" class="category-image" data-type="Combi">
    </div>
    <div class="category">
        <h3>Cabriolet</h3>
        <img src="images/categories/cabriolet.jpg" alt="Cabriolet" class="category-image" data-type="Cabriolet">
    </div>
    <div class="category">
        <h3>SUV</h3>
        <img src="images/categories/suv.jpg" alt="SUV" class="category-image" data-type="SUV">
    </div>
</section>
<hr class="category-divider">


 <section class="features">
    <div class="feature">
        <div class="feature-header">
            <img src="images/maps-icon.png" alt="Zuverlässig">
            <h3>Zuverlässig</h3>
        </div>
        <p><strong>Über 40 Städte und mehr als 400 Fahrzeuge für flexible Mobilität</strong></p>
    </div>
    <div class="feature">
        <div class="feature-header">
            <img src="images/couple-icon.png" alt="Aufmerksam">
            <h3>Aufmerksam</h3>
        </div>
        <p><strong>Persönlicher Kundenservice mit schneller und zuverlässiger Betreuung</strong></p>
    </div>
    <div class="feature">
        <div class="feature-header">
            <img src="images/tree-icon.png" alt="Naturbewusst">
            <h3>Naturbewusst</h3>
        </div>
        <p><strong>Für jeden Mietwagen pflanzen wir einen Baum, seien Sie umweltfreundlich unterwegs</strong></p>
    </div>
</section>

<section class="cs">
    <h1>UNSERE KUNDEN</h1>
    <div class="review-slider">
        <div class="review">
            <div class="review-overlay"></div>
            <img src="images/review-1.png" alt="Review-1">


            <div class="review-text active">
                <p><strong>Flamin-Go hat meine Mobilität völlig verändert – umweltfreundlich, flexibel und zuverlässig. Perfekt für spontane Ausflüge!</strong></p>
                <span>- Ole Hansen</span>
            </div>
            <div class="review-text">
                <p><strong>Ich liebe das nachhaltige Konzept von Flamin-Go! Jede Fahrt hinterlässt nicht nur keinen CO₂-Fußabdruck, sondern pflanzt sogar einen Baum.</strong></p>
                <span>- Maleen Zemla</span>
            </div>
            <div class="review-text">
                <p><strong>Moderne, top-gepflegte Autos zu fairen Preisen. Einfach buchen und losfahren – besser geht’s nicht!</strong></p>
                <span>- Tiago Jung</span>
            </div>
            <div class="review-text">
                <p><strong>Super einfacher Buchungsprozess, tolle Auswahl an Fahrzeugen und ein erstklassiger Kundenservice – Flamin-Go macht Carsharing richtig!</strong></p>
                <span>- Lasse Abram</span>
            </div>


            <div class="review-navigation">
                <button id="prevBtn">&#10094;</button>
                <button id="nextBtn">&#10095;</button>
            </div>


            <div class="review-dots">
                <span class="dot active-dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>
    </div>
</section>

<section class="earth-section">
    <h1>FÜR UNSERE ERDE</h1>
    <a href="brandpage.php" class="earth-link">
        <div class="earth-image">
            <div class="earth-overlay"></div>
            <img src="images/brand-1.png" alt="Flamin-Go Konzept">
            <div class="earth-text">
                <h2>FLAMIN-GO</h2>
                <p>Jetzt unser Konzept anschauen</p>
            </div>
        </div>
    </a>
</section>

<hr class="category-divider">

<section class="locations-section">
<h1>Unsere Standorte</h1>
<div class="map-spacer">
    <div class="map-container">
        <div class="map-marker" data-city="Berlin" style="left: 70%; top: 28%;"></div>
        <div class="map-marker" data-city="Bielefeld" style="left: 35%; top: 35%;"></div>
        <div class="map-marker" data-city="Bochum" style="left: 27%; top: 43%;"></div>
        <div class="map-marker" data-city="Bremen" style="left: 37%; top: 24%;"></div>
        <div class="map-marker" data-city="Dortmund" style="left: 29%; top: 41%;"></div>
        <div class="map-marker" data-city="Dresden" style="left: 73%; top: 51%;"></div>
        <div class="map-marker" data-city="Freiburg" style="left: 30%; top: 87%;"></div>
        <div class="map-marker" data-city="Hamburg" style="left: 45%; top: 20%;"></div>
        <div class="map-marker" data-city="Köln" style="left: 23%; top: 50%;"></div>
        <div class="map-marker" data-city="Leipzig" style="left: 65%; top: 46%;"></div>
        <div class="map-marker" data-city="München" style="left: 60%; top: 85%;"></div>
        <div class="map-marker" data-city="Nürnberg" style="left: 56%; top: 72%;"></div>
        <div class="map-marker" data-city="Paderborn" style="left: 36%; top: 39%;"></div>
        <div class="map-marker" data-city="Rostock" style="left: 62%; top: 14%;"></div>
    </div>
</div>
</section>
<script src="js/calendar_elements.js"></script>
<script src="js/calender.js"></script>
<script src="js/quote.js"></script>
<script src="js/category_redirect.js"></script>
<script src="js/map_interaction.js"></script>
<?php

include("includes/footer.php");
?>