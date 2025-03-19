document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registerForm"); // Get registration form
    const popupOverlay = document.getElementById("popupOverlay"); // Popup overlay for error messages
    const popupErrors = document.getElementById("popupErrors"); // Error list container
    const popupClose = document.getElementById("popupClose"); // Close button for the popup

    /**
     * 🔹 Displays a popup with error messages
     * @param {Array} errors - List of error messages
     */
    function showPopup(errors) {
        popupErrors.innerHTML = ""; // Clear previous errors

        errors.forEach(error => {
            let li = document.createElement("li");
            li.innerHTML = `<span class="bullet">●</span> ${error}`;
            popupErrors.appendChild(li);
        });

        popupOverlay.style.display = "flex"; // Show the popup
    }

    // 🔹 Close the popup when the close button is clicked
    popupClose.addEventListener("click", function () {
        popupOverlay.style.display = "none";
    });

    // 🔹 Validate registration input when the form is submitted
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        let errors = [];
        let username = document.getElementById("Benutzername").value; // Get username input
        let email = document.getElementById("email").value; // Get email input
        let password = document.getElementById("password").value; // Get password input
        let passwordRepeat = document.getElementById("password_repeat").value; // Get password confirmation
        let birthdate = new Date(document.getElementById("birthdate").value); // Convert birthdate to Date object
        let today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear(); // Calculate age
        let checkbox = document.getElementById("meineCheckbox").checked; // Check if user agreed to data policy

        // 🔹 Age validation (Minimum 18 years old)
        if (age < 18) {
            errors.push("You must be at least 18 years old");
        }

        // 🔹 Password match validation
        if (password !== passwordRepeat) {
            errors.push("Passwords do not match");
        }

        // 🔹 Data policy agreement validation
        if (!checkbox) {
            errors.push("You must accept the data policy");
        }

        // 🔹 Check if username and email are already taken via AJAX
        let requests = [
            fetch(`check_availability.php?field=username&value=${username}`).then(res => res.text()),
            fetch(`check_availability.php?field=email&value=${email}`).then(res => res.text())
        ];

        // 🔹 Wait for both AJAX requests to complete
        Promise.all(requests).then(results => {
            if (results[0] === "exists") {
                errors.push("This username is already taken");
            }
            if (results[1] === "exists") {
                errors.push("This email is already registered");
            }

            // 🔹 Show popup if there are errors, otherwise submit the form
            if (errors.length > 0) {
                showPopup(errors);
            } else {
                form.submit(); // ✅ If no errors, proceed with form submission
            }
        }).catch(error => console.error("Error:", error));
    });
});