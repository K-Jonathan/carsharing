/**
 * This script handles client-side validation and availability checks for the registration form.
 * 
 * Features:
 * 
 * ✅ Form Validation:
 * - Ensures first and last names contain only letters (including German umlauts).
 * - Checks that the user is at least 18 years old based on the birthdate input.
 * - Verifies that the password and password confirmation match.
 * - Ensures the user agrees to the privacy policy (checkbox).
 * 
 * 🔄 Username & Email Availability Check:
 * - Sends AJAX requests to `check_availability.php` to verify if the username or email is already taken.
 * - If unavailable, adds appropriate error messages.
 * 
 * ❌ Error Handling:
 * - Displays errors inside a popup (`showPopup(errors)`).
 * - Allows users to close the popup manually.
 * 
 * 🚀 Submission Logic:
 * - If validation passes and the username/email are available, the form is submitted.
 * - Otherwise, errors are displayed without submitting the form.
 * 
 * This improves user experience by preventing unnecessary form submissions and providing instant feedback.
 */
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registerForm");
    const popupOverlay = document.getElementById("popupOverlay");
    const popupErrors = document.getElementById("popupErrors");
    const popupClose = document.getElementById("popupClose");
    const firstNameInput = document.getElementById("Vorname");
    const lastNameInput = document.getElementById("name");

    function showPopup(errors) {
        popupErrors.innerHTML = "";
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

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        let errors = [];

        let username = document.getElementById("Benutzername").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let passwordRepeat = document.getElementById("password_repeat").value;
        let birthdate = new Date(document.getElementById("birthdate").value);
        let today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        let checkbox = document.getElementById("meineCheckbox").checked;

        if (!validateName(firstNameInput)) {
            errors.push("Vorname darf nur Buchstaben enthalten.");
        }
        if (!validateName(lastNameInput)) {
            errors.push("Nachname darf nur Buchstaben enthalten.");
        }
        if (age < 18) {
            errors.push("Sie müssen mindestens 18 Jahre alt sein.");
        }
        if (password !== passwordRepeat) {
            errors.push("Die Passwörter stimmen nicht überein.");
        }
        if (!checkbox) {
            errors.push("Sie müssen den Datenschutzrichtlinien zustimmen.");
        }

        let requests = [
            fetch(`check_availability.php?field=username&value=${username}`).then(res => res.text()),
            fetch(`check_availability.php?field=email&value=${email}`).then(res => res.text())
        ];

        Promise.all(requests).then(results => {
            if (results[0] === "exists") {
                errors.push("Der Benutzername ist bereits vergeben.");
            }
            if (results[1] === "exists") {
                errors.push("Die E-Mail-Adresse ist bereits vergeben.");
            }

            if (errors.length > 0) {
                showPopup(errors);
            } else {
                form.submit();
            }
        }).catch(error => console.error("Fehler:", error));
    });
});