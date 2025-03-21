<!--
This is the Careers ("Karriere") page for Flamin-Go! car rental, designed to showcase job opportunities and encourage applications.

📸 Header & Intro:
- Includes global header (`includes/header.php`).
- Displays a full-width background image (`.Karriere-bg-image`) for visual appeal.
- A white, rounded text box (`.Karriere-box`) promotes working at Flamin-Go!
  - Explains the eco-conscious philosophy of the company.
  - Contains a button linking to the contact form for applications.

💼 Job Listings Section:
- Set against a grey background (`.Karriere-spacer`) to distinguish job offers.
- Each job is displayed in a `.card` with:
  - Job Title, Location, Type (Full-time/Part-time), and Salary.
  - A short description highlighting responsibilities and key attributes.
- Example positions:
  1. **Filialleiter (Branch Manager)** – Hamburg, full-time
  2. **Service-Mitarbeiter (Service Staff)** – Hamburg, part-time
  3. **Regionalleiter (Regional Manager)** – North region, full-time

🧩 Footer:
- Ends with the global footer (`includes/footer.php`).

This page blends company culture with job openings, inviting visitors to join a purpose-driven team.
-->
<!--Insert Header-->
<?php include("includes/header.php"); ?>
<!--Foto background-->
<div class="Karriere-bg-image"></div>
<!--Invisible positioning Box-->
<div class="static-spacer">
    <!--White rounded Textbox-->
    <div class="Karriere-box">
        <h6>Karriere bei Famin-GO!</h6>
        <h1>Arbeite mit uns!</h1> <br>
        <p>
            Erkunde unsere Philosophie von einer besseren Autovermietung, welche nicht nur Autos vermietet, sondern auch etwas für die Umwelt macht!
        </p><br><br>
 
        <!-- Button to open Pop-Up -->
        <a href="contact.php" class="bewerbung-button">Bewirb dich hier, über unsere Kontaktseite! </a>
 
    </div>
</div>
 
<!--Grey Job description Background-->
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
 
<!--Insert Footer-->
<?php include("includes/footer.php"); ?>