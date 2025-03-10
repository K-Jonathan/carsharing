document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("loginForm");
    const popupOverlay = document.getElementById("popupOverlay");
    const popupErrors = document.getElementById("popupErrors");
    const popupClose = document.getElementById("popupClose");

    function showPopup(errors) {
        popupErrors.innerHTML = ""; // Vorherige Fehler entfernen
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
        event.preventDefault(); // Verhindert das Absenden

        let classe = document.getElementById("Classe").value;
        let password = document.getElementById("Classf").value;
        let redirect = document.getElementById("redirect").value; // 🔥 Holt den Redirect-Wert

        let formData = `Classe=${encodeURIComponent(classe)}&Classf=${encodeURIComponent(password)}&redirect=${encodeURIComponent(redirect)}`;

        fetch("login_process.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect; // ✅ Erfolgreich → Zur ursprünglichen Seite zurück
            } else {
                showPopup(data.errors); // ❌ Falls Fehler → Pop-up anzeigen
            }
        })
        .catch(error => console.error("Fehler:", error));
    });
});