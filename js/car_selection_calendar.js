/**
 * This script manages the "Edit Search" popup, including its calendar and time pickers.
 * 
 * Features:
 * 
 * 🖊 Popup Control:
 * - Clicking the "Edit Search" button opens the popup and disables background scrolling.
 * - Clicking the close icon or submitting the form closes the popup and re-enables scrolling.
 * 
 * 📅 Calendar Integration:
 * - Clicking the pickup or return date input opens a shared calendar component.
 * - The calendar uses a `data-target` attribute to remember which input it’s updating.
 * - Clicking outside the calendar closes it.
 * 
 * ⏰ Time Dropdowns:
 * - Time pickers for pickup and return allow selection in 30-minute intervals.
 * - Each dropdown displays on input focus and hides when clicking outside.
 * - Selection auto-fills the input and closes the dropdown.
 * 
 * This script creates a smooth, modal-based search editing experience with fully integrated date/time selection.
 */
document.addEventListener("DOMContentLoaded", function () {
    const editSearchBtn = document.getElementById("edit-search-btn");
    const searchPopup = document.getElementById("search-popup");
    const closePopupBtn = document.getElementById("close-hero-popup");
    const body = document.body;

    // 🖊 Opens the search pop-up
    editSearchBtn.addEventListener("click", function () {
        searchPopup.style.display = "flex"; // Show pop-up
        body.style.overflow = "hidden"; // Deactivate scrolling
    });

    // ❌ Closes the pop-up
    closePopupBtn.addEventListener("click", function () {
        searchPopup.style.display = "none";
        body.style.overflow = "auto"; // Allow scrolling again
    });

    // 🚀 Function for date selection (calendar)
    const pickupInput = document.getElementById("pickup");
    const returnInput = document.getElementById("return");
    const calendarContainer = document.getElementById("calendar-container");

    function openCalendar(input) {
        calendarContainer.style.display = "block";
        calendarContainer.dataset.target = input.id; // Saves which field is being edited
    }

    pickupInput.addEventListener("click", function () {
        openCalendar(pickupInput);
    });

    returnInput.addEventListener("click", function () {
        openCalendar(returnInput);
    });

    // Click outside the calendar to close it
    document.addEventListener("click", function (event) {
        if (!calendarContainer.contains(event.target) && event.target !== pickupInput && event.target !== returnInput) {
            calendarContainer.style.display = "none";
        }
    });

    // 🚀 Function for time selection
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

    // 🚀 Closes the pop-up when “Search” is clicked
    const searchForm = document.querySelector("#search-popup form");

    searchForm.addEventListener("submit", function () {
        searchPopup.style.display = "none"; // Hide pop-up
        body.style.overflow = "auto"; // Allow scrolling again
    });
});