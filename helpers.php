<?php
/*
The `convertDate()` function converts a German date format (e.g., "14. Mai") into the standardized "YYYY-MM-DD" format.  
It maps German month names to their English equivalents to ensure compatibility with `DateTime` functions.  
The function determines the current year and assigns the year for the given date as either the current year or,  
if the date has already passed, the next year.  
If the input format is invalid, the function returns `null`.
*/
function convertDate($dateString) {
    $months = [
        // Mapping of German month abbreviations to full English month names
        "Jan" => "January", "Feb" => "February", "Mär" => "March", "Apr" => "April",
        "Mai" => "May", "Jun" => "June", "Jul" => "July", "Aug" => "August",
        "Sep" => "September", "Okt" => "October", "Nov" => "November", "Dez" => "December"
    ];

    // Divide the string (e.g. "14 May")
    $parts = explode(". ", $dateString);
    if (count($parts) != 2) return null;

    $day = intval($parts[0]);
    $month = $months[$parts[1]] ?? null;
    if (!$month) return null;

    // Current date
    $today = new DateTime();
    $today->setTime(0, 0); // Exact comparability without time
    $currentYear = $today->format("Y");
    $nextYear = $currentYear + 1;

    // Create a date with the current year
    $parsedDate = DateTime::createFromFormat("j F Y", "$day $month $currentYear");

    // Increase year only if pickup_date is SMALLER than today
    $year = ($parsedDate < $today) ? $nextYear : $currentYear;

    // Return the formatted date in "YYYY-MM-DD" format
    return date("Y-m-d", strtotime("$day $month $year"));
}
?>