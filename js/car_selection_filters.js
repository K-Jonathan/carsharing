/**
 * This script manages car filtering, sorting, and pagination for the car selection page.
 * 
 * Features:
 * 
 * 🔽 Dropdown Filters:
 * - Initializes multiple dropdown filters (gearbox, type, sorting, price, etc.).
 * - Allows both single and multiple selections, dynamically updating button states.
 * - Closes dropdowns when clicking outside.
 * 
 * 🎛️ Toggle Filters:
 * - Climate control and GPS filters toggle active states on click.
 * 
 * 🚗 Car Filtering & Sorting:
 * - Collects active filters and sorting preferences.
 * - Constructs a dynamic query string for `fetch_cars.php`.
 * - Calls `fetchCarIds()` to retrieve available cars.
 * 
 * 🔄 Loading Unavailable Cars:
 * - Fetches booked cars separately via `fetch_unavailable_cars.php`.
 * - Groups identical unavailable cars and merges them into the results.
 * - Styles unavailable cars with a grayscale overlay.
 * 
 * 📄 Car List Rendering:
 * - Displays 15 cars per page with title, location, price, and availability.
 * - Differentiates between available and booked cars visually.
 * - "Details" buttons trigger `redirectToDetails(carId)`, forwarding search parameters.
 * 
 * 📑 Pagination:
 * - Implements "Previous" and "Next" buttons for navigating pages.
 * - Updates button states based on the number of cars.
 * 
 * 🚀 Real-time Filtering:
 * - Clicking any filter option immediately triggers `fetchCarIds()` to update results.
 * - Ensures seamless filtering without requiring page reloads.
 * 
 * This script provides an interactive and dynamic car search experience, ensuring that
 * filtering, sorting, and pagination function smoothly for an optimized user journey.
 */
document.addEventListener("DOMContentLoaded", function () {
    function setupDropdown(buttonId, dropdownId) {
        const button = document.getElementById(buttonId);
        const dropdown = document.getElementById(dropdownId);
        const options = dropdown.querySelectorAll("button");
        
        button.addEventListener("click", function () {
            const rect = button.getBoundingClientRect(); // Get position of the button

            // 🛠 Adjustments for exact positioning
            const offsetY = -190; // Distance downwards
            const offsetX = -635; // If necessary, for left/right shift

            dropdown.style.top = `${rect.bottom + window.scrollY + offsetY}px`; // Directly under the button
            dropdown.style.left = `${rect.left + window.scrollX + rect.width / 2 - dropdown.offsetWidth / 2 + offsetX}px`; // Exactly centered
            dropdown.classList.toggle("visible");
        });

        // Event listener for dropdown options (single selection for “Sorting” and “Price to”, multiple selection for others)
        options.forEach(option => {
            option.addEventListener("click", function () {
                if (buttonId === "sort-filter" || buttonId === "price-filter") {
                    // If “Sorting” or “Price to”, allow only one selection, but can also be deactivated
                    if (this.classList.contains("active")) {
                        this.classList.remove("active");

                        // If nothing is active anymore, remove color from the main button
                        button.classList.remove("active");
                    } else {
                        options.forEach(opt => opt.classList.remove("active"));
                        this.classList.add("active");

                        // Color main button
                        button.classList.add("active");
                    }
                } else {
                    // If already active, remove selection (for multiple selection buttons)
                    if (this.classList.contains("active")) {
                        this.classList.remove("active");
                    } else {
                        this.classList.add("active");
                    }

                    // Check whether at least one selection is active
                    const anyActive = [...options].some(opt => opt.classList.contains("active"));

                    // If a selection is active, color the main button
                    if (anyActive) {
                        button.classList.add("active");
                    } else {
                        button.classList.remove("active");
                    }
                }
            });
        });

        // Click outside the box to close it again
        document.addEventListener("click", function (event) {
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove("visible");
            }
        });
    }

    // Initialize dropdowns
    setupDropdown("gear-filter", "gear-dropdown"); // Gearbox
    setupDropdown("type-filter", "type-dropdown"); // Type
    setupDropdown("sort-filter", "sort-dropdown"); // Sorting
    setupDropdown("price-filter", "price-dropdown"); // Price until
});

document.addEventListener("DOMContentLoaded", function () {
    const moreFiltersBtn = document.getElementById("more-filters-btn");
    const extraFiltersBox = document.getElementById("extra-filters-box");

    if (moreFiltersBtn && extraFiltersBox) {
        moreFiltersBtn.addEventListener("click", function () {
            // Check the current `display` value
            const isHidden = getComputedStyle(extraFiltersBox).display === "none";

            // Set the new `display` value based on the previous state
            extraFiltersBox.style.display = isHidden ? "block" : "none";

            // 🔹 Color the button if extraFiltersBox is visible
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

            // Fixed position WITHOUT scrolling
            dropdown.style.top = `${rect.bottom - 253.5}px`; // Removes window.scrollY
            dropdown.style.left = `${rect.left + rect.width / 2 - dropdown.offsetWidth / 2 + offsetX}px`;

            dropdown.classList.toggle("visible");
        });

        // Click outside the dropdown to close it
        document.addEventListener("click", function (event) {
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove("visible");
            }
        });

        // Event listener for multiple selection (buttons change color)
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

    // 🔹 Initialize dropdowns for new filter buttons (with X-displacement)
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
    let allCars = [];  // Saves all cars after filtering
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
    
                // 🚀 Reload booked cars afterwards
                fetchUnavailableCars();
            })
            .catch(error => console.error("Fehler beim Laden der Car-IDs:", error));
    }
    
    // 🔹 New function: Reload & display booked cars
    function fetchUnavailableCars() {
        let url = `fetch_unavailable_cars.php`;
        let params = [];
    
        // 🔹 Collect the same filters as for available cars
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
    
        // 🔹 Retrieve data
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.cars && data.cars.length > 0) {
                    const groupedUnavailableCars = groupUnavailableCars(data.cars);
                    allCars.push(...groupedUnavailableCars); // 🚀 Add filtered, booked cars
                    renderCars(); // 🔄 Update the display with the new cars
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
            updatePaginationButtons(); // ❗ Check directly after adding!
            return;
        }
    
        // 🔹 Show only cars for the current page
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
                                <span class="availability">- Verfügbar: ${car.availability_count}</span>
                            </p>
                            <p class="car-price">${car.price}€/Tag</p>
                        </div>
                        <button class="book-button" data-car-id="${car.car_id}">Details</button>
                    </div>
                `;
    
                // ✅ Event listener for “Details” button
                carElement.querySelector(".book-button").addEventListener("click", function () {
                    const carId = this.getAttribute("data-car-id");
                    redirectToDetails(carId);
                });
            }
    
            container.appendChild(carElement);
        });
    
        updatePaginationButtons(); // ❗ Call up after rendering the cars
    }            

    function updatePaginationButtons() {
        const prevButton = document.getElementById("prev-cars");
        const nextButton = document.getElementById("next-cars");
        const noCarsMessage = document.querySelector(".no-results"); // Checks whether no cars are present
    
        // 🔹 If no cars are available → Deactivate both buttons
        if (noCarsMessage) {
            prevButton.disabled = true;
            nextButton.disabled = true;
        } else {
            prevButton.disabled = (currentPage === 0);
            nextButton.disabled = ((currentPage + 1) * carsPerPage >= allCars.length);
        }
    
        // 🔹 Set classes for deactivated buttons to retain the styling
        prevButton.classList.toggle("disabled", prevButton.disabled);
        nextButton.classList.toggle("disabled", nextButton.disabled);
    }
    
    // 🔹 Event listener for the paging buttons
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
    
    // 🏁 Event listener for ALL filter buttons (immediate update)
    document.querySelectorAll("#sort-dropdown button, #type-dropdown button, #gear-dropdown button, #manufacturer-dropdown button, #doors-dropdown button, #seats-dropdown button, #drive-dropdown button, #age-dropdown button, #price-dropdown button, #climate-filter, #gps-filter, #trunk-dropdown button")
        .forEach(button => {
            button.addEventListener("click", function () {
                fetchCarIds();
            });
        });
    
    fetchCarIds(); // 🚀 Start the first data query            
});