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
    $currentYear = date("Y");
    $today = new DateTime();
    
    // Erstelle ein Datum mit dem aktuellen Jahr
    $parsedDate = DateTime::createFromFormat("j F Y", "$day $month $currentYear");

    // Falls das Datum schon in der Vergangenheit liegt, nimm das nächste Jahr
    if ($parsedDate < $today) {
        $currentYear++;
    }

    return date("Y-m-d", strtotime("$day $month $currentYear"));
}
?>