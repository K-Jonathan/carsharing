document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("loginForm"); // Get the login form
    const popupOverlay = document.getElementById("popupOverlay"); // Get the popup overlay
    const popupErrors = document.getElementById("popupErrors"); // Get the error message container
    const popupClose = document.getElementById("popupClose"); // Get the close button for the popup

    /**
     * 🔹 Display a popup with a list of error messages
     * @param {Array} errors - Array of error messages
     */
    function showPopup(errors) {
        popupErrors.innerHTML = ""; // Clear previous errors

        errors.forEach(error => {
            let li = document.createElement("li");
            li.innerHTML = `<span class="bullet">●</span> ${error}`; // Add bullet points to errors
            popupErrors.appendChild(li);
        });

        popupOverlay.style.display = "flex"; // Show the popup
    }

    // 🔹 Close the popup when the user clicks the close button
    popupClose.addEventListener("click", function () {
        popupOverlay.style.display = "none";
    });

    // 🔹 Handle form submission
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // 🔹 Get user input values
        let classe = document.getElementById("Classe").value;
        let password = document.getElementById("Classf").value;
        let redirect = document.getElementById("redirect").value; // 🔥 Get redirect value

        // 🔹 Encode data to send in the POST request
        let formData = `Classe=${encodeURIComponent(classe)}&Classf=${encodeURIComponent(password)}&redirect=${encodeURIComponent(redirect)}`;

        // 🔹 Send login data via AJAX request
        fetch("login_process.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: formData
        })
        .then(response => response.json()) // Parse JSON response
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect; // ✅ If login is successful, redirect user
            } else {
                showPopup(data.errors); // ❌ If login fails, display errors in a popup
            }
        })
        .catch(error => console.error("Error:", error)); // Log errors in console
    });
});