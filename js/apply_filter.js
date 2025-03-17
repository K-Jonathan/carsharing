document.addEventListener("DOMContentLoaded", function () {
    // URL-Parameter auslesen
    const urlParams = new URLSearchParams(window.location.search);
    const carType = urlParams.get("car_type"); // `car_type` aus URL holen

    if (carType) {
        // ✅ Haupt-Button für "Typ" aktiv setzen
        const typeFilterBtn = document.getElementById("type-filter");
        if (typeFilterBtn) {
            typeFilterBtn.classList.add("active");
        } else {
            console.error("❌ Der Hauptfilter-Button für Typ wurde nicht gefunden!");
        }

        // ✅ Prüfen, ob der Typ-Filter existiert
        const typeDropdown = document.getElementById("type-dropdown");
        if (!typeDropdown) {
            console.error("❌ Das Typ-Dropdown wurde nicht gefunden!");
            return;
        }

        // ✅ Alle Buttons im Typ-Dropdown durchsuchen
        let found = false;
        typeDropdown.querySelectorAll("button").forEach(button => {
            if (button.innerText.trim().toLowerCase() === carType.trim().toLowerCase()) {
                button.classList.add("active"); // Aktivieren!
                found = true;
            } else {
                button.classList.remove("active"); // Falls ein anderer aktiv war, deaktivieren
            }
        });

        if (!found) {
            console.error(`❌ Kein passender Filter für '${carType}' gefunden.`);
        }

        
        // ✅ Autos mit aktualisierten Filtern laden
        fetchCarIds();
    }
});