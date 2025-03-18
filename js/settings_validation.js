document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("settingsForm");
    const inputs = document.querySelectorAll(".registerpage-input");
    const saveButton = document.querySelector(".loginregisterpage-button");
    const popupOverlay = document.getElementById("popupOverlay");
    const popupErrors = document.getElementById("popupErrors");
    const popupClose = document.getElementById("popupClose");

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

    // 🔹 Deaktiviert den Button, wenn keine Änderungen gemacht wurden
    const initialValues = {};
    inputs.forEach(input => {
        initialValues[input.name] = input.value;
        input.addEventListener("input", checkChanges);
    });

    function checkChanges() {
        let hasChanges = false;
        let hasEmptyFields = false;

        inputs.forEach(input => {
            if (input.value.trim() !== initialValues[input.name]) {
                hasChanges = true;
            }
            if (input.value.trim() === "") {
                hasEmptyFields = true;
            }
        });

        saveButton.disabled = !hasChanges || hasEmptyFields;
    }

    checkChanges(); // Direkt prüfen, falls der Button beim Laden deaktiviert sein soll

    // **🔹 Formulardaten per AJAX senden**
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Standardformularverhalten verhindern

        let formData = new FormData(form);

        fetch("update_user.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "error") {
                showPopup(data.errors); // ❌ Falls Fehler → Pop-up mit Fehlern
            } else if (data.status === "success") {
                showPopup(["Änderungen gespeichert!"]); // ✅ Erfolgreich → Bestätigung anzeigen
                saveButton.disabled = true; // Button nach erfolgreicher Änderung deaktivieren
            }
        })
        .catch(error => console.error("Fehler:", error));
    });
});