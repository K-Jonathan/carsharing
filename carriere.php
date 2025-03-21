<?php
/**
 * Careers Page – Job Listings and Company Mission
 * 
 * - Presents FLAMIN-GO!'s career philosophy and eco-conscious company culture.
 * - Encourages users to apply via the contact page with a prominent call-to-action button.
 * - Displays open job positions in a clean card layout including:
 *   - Job title, location, employment type, salary, and description.
 * - Background visuals (e.g. hero image, spacer elements) enhance the visual appeal.
 * - Includes standard header and footer for consistent page design.
 * 
 * This page aims to attract talent by combining clear job info with a strong brand identity.
 */
?>
<!--Insert Header-->
<?php include("includes/header.php"); ?>

<div class="Karriere-bg-image"></div>

<div class="static-spacer">

    <div class="Karriere-box">
        <h6>Karriere bei Famin-GO!</h6>
        <h1>Arbeite mit uns!</h1> <br>
        <p>
            Erkunde unsere Philosophie von einer besseren Autovermietung, welche nicht nur Autos vermietet, sondern auch etwas für die Umwelt macht!
        </p><br><br>
 
  
        <a href="contact.php" class="bewerbung-button">Bewirb dich hier, über unsere Kontaktseite! </a>
 
    </div>
</div>
 

<div class="Karriere-spacer">
    <div class="card">
        <h2>Filialleiter</h2><br>
        <h5>Hamburg</h5><br>
        <h5>Vollzeit</h5><br>
        <h6>25€/std.</h6><br>
        <p>
            Wir suchen einen engagierten Filialleiter (m/w/d) für unsere Autovermietung, der mit Führungsstärke, Serviceorientierung und betriebswirtschaftlichem Geschick unser Team zum Erfolg führt.
        </p>
    </div>
    <div class="card">
        <h2>Service-Mitarbeiter</h2><br>
        <h5>Hamburg</h5><br>
        <h5>Teilzeit</h5><br>
        <h6>14€/std.</h6><br>
        <p>
            Wir suchen einen serviceorientierten Mitarbeiter (m/w/d) für unsere Autovermietung, der mit Freundlichkeit, Organisationstalent und Engagement unsere Kunden begeistert und unterstützt.
        </p>
    </div>
    <div class="card">
        <h2>Regionalleiter</h2><br>
        <h5>Nord</h5><br>
        <h5>Vollzeit</h5><br>
        <h6>k.A.</h6><br>
        <p>
            Wir suchen einen erfahrenen Regionalleiter (m/w/d) für unsere Autovermietung, der mit strategischem Weitblick, Führungskompetenz und unternehmerischem Denken unsere Standorte erfolgreich weiterentwickelt
        </p>
    </div>
</div>
 

<?php include("includes/footer.php"); ?>