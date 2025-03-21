/**
 * This script handles the login form submission with client-side validation and error handling.
 * 
 * Features:
 * 
 * 🔐 Login Handling:
 * - Listens for form submission and prevents default behavior.
 * - Retrieves user input (class and password) and encodes it for safe transmission.
 * - Includes a `redirect` parameter to return users to their intended page after login.
 * 
 * 📡 AJAX Request:
 * - Sends form data to `login_process.php` using a POST request.
 * - Parses the JSON response to check for success or errors.
 * 
 * ✅ Success:
 * - Redirects the user to the specified page from the `redirect` parameter.
 * 
 * ❌ Error Handling:
 * - Displays a popup listing error messages from the server.
 * - Allows users to close the popup manually.
 * 
 * This improves the login experience by providing real-time validation feedback
 * without reloading the page.
 */
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("loginForm");
    const popupOverlay = document.getElementById("popupOverlay");
    const popupErrors = document.getElementById("popupErrors");
    const popupClose = document.getElementById("popupClose");

    function showPopup(errors) {
        popupErrors.innerHTML = ""; // Remove previous errors
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

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevents sending

        let classe = document.getElementById("Classe").value;
        let password = document.getElementById("Classf").value;
        let redirect = document.getElementById("redirect").value; // 🔥 Get the redirect value

        let formData = `Classe=${encodeURIComponent(classe)}&Classf=${encodeURIComponent(password)}&redirect=${encodeURIComponent(redirect)}`;

        fetch("login_process.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect; // ✅ Successful → Back to the original page
            } else {
                showPopup(data.errors); // ❌ If error → Show pop-up
            }
        })
        .catch(error => console.error("Fehler:", error));
    });
});