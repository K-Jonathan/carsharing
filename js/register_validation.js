document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registerForm");
    const popupOverlay = document.getElementById("popupOverlay");
    const popupErrors = document.getElementById("popupErrors");
    const popupClose = document.getElementById("popupClose");

    // 🔹 Funktion zum Anzeigen des Pop-ups mit Fehlern
    function showPopup(errors) {
        popupErrors.innerHTML = ""; // Vorherige Fehler entfernen
        errors.forEach(error => {
            let li = document.createElement("li");
            li.innerHTML = `<span class="bullet">●</span> ${error}`;
            popupErrors.appendChild(li);
        });
        popupOverlay.style.display = "flex";
    }

    // 🔹 Funktion zum Verstecken des Pop-ups
    popupClose.addEventListener("click", function () {
        popupOverlay.style.display = "none";
    });

    // 🔹 Registrierung prüfen
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Verhindert das Absenden

        let errors = [];
        let username = document.getElementById("Benutzername").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let passwordRepeat = document.getElementById("password_repeat").value;
        let birthdate = new Date(document.getElementById("birthdate").value);
        let today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        let checkbox = document.getElementById("meineCheckbox").checked; // Datenschutz-Checkbox

        // 🔹 Alter prüfen (mind. 18 Jahre)
        if (age < 18) {
            errors.push("Sie müssen mindestens 18 Jahre alt sein");
        }

        // 🔹 Passwort-Überprüfung
        if (password !== passwordRepeat) {
            errors.push("Die Passwörter stimmen nicht überein");
        }

        // 🔹 Datenschutz-Checkbox prüfen
        if (!checkbox) {
            errors.push("Zustimmen der Datenschutzrichtlinien");
        }

        // 🔹 Benutzername & E-Mail per AJAX prüfen
        let requests = [
            fetch(`check_availability.php?field=username&value=${username}`).then(res => res.text()),
            fetch(`check_availability.php?field=email&value=${email}`).then(res => res.text())
        ];

        Promise.all(requests).then(results => {
            if (results[0] === "exists") {
                errors.push("Der Benutzername ist bereits vergeben");
            }
            if (results[1] === "exists") {
                errors.push("Die E-Mail-Adresse ist bereits vergeben");
            }

            // 🔹 Falls Fehler → Pop-up anzeigen
            if (errors.length > 0) {
                showPopup(errors);
            } else {
                form.submit(); // ✅ Wenn keine Fehler → Formular absenden
            }
        }).catch(error => console.error("Fehler:", error));
    });
});