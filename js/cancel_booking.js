document.addEventListener("DOMContentLoaded", function () {
    const cancelButtons = document.querySelectorAll(".cancel-booking-button");
    const popup = document.getElementById("cancel-booking-popup");
    const confirmButton = document.getElementById("cancel-booking-confirm");
    const closeButton = document.getElementById("cancel-booking-close");

    let bookingIdToCancel = null;

    cancelButtons.forEach(button => {
        button.addEventListener("click", function () {
            bookingIdToCancel = this.getAttribute("data-booking-id");
            popup.style.display = "flex";

            // 🔹 In die Browser-Historie pushen, damit "Zurück" das Pop-up schließt
            history.pushState({ popupOpen: true }, "", window.location.href);
        });
    });

    closeButton.addEventListener("click", function () {
        popup.style.display = "none";

        // 🔹 Zurück zur vorherigen URL
        history.back();
    });

    confirmButton.addEventListener("click", function () {
        if (bookingIdToCancel) {
            window.location.href = `cancel_booking.php?booking_id=${bookingIdToCancel}`;
        }
    });

    // 🏁 **Event-Listener für "Zurück"-Button im Browser**
    window.addEventListener("popstate", function (event) {
        if (event.state && event.state.popupOpen) {
            // ⛔ Falls das Pop-up offen war, einfach nur schließen
            popup.style.display = "none";
        } else {
            // 🔄 Falls nicht → **Seite komplett neu laden**, um Buchungsliste zu aktualisieren
            window.location.reload();
        }
    });

    // 🚀 **Sicherstellen, dass die Seite neu lädt, wenn sie aus dem Cache kommt**
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
});