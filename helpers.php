<?php
function convertDate($dateString) {
    $months = [
        "Jan" => "January", "Feb" => "February", "Mär" => "March", "Apr" => "April",
        "Mai" => "May", "Jun" => "June", "Jul" => "July", "Aug" => "August",
        "Sep" => "September", "Okt" => "October", "Nov" => "November", "Dez" => "December"
    ];

    // Teile den String (z. B. "14. Mai")
    $parts = explode(". ", $dateString);
    if (count($parts) != 2) return null;

    $day = intval($parts[0]);
    $month = $months[$parts[1]] ?? null;
    if (!$month) return null;

    // Aktuelles Datum
    $today = new DateTime();
    $today->setTime(0, 0); // 🔹 Exakte Vergleichbarkeit ohne Uhrzeit
    $currentYear = $today->format("Y");
    $nextYear = $currentYear + 1;

    // Erstelle ein Datum mit dem aktuellen Jahr
    $parsedDate = DateTime::createFromFormat("j F Y", "$day $month $currentYear");

    // ✅ **Fix: Jahr nur erhöhen, wenn pickup_date KLEINER als heute ist**
    $year = ($parsedDate < $today) ? $nextYear : $currentYear;

    return date("Y-m-d", strtotime("$day $month $year"));
}
?>