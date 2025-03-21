<?php
/**
 * Convert Localized Date String to SQL-Compatible Format (YYYY-MM-DD)
 * 
 * - Accepts a date string in the format "14. Mai" (German short month names).
 * - Translates German month abbreviations to full English month names.
 * - Determines whether the given date belongs to the current or next year.
 * - Ensures correct handling by comparing with today's date (ignoring time).
 * - Returns the formatted date as `YYYY-MM-DD` or `null` if parsing fails.
 * 
 * This function is used to standardize date inputs for database storage.
 */
?>
<?php
function convertDate($dateString) {
    $months = [
        "Jan" => "January", "Feb" => "February", "Mär" => "March", "Apr" => "April",
        "Mai" => "May", "Jun" => "June", "Jul" => "July", "Aug" => "August",
        "Sep" => "September", "Okt" => "October", "Nov" => "November", "Dez" => "December"
    ];

    
    $parts = explode(". ", $dateString);
    if (count($parts) != 2) return null;

    $day = intval($parts[0]);
    $month = $months[$parts[1]] ?? null;
    if (!$month) return null;

    
    $today = new DateTime();
    $today->setTime(0, 0); 
    $currentYear = $today->format("Y");
    $nextYear = $currentYear + 1;

  
    $parsedDate = DateTime::createFromFormat("j F Y", "$day $month $currentYear");

    
    $year = ($parsedDate < $today) ? $nextYear : $currentYear;

    return date("Y-m-d", strtotime("$day $month $year"));
}
?>