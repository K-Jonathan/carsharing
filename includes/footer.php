<footer class="footer">
    <div class="footer-container">
        <!-- Left section of the footer containing the logo, title, and description -->
        <div class="footer-left">
            <!-- Company logo with a dynamically generated image path -->
            <img src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/images/brand-icon.png" 
                 alt="Flamin-Go Logo" 
                 class="footer-logo">

            <!-- Footer title with the company's slogan -->
            <h2 class="footer-title">
                NACHHALTIGE MOBILITÄT <br> NEU GEDACHT.
            </h2>

            <!-- Short description about the company and its mission -->
            <p class="footer-text">
                Mieten Sie umweltfreundliche Fahrzeuge mit Stil. 
                <strong>40+ Standorte, 400+ Autos</strong> und für jede Buchung ein gepflanzter Baum.
                Fahren Sie nachhaltig und hinterlassen Sie einen positiven <strong>ökologischen Fußabdruck.</strong>
            </p>
        </div>

        <!-- Divider line to visually separate footer sections -->
        <div class="footer-divider"></div>

        <!-- Right section containing navigation buttons -->
        <div class="footer-right">
            <div class="footer-buttons">
                <!-- Left column with main navigation links (styled as dark buttons) -->
                <div class="footer-column">
                    <!-- Links use dynamic paths instead of hardcoded URLs to ensure they remain functional 
                         even if the directory structure changes. `dirname($_SERVER['SCRIPT_NAME'])` dynamically 
                         resolves the current script directory, preventing broken links when moving files. -->
                    <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/Contact.php" class="footer-btn dark">KONTAKT</a>
                    <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/brandpage.php" class="footer-btn dark">FLAMIN-GO</a>
                    <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/car_selection.php" class="footer-btn dark">AUTOSUCHE</a>
                    <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/carriere.php" class="footer-btn dark">KARRIERE</a>
                </div>

                <!-- Right column with secondary navigation links (styled as light buttons) -->
                <div class="footer-column">
                    <!-- "/carsharing" is an absolute path, meaning it points to the root directory of the server.
                         The other links still use dynamic paths to maintain flexibility within the project structure. -->
                    <a href="/carsharing" class="footer-btn light">HOMEPAGE</a>
                    <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/agb.php" class="footer-btn light">AGB</a>
                    <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/impressum.php" class="footer-btn light">IMPRESSUM</a>
                    <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/datenschutz.php" class="footer-btn light">DATENSCHUTZ</a>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>