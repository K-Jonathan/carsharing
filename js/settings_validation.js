/**
 * This script manages the user settings form, handling validation, change detection, 
 * and AJAX-based form submission.
 * 
 * Features:
 * 
 * ✅ Input Validation:
 * - Ensures first and last names contain only letters (including German umlauts).
 * - Validates that the birthdate input ensures the user is at least 18 years old.
 * - Prevents submission if any required field is empty or contains invalid data.
 * 
 * 🔄 Change Detection:
 * - Tracks initial input values and detects modifications.
 * - Enables the "Save" button only when changes are detected.
 * - Prevents submission if no modifications have been made.
 * 
 * 📡 AJAX Form Submission:
 * - Sends updated user data to `update_user.php` via a POST request.
 * - Processes JSON response to handle success or error messages.
 * - Displays a popup with validation errors or a success message.
 * 
 * ❌ Error Handling:
 * - Shows validation errors inside a popup (`showPopup(errors)`).
 * - Prevents form submission if validation fails.
 * 
 * 🔄 Session Refresh:
 * - After closing the popup, makes a request to `refresh_session.php` to update session data.
 * - Reloads the page upon successful session refresh to reflect changes.
 * 
 * This script enhances the user settings page by ensuring real-time validation, 
 * preventing unnecessary updates, and providing instant feedback.
 */
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("settingsForm");
    const inputs = document.querySelectorAll(".registerpage-input");
    const saveButton = document.querySelector(".loginregisterpage-button");
    const popupOverlay = document.getElementById("popupOverlay");
    const popupErrors = document.getElementById("popupErrors");
    const popupClose = document.getElementById("popupClose");
    const firstNameInput = document.getElementById("first_name");
    const lastNameInput = document.getElementById("last_name");
    const birthdateInput = document.getElementById("birthdate");

    function showPopup(errors, title = "Fehler bei der Aktualisierung") {
        const popupTitle = document.querySelector(".popup-title");
        popupErrors.innerHTML = "";
        popupTitle.textContent = title;
        errors.forEach(error => {
            let li = document.createElement("li");
            li.innerHTML = `<span class="bullet">●</span> ${error}`;
            popupErrors.appendChild(li);
        });
        popupOverlay.style.display = "flex";
    }

    popupClose.addEventListener("click", function () {
        popupOverlay.style.display = "none";
    });

    function validateName(input) {
        const namePattern = /^[A-Za-zÄÖÜäöüß\s]+$/;
        return namePattern.test(input.value.trim());
    }

    function validateBirthdate() {
        let birthdate = new Date(birthdateInput.value);
        let today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        let monthDiff = today.getMonth() - birthdate.getMonth();
        let dayDiff = today.getDate() - birthdate.getDate();

        if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
            age--;
        }

        return age >= 18;
    }

    function checkChanges() {
        let hasChanges = false;
        let hasEmptyFields = false;
        let errors = [];

        inputs.forEach(input => {
            if (input.value.trim() !== initialValues[input.name]) {
                hasChanges = true;
            }
            if (input.value.trim() === "") {
                hasEmptyFields = true;
            }
        });

        if (!validateName(firstNameInput)) {
            errors.push("Vorname darf nur Buchstaben enthalten.");
            hasChanges = false;
        }
        if (!validateName(lastNameInput)) {
            errors.push("Nachname darf nur Buchstaben enthalten.");
            hasChanges = false;
        }
        if (!validateBirthdate()) {
            errors.push("Sie müssen mindestens 18 Jahre alt sein.");
            hasChanges = false;
        }

        saveButton.disabled = !hasChanges || hasEmptyFields;

        if (errors.length > 0) {
            showPopup(errors);
        }
    }

    const initialValues = {};
    inputs.forEach(input => {
        initialValues[input.name] = input.value;
        input.addEventListener("input", checkChanges);
    });

    checkChanges();

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        let errors = checkChanges();
        if (!errors) {
            let formData = new FormData(form);
            fetch("update_user.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "error") {
                    showPopup(data.errors, "Fehler bei der Aktualisierung");
                } else if (data.status === "success") {
                    showPopup(["Änderungen gespeichert!"], "Erfolgreiche Aktualisierung");
                    saveButton.disabled = true;
                }
            })
            .catch(error => console.error("Fehler:", error));
        }
    });
});

popupClose.addEventListener("click", function () {
    fetch("refresh_session.php")
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                location.reload(); // 🔄 Seite ohne `Autotyp` neu laden
            }
        })
        .catch(error => console.error("Fehler beim Aktualisieren der Session:", error));

    popupOverlay.style.display = "none";
});