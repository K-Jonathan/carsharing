document.addEventListener("DOMContentLoaded", function () {
    function setupDropdown(buttonId, dropdownId) {
        const button = document.getElementById(buttonId);
        const dropdown = document.getElementById(dropdownId);
        const options = dropdown.querySelectorAll("button");
        
        button.addEventListener("click", function () {
            const rect = button.getBoundingClientRect(); // Position des Buttons holen

            // 🛠 Anpassungen für exakte Positionierung
            const offsetY = -190; // Abstand nach unten
            const offsetX = -635; // Falls notwendig, für Links/Rechts-Verschiebung

            dropdown.style.top = `${rect.bottom + window.scrollY + offsetY}px`; // Direkt unter den Button
            dropdown.style.left = `${rect.left + window.scrollX + rect.width / 2 - dropdown.offsetWidth / 2 + offsetX}px`; // Exakt mittig
            dropdown.classList.toggle("visible");
        });

        // Event-Listener für Dropdown-Optionen (Einzelauswahl für "Sortierung" und "Preis bis", Mehrfachauswahl für andere)
        options.forEach(option => {
            option.addEventListener("click", function () {
                if (buttonId === "sort-filter" || buttonId === "price-filter") {
                    // Falls "Sortierung" oder "Preis bis", nur eine Auswahl zulassen, aber auch deaktivierbar machen
                    if (this.classList.contains("active")) {
                        this.classList.remove("active");

                        // Falls nichts mehr aktiv ist, entferne Farbe vom Hauptbutton
                        button.classList.remove("active");
                    } else {
                        options.forEach(opt => opt.classList.remove("active"));
                        this.classList.add("active");

                        // Hauptbutton färben
                        button.classList.add("active");
                    }
                } else {
                    // Falls bereits aktiv, entferne Auswahl (für Mehrfachauswahl-Buttons)
                    if (this.classList.contains("active")) {
                        this.classList.remove("active");
                    } else {
                        this.classList.add("active");
                    }

                    // Prüfe, ob mindestens eine Auswahl aktiv ist
                    const anyActive = [...options].some(opt => opt.classList.contains("active"));

                    // Falls eine Auswahl aktiv ist, färbe den Hauptbutton
                    if (anyActive) {
                        button.classList.add("active");
                    } else {
                        button.classList.remove("active");
                    }
                }
            });
        });

        // Klick außerhalb der Box schließt sie wieder
        document.addEventListener("click", function (event) {
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove("visible");
            }
        });
    }

    // Dropdowns initialisieren
    setupDropdown("gear-filter", "gear-dropdown"); // Getriebe
    setupDropdown("type-filter", "type-dropdown"); // Typ
    setupDropdown("sort-filter", "sort-dropdown"); // Sortierung
    setupDropdown("price-filter", "price-dropdown"); // Preis bis
});

document.addEventListener("DOMContentLoaded", function () {
    const moreFiltersBtn = document.getElementById("more-filters-btn");
    const extraFiltersBox = document.getElementById("extra-filters-box");

    if (moreFiltersBtn && extraFiltersBox) {
        moreFiltersBtn.addEventListener("click", function () {
            // Prüfe den aktuellen `display`-Wert
            const isHidden = getComputedStyle(extraFiltersBox).display === "none";

            // Setze den neuen `display`-Wert basierend auf dem vorherigen Zustand
            extraFiltersBox.style.display = isHidden ? "block" : "none";

            // 🔹 Button einfärben, wenn extraFiltersBox sichtbar ist
            if (!isHidden) {
                moreFiltersBtn.classList.remove("active");
            } else {
                moreFiltersBtn.classList.add("active");
            }
        });
    } else {
        console.error("Fehler: Elemente nicht gefunden!");
    }
});

document.addEventListener("DOMContentLoaded", function () {
    function setupDropdown(buttonId, dropdownId, offsetX = 0) {
        const button = document.getElementById(buttonId);
        const dropdown = document.getElementById(dropdownId);
        const options = dropdown.querySelectorAll("button");

        button.addEventListener("click", function () {
            const rect = button.getBoundingClientRect();

            // Fixierte Position OHNE Scrollen
            dropdown.style.top = `${rect.bottom - 253.5}px`; // Entfernt window.scrollY
            dropdown.style.left = `${rect.left + rect.width / 2 - dropdown.offsetWidth / 2 + offsetX}px`;

            dropdown.classList.toggle("visible");
        });

        // Klick außerhalb des Dropdowns schließt es
        document.addEventListener("click", function (event) {
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove("visible");
            }
        });

        // Event-Listener für Mehrfachauswahl (Buttons färben sich)
        options.forEach(option => {
            option.addEventListener("click", function () {
                if (this.classList.contains("active")) {
                    this.classList.remove("active");
                } else {
                    this.classList.add("active");
                }

                const anyActive = [...options].some(opt => opt.classList.contains("active"));

                if (anyActive) {
                    button.classList.add("active");
                } else {
                    button.classList.remove("active");
                }
            });
        });
    }

    // 🔹 Dropdowns für neue Filter-Buttons initialisieren (mit X-Verschiebung)
    setupDropdown("manufacturer-filter", "manufacturer-dropdown", -121.5);
    setupDropdown("doors-filter", "doors-dropdown", -122.5);
    setupDropdown("seats-filter", "seats-dropdown", -125);
    setupDropdown("drive-filter", "drive-dropdown", -125);
    setupDropdown("age-filter", "age-dropdown", -127.5);
    setupDropdown("trunk-filter", "trunk-dropdown", -122.5);
});

document.addEventListener("DOMContentLoaded", function () {
    function setupToggleButton(buttonId) {
        const button = document.getElementById(buttonId);

        button.addEventListener("click", function () {
            button.classList.toggle("active");
        });
    }

    setupToggleButton("climate-filter");
    setupToggleButton("gps-filter");
});





document.addEventListener("DOMContentLoaded", function () {
    let allCars = [];  // Speichert alle Autos nach der Filterung
    let currentPage = 0;
    const carsPerPage = 15;

    function fetchCarIds() {
        let url = `fetch_cars.php`;
        let params = [];
    
        const activeSortButton = document.querySelector("#sort-dropdown button.active");
        if (activeSortButton) {
            const sortOrder = activeSortButton.innerText.includes("absteigend") ? "price_desc" : "price_asc";
            params.push(`sort=${sortOrder}`);
        }
    
        function collectActiveValues(selector, paramName) {
            const activeValues = [...document.querySelectorAll(selector + " button.active")]
                .map(button => button.innerText.trim());
            if (activeValues.length > 0) {
                params.push(`${paramName}=${activeValues.join(",")}`);
            }
        }
    
        collectActiveValues("#type-dropdown", "type");
        collectActiveValues("#gear-dropdown", "gear");
        collectActiveValues("#manufacturer-dropdown", "vendor");
        collectActiveValues("#doors-dropdown", "doors");
        collectActiveValues("#seats-dropdown", "seats");
        collectActiveValues("#drive-dropdown", "drive");
        collectActiveValues("#age-dropdown", "min_age");
        collectActiveValues("#trunk-dropdown", "trunk");
    
        const activePriceButton = document.querySelector("#price-dropdown button.active");
        if (activePriceButton) params.push(`max_price=${activePriceButton.innerText}`);
    
        if (document.getElementById("climate-filter").classList.contains("active")) {
            params.push(`air_condition=1`);
        }
        if (document.getElementById("gps-filter").classList.contains("active")) {
            params.push(`gps=1`);
        }
    
        if (params.length > 0) {
            url += `?${params.join("&")}`;
        }
    
        fetch(url)
            .then(response => response.json())
            .then(data => {
                allCars = data.cars;
                currentPage = 0;
                renderCars();
    
                // 🚀 Danach gebuchte Autos nachladen
                fetchUnavailableCars();
            })
            .catch(error => console.error("Fehler beim Laden der Car-IDs:", error));
    }
    
    // 🔹 Neue Funktion: Gebuchte Autos nachladen & anzeigen
    function fetchUnavailableCars() {
        let url = `fetch_unavailable_cars.php`;
        let params = [];
    
        // 🔹 Dieselben Filter wie für verfügbare Autos sammeln
        const activeSortButton = document.querySelector("#sort-dropdown button.active");
        if (activeSortButton) {
            const sortOrder = activeSortButton.innerText.includes("absteigend") ? "price_desc" : "price_asc";
            params.push(`sort=${sortOrder}`);
        }
    
        function collectActiveValues(selector, paramName) {
            const activeValues = [...document.querySelectorAll(selector + " button.active")]
                .map(button => button.innerText.trim());
            if (activeValues.length > 0) {
                params.push(`${paramName}=${activeValues.join(",")}`);
            }
        }
    
        collectActiveValues("#type-dropdown", "type");
        collectActiveValues("#gear-dropdown", "gear");
        collectActiveValues("#manufacturer-dropdown", "vendor");
        collectActiveValues("#doors-dropdown", "doors");
        collectActiveValues("#seats-dropdown", "seats");
        collectActiveValues("#drive-dropdown", "drive");
        collectActiveValues("#age-dropdown", "min_age");
        collectActiveValues("#trunk-dropdown", "trunk");
    
        const activePriceButton = document.querySelector("#price-dropdown button.active");
        if (activePriceButton) params.push(`max_price=${activePriceButton.innerText}`);
    
        if (document.getElementById("climate-filter").classList.contains("active")) {
            params.push(`air_condition=1`);
        }
        if (document.getElementById("gps-filter").classList.contains("active")) {
            params.push(`gps=1`);
        }
    
        if (params.length > 0) {
            url += `?${params.join("&")}`;
        }
    
        // 🔹 Daten abrufen
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.cars && data.cars.length > 0) {
                    const groupedUnavailableCars = groupUnavailableCars(data.cars);
                    allCars.push(...groupedUnavailableCars); // 🚀 Füge gefilterte, gebuchte Autos hinzu
                    renderCars(); // 🔄 Aktualisiere die Anzeige mit den neuen Autos
                }
            })
            .catch(error => console.error("Fehler beim Laden der gebuchten Autos:", error));
    }      
    
    function groupUnavailableCars(cars) {
        const grouped = {};
    
        cars.forEach(car => {
            const key = `${car.vendor_name}|${car.vendor_name_abbr}|${car.name}|${car.name_extension}|${car.loc_name}`;
            
            if (!grouped[key]) {
                grouped[key] = { ...car, count: 0 };
            }
            grouped[key].count++;
        });
    
        return Object.values(grouped);
    }    

    function renderCars() {
        const container = document.getElementById("car-list");
        container.innerHTML = "";
    
        if (allCars.length === 0) {
            container.innerHTML = `
                <div class="no-results">
                    <p>Derzeit stehen keine Fahrzeuge, für die von Ihnen gewählten Filteroptionen, zur Verfügung</p>
                </div>
            `;
            updatePaginationButtons(); // ❗ Direkt nach dem Hinzufügen prüfen!
            return;
        }
    
        // 🔹 Zeige nur Autos für die aktuelle Seite
        const start = currentPage * carsPerPage;
        const visibleCars = allCars.slice(start, start + carsPerPage);
    
        visibleCars.forEach(car => {
            const carElement = document.createElement("div");
            carElement.classList.add("car-card");
    
            const imageName = car.img_file_name ? car.img_file_name : "default.jpg";
    
            if (car.status === "booked") {
                // 🔹 Stil für gebuchte Autos
                carElement.classList.add("unavailable");
                carElement.innerHTML = `
                    <div class="car-image">
                        <img src="images/cars/${imageName}" alt="${car.vendor_name} ${car.name}" 
                             class="grayscale"
                             onerror="this.onerror=null; this.src='images/cars/default.jpg';">
                        <div class="overlay-text">Für den gewünschten Zeitraum ausgebucht</div>
                    </div>
                    <div class="car-info">
                        <div class="car-info-left">
                            <h3 class="car-title">${car.vendor_name} ${car.name} ${car.name_extension}</h3>
                            <p class="car-location">${car.loc_name}</p>
                            <p class="car-price">${car.price}€/Tag</p>
                        </div>
                    </div>
                `;
            } else {
                // 🔹 Stil für verfügbare Autos
                carElement.innerHTML = `
                    <div class="car-image">
                        <img src="images/cars/${imageName}" alt="${car.vendor_name} ${car.type}" 
                             onerror="this.onerror=null; this.src='images/cars/default.jpg';">
                    </div>
                    <div class="car-info">
                        <div class="car-info-left">
                            <h3 class="car-title">${car.vendor_name} ${car.name} ${car.name_extension}</h3>
                            <p class="car-location">${car.loc_name}  
                                <span class="availability">- Verfügbar: ${car.availability_count}</span>
                            </p>
                            <p class="car-price">${car.price}€/Tag</p>
                        </div>
                        <button class="book-button" data-car-id="${car.car_id}">Details</button>
                    </div>
                `;
    
                // ✅ Event Listener für "Details"-Button
                carElement.querySelector(".book-button").addEventListener("click", function () {
                    const carId = this.getAttribute("data-car-id");
                    redirectToDetails(carId);
                });
            }
    
            container.appendChild(carElement);
        });
    
        updatePaginationButtons(); // ❗ Nach dem Rendern der Autos aufrufen
    }            

    function updatePaginationButtons() {
        const prevButton = document.getElementById("prev-cars");
        const nextButton = document.getElementById("next-cars");
        const noCarsMessage = document.querySelector(".no-results"); // Prüft, ob keine Autos vorhanden sind
    
        // 🔹 Falls keine Autos verfügbar sind → Beide Buttons deaktivieren
        if (noCarsMessage) {
            prevButton.disabled = true;
            nextButton.disabled = true;
        } else {
            prevButton.disabled = (currentPage === 0);
            nextButton.disabled = ((currentPage + 1) * carsPerPage >= allCars.length);
        }
    
        // 🔹 Klassen für deaktivierte Buttons setzen, um das Styling beizubehalten
        prevButton.classList.toggle("disabled", prevButton.disabled);
        nextButton.classList.toggle("disabled", nextButton.disabled);
    }
    
    // 🔹 Event Listener für die Paging-Buttons
    document.getElementById("prev-cars").addEventListener("click", function () {
        if (currentPage > 0) {
            currentPage--;
            renderCars();
        }
    });
    
    document.getElementById("next-cars").addEventListener("click", function () {
        if ((currentPage + 1) * carsPerPage < allCars.length) {
            currentPage++;
            renderCars();
        }
    });
    
    // 🏁 Event Listener für ALLE Filter-Buttons (Sofortige Aktualisierung)
    document.querySelectorAll("#sort-dropdown button, #type-dropdown button, #gear-dropdown button, #manufacturer-dropdown button, #doors-dropdown button, #seats-dropdown button, #drive-dropdown button, #age-dropdown button, #price-dropdown button, #climate-filter, #gps-filter, #trunk-dropdown button")
        .forEach(button => {
            button.addEventListener("click", function () {
                fetchCarIds();
            });
        });
    
    fetchCarIds(); // 🚀 Starte die erste Datenabfrage            
});