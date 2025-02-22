<?php
//STRG + U auf beliebigen Websites für Insights
//header
include("includes/header.php");
?>

<section class="hero">
    </div>
    <div class="search-container">
    <div class="search-field">
        <label for="location">Stadt</label>
        <div class="location-group">
            <input type="text" id="location" placeholder="Abholung & Rückgabe">
        </div>
    </div>
    <div class="search-field">
        <label for="pickup">Abholdatum</label>
        <div class="input-group">
            <input type="text" id="pickup" placeholder="Datum">
            <input type="text" placeholder="Uhrzeit">
        </div>
    </div>
    <div class="search-field">
        <label for="return">Rückgabedatum</label>
        <div class="input-group">
            <input type="text" id="return" placeholder="Datum">
            <input type="text" placeholder="Uhrzeit">
        </div>
    </div>
    <button type="submit" class="search-btn">Suchen</button>
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
                <span>- Luisa Reiter</span>
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

<?php
//STRG + U auf beliebigen Websites für Insights
//header
include("includes/footer.php");
?>