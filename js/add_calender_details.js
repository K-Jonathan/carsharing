/**
 * This script auto-fills form fields on page load using URL query parameters.
 * 
 * - Extracts parameters from the URL (e.g. ?search-location=Berlin&pickup=2025-03-21).
 * - Sets corresponding input values if the parameters exist:
 *    🏙  "search-location" → sets the location input field.
 *    📅  "pickup" → sets the pick-up date.
 *    ⏰  "pickup-time" → sets the pick-up time.
 *    📅  "return" → sets the return date.
 *    ⏰  "return-time" → sets the return time.
 * 
 * This helps retain user search data when navigating between pages or sharing links.
 */
document.addEventListener("DOMContentLoaded", function () {
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    // 🏙 Set city
    const locationInput = document.getElementById("search-location");
    const urlLocation = getUrlParameter("search-location");
    if (urlLocation && locationInput) {
        locationInput.value = decodeURIComponent(urlLocation);
    }

    // 📅 Set pick-up date
    const pickupInput = document.getElementById("pickup");
    const urlPickup = getUrlParameter("pickup");
    if (urlPickup && pickupInput) {
        pickupInput.value = decodeURIComponent(urlPickup);
    }

    // ⏰ Set pick-up time
    const pickupTimeInput = document.getElementById("pickup-time");
    const urlPickupTime = getUrlParameter("pickup-time");
    if (urlPickupTime && pickupTimeInput) {
        pickupTimeInput.value = decodeURIComponent(urlPickupTime);
    }

    // 📅 Set return date
    const returnInput = document.getElementById("return");
    const urlReturn = getUrlParameter("return");
    if (urlReturn && returnInput) {
        returnInput.value = decodeURIComponent(urlReturn);
    }

    // ⏰ Set return time
    const returnTimeInput = document.getElementById("return-time");
    const urlReturnTime = getUrlParameter("return-time");
    if (urlReturnTime && returnTimeInput) {
        returnTimeInput.value = decodeURIComponent(urlReturnTime);
    }
});