document.addEventListener("DOMContentLoaded", function () {

    // 🔹 Function to extract URL parameters (query strings)
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search); // Extract parameters from URL
        return urlParams.get(name); // Get the value of the given parameter
    }

    // 🔹 Set location from URL if available
    const locationInput = document.getElementById("search-location"); // Get the location input field
    const urlLocation = getUrlParameter("search-location"); // Read the "search-location" parameter
    if (urlLocation && locationInput) {
        locationInput.value = decodeURIComponent(urlLocation); // Set input field value
    }

    // 🔹 Set pickup date from URL if available
    const pickupInput = document.getElementById("pickup"); // Get the pickup date field
    const urlPickup = getUrlParameter("pickup"); // Read the "pickup" parameter from URL
    if (urlPickup && pickupInput) {
        pickupInput.value = decodeURIComponent(urlPickup); // Set input field value
    }

    // 🔹 Set pickup time from URL if available
    const pickupTimeInput = document.getElementById("pickup-time"); // Get the pickup time field
    const urlPickupTime = getUrlParameter("pickup-time"); // Read the "pickup-time" parameter
    if (urlPickupTime && pickupTimeInput) {
        pickupTimeInput.value = decodeURIComponent(urlPickupTime); // Set input field value
    }

    // 🔹 Set return date from URL if available
    const returnInput = document.getElementById("return"); // Get the return date field
    const urlReturn = getUrlParameter("return"); // Read the "return" parameter from URL
    if (urlReturn && returnInput) {
        returnInput.value = decodeURIComponent(urlReturn); // Set input field value
    }

    // 🔹 Set return time from URL if available
    const returnTimeInput = document.getElementById("return-time"); // Get the return time field
    const urlReturnTime = getUrlParameter("return-time"); // Read the "return-time" parameter
    if (urlReturnTime && returnTimeInput) {
        returnTimeInput.value = decodeURIComponent(urlReturnTime); // Set input field value
    }
});