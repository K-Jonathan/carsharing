/**
 * This script automatically redirects the user to the homepage (or another specified page) after a delay.
 * 
 * Features:
 * 
 * ⏳ Delayed Redirection:
 * - Waits for 5 seconds (5000 milliseconds) before executing the redirect.
 * - Redirects the user to `index.php` (modifiable target page).
 * 
 * 🔄 Use Case:
 * - Typically used on confirmation pages (e.g., after a successful booking or logout).
 * - Provides users with time to read a message before being redirected.
 */
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        window.location.href = "index.php"; // Customize target page
    }, 5000); // 5 seconds delay (5000 milliseconds)
});