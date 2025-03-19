// 🔹 Location search with autocomplete functionality
document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Get input field and suggestions container
    const inputField = document.getElementById("search-location");
    const suggestionsContainer = document.getElementById("autocomplete-container");

    // Hide suggestions container by default
    suggestionsContainer.style.display = "none";

    // 🔹 Find the search icon inside the input field
    let icon = document.querySelector(".input-icon");
    if (!icon) {
        console.error("Error: Search field icon not found.");
        return;
    }

    // 🔹 Function to get a dynamic image path based on the current script location
    function getImagePath(filename) {
        return `${window.location.origin}${window.location.pathname.replace(/\/[^/]*$/, '')}/images/${filename}`;
    }

    // 🔹 Function to fetch location suggestions based on user input
    function fetchLocations(query = "") {
        fetch("search_locations.php?q=" + query)
            .then(response => response.json()) // Convert response to JSON
            .then(data => {
                suggestionsContainer.innerHTML = ""; // Clear existing suggestions

                if (data.length > 0) {
                    // Show suggestions container and set max height
                    suggestionsContainer.style.display = "block";
                    suggestionsContainer.style.maxHeight = "200px"; // Limit to 5 suggestions
                    suggestionsContainer.style.overflowY = query.length === 0 ? "scroll" : "auto";

                    // Generate suggestions dynamically
                    data.forEach(location => {
                        const suggestionItem = document.createElement("div");
                        suggestionItem.classList.add("autocomplete-suggestion");

                        // 🔹 Container for icon and text
                        const suggestionContent = document.createElement("div");
                        suggestionContent.classList.add("suggestion-content");

                        const suggestionIcon = document.createElement("img");
                        suggestionIcon.src = getImagePath("city-icon.png"); // Use dynamic path
                        suggestionIcon.alt = "City Icon";
                        suggestionIcon.classList.add("suggestion-icon");

                        const text = document.createElement("span");
                        text.textContent = location;

                        suggestionContent.appendChild(suggestionIcon);
                        suggestionContent.appendChild(text);
                        suggestionItem.appendChild(suggestionContent);

                        // 🔹 When a city is selected from suggestions
                        suggestionItem.addEventListener("click", function () {
                            inputField.value = location;
                            icon.src = getImagePath("city-icon.png"); // Change to city icon dynamically
                            icon.style.display = "inline-block";
                            suggestionsContainer.innerHTML = ""; // Clear suggestions
                            suggestionsContainer.style.display = "none"; // Hide container
                        });

                        suggestionsContainer.appendChild(suggestionItem);
                    });
                } else {
                    suggestionsContainer.style.display = "none"; // Hide container if no results
                }
            })
            .catch(error => console.error("Error in autocomplete:", error));
    }

    // 🔹 Listen for user input and fetch location suggestions
    inputField.addEventListener("input", function () {
        const query = inputField.value.trim();
        fetchLocations(query);
    });

    // 🔹 Show all locations when input is empty
    inputField.addEventListener("focus", function () {
        if (inputField.value.trim().length === 0) {
            fetchLocations("");
        }
        suggestionsContainer.style.display = "block"; // Keep dropdown open while focused
    });

    // 🔹 Pressing ENTER selects the first suggestion
    inputField.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent default form submission behavior

            const firstSuggestion = suggestionsContainer.querySelector(".autocomplete-suggestion");
            if (firstSuggestion) {
                inputField.value = firstSuggestion.textContent.trim();
                icon.src = getImagePath("city-icon.png"); // Update icon dynamically
                icon.style.display = "inline-block";
                suggestionsContainer.innerHTML = "";
                suggestionsContainer.style.display = "none";
            }
        }
    });

    // 🔹 Keep the suggestion list open while the input field is active
    inputField.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevents closing due to other click listeners
        suggestionsContainer.style.display = "block";
    });

    // 🔹 Hide suggestions when clicking outside
    document.addEventListener("click", function (event) {
        if (!inputField.contains(event.target) && !suggestionsContainer.contains(event.target)) {
            suggestionsContainer.style.display = "none";
        }
    });

    // 🔹 Reset the search icon to a magnifying glass when the input field is empty
    inputField.addEventListener("input", function () {
        if (inputField.value.trim().length === 0) {
            icon.src = getImagePath("lupe-icon.png"); // Show magnifying glass dynamically
            icon.style.display = "inline-block";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Select relevant elements from the DOM
    const dateInputs = document.querySelectorAll("#pickup, #return");
    const calendarContainer = document.getElementById("calendar-container");
    const prevButton = document.getElementById("prev-month");
    const nextButton = document.getElementById("next-month");
    const pickupInput = document.getElementById("pickup");
    const returnInput = document.getElementById("return");

    let selectedDates = []; // Stores selected dates

    // 🔹 Month names for display (German format)
    const monthNamesShort = ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"];
    const monthNames = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];

    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();

    // 🔹 Function to generate the calendar grid for a specific month
    function generateMonthGrid(container, year, month) {
        container.innerHTML = "";
        let firstDay = new Date(year, month, 1).getDay();
        if (firstDay === 0) firstDay = 7; // Convert Sunday from 0 to 7

        let daysInMonth = new Date(year, month + 1, 0).getDate();
        let prevMonthDays = new Date(year, month, 0).getDate();

        let today = new Date();
        today.setHours(0, 0, 0, 0); // Ensure time is 00:00 for comparison

        // 🔹 Maximum future booking date (1 year in advance)
        let maxFutureDate = new Date(today);
        maxFutureDate.setFullYear(today.getFullYear() + 1);
        maxFutureDate.setDate(maxFutureDate.getDate() - 1); // 1 year minus 1 day

        let daysHTML = "";

        // 🔹 Add previous month's remaining days (for alignment)
        for (let i = firstDay - 1; i > 0; i--) {
            daysHTML += `<span class="calendar-day outside">${prevMonthDays - i + 1}</span>`;
        }

        // 🔹 Add current month's days
        for (let day = 1; day <= daysInMonth; day++) {
            let currentDate = new Date(year, month, day);
            let isPast = currentDate < today;
            let isTooFar = currentDate > maxFutureDate; // More than 1 year ahead?

            daysHTML += `<span class="calendar-day ${isPast || isTooFar ? 'disabled' : ''}" 
                         data-day="${day}" data-month="${month}" data-year="${year}">
                         ${day}
                         </span>`;
        }

        container.innerHTML = daysHTML;
        addDateSelectionListeners(container);
    }

    // 🔹 Function to update the entire calendar view
    function updateCalendar() {
        generateMonthGrid(document.getElementById("calendar-prev"), currentYear, currentMonth);
        generateMonthGrid(document.getElementById("calendar-current"), currentYear, currentMonth + 1);
        generateMonthGrid(document.getElementById("calendar-next"), currentYear, currentMonth + 2);
        updateMonthLabels();
        updateSelectionUI();
    }

    // 🔹 Function to update the month labels in the UI
    function updateMonthLabels() {
        document.getElementById("month-prev").textContent = monthNames[currentMonth] + " " + currentYear;
        document.getElementById("month-current").textContent = monthNames[(currentMonth + 1) % 12] + " " + (currentMonth + 1 > 11 ? currentYear + 1 : currentYear);
        document.getElementById("month-next").textContent = monthNames[(currentMonth + 2) % 12] + " " + (currentMonth + 2 > 11 ? currentYear + 1 : currentYear);

        prevButton.disabled = (currentMonth === new Date().getMonth() && currentYear === new Date().getFullYear());
    }

    // 🔹 Navigation: Move to previous month
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

    // 🔹 Navigation: Move to next month
    nextButton.addEventListener("click", function () {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendar();
    });

    // 🔹 Function to add event listeners for selecting dates
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

    // 🔹 Function to update the input fields with the selected dates
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

    // 🔹 Function to update the calendar UI (highlighting selected dates)
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

        // Highlight days between the selected range
        if (selectedDates.length === 2) {
            let startDate = selectedDates[0];
            let endDate = selectedDates[1];

            document.querySelectorAll(".calendar-day").forEach(day => {
                let dateObj = new Date(day.getAttribute("data-year"), day.getAttribute("data-month"), day.getAttribute("data-day"));
                if (dateObj > startDate && dateObj < endDate) {
                    day.classList.add("in-range");
                }
            });
        }
    }

    // 🔹 Open calendar on input field click
    dateInputs.forEach(input => {
        input.addEventListener("click", function () {
            calendarContainer.style.display = "block";
            updateCalendar();
            updateSelectionUI();
        });
    });

    // 🔹 Close calendar when clicking outside
    document.addEventListener("click", function (event) {
        if (!calendarContainer.contains(event.target) && !Array.from(dateInputs).includes(event.target)) {
            calendarContainer.style.display = "none";
        }
    });

    updateCalendar(); // Initial calendar setup
});

// 🔹 Wait for the DOM to fully load before executing scripts
document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Get all elements related to time selection
    const pickupTimeInput = document.getElementById("pickup-time");
    const pickupTimeDropdown = document.getElementById("time-dropdown");
    const pickupTimeGrid = document.getElementById("time-grid");

    const returnTimeInput = document.getElementById("return-time");
    const returnTimeDropdown = document.getElementById("return-time-dropdown");
    const returnTimeGrid = document.getElementById("return-time-grid");

    // 🔹 Function to generate time selection options (every 30 minutes)
    function generateTimeOptions(grid, input, dropdown) {
        grid.innerHTML = ""; // Clear previous content

        for (let hour = 0; hour < 24; hour++) {
            for (let min of ["00", "30"]) {
                const timeString = `${hour.toString().padStart(2, '0')}:${min}`;
                const timeOption = document.createElement("div");
                timeOption.classList.add("time-option");
                timeOption.textContent = timeString;

                // 🔹 Click event to select time and close dropdown
                timeOption.addEventListener("click", function () {
                    input.value = timeString;
                    dropdown.style.display = "none";
                });

                grid.appendChild(timeOption);

                // 🔹 Stop generating after "23:30"
                if (hour === 23 && min === "30") break;
            }
        }
    }

    // 🔹 Open dropdown when clicking on pickup time input
    pickupTimeInput.addEventListener("click", function (event) {
        event.stopPropagation();
        pickupTimeDropdown.style.display = "block";
        generateTimeOptions(pickupTimeGrid, pickupTimeInput, pickupTimeDropdown);
    });

    // 🔹 Open dropdown when clicking on return time input
    returnTimeInput.addEventListener("click", function (event) {
        event.stopPropagation();
        returnTimeDropdown.style.display = "block";
        generateTimeOptions(returnTimeGrid, returnTimeInput, returnTimeDropdown);
    });

    // 🔹 Close dropdowns when clicking outside
    document.addEventListener("click", function (event) {
        if (!pickupTimeDropdown.contains(event.target) && event.target !== pickupTimeInput) {
            pickupTimeDropdown.style.display = "none";
        }
        if (!returnTimeDropdown.contains(event.target) && event.target !== returnTimeInput) {
            returnTimeDropdown.style.display = "none";
        }
    });
});

// 🔹 Handle visibility for different input groups (calendar, location, time pickers)
document.addEventListener("DOMContentLoaded", function () {
    const locationInput = document.getElementById("search-location");
    const calendarContainer = document.getElementById("calendar-container");
    const pickupInput = document.getElementById("pickup");
    const returnInput = document.getElementById("return");
    const pickupTimeInput = document.getElementById("pickup-time");
    const returnTimeInput = document.getElementById("return-time");

    function closeAllExcept(except) {
        if (except !== "calendar") calendarContainer.style.display = "none";
        if (except !== "location") document.getElementById("autocomplete-container").style.display = "none";
        if (except !== "pickupTime") document.getElementById("time-dropdown").style.display = "none";
        if (except !== "returnTime") document.getElementById("return-time-dropdown").style.display = "none";
    }

    // 🔹 Open the calendar when clicking on the pickup date input
    pickupInput.addEventListener("click", function (event) {
        event.stopPropagation();
        closeAllExcept("calendar");
        calendarContainer.style.display = "block";
    });

    // 🔹 Open the calendar when clicking on the return date input
    returnInput.addEventListener("click", function (event) {
        event.stopPropagation();
        closeAllExcept("calendar");
        calendarContainer.style.display = "block";
    });

    // 🔹 Close the calendar when clicking outside of relevant elements
    document.addEventListener("click", function (event) {
        if (
            !calendarContainer.contains(event.target) &&
            !pickupInput.contains(event.target) &&
            !returnInput.contains(event.target)
        ) {
            closeAllExcept(null);
        }
    });

    // 🔹 Prevent calendar from closing when clicking inside it
    document.querySelectorAll(".calendar-days span").forEach(day => {
        day.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    });

    // 🔹 Close calendar when clicking on location or time fields
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

// 🔹 Handle focus styles for input groups (adds/removes highlight classes)
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

    // 🔹 Highlight input field when focused
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

    // 🔹 Remove highlight when clicking outside
    document.addEventListener("click", function (event) {
        if (!event.target.closest(".input-group") && !event.target.closest(".location-group")) {
            closeAllExcept(null);
        }
    });
});