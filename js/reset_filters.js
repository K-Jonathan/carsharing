document.addEventListener("DOMContentLoaded", function () {
    const resetButton = document.getElementById("reset-filters");

    resetButton.addEventListener("click", function () {
        // 🚀 Aktuelle URL holen
        const url = new URL(window.location.href);

        // 🗑️ Den `car_type` Parameter entfernen
        url.searchParams.delete("car_type");

        // 🔄 Seite neu laden ohne `car_type`
        window.location.href = url.toString();
    });
});