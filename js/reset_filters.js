document.addEventListener("DOMContentLoaded", function () {
    const resetButton = document.getElementById("reset-filters");

    resetButton.addEventListener("click", function () {
        location.reload(); // 🌟 Seite wird neu geladen, URL bleibt exakt gleich!
    });
});