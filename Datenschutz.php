<!--Insert Header-->
<?php include("includes/header.php");?>


<!-- Hintergrund für die Datenschutzseite -->
<div class="datenschutzpage-background"></div>

<!-- Unsichtbarer Positionierungs-Spacer -->
<div class="datenschutzpage-spacer">
    <!-- Weiße abgerundete Box für die Datenschutzrichtlinien -->
    <div class="datenschutzpage-box">
        <h2 class="datenschutzpage-title">Datenschutzrichtlinien</h2>
        <h6 class="datenschutzpage-subtitle" id="datenschutz-datum"></h6>
        <p class="datenschutzpage-text">
            Die Flamin-Go Datenschutzrichtlinie beschreibt, wie Flamin-Go Ihre personenbezogenen Daten erfasst, verwendet und weitergibt.
            Zusätzlich zu dieser Datenschutzrichtlinie stellen wir Ihnen Hinweise und Datenschutzinformationen zur Verfügung, die in unsere Produkte und bestimmte Funktionen eingebettet sind und Zugriff auf Ihre personenbezogenen Daten erfordern.
        </p>

        <!-- Accordion-Bereich -->
        <div class="datenschutzpage-accordion">
            <!-- Erster Accordion-Punkt -->
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
            
            <!-- Zweiter Accordion-Punkt -->
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

            <!-- Vierter Accordion-Punkt -->
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

            <!-- Fünfter Accordion-Punkt -->
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

            <!-- Sechster Accordion-Punkt -->
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