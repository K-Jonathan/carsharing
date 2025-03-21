<!--
This is the "Privacy Policy" (Datenschutzrichtlinien) page of Flamin-Go!, outlining how user data is collected, used, and protected.

🛡️ Overview:
- Includes global header (`includes/header.php`) and footer (`includes/footer.php`).
- Displays a background and rounded content box styled specifically for the privacy page.

📅 Dynamic Date:
- The subtitle `<h6 id="datenschutz-datum">` is intended to be dynamically filled with the policy's last update date via JavaScript.

📚 Accordion Format:
- Key sections of the privacy policy are presented as expandable/collapsible accordions for improved readability.
- Each section covers a specific topic:
  1. **User Rights** – How users can access, correct, or delete their data.
  2. **Definition of Personal Data** – What information Flamin-Go! collects.
  3. **Data Retention** – How long personal data is stored.
  4. **Third-Party Sharing** – Conditions under which data is shared (e.g. payment processing, legal requests).
  5. **Contact Info** – Instructions for reaching out regarding privacy concerns.

🧩 Interactive Behavior:
- Accordion logic is handled by an external script (`accordion.js`) to toggle sections open/closed.
- Enhances UX by keeping the page clean and scannable.

This layout effectively communicates data protection practices while maintaining a user-friendly design.
-->
<!--Insert Header-->
<?php include("includes/header.php");?>


<!-- Background for page -->
<div class="datenschutzpage-background"></div>

<!-- Invisible Positioning Spacer -->
<div class="datenschutzpage-spacer">
    <!-- White rounded box for text -->
    <div class="datenschutzpage-box">
        <h2 class="datenschutzpage-title">Datenschutzrichtlinien</h2>
        <h6 class="datenschutzpage-subtitle" id="datenschutz-datum"></h6>
        <p class="datenschutzpage-text">
            Die Flamin-Go Datenschutzrichtlinie beschreibt, wie Flamin-Go Ihre personenbezogenen Daten erfasst, verwendet und weitergibt.
            Zusätzlich zu dieser Datenschutzrichtlinie stellen wir Ihnen Hinweise und Datenschutzinformationen zur Verfügung, die in unsere Produkte und bestimmte Funktionen eingebettet sind und Zugriff auf Ihre personenbezogenen Daten erfordern.
        </p>

        <!-- Accordion-Area -->
        <div class="datenschutzpage-accordion">
            <!-- First Accordion-Bullet-Point -->
            <div class="datenschutzpage-accordion-item">
                <button class="datenschutzpage-accordion-button">
                    Ihre Datenschutzrechte bei Flamin-Go
                    <span class="datenschutzpage-accordion-icon">+</span>
                </button>
                <div class="datenschutzpage-accordion-content">
                    <p class="datenschutzpage-text">
                        Wir bei Flamin-Go! geben Ihnen die Möglichkeit, Auskunft über Ihre personenbezogenen Daten zu erhalten, auf sie zuzugreifen, sie zu korrigieren, zu übertragen, ihre Verarbeitung einzuschränken und sie zu löschen.
                        Sie können jederzeit eine Anfrage stellen, um zu erfahren, welche Daten wir über Sie gespeichert haben. Falls Ihre Daten fehlerhaft oder veraltet sind, haben Sie das Recht, diese korrigieren zu lassen.
                    </p>
                    <p class="datenschutzpage-text">
                        Darüber hinaus können Sie beantragen, dass wir Ihre personenbezogenen Daten in einem strukturierten, gängigen und maschinenlesbaren Format bereitstellen, sodass Sie diese an einen anderen Dienst übertragen können.
                    </p>
                </div>
            </div>
            
            <!-- Second Accordion-Bullet-Point -->
            <div class="datenschutzpage-accordion-item">
                <button class="datenschutzpage-accordion-button">
                    Was sind personenbezogene Daten bei Flamin-Go?
                    <span class="datenschutzpage-accordion-icon">+</span>
                </button>
                <div class="datenschutzpage-accordion-content">
                    <p class="datenschutzpage-text">
                        Wir erfassen nur die personenbezogenen Daten, die für unsere Dienstleistungen erforderlich sind. Welche Daten genau erhoben werden, hängt von Ihrer Nutzung unserer Services ab.
                    </p>
                    <p class="datenschutzpage-text">
                        Zu den von uns erfassten personenbezogenen Daten gehören unter anderem:
                    </p>
                    <ul class="datenschutzpage-list">
                    <li>Ihr Name, Ihre Anschrift und Ihre Kontaktdaten</li>
                        <li>Ihr Geburtsdatum und Ihre Identitätsnachweise (z. B. Personalausweisnummer)</li>
                        <li>Zahlungsinformationen für die Abwicklung von Mietvorgängen</li>
                        <li>Standortdaten zur Fahrzeugnutzung</li>
                        <li>Ihr Fahrverhalten (Geschwindigkeit, Bremsverhalten), falls Sie unser Telematik-Tracking nutzen</li>
                        <br>
                    </ul>
                </div>
            </div>

            <!-- 4th Accordion... -->
            <div class="datenschutzpage-accordion-item">
                <button class="datenschutzpage-accordion-button">
                    Wie lange speichern wir Ihre Daten?
                    <span class="datenschutzpage-accordion-icon">+</span>
                </button>
                <div class="datenschutzpage-accordion-content">
                    <p class="datenschutzpage-text">
                        Wir bewahren Ihre Daten nur so lange auf, wie es für die Bereitstellung unserer Dienstleistungen oder zur Erfüllung gesetzlicher Verpflichtungen erforderlich ist.
                    </p>
                    <p class="datenschutzpage-text">
                        Nach Ablauf dieser Frist werden Ihre Daten sicher gelöscht oder anonymisiert, sodass sie nicht mehr mit Ihrer Person in Verbindung gebracht werden können.
                    </p>
                </div>
            </div>

            <!-- 5th Accordion-... -->
            <div class="datenschutzpage-accordion-item">
                <button class="datenschutzpage-accordion-button">
                    Teilen wir Ihre Daten mit Dritten?
                    <span class="datenschutzpage-accordion-icon">+</span>
                </button>
                <div class="datenschutzpage-accordion-content">
                    <p class="datenschutzpage-text">
                        Wir geben Ihre personenbezogenen Daten nur weiter, wenn dies zur Bereitstellung unserer Dienstleistungen erforderlich ist oder wir gesetzlich dazu verpflichtet sind.
                    </p>
                    <p class="datenschutzpage-text">
                        Dies kann in folgenden Fällen geschehen:
                    </p>
                    <ul class="datenschutzpage-list">
                        <li>Zur Zahlungsabwicklung mit Banken oder Zahlungsdienstleistern</li>
                        <li>An Strafverfolgungsbehörden im Falle rechtlicher Anforderungen</li>
                        <li>Bei der Nutzung von Partnerdienstleistungen (z. B. Versicherungen oder Werkstätten)</li>
                        <br>
                    </ul>
                </div>
            </div>

            <!-- 6th Accordion-... -->
            <div class="datenschutzpage-accordion-item">
                <button class="datenschutzpage-accordion-button">
                    Fragen zum Datenschutz
                    <span class="datenschutzpage-accordion-icon">+</span>
                </button>
                <div class="datenschutzpage-accordion-content">
                    <p class="datenschutzpage-text">
                        Wenn Sie Fragen zur Datenschutzrichtlinie oder zu den Datenschutzpraktiken von Flamin-Go! haben, einschließlich der Fälle, in denen ein Drittanbieter in unserem Namen handelt, oder unseren Datenschutzbeauftragten kontaktieren möchten, können Sie uns unter <br> info@flamin-go.de erreichen.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Insert JS Accordion control logic-->
<script src="js/accordion.js"></script>
<!--Insert Footer-->
<?php include("includes/footer.php");?>