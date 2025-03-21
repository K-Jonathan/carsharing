// Location search
/**
 * This script bundle enhances the booking form UI with a custom-built interactive experience:
 * 
 * 1. 🔍 Location Autocomplete:
 *    - Fetches matching locations from `search_locations.php` based on user input.
 *    - Displays clickable suggestions with icons.
 *    - Selects a city by clicking or pressing ENTER (auto-fills input + icon swap).
 *    - Handles visibility and resets icon when the input is cleared.
 * 
 * 2. 📅 Custom Date Picker:
 *    - Renders a 3-month scrollable calendar view with disabled past and future-unbookable dates.
 *    - Allows date range selection (pickup and return).
 *    - Highlights selected dates and in-between days with UI feedback.
 *    - Auto-fills the pickup/return date fields.
 * 
 * 3. ⏰ Time Picker:
 *    - Dropdown time selection for pickup and return time (30-minute intervals).
 *    - Displays time options and fills input upon selection.
 *    - Handles open/close logic on clicks inside/outside the dropdown.
 * 
 * 4. 🔁 Input Focus & UI Sync:
 *    - Manages visibility between overlapping inputs: location, calendar, and time fields.
 *    - Ensures only one widget is open at a time via `closeAllExcept()`.
 *    - Maintains visual feedback for active input groups with `focus-within` class toggling.
 * 
 * Overall, this script turns a basic booking form into a fully interactive date/time/location selector.
 */
document.addEventListener("DOMContentLoaded", function () {
    const inputField = document.getElementById("search-location");
    const suggestionsContainer = document.getElementById("autocomplete-container");

    suggestionsContainer.style.display = "none";

    // Find the existing icon element (magnifying glass)
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
                    suggestionsContainer.style.maxHeight = "200px"; // Maximum 5 suggestions visible
                    suggestionsContainer.style.overflowY = query.length === 0 ? "scroll" : "auto"; // Scrollbar only if empty
                    
                    data.forEach(location => {
                        const suggestionItem = document.createElement("div");
                        suggestionItem.classList.add("autocomplete-suggestion");

                        // Container for icon + text
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

                        // When a city is selected
                        suggestionItem.addEventListener("click", function () {
                            inputField.value = location;
                            icon.src = "images/city-icon.png"; // Switch to the city icon
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

    // Event listener for the input
    inputField.addEventListener("input", function () {
        const query = inputField.value.trim();
        fetchLocations(query);
    });

    // Show all cities if the field is empty
    inputField.addEventListener("focus", function () {
        if (inputField.value.trim().length === 0) {
            fetchLocations("");
        }
        suggestionsContainer.style.display = "block"; // Keep dropdown open as long as the field is active
    });

    // ENTER button: When the user presses Enter, the first city from the suggestions is adopted
    inputField.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent default behavior

            const firstSuggestion = suggestionsContainer.querySelector(".autocomplete-suggestion");
            if (firstSuggestion) {
                inputField.value = firstSuggestion.textContent.trim();
                icon.src = "images/city-icon.png"; // Update icon
                icon.style.display = "inline-block";
                suggestionsContainer.innerHTML = "";
                suggestionsContainer.style.display = "none";
            }
        }
    });

    // Fix: The location selection remains open as long as the input field is focused
    inputField.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevents closing by other click listeners
        suggestionsContainer.style.display = "block";
    });

    // Click outside -> Hide suggestions
    document.addEventListener("click", function (event) {
        if (!inputField.contains(event.target) && !suggestionsContainer.contains(event.target)) {
            suggestionsContainer.style.display = "none";
        }
    });

    // Remove the city icon and reset the magnifying glass if the field is empty
    inputField.addEventListener("input", function () {
        if (inputField.value.trim().length === 0) {
            icon.src = "images/lupe-icon.png"; // Show the magnifying glass if the field is empty
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
        if (firstDay === 0) firstDay = 7; // Set Sunday as 7
    
        let daysInMonth = new Date(year, month + 1, 0).getDate();
        let prevMonthDays = new Date(year, month, 0).getDate();
    
        let today = new Date();
        today.setHours(0, 0, 0, 0); // Sets the time to 00:00 for correct comparison
    
        let maxFutureDate = new Date(today);
        maxFutureDate.setFullYear(today.getFullYear() + 1);
        maxFutureDate.setDate(maxFutureDate.getDate() - 1); // Bookable a maximum of one year in advance
    
        let daysHTML = "";
        for (let i = firstDay - 1; i > 0; i--) {
            daysHTML += `<span class="calendar-day outside">${prevMonthDays - i + 1}</span>`;
        }
    
        for (let day = 1; day <= daysInMonth; day++) {
            let currentDate = new Date(year, month, day);
            let isPast = currentDate < today;
            let isTooFar = currentDate > maxFutureDate; // Check whether it is more than 1 year in the future
    
            daysHTML += `<span class="calendar-day ${isPast || isTooFar ? 'disabled' : ''}" 
                         data-day="${day}" data-month="${month}" data-year="${year}">
                         ${day}
                         </span>`;
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

        // Colors the days between the two selected dates in light pink
        if (selectedDates.length === 2) {
            let startDate = selectedDates[0];
            let endDate = selectedDates[1];

            document.querySelectorAll(".calendar-day").forEach(day => {
                let dayNumber = parseInt(day.getAttribute("data-day"));
                let month = parseInt(day.getAttribute("data-month"));
                let year = parseInt(day.getAttribute("data-year"));
                let dateObj = new Date(year, month, dayNumber);

                if (dateObj > startDate && dateObj < endDate) {
                    day.classList.add("in-range"); // Colors the days in between
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
        grid.innerHTML = ""; // Empty if content is already there
        for (let hour = 0; hour < 24; hour++) {
            for (let min of ["00", "30"]) {
                const timeString = `${hour.toString().padStart(2, '0')}:${min}`;
                const timeOption = document.createElement("div");
                timeOption.classList.add("time-option");
                timeOption.textContent = timeString;

                // Click event for selecting the time
                timeOption.addEventListener("click", function () {
                    input.value = timeString;
                    dropdown.style.display = "none";
                });

                grid.appendChild(timeOption);

                // Last line with a time only
                if (hour === 23 && min === "30") break;
            }
        }
    }

    // Opens the dropdown with times for pick-up date
    pickupTimeInput.addEventListener("click", function (event) {
        event.stopPropagation();
        pickupTimeDropdown.style.display = "block";
        generateTimeOptions(pickupTimeGrid, pickupTimeInput, pickupTimeDropdown);
    });

    // Opens the dropdown with times for return date
    returnTimeInput.addEventListener("click", function (event) {
        event.stopPropagation();
        returnTimeDropdown.style.display = "block";
        generateTimeOptions(returnTimeGrid, returnTimeInput, returnTimeDropdown);
    });

    // Closes the dropdown when clicked outside of it
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
    const calendarDays = document.querySelectorAll(".calendar-days span"); // All days in the calendar

    function closeAllExcept(except) {
        if (except !== "calendar") calendarContainer.style.display = "none";
        if (except !== "location") document.getElementById("autocomplete-container").style.display = "none";
        if (except !== "pickupTime") document.getElementById("time-dropdown").style.display = "none";
        if (except !== "returnTime") document.getElementById("return-time-dropdown").style.display = "none";
    }

    // Opens the calendar
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

    // Closes the calendar only when clicking outside or on location/time fields
    document.addEventListener("click", function (event) {
        if (
            !calendarContainer.contains(event.target) &&
            !pickupInput.contains(event.target) &&
            !returnInput.contains(event.target)
        ) {
            closeAllExcept(null);
        }
    });

    // **IMPORTANT**: Calendar remains open when a day is clicked
    calendarDays.forEach(day => {
        day.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevents closing when clicking on a day
        });
    });

    // Click on location or time to close the calendar
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

    // Click outside to close all borders
    document.addEventListener("click", function (event) {
        if (!event.target.closest(".input-group") && !event.target.closest(".location-group")) {
            closeAllExcept(null);
        }
    });
});