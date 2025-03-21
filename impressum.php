<!--
This is the Impressum (Legal Disclosure) page for Flamin-Go!, required under §5 TMG (German Telemedia Act).

📜 Structure:
- Includes the global header and footer for consistent layout.
- Uses a background and a styled spacer (`.impressumpage-spacer`) to center content visually.
- The core content is placed inside a white, rounded box (`.impressumpage-box`) with a structured table layout.

📋 Content Details:
- **Company Info**:
  - Flamin-GO! GmbH
  - Address, contact email, and phone number
  - VAT ID (Umsatzsteuer-ID)

- **Legal Disclaimers**:
  - **Liability Disclaimer**: No guarantee for completeness, accuracy, or timeliness of content.
  - **Copyright**: All content is protected under German copyright law.

- **Representation**:
  - Lists managing directors or legal representatives.

📐 Layout Note:
- Two-column layout using `<table>` ensures legal and company details are clearly separated and visually accessible.

This page fulfills the legal requirement for business transparency and accountability in Germany.
-->
<!--Insert Header-->
<?php 
include 'includes/header.php'; 
?>


<!-- Background for page -->
<div class="impressumpage-background"></div>

<!-- Invisible Positioning-Spacer -->
<div class="impressumpage-spacer">
    <!-- White rounded box for content -->
    <div class="impressumpage-box">
        <h2 class="impressumpage-title">Impressum</h2>

        <!-- Formated table with content -->
        <table class="impressumpage-table">
            <tr>
                <td>
                    <h4 class="impressumpage-subtitle">Angaben gemäß § 5 TMG</h4>
                </td>
            </tr>
            <tr>
                <td>
                    <h4 class="impressumpage-subtitle">Flamin-GO! GmbH</h4>
                    <p class="impressumpage-text">Musterstraße 123, 12345 Musterstadt</p>
                    <p class="impressumpage-text">E-Mail:<br>info@flamin-go.de</p>
                    <p class="impressumpage-text">Telefon: +49 123 456789</p>
                    <h4 class="impressumpage-subtitle">Umsatzsteuer-ID:</h4>
                    <p class="impressumpage-text">DE123456789</p>
                </td>
                <td>
                    <h4 class="impressumpage-subtitle">Haftungsausschluss:</h4>
                    <p class="impressumpage-text">
                        Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit, Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen.
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <h4 class="impressumpage-subtitle">Vertreten durch:</h4>
                    <p class="impressumpage-text">Jonathan Koenning</p>
                    <p class="impressumpage-text">Raphael Goslinowski</p>
                    <p class="impressumpage-text">Leon Ende</p>
                </td>
                <td>
                    <h4 class="impressumpage-subtitle">Urheberrecht:</h4>
                    <p class="impressumpage-text">
                        Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht.
                    </p>
                </td>
            </tr>
        </table>
    </div>
</div>


<!--Insert Footer-->
<?php 
include 'includes/footer.php';
?>