<!--
This page displays the "Allgemeine Geschäftsbedingungen" (Terms & Conditions) for the car rental platform.

🧩 Structure Overview:
- Includes the site-wide header (`includes/header.php`).
- Displays a background specific to the AGB page (`.agbpage-background`).
- Uses a spacer (`.agbpage-spacer`) to vertically position the content correctly.

📄 AGB Content:
- The terms are wrapped in a white, rounded container box (`.agbpage-box`).
- Inside, there's a scrollable text container (`.agbpage-scrollbox`) for better UX on long content.
- Each section of the AGB is clearly structured with subtitles and paragraphs.
- Some clauses (e.g., vehicle use rules) use a list format for readability.

🧾 Legal Topics Covered:
1. Scope of Terms
2. Contract Conclusion
3. Rental Duration & Return
4. Vehicle Use Conditions
5. Insurance & Liability
6. Cancellation Policy
7. Accident Procedure
8. Payment & Deposit
9. Data Privacy
10. Legal Jurisdiction & Final Clauses

🟢 Footer:
- The page concludes with the global site footer (`includes/footer.php`).

This layout ensures the terms are accessible, legible, and compliant with UX best practices for legal documents.
-->
<!--Insert Header-->
<?php include("includes/header.php");?>


<!--Background for AGB Page -->
<div class="agbpage-background"></div>


<!-- Invisible Positioning-Spacer -->
<div class="agbpage-spacer">  
    <!-- White rounded box with agb text -->
    <div class="agbpage-box">
        <h2 class="agbpage-title">Unsere Allgemeinen Geschäftsbedingungen</h2> <br>
        
        <!-- Scrollable AGB-Text -->
        <div class="agbpage-scrollbox">
            <h4 class="agbpage-subtitle">1. Geltungsbereich</h4>
            <p class="agbpage-text">
                Diese Allgemeinen Geschäftsbedingungen (AGB) gelten für alle Verträge über die Vermietung von Fahrzeugen durch Flamin-Go! (nachfolgend „Vermieter“ genannt) an Kunden (nachfolgend „Mieter“ genannt). Sie regeln die Buchung, Nutzung und Rückgabe der Fahrzeuge sowie die gegenseitigen Rechte und Pflichten von Vermieter und Mieter.
            </p>

            <h4 class="agbpage-subtitle">2. Vertragsabschluss</h4>
            <p class="agbpage-text">
                Ein Mietvertrag kommt durch die Reservierung und Bestätigung durch den Vermieter oder durch die Übergabe des Fahrzeugs an den Mieter zustande. Mit der Anmietung akzeptiert der Mieter diese AGB.
            </p>

            <h4 class="agbpage-subtitle">3. Mietdauer und Rückgabe</h4>
            <p class="agbpage-text">
                Die Mietdauer ergibt sich aus dem Mietvertrag. Eine Verlängerung ist nur mit vorheriger Zustimmung des Vermieters möglich. Das Fahrzeug muss zum vereinbarten Zeitpunkt und Ort in ordnungsgemäßem Zustand zurückgegeben werden.
            </p>
            <p class="agbpage-text">
                Bei verspäteter Rückgabe können zusätzliche Gebühren anfallen. Falls das Fahrzeug mehr als 24 Stunden zu spät zurückgegeben wird und keine Rückmeldung des Mieters erfolgt, behält sich der Vermieter das Recht vor, rechtliche Schritte einzuleiten und das Fahrzeug als gestohlen zu melden.
            </p>

            <h4 class="agbpage-subtitle">4. Fahrzeugzustand und Nutzung</h4>
            <p class="agbpage-text">
                Der Mieter erhält das Fahrzeug in verkehrssicherem Zustand und verpflichtet sich:
            </p>
            <ul class="agbpage-list">
                <li>Das Fahrzeug pfleglich zu behandeln</li>
                <li>Die geltenden Verkehrsregeln zu beachten</li>
                <li>Das Fahrzeug nicht für illegale Zwecke, Rennen oder Geländefahrten zu nutzen</li>
                <li>Keine Tiere im Fahrzeug zu transportieren, sofern nicht anders vereinbart</li>
                <li>Das Fahrzeug nicht unter Einfluss von Alkohol, Drogen oder Medikamenten zu führen</li>
            </ul>

            <h4 class="agbpage-subtitle">5. Versicherung und Haftung</h4>
            <p class="agbpage-text">
                Das Fahrzeug ist haftpflichtversichert. Der Mieter haftet für Schäden am Fahrzeug, sofern sie durch unsachgemäßen Gebrauch, grobe Fahrlässigkeit oder vorsätzliches Handeln verursacht wurden.
            </p>
            <p class="agbpage-text">
                Der Mieter haftet für alle Verkehrs- und Ordnungsverstöße während der Mietdauer. Bußgelder, Strafzettel und Gebühren, die während der Nutzung des Fahrzeugs anfallen, werden dem Mieter in Rechnung gestellt.
            </p>

            <h4 class="agbpage-subtitle">6. Stornierung und Rücktritt</h4>
            <p class="agbpage-text">
                Eine Stornierung muss schriftlich erfolgen. Bis zu 48 Stunden vor Mietbeginn ist eine Stornierung kostenfrei. Bei einer Stornierung bis 24 Stunden vor Mietbeginn wird eine Gebühr in Höhe von 25% der Mietkosten erhoben. Erfolgt die Stornierung weniger als 12 Stunden vor Mietbeginn, wird der gesamte Mietpreis fällig.
            </p>

            <h4 class="agbpage-subtitle">7. Verhalten im Schadensfall</h4>
            <p class="agbpage-text">
                Bei einem Unfall oder Schaden ist der Mieter verpflichtet, den Vermieter sofort zu informieren. Falls Personen- oder Fremdschäden entstanden sind, ist die Polizei zu rufen. Der Mieter darf den Schaden nicht selbst reparieren oder reparieren lassen.
            </p>

            <h4 class="agbpage-subtitle">8. Zahlungsbedingungen und Kaution</h4>
            <p class="agbpage-text">
                Die Miete ist vorab oder bei Übergabe des Fahrzeugs zu zahlen. Der Mieter hinterlegt vor Mietbeginn eine Kaution, die nach ordnungsgemäßer Rückgabe zurückerstattet wird.
            </p>

            <h4 class="agbpage-subtitle">9. Datenschutz</h4>
            <p class="agbpage-text">
                Der Vermieter erhebt und verarbeitet personenbezogene Daten des Mieters ausschließlich zur Vertragsabwicklung. Eine Weitergabe an Dritte erfolgt nur, sofern dies zur Erfüllung des Vertrags oder gesetzlich erforderlich ist.
            </p>

            <h4 class="agbpage-subtitle">10. Gerichtsstand und Schlussbestimmungen</h4>
            <p class="agbpage-text">
                Sollten einzelne Bestimmungen dieser AGB unwirksam sein oder werden, bleibt die Wirksamkeit der übrigen Bestimmungen unberührt.
            </p>
        </div>
    </div>  
</div>


<!--Insert Footer-->
<?php include("includes/footer.php");?>