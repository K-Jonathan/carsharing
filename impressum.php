<?php
/**
 * Impressum Page – Legal Notice
 * 
 * - Displays the required company details in compliance with § 5 TMG (German law).
 * - Includes:
 *   - Company name, address, contact details (email & phone).
 *   - VAT identification number (Umsatzsteuer-ID).
 *   - Legal representatives (managing directors).
 *   - Liability disclaimer.
 *   - Copyright notice.
 * - Uses a structured table format for readability.
 * - Includes a consistent header and footer.
 * 
 * This page ensures legal transparency and compliance with German regulations.
 */
?>
<?php 
include 'includes/header.php'; // Header einfügen
?>



<div class="impressumpage-background"></div>


<div class="impressumpage-spacer">

    <div class="impressumpage-box">
        <h2 class="impressumpage-title">Impressum</h2>


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



<?php 
include 'includes/footer.php';
?>