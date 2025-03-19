document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("settingsForm"); // Get the settings form
    const inputs = document.querySelectorAll(".registerpage-input"); // Get all input fields
    const saveButton = document.querySelector(".loginregisterpage-button"); // Get the save button
    const popupOverlay = document.getElementById("popupOverlay"); // Get the error popup overlay
    const popupErrors = document.getElementById("popupErrors"); // Get the error message container
    const popupClose = document.getElementById("popupClose"); // Get the close button for the popup

    /**
     * 🔹 Display a popup with error messages
     * @param {Array} errors - List of error messages
     * @param {string} title - Title of the popup (default: "Fehler bei der Aktualisierung")
     */
    function showPopup(errors, title = "Fehler bei der Aktualisierung") {
        const popupTitle = document.querySelector(".popup-title"); // Get the popup title
        popupErrors.innerHTML = ""; // Clear previous errors
        popupTitle.textContent = title; // Dynamically set the title

        // 🔹 Loop through error messages and add them to the popup
        errors.forEach(error => {
            let li = document.createElement("li");
            li.innerHTML = `<span class="bullet">●</span> ${error}`;
            popupErrors.appendChild(li);
        });

        popupOverlay.style.display = "flex"; // Show the popup
    }

    // 🔹 Close popup when the close button is clicked
    popupClose.addEventListener("click", function () {
        popupOverlay.style.display = "none";
    });

    // 🔹 Disable the save button when no changes are made
    const initialValues = {}; // Store initial values of input fields

    // Save the initial values of all input fields when the page loads
    inputs.forEach(input => {
        initialValues[input.name] = input.value;
        input.addEventListener("input", checkChanges); // Add event listener for changes
    });

    /**
     * 🔹 Checks if any input field has been changed or left empty
     * - If there are changes, the save button is enabled
     * - If there are no changes or empty fields, the save button is disabled
     */
    function checkChanges() {
        let hasChanges = false;
        let hasEmptyFields = false;

        inputs.forEach(input => {
            if (input.value.trim() !== initialValues[input.name]) {
                hasChanges = true; // Mark as changed
            }
            if (input.value.trim() === "") {
                hasEmptyFields = true; // Check for empty fields
            }
        });

        saveButton.disabled = !hasChanges || hasEmptyFields; // Enable or disable the save button
    }

    checkChanges(); // Run validation on page load to disable button if needed

    // **🔹 Send form data via AJAX**
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        let formData = new FormData(form); // Get form data

        // 🔹 Send data to the server via AJAX
        fetch("update_user.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json()) // Parse JSON response
        .then(data => {
            if (data.status === "error") {
                showPopup(data.errors, "Fehler bei der Aktualisierung"); // ❌ Display error messages
            } else if (data.status === "success") {
                showPopup(["Änderungen gespeichert!"], "Erfolgreiche Aktualisierung"); // ✅ Show success message
                saveButton.disabled = true; // Disable button after successful update
            }
        })
        .catch(error => console.error("Fehler:", error)); // Log errors in the console
    });
});