<!--
This page presents the brand concept and environmental commitment of "Flamin-Go!" car rental.

🌱 Header Section:
- Displays the brand name (`FLAMIN-GO!`) and core messages:
  - “Unser Konzept” (Our Concept)
  - “Wir pflanzen für jede Buchung einen Baum!” (We plant a tree for every booking)

🌍 Environmental Message Section:
- Titled “Unser Verständnis – Umwelt & Verantwortung” (Our Understanding – Environment & Responsibility)
- Contains two content boxes:
  1. 🌿 “Naturbewusst mieten” – Emphasizes eco-friendly car rentals.
  2. 🌳 “7.500” – Highlights the number of trees planted thanks to customer participation.

🚗 Commitment Section:
- Left side: Text block explaining the mission (“Rent pink and drive green”)
  - Focuses on combining eye-catching pink vehicles with sustainability.
  - Details the carbon offset strategy and green mobility goals.
- Right side: Embedded brand video (autoplaying, looping, muted)

🧩 Footer:
- Adds vertical spacing before including the site-wide footer.

This landing page clearly communicates the brand’s unique positioning and eco-conscious mission using compelling visuals and messaging.
-->
<?php include("includes/header.php"); ?>
<!-- Brandpage specific classes for landing page below Header -->
<div class="brandpage-header">
    <h1 class="brandpage-title">FLAMIN-GO!</h1>
    <p class="brandpage-subtitle">Unser Konzept</p>
    <p class="brandpage-highlight">Wir pflanzen für jede Buchung einen Baum!</p>
</div>
<!-- Start of new section for page content -->
<section class="brandpage-content">
    <h2 class="section-title">Unser Verständnis - Umwelt & Verantwortung</h2>
    <!-- 2 content boxes next to each other including icons and text (next to and below those) -->
    <div class="features-container">
        <div class="feature-box">
            <div class="feature-header2">
                <img src="images/maps-icon.png" alt="Zuverlässig">
                <p class="feature-title">Naturbewusst mieten</p>
            </div>
            <p class="feature-text">Wir verbinden unsere Mieten mit der Verantwortung der Umwelt gegenüber.</p>
        </div>

        <div class="feature-box">
            <div class="feature-header2">
                <img src="images/tree-icon.png" alt="Naturbewusst">
                <p class="feature-title">7.500</p>
            </div>
            <p class="feature-text">Bäume konnten wir bisher, dank euch pflanzen. Es werden jeden Tag mehr!</p>
        </div>
    </div>
</section>
<!-- Content box on the left side -->
<section class="brandpage-commitment">
    <div class="commitment-text">
        <h2>Unsere Autovermietung verbindet Umweltbewusstsein & Design</h2>
        <p>
            Unter dem Motto <b>„Rent pink and drive green“</b> setzen wir auf pinke Fahrzeuge als Markenzeichen und nachhaltiges Engagement als Mission. 
            Für jede Anmietung pflanzen wir einen Baum – so kompensieren wir CO₂-Emissionen und tragen aktiv zum <b>Klimaschutz</b> bei.
            Unser Ziel: <b>Moderne Mobilität</b> mit Verantwortung zu verbinden und umweltfreundliche Alternativen zu fördern.
            Wähle Pink, fahre Grün – <b>für eine nachhaltigere Zukunft auf vier Rädern!</b>
        </p>
    </div>
<!-- Video inserted in box on the right -->
    <div class="commitment-video">
        <video autoplay loop muted playsinline class="bg-video">
            <source src="/Carsharing/videos/brandvideo.mp4" type="video/mp4">
        </video>
    </div>
</section>

<!-- Distance to Footer -->
<div class="brandpage-spacing"></div>

<?php include("includes/footer.php"); ?>