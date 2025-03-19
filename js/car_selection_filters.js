document.addEventListener("DOMContentLoaded", function () {
    /**
     * 🔹 Function to set up a dropdown menu
     * @param {string} buttonId - ID of the button that triggers the dropdown
     * @param {string} dropdownId - ID of the dropdown element
     */
    function setupDropdown(buttonId, dropdownId) {
        const button = document.getElementById(buttonId);
        const dropdown = document.getElementById(dropdownId);
        const options = dropdown.querySelectorAll("button");

        // Open dropdown on button click
        button.addEventListener("click", function () {
            const rect = button.getBoundingClientRect(); // Get button position

            // 🛠 Adjust positioning for accurate placement
            const offsetY = -190; // Vertical adjustment
            const offsetX = -635; // Horizontal adjustment (if needed)

            dropdown.style.top = `${rect.bottom + window.scrollY + offsetY}px`; // Position below button
            dropdown.style.left = `${rect.left + window.scrollX + rect.width / 2 - dropdown.offsetWidth / 2 + offsetX}px`; // Center align
            dropdown.classList.toggle("visible");
        });

        // Handle dropdown option selection
        options.forEach(option => {
            option.addEventListener("click", function () {
                if (buttonId === "sort-filter" || buttonId === "price-filter") {
                    // Single selection logic for "Sort" & "Price"
                    if (this.classList.contains("active")) {
                        this.classList.remove("active");
                        button.classList.remove("active"); // Remove highlight if no selection
                    } else {
                        options.forEach(opt => opt.classList.remove("active"));
                        this.classList.add("active");
                        button.classList.add("active");
                    }
                } else {
                    // Multiple selection logic for other filters
                    this.classList.toggle("active");

                    // Check if at least one option is selected
                    const anyActive = [...options].some(opt => opt.classList.contains("active"));
                    button.classList.toggle("active", anyActive);
                }
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove("visible");
            }
        });
    }

    // 🔹 Initialize dropdowns for filters
    setupDropdown("gear-filter", "gear-dropdown"); // Transmission
    setupDropdown("type-filter", "type-dropdown"); // Car Type
    setupDropdown("sort-filter", "sort-dropdown"); // Sorting
    setupDropdown("price-filter", "price-dropdown"); // Price Range
});

document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Get elements for the "More Filters" section
    const moreFiltersBtn = document.getElementById("more-filters-btn");
    const extraFiltersBox = document.getElementById("extra-filters-box");

    if (moreFiltersBtn && extraFiltersBox) {
        moreFiltersBtn.addEventListener("click", function () {
            // 🔹 Check the current `display` value
            const isHidden = getComputedStyle(extraFiltersBox).display === "none";

            // 🔹 Toggle the `display` value based on the previous state
            extraFiltersBox.style.display = isHidden ? "block" : "none";

            // 🔹 Highlight the button when extra filters are visible
            if (!isHidden) {
                moreFiltersBtn.classList.remove("active");
            } else {
                moreFiltersBtn.classList.add("active");
            }
        });
    } else {
        console.error("Error: Required elements not found!");
    }
});

document.addEventListener("DOMContentLoaded", function () {
    /**
     * 🔹 Function to initialize dropdown menus with adjustable X-offset
     * @param {string} buttonId - The ID of the button that opens the dropdown
     * @param {string} dropdownId - The ID of the dropdown element
     * @param {number} offsetX - Horizontal offset adjustment for positioning
     */
    function setupDropdown(buttonId, dropdownId, offsetX = 0) {
        const button = document.getElementById(buttonId);
        const dropdown = document.getElementById(dropdownId);
        const options = dropdown.querySelectorAll("button");

        button.addEventListener("click", function () {
            const rect = button.getBoundingClientRect();

            // Fixed position WITHOUT scrolling
            dropdown.style.top = `${rect.bottom - 253.5}px`; // Removed window.scrollY
            dropdown.style.left = `${rect.left + rect.width / 2 - dropdown.offsetWidth / 2 + offsetX}px`;

            dropdown.classList.toggle("visible");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove("visible");
            }
        });

        // Event listener for multi-selection (buttons change appearance)
        options.forEach(option => {
            option.addEventListener("click", function () {
                if (this.classList.contains("active")) {
                    this.classList.remove("active");
                } else {
                    this.classList.add("active");
                }

                // Check if at least one option is selected
                const anyActive = [...options].some(opt => opt.classList.contains("active"));

                if (anyActive) {
                    button.classList.add("active");
                } else {
                    button.classList.remove("active");
                }
            });
        });
    }

    // 🔹 Initialize dropdowns for filter buttons (with horizontal offset adjustment)
    setupDropdown("manufacturer-filter", "manufacturer-dropdown", -121.5);
    setupDropdown("doors-filter", "doors-dropdown", -122.5);
    setupDropdown("seats-filter", "seats-dropdown", -125);
    setupDropdown("drive-filter", "drive-dropdown", -125);
    setupDropdown("age-filter", "age-dropdown", -127.5);
    setupDropdown("trunk-filter", "trunk-dropdown", -122.5);
});

document.addEventListener("DOMContentLoaded", function () {
    /**
     * 🔹 Function to set up a toggle button
     * @param {string} buttonId - The ID of the button to toggle
     */
    function setupToggleButton(buttonId) {
        const button = document.getElementById(buttonId);

        button.addEventListener("click", function () {
            button.classList.toggle("active");
        });
    }

    // 🔹 Initialize toggle buttons
    setupToggleButton("climate-filter"); // Climate control
    setupToggleButton("gps-filter"); // GPS
});

document.addEventListener("DOMContentLoaded", function () {
    let allCars = [];  // Stores all cars after filtering
    let currentPage = 0;
    const carsPerPage = 15;

    /**
     * 🔹 Fetch available car listings based on active filters
     */
    function fetchCarIds() {
        let url = `fetch_cars.php`;
        let params = [];
    
        const activeSortButton = document.querySelector("#sort-dropdown button.active");
        if (activeSortButton) {
            const sortOrder = activeSortButton.innerText.includes("absteigend") ? "price_desc" : "price_asc";
            params.push(`sort=${sortOrder}`);
        }
    
        /**
         * 🔹 Collect active filter values and add them to the request parameters
         * @param {string} selector - The CSS selector for the filter group
         * @param {string} paramName - The corresponding parameter name for the backend
         */
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
    
                // 🚀 Load booked (unavailable) cars separately
                fetchUnavailableCars();
            })
            .catch(error => console.error("Error loading car IDs:", error));
    }
    
        /**
     * 🔹 Fetch unavailable (booked) cars and display them
     */
        function fetchUnavailableCars() {
            let url = `fetch_unavailable_cars.php`;
            let params = [];
        
            // 🔹 Collect the same filters as for available cars
            const activeSortButton = document.querySelector("#sort-dropdown button.active");
            if (activeSortButton) {
                const sortOrder = activeSortButton.innerText.includes("absteigend") ? "price_desc" : "price_asc";
                params.push(`sort=${sortOrder}`);
            }
        
            /**
             * 🔹 Collect active filter values and add them to the request parameters
             * @param {string} selector - The CSS selector for the filter group
             * @param {string} paramName - The corresponding parameter name for the backend
             */
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
        
            // 🔹 Fetch data
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.cars && data.cars.length > 0) {
                        const groupedUnavailableCars = groupUnavailableCars(data.cars);
                        allCars.push(...groupedUnavailableCars); // 🚀 Add filtered, booked cars to the list
                        renderCars(); // 🔄 Update the UI with new cars
                    }
                })
                .catch(error => console.error("Error loading booked cars:", error));
        }      
    
        /**
         * 🔹 Group unavailable cars by vendor and location to avoid duplicate listings
         * @param {Array} cars - List of unavailable cars
         * @returns {Array} - Grouped list of unavailable cars
         */
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
                        <p>No vehicles available for the selected filter options.</p>
                    </div>
                `;
                updatePaginationButtons(); // ❗ Ensure pagination buttons are updated
                return;
            }
        
            // 🔹 Display only cars for the current page
            const start = currentPage * carsPerPage;
            const visibleCars = allCars.slice(start, start + carsPerPage);
        
            visibleCars.forEach(car => {
                const carElement = document.createElement("div");
                carElement.classList.add("car-card");
        
                const imageName = car.img_file_name ? car.img_file_name : "default.jpg";
        
                if (car.status === "booked") {
                    // 🔹 Style for booked cars
                    carElement.classList.add("unavailable");
                    carElement.innerHTML = `
                        <div class="car-image">
                            <img src="images/cars/${imageName}" alt="${car.vendor_name} ${car.name}" 
                                 class="grayscale"
                                 onerror="this.onerror=null; this.src='images/cars/default.jpg';">
                            <div class="overlay-text">Unavailable for the selected period</div>
                        </div>
                        <div class="car-info">
                            <div class="car-info-left">
                                <h3 class="car-title">${car.vendor_name} ${car.name} ${car.name_extension}</h3>
                                <p class="car-location">${car.loc_name}</p>
                                <p class="car-price">${car.price}€/day</p>
                            </div>
                        </div>
                    `;
                } else {
                    // 🔹 Style for available cars
                    carElement.innerHTML = `
                        <div class="car-image">
                            <img src="images/cars/${imageName}" alt="${car.vendor_name} ${car.type}" 
                                 onerror="this.onerror=null; this.src='images/cars/default.jpg';">
                        </div>
                        <div class="car-info">
                            <div class="car-info-left">
                                <h3 class="car-title">${car.vendor_name} ${car.name} ${car.name_extension}</h3>
                                <p class="car-location">${car.loc_name}  
                                    <span class="availability">- Available: ${car.availability_count}</span>
                                </p>
                                <p class="car-price">${car.price}€/day</p>
                            </div>
                            <button class="book-button" data-car-id="${car.car_id}">Details</button>
                        </div>
                    `;
        
                    // ✅ Add event listener for "Details" button
                    carElement.querySelector(".book-button").addEventListener("click", function () {
                        const carId = this.getAttribute("data-car-id");
                        redirectToDetails(carId);
                    });
                }
        
                container.appendChild(carElement);
            });
        
            updatePaginationButtons(); // ❗ Ensure pagination buttons are updated after rendering
        }               

        function updatePaginationButtons() {
            const prevButton = document.getElementById("prev-cars");
            const nextButton = document.getElementById("next-cars");
            const noCarsMessage = document.querySelector(".no-results"); // Checks if no cars are available
        
            // 🔹 If no cars are available → Disable both buttons
            if (noCarsMessage) {
                prevButton.disabled = true;
                nextButton.disabled = true;
            } else {
                prevButton.disabled = (currentPage === 0);
                nextButton.disabled = ((currentPage + 1) * carsPerPage >= allCars.length);
            }
        
            // 🔹 Add CSS classes for disabled buttons to maintain styling
            prevButton.classList.toggle("disabled", prevButton.disabled);
            nextButton.classList.toggle("disabled", nextButton.disabled);
        }
        
        // 🔹 Event listeners for pagination buttons
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
        
        // 🏁 Event listeners for ALL filter buttons (Trigger immediate update)
        document.querySelectorAll("#sort-dropdown button, #type-dropdown button, #gear-dropdown button, #manufacturer-dropdown button, #doors-dropdown button, #seats-dropdown button, #drive-dropdown button, #age-dropdown button, #price-dropdown button, #climate-filter, #gps-filter, #trunk-dropdown button")
            .forEach(button => {
                button.addEventListener("click", function () {
                    fetchCarIds();
            });
        });
        
    fetchCarIds(); // 🚀 Trigger the first data fetch  
});        