document.addEventListener("DOMContentLoaded", function () {
    const categoryImages = document.querySelectorAll(".category-image");

    categoryImages.forEach(image => {
        image.addEventListener("click", function () {
            const carType = this.getAttribute("data-type");

            // URL aus dem Formular auslesen
            const searchForm = document.querySelector("form[action='car_selection.php']");
            if (!searchForm) {
                console.error("Suchformular nicht gefunden!");
                return;
            }

            const params = new URLSearchParams(new FormData(searchForm));

            // Neuen Parameter für car_type hinzufügen
            params.set("car_type", carType);

            // Weiterleitung mit der gleichen Struktur + car_type
            window.location.href = `car_selection.php?${params.toString()}`;
        });
    });
});