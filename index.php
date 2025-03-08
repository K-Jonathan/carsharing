<?php
//STRG + U auf beliebigen Websites für Insights
//header
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
</section>










<section class="pink-text">
    <h1>MIETE PINK - FAHR GRÜN</h1>
    <h2>Nachhaltige Autovermietung einfach gemacht</h2>
 </section>

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

            <!-- TEXT SLIDER -->
            <div class="review-text active">
                <p><strong>Bester Mietwagen meines Lebens. Endlich kann ich auch grün Autofahren. Ich bin begeistert.</strong></p>
                <span>- Rudi Völler</span>
            </div>
            <div class="review-text">
                <p><strong>Super Starker Wagen.</strong></p>
                <span>- Maleen Zemla</span>
            </div>
            <div class="review-text">
                <p><strong>Sau Stark.</strong></p>
                <span>- Tiago Jung</span>
            </div>
            <div class="review-text">
                <p><strong>Mega Sache.</strong></p>
                <span>- Jonathan Könning</span>
            </div>

            <!-- Navigation innerhalb des Bild-Containers -->
            <div class="review-navigation">
                <button id="prevBtn">&#10094;</button>
                <button id="nextBtn">&#10095;</button>
            </div>

            <!-- Punkte für den Slider -->
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
    <a href="#" class="earth-link">
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

<?php
//STRG + U auf beliebigen Websites für Insights
//header
include("includes/footer.php");
?>