document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Get elements related to search popup
    const editSearchBtn = document.getElementById("edit-search-btn");
    const searchPopup = document.getElementById("search-popup");
    const closePopupBtn = document.getElementById("close-hero-popup");
    const body = document.body;

    // 🖊 Open the search popup
    editSearchBtn.addEventListener("click", function () {
        searchPopup.style.display = "flex"; // Show the popup
        body.style.overflow = "hidden"; // Disable scrolling
    });

    // ❌ Close the popup when clicking the close button
    closePopupBtn.addEventListener("click", function () {
        searchPopup.style.display = "none";
        body.style.overflow = "auto"; // Re-enable scrolling
    });

    // 🚀 Handle date selection in calendar
    const pickupInput = document.getElementById("pickup");
    const returnInput = document.getElementById("return");
    const calendarContainer = document.getElementById("calendar-container");

    function openCalendar(input) {
        calendarContainer.style.display = "block";
        calendarContainer.dataset.target = input.id; // Store which input is being edited
    }

    pickupInput.addEventListener("click", function () {
        openCalendar(pickupInput);
    });

    returnInput.addEventListener("click", function () {
        openCalendar(returnInput);
    });

    // Close calendar when clicking outside
    document.addEventListener("click", function (event) {
        if (!calendarContainer.contains(event.target) && event.target !== pickupInput && event.target !== returnInput) {
            calendarContainer.style.display = "none";
        }
    });

    // 🚀 Function to handle time selection
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

    // 🚀 Close search popup when submitting the form
    const searchForm = document.querySelector("#search-popup form");

    searchForm.addEventListener("submit", function () {
        searchPopup.style.display = "none"; // Hide popup
        body.style.overflow = "auto"; // Re-enable scrolling
    });
});