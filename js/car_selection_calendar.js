document.addEventListener("DOMContentLoaded", function () {
    const editSearchBtn = document.getElementById("edit-search-btn");
    const searchPopup = document.getElementById("search-popup");
    const closePopupBtn = document.getElementById("close-hero-popup");
    const body = document.body;

    // 🖊 Öffnet das Such-Pop-up
    editSearchBtn.addEventListener("click", function () {
        searchPopup.style.display = "flex"; // Pop-up anzeigen
        body.style.overflow = "hidden"; // Scrollen deaktivieren
    });

    // ❌ Schließt das Pop-up
    closePopupBtn.addEventListener("click", function () {
        searchPopup.style.display = "none";
        body.style.overflow = "auto"; // Scrollen wieder erlauben
    });

    // 🚀 Funktion für Datumsauswahl (Kalender)
    const pickupInput = document.getElementById("pickup");
    const returnInput = document.getElementById("return");
    const calendarContainer = document.getElementById("calendar-container");

    function openCalendar(input) {
        calendarContainer.style.display = "block";
        calendarContainer.dataset.target = input.id; // Speichert, welches Feld editiert wird
    }

    pickupInput.addEventListener("click", function () {
        openCalendar(pickupInput);
    });

    returnInput.addEventListener("click", function () {
        openCalendar(returnInput);
    });

    // Klick außerhalb des Kalenders schließt diesen
    document.addEventListener("click", function (event) {
        if (!calendarContainer.contains(event.target) && event.target !== pickupInput && event.target !== returnInput) {
            calendarContainer.style.display = "none";
        }
    });

    // 🚀 Funktion für Uhrzeitauswahl
    function setupTimeDropdown(inputId, dropdownId) {
        const input = document.getElementById(inputId);
        const dropdown = document.getElementById(dropdownId);
        const grid = dropdown.querySelector(".time-grid");

        function generateTimeOptions() {
            grid.innerHTML = "";
            for (let hour = 0; hour < 24; hour++) {
                for (let min of ["00", "30"]) {
                    const timeString = `${hour.toString().padStart(2, '0')}:${min}`;
                    const option = document.createElement("div");
                    option.classList.add("time-option");
                    option.textContent = timeString;
                    option.addEventListener("click", function () {
                        input.value = timeString;
                        dropdown.style.display = "none";
                    });
                    grid.appendChild(option);
                }
            }
        }

        input.addEventListener("click", function (event) {
            event.stopPropagation();
            dropdown.style.display = "block";
            generateTimeOptions();
        });

        document.addEventListener("click", function (event) {
            if (!dropdown.contains(event.target) && event.target !== input) {
                dropdown.style.display = "none";
            }
        });
    }

    setupTimeDropdown("pickup-time", "time-dropdown");
    setupTimeDropdown("return-time", "return-time-dropdown");

    // 🚀 Schließt das Pop-up, wenn auf "Suchen" geklickt wird
    const searchForm = document.querySelector("#search-popup form");

    searchForm.addEventListener("submit", function () {
        searchPopup.style.display = "none"; // Pop-up ausblenden
        body.style.overflow = "auto"; // Scrollen wieder erlauben
    });
});