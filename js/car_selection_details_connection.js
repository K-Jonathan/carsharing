document.addEventListener("DOMContentLoaded", function () {
    function fetchCarIds() {
        // (Der restliche fetch-Code bleibt unverändert)
    }

    function redirectToDetails(carId) {
        // 📌 Werte direkt aus der URL holen
        const urlParams = new URLSearchParams(window.location.search);
        const location = urlParams.get("search-location") ? urlParams.get("search-location").trim() : "";
        const pickupDate = urlParams.get("pickup") ? urlParams.get("pickup").trim() : "";
        const pickupTime = urlParams.get("pickup-time") ? urlParams.get("pickup-time").trim() : "";
        const returnDate = urlParams.get("return") ? urlParams.get("return").trim() : "";
        const returnTime = urlParams.get("return-time") ? urlParams.get("return-time").trim() : "";

        // 📌 Prüfen, ob Werte leer sind oder Platzhalter enthalten
        if (!location || location === "Stadt" || 
            !pickupDate || pickupDate === "Datum" || 
            !pickupTime || pickupTime === "--:--" || 
            !returnDate || returnDate === "Datum" || 
            !returnTime || returnTime === "--:--") {
            
            showPopup("Wählen Sie bitte Ihren gewünschten Buchungszeitraum und Standort aus.");
            return;
        }

        // 📌 Falls alles passt, weiterleiten
        urlParams.set("car_id", carId);
        window.location.href = "car_details.php?" + urlParams.toString();
    }

    function showPopup(message) {
        document.getElementById("popupMessage").textContent = message;
        document.getElementById("popupOverlay").style.display = "flex";
    }

    document.getElementById("popupClose").addEventListener("click", function () {
        document.getElementById("popupOverlay").style.display = "none";
    });

    // 📌 Event Listener für ALLE "Details"-Buttons
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("book-button")) {
            const carId = event.target.getAttribute("data-car-id");
            redirectToDetails(carId);
        }
    });

    fetchCarIds(); // 🚀 Erste Datenabfrage beim Laden der Seite
});