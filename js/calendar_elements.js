document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.querySelector("form[action='car_selection.php']");
    
    if (searchForm) {
        searchForm.addEventListener("submit", function () {
            document.getElementById("hidden-search-location").value = document.getElementById("search-location").value;
            document.getElementById("hidden-pickup").value = document.getElementById("pickup").value;
            document.getElementById("hidden-pickup-time").value = document.getElementById("pickup-time").value;
            document.getElementById("hidden-return").value = document.getElementById("return").value;
            document.getElementById("hidden-return-time").value = document.getElementById("return-time").value;
        });
    }
});