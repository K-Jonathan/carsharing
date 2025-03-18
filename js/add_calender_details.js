document.addEventListener("DOMContentLoaded", function () {
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    // 🏙 Stadt setzen
    const locationInput = document.getElementById("search-location");
    const urlLocation = getUrlParameter("search-location");
    if (urlLocation && locationInput) {
        locationInput.value = decodeURIComponent(urlLocation);
    }

    // 📅 Abholdatum setzen
    const pickupInput = document.getElementById("pickup");
    const urlPickup = getUrlParameter("pickup");
    if (urlPickup && pickupInput) {
        pickupInput.value = decodeURIComponent(urlPickup);
    }

    // ⏰ Abholzeit setzen
    const pickupTimeInput = document.getElementById("pickup-time");
    const urlPickupTime = getUrlParameter("pickup-time");
    if (urlPickupTime && pickupTimeInput) {
        pickupTimeInput.value = decodeURIComponent(urlPickupTime);
    }

    // 📅 Rückgabedatum setzen
    const returnInput = document.getElementById("return");
    const urlReturn = getUrlParameter("return");
    if (urlReturn && returnInput) {
        returnInput.value = decodeURIComponent(urlReturn);
    }

    // ⏰ Rückgabezeit setzen
    const returnTimeInput = document.getElementById("return-time");
    const urlReturnTime = getUrlParameter("return-time");
    if (urlReturnTime && returnTimeInput) {
        returnTimeInput.value = decodeURIComponent(urlReturnTime);
    }
});