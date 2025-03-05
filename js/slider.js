document.addEventListener("DOMContentLoaded", function () {
    const reviewTexts = document.querySelectorAll(".review-text");
    const dots = document.querySelectorAll(".dot");
    let currentIndex = 0;
    let isAnimating = false; // Sperrt die Funktion während einer laufenden Animation

    // Setzt das erste Zitat sichtbar
    reviewTexts[currentIndex].classList.add("active");
    updateDots();

    document.getElementById("nextBtn").addEventListener("click", function () {
        if (!isAnimating) {
            isAnimating = true;
            changeText("next");
        }
    });

    document.getElementById("prevBtn").addEventListener("click", function () {
        if (!isAnimating) {
            isAnimating = true;
            changeText("prev");
        }
    });

    function changeText(direction) {
        const currentText = reviewTexts[currentIndex];

        // Entferne das aktive Zitat mit der passenden Animation
        if (direction === "next") {
            currentText.classList.add("exit-left");
        } else {
            currentText.classList.add("exit-right");
        }

        setTimeout(() => {
            currentText.classList.remove("active", "exit-left", "exit-right");

            // Neuer Index berechnen
            if (direction === "next") {
                currentIndex = (currentIndex + 1) % reviewTexts.length;
            } else {
                currentIndex = (currentIndex - 1 + reviewTexts.length) % reviewTexts.length;
            }

            const newText = reviewTexts[currentIndex];

            // Setze das neue Zitat mit der passenden Animation
            newText.classList.add("active");
            if (direction === "next") {
                newText.classList.add("enter-right");
            } else {
                newText.classList.add("enter-left");
            }

            setTimeout(() => {
                newText.classList.remove("enter-left", "enter-right");
                isAnimating = false; // Entsperrt die Funktion nach der Animation
            }, 500);

            updateDots();
        }, 500);
    }

    function updateDots() {
        dots.forEach((dot, index) => {
            if (index === currentIndex) {
                dot.classList.add("active-dot");
            } else {
                dot.classList.remove("active-dot");
            }
        });
    }
});

// Standortsuche
document.addEventListener("DOMContentLoaded", function () {
    const inputField = document.getElementById("search-location");
    const suggestionsContainer = document.getElementById("autocomplete-container");

    suggestionsContainer.style.display = "none";

    // Finde das bestehende Icon-Element (Lupe)
    let icon = document.querySelector(".input-icon");
    if (!icon) {
        console.error("Icon für das Suchfeld nicht gefunden.");
        return;
    }

    function fetchLocations(query = "") {
        fetch("search_locations.php?q=" + query)
            .then(response => response.json())
            .then(data => {
                suggestionsContainer.innerHTML = "";

                if (data.length > 0) {
                    suggestionsContainer.style.display = "block";
                    suggestionsContainer.style.maxHeight = "200px"; // Maximal 5 Vorschläge sichtbar
                    suggestionsContainer.style.overflowY = query.length === 0 ? "scroll" : "auto"; // Scrollbar nur wenn leer
                    
                    data.forEach(location => {
                        const suggestionItem = document.createElement("div");
                        suggestionItem.classList.add("autocomplete-suggestion");

                        // Container für Icon + Text
                        const suggestionContent = document.createElement("div");
                        suggestionContent.classList.add("suggestion-content");

                        const suggestionIcon = document.createElement("img");
                        suggestionIcon.src = "images/city-icon.png";
                        suggestionIcon.alt = "Stadt-Icon";
                        suggestionIcon.classList.add("suggestion-icon");

                        const text = document.createElement("span");
                        text.textContent = location;

                        suggestionContent.appendChild(suggestionIcon);
                        suggestionContent.appendChild(text);
                        suggestionItem.appendChild(suggestionContent);

                        // Wenn eine Stadt ausgewählt wird
                        suggestionItem.addEventListener("click", function () {
                            inputField.value = location;
                            icon.src = "images/city-icon.png"; // Wechsel zur Stadt-Icon
                            icon.style.display = "inline-block";
                            suggestionsContainer.innerHTML = "";
                            suggestionsContainer.style.display = "none";
                        });

                        suggestionsContainer.appendChild(suggestionItem);
                    });
                } else {
                    suggestionsContainer.style.display = "none";
                }
            })
            .catch(error => console.error("Fehler bei der Autovervollständigung:", error));
    }

    // Eventlistener für die Eingabe
    inputField.addEventListener("input", function () {
        const query = inputField.value.trim();
        fetchLocations(query);
    });

    // Zeige alle Städte, wenn das Feld leer ist
    inputField.addEventListener("focus", function () {
        if (inputField.value.trim().length === 0) {
            fetchLocations("");
        }
        suggestionsContainer.style.display = "block"; // Dropdown offen halten, solange das Feld aktiv ist
    });

    // ENTER-Taste: Wenn der Benutzer Enter drückt, wird die erste Stadt aus den Vorschlägen übernommen
    inputField.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Standardverhalten verhindern

            const firstSuggestion = suggestionsContainer.querySelector(".autocomplete-suggestion");
            if (firstSuggestion) {
                inputField.value = firstSuggestion.textContent.trim();
                icon.src = "images/city-icon.png"; // Icon aktualisieren
                icon.style.display = "inline-block";
                suggestionsContainer.innerHTML = "";
                suggestionsContainer.style.display = "none";
            }
        }
    });

    // Fix: Die Standortauswahl bleibt offen, solange das Eingabefeld fokussiert ist
    inputField.addEventListener("click", function (event) {
        event.stopPropagation(); // Verhindert das Schließen durch andere Klick-Listener
        suggestionsContainer.style.display = "block";
    });

    // Klicke außerhalb -> Vorschläge ausblenden
    document.addEventListener("click", function (event) {
        if (!inputField.contains(event.target) && !suggestionsContainer.contains(event.target)) {
            suggestionsContainer.style.display = "none";
        }
    });

    // Entferne die Stadt-Icon und setze die Lupe zurück, wenn das Feld leer ist
    inputField.addEventListener("input", function () {
        if (inputField.value.trim().length === 0) {
            icon.src = "images/lupe-icon.png"; // Zeige die Lupe an, wenn das Feld leer ist
            icon.style.display = "inline-block";
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const dateInputs = document.querySelectorAll("#pickup, #return");
    const calendarContainer = document.getElementById("calendar-container");
    const prevButton = document.getElementById("prev-month");
    const nextButton = document.getElementById("next-month");
    const pickupInput = document.getElementById("pickup");
    const returnInput = document.getElementById("return");

    let selectedDates = [];

    const monthNamesShort = ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"];
    const monthNames = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];

    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();

    function generateMonthGrid(container, year, month) {
        container.innerHTML = "";
        let firstDay = new Date(year, month, 1).getDay();
        if (firstDay === 0) firstDay = 7; // Sonntag als 7 setzen

        let daysInMonth = new Date(year, month + 1, 0).getDate();
        let prevMonthDays = new Date(year, month, 0).getDate();

        let daysHTML = "";
        for (let i = firstDay - 1; i > 0; i--) {
            daysHTML += `<span class="calendar-day outside">${prevMonthDays - i + 1}</span>`;
        }

        for (let day = 1; day <= daysInMonth; day++) {
            daysHTML += `<span class="calendar-day" data-day="${day}" data-month="${month}" data-year="${year}">${day}</span>`;
        }

        container.innerHTML = daysHTML;
        addDateSelectionListeners(container);
    }

    function updateCalendar() {
        generateMonthGrid(document.getElementById("calendar-prev"), currentYear, currentMonth);
        generateMonthGrid(document.getElementById("calendar-current"), currentYear, currentMonth + 1);
        generateMonthGrid(document.getElementById("calendar-next"), currentYear, currentMonth + 2);
        updateMonthLabels();
        updateSelectionUI();
    }

    function updateMonthLabels() {
        document.getElementById("month-prev").textContent = monthNames[currentMonth] + " " + currentYear;
        document.getElementById("month-current").textContent = monthNames[(currentMonth + 1) % 12] + " " + (currentMonth + 1 > 11 ? currentYear + 1 : currentYear);
        document.getElementById("month-next").textContent = monthNames[(currentMonth + 2) % 12] + " " + (currentMonth + 2 > 11 ? currentYear + 1 : currentYear);

        prevButton.disabled = (currentMonth === new Date().getMonth() && currentYear === new Date().getFullYear());
    }

    prevButton.addEventListener("click", function () {
        if (!prevButton.disabled) {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            updateCalendar();
        }
    });

    nextButton.addEventListener("click", function () {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendar();
    });

    function addDateSelectionListeners(container) {
        container.querySelectorAll(".calendar-day").forEach(day => {
            day.addEventListener("click", function () {
                const selectedDay = this.getAttribute("data-day");
                const selectedMonth = this.getAttribute("data-month");
                const selectedYear = this.getAttribute("data-year");
                let selectedDate = new Date(selectedYear, selectedMonth, selectedDay);

                if (selectedDates.length === 0) {
                    selectedDates.push(selectedDate);
                } else if (selectedDates.length === 1) {
                    if (selectedDate.getTime() === selectedDates[0].getTime()) return;
                    selectedDates.push(selectedDate);
                    selectedDates.sort((a, b) => a - b);
                } else {
                    selectedDates = [selectedDate];
                }

                updateDateInputs();
                updateSelectionUI();
            });
        });
    }

    function updateDateInputs() {
        if (selectedDates.length > 0) {
            pickupInput.value = `${selectedDates[0].getDate()}. ${monthNamesShort[selectedDates[0].getMonth()]}`;
        }
        if (selectedDates.length > 1) {
            returnInput.value = `${selectedDates[1].getDate()}. ${monthNamesShort[selectedDates[1].getMonth()]}`;
        } else {
            returnInput.value = "";
        }
    }

    function updateSelectionUI() {
        document.querySelectorAll(".calendar-day").forEach(day => {
            day.classList.remove("selected", "in-range");
        });

        selectedDates.forEach(date => {
            document.querySelectorAll(".calendar-day").forEach(day => {
                if (day.getAttribute("data-day") == date.getDate() &&
                    day.getAttribute("data-month") == date.getMonth() &&
                    day.getAttribute("data-year") == date.getFullYear()) {
                    day.classList.add("selected");
                }
            });
        });

        // Färbt die Tage zwischen den zwei gewählten Daten in hellpink
        if (selectedDates.length === 2) {
            let startDate = selectedDates[0];
            let endDate = selectedDates[1];

            document.querySelectorAll(".calendar-day").forEach(day => {
                let dayNumber = parseInt(day.getAttribute("data-day"));
                let month = parseInt(day.getAttribute("data-month"));
                let year = parseInt(day.getAttribute("data-year"));
                let dateObj = new Date(year, month, dayNumber);

                if (dateObj > startDate && dateObj < endDate) {
                    day.classList.add("in-range"); // Färbt die Tage dazwischen
                }
            });
        }
    }

    dateInputs.forEach(input => {
        input.addEventListener("click", function () {
            calendarContainer.style.display = "block";
            updateCalendar();
            updateSelectionUI();
        });
    });

    document.addEventListener("click", function (event) {
        if (!calendarContainer.contains(event.target) && !Array.from(dateInputs).includes(event.target)) {
            calendarContainer.style.display = "none";
        }
    });

    updateCalendar();
});

document.addEventListener("DOMContentLoaded", function () {
    const pickupTimeInput = document.getElementById("pickup-time");
    const pickupTimeDropdown = document.getElementById("time-dropdown");
    const pickupTimeGrid = document.getElementById("time-grid");

    const returnTimeInput = document.getElementById("return-time");
    const returnTimeDropdown = document.getElementById("return-time-dropdown");
    const returnTimeGrid = document.getElementById("return-time-grid");

    function generateTimeOptions(grid, input, dropdown) {
        grid.innerHTML = ""; // Leeren, falls schon Inhalte da sind
        for (let hour = 0; hour < 24; hour++) {
            for (let min of ["00", "30"]) {
                const timeString = `${hour.toString().padStart(2, '0')}:${min}`;
                const timeOption = document.createElement("div");
                timeOption.classList.add("time-option");
                timeOption.textContent = timeString;

                // Klick-Event für Auswahl der Uhrzeit
                timeOption.addEventListener("click", function () {
                    input.value = timeString;
                    dropdown.style.display = "none";
                });

                grid.appendChild(timeOption);

                // Letzte Zeile nur mit einer Uhrzeit
                if (hour === 23 && min === "30") break;
            }
        }
    }

    // Öffnet das Dropdown mit Uhrzeiten für Abholdatum
    pickupTimeInput.addEventListener("click", function (event) {
        event.stopPropagation();
        pickupTimeDropdown.style.display = "block";
        generateTimeOptions(pickupTimeGrid, pickupTimeInput, pickupTimeDropdown);
    });

    // Öffnet das Dropdown mit Uhrzeiten für Rückgabedatum
    returnTimeInput.addEventListener("click", function (event) {
        event.stopPropagation();
        returnTimeDropdown.style.display = "block";
        generateTimeOptions(returnTimeGrid, returnTimeInput, returnTimeDropdown);
    });

    // Schließt das Dropdown, wenn außerhalb geklickt wird
    document.addEventListener("click", function (event) {
        if (!pickupTimeDropdown.contains(event.target) && event.target !== pickupTimeInput) {
            pickupTimeDropdown.style.display = "none";
        }
        if (!returnTimeDropdown.contains(event.target) && event.target !== returnTimeInput) {
            returnTimeDropdown.style.display = "none";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const locationInput = document.getElementById("search-location");
    const calendarContainer = document.getElementById("calendar-container");
    const pickupInput = document.getElementById("pickup");
    const returnInput = document.getElementById("return");
    const pickupTimeInput = document.getElementById("pickup-time");
    const returnTimeInput = document.getElementById("return-time");
    const calendarDays = document.querySelectorAll(".calendar-days span"); // Alle Tage im Kalender

    function closeAllExcept(except) {
        if (except !== "calendar") calendarContainer.style.display = "none";
        if (except !== "location") document.getElementById("autocomplete-container").style.display = "none";
        if (except !== "pickupTime") document.getElementById("time-dropdown").style.display = "none";
        if (except !== "returnTime") document.getElementById("return-time-dropdown").style.display = "none";
    }

    // Öffnet den Kalender
    pickupInput.addEventListener("click", function (event) {
        event.stopPropagation();
        closeAllExcept("calendar");
        calendarContainer.style.display = "block";
    });

    returnInput.addEventListener("click", function (event) {
        event.stopPropagation();
        closeAllExcept("calendar");
        calendarContainer.style.display = "block";
    });

    // Schließt den Kalender nur bei Klick außerhalb oder auf Standort/Uhrzeitfelder
    document.addEventListener("click", function (event) {
        if (
            !calendarContainer.contains(event.target) &&
            !pickupInput.contains(event.target) &&
            !returnInput.contains(event.target)
        ) {
            closeAllExcept(null);
        }
    });

    // **WICHTIG**: Kalender bleibt offen, wenn ein Tag angeklickt wird
    calendarDays.forEach(day => {
        day.addEventListener("click", function (event) {
            event.stopPropagation(); // Verhindert das Schließen beim Anklicken eines Tages
        });
    });

    // Klick auf Standort oder Uhrzeit schließt den Kalender
    locationInput.addEventListener("click", function () {
        closeAllExcept("location");
    });

    pickupTimeInput.addEventListener("click", function () {
        closeAllExcept("pickupTime");
    });

    returnTimeInput.addEventListener("click", function () {
        closeAllExcept("returnTime");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const locationWrapper = document.querySelector(".location-group");
    const locationInput = document.getElementById("search-location");

    const pickupWrapper = document.getElementById("pickup").closest(".input-group");
    const returnWrapper = document.getElementById("return").closest(".input-group");

    function closeAllExcept(except) {
        if (except !== "location") locationWrapper.classList.remove("focus-within");
        if (except !== "pickup") pickupWrapper.classList.remove("focus-within");
        if (except !== "return") returnWrapper.classList.remove("focus-within");
    }

    locationInput.addEventListener("focus", function () {
        closeAllExcept("location");
        locationWrapper.classList.add("focus-within");
    });

    document.getElementById("pickup").addEventListener("focus", function () {
        closeAllExcept("pickup");
        pickupWrapper.classList.add("focus-within");
    });

    document.getElementById("return").addEventListener("focus", function () {
        closeAllExcept("return");
        returnWrapper.classList.add("focus-within");
    });

    // Klick außerhalb schließt alle Umrandungen
    document.addEventListener("click", function (event) {
        if (!event.target.closest(".input-group") && !event.target.closest(".location-group")) {
            closeAllExcept(null);
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.querySelector("form[action='car_selection.php']");
    
    if (searchForm) {
        searchForm.addEventListener("submit", function () {
            document.getElementById("hidden-search-location").value = document.getElementById("search-location").value;
            document.getElementById("hidden-pickup").value = document.getElementById("pickup").value;
            document.getElementById("hidden-pickup-time").value = document.getElementById("pickup-time").value;
            document.getElementById("hidden-return").value = document.getElementById("return").value;
            document.getElementById("hidden-return-time").value = document.getElementById("return-time").value;
        });
    }
});

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