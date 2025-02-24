document.addEventListener("DOMContentLoaded", function () {
    const reviewTexts = document.querySelectorAll(".review-text");
    const dots = document.querySelectorAll(".dot");
    let currentIndex = 0;
    let isAnimating = false; // Sperrt die Funktion während einer laufenden Animation

    // Setzt das erste Zitat sichtbar
    reviewTexts[currentIndex].classList.add("active");
    updateDots();

    document.getElementById("nextBtn").addEventListener("click", function () {
        if (!isAnimating) {
            isAnimating = true;
            changeText("next");
        }
    });

    document.getElementById("prevBtn").addEventListener("click", function () {
        if (!isAnimating) {
            isAnimating = true;
            changeText("prev");
        }
    });

    function changeText(direction) {
        const currentText = reviewTexts[currentIndex];

        // Entferne das aktive Zitat mit der passenden Animation
        if (direction === "next") {
            currentText.classList.add("exit-left");
        } else {
            currentText.classList.add("exit-right");
        }

        setTimeout(() => {
            currentText.classList.remove("active", "exit-left", "exit-right");

            // Neuer Index berechnen
            if (direction === "next") {
                currentIndex = (currentIndex + 1) % reviewTexts.length;
            } else {
                currentIndex = (currentIndex - 1 + reviewTexts.length) % reviewTexts.length;
            }

            const newText = reviewTexts[currentIndex];

            // Setze das neue Zitat mit der passenden Animation
            newText.classList.add("active");
            if (direction === "next") {
                newText.classList.add("enter-right");
            } else {
                newText.classList.add("enter-left");
            }

            setTimeout(() => {
                newText.classList.remove("enter-left", "enter-right");
                isAnimating = false; // Entsperrt die Funktion nach der Animation
            }, 500);

            updateDots();
        }, 500);
    }

    function updateDots() {
        dots.forEach((dot, index) => {
            if (index === currentIndex) {
                dot.classList.add("active-dot");
            } else {
                dot.classList.remove("active-dot");
            }
        });
    }
});

// Standortsuche
document.addEventListener("DOMContentLoaded", function () {
    const inputField = document.getElementById("search-location");
    const suggestionsContainer = document.getElementById("autocomplete-container");

    suggestionsContainer.style.display = "none";

    // Finde das bestehende Icon-Element (Lupe)
    let icon = document.querySelector(".input-icon");
    if (!icon) {
        console.error("Icon für das Suchfeld nicht gefunden.");
        return;
    }

    function fetchLocations(query = "") {
        fetch("search_locations.php?q=" + query)
            .then(response => response.json())
            .then(data => {
                suggestionsContainer.innerHTML = "";

                if (data.length > 0) {
                    suggestionsContainer.style.display = "block";
                    suggestionsContainer.style.maxHeight = "200px"; // Maximal 5 Vorschläge sichtbar
                    suggestionsContainer.style.overflowY = query.length === 0 ? "scroll" : "auto"; // Scrollbar nur wenn leer
                    
                    data.forEach(location => {
                        const suggestionItem = document.createElement("div");
                        suggestionItem.classList.add("autocomplete-suggestion");

                        // Container für Icon + Text
                        const suggestionContent = document.createElement("div");
                        suggestionContent.classList.add("suggestion-content");

                        const suggestionIcon = document.createElement("img");
                        suggestionIcon.src = "images/city-icon.png";
                        suggestionIcon.alt = "Stadt-Icon";
                        suggestionIcon.classList.add("suggestion-icon");

                        const text = document.createElement("span");
                        text.textContent = location;

                        suggestionContent.appendChild(suggestionIcon);
                        suggestionContent.appendChild(text);
                        suggestionItem.appendChild(suggestionContent);

                        // Wenn eine Stadt ausgewählt wird
                        suggestionItem.addEventListener("click", function () {
                            inputField.value = location;
                            icon.src = "images/city-icon.png"; // Wechsel zur Stadt-Icon
                            icon.style.display = "inline-block";
                            suggestionsContainer.innerHTML = "";
                            suggestionsContainer.style.display = "none";
                        });

                        suggestionsContainer.appendChild(suggestionItem);
                    });
                } else {
                    suggestionsContainer.style.display = "none";
                }
            })
            .catch(error => console.error("Fehler bei der Autovervollständigung:", error));
    }

    // Eventlistener für die Eingabe
    inputField.addEventListener("input", function () {
        const query = inputField.value.trim();
        fetchLocations(query);
    });

    // Zeige alle Städte, wenn das Feld leer ist
    inputField.addEventListener("focus", function () {
        if (inputField.value.trim().length === 0) {
            fetchLocations("");
        }
    });

    // ENTER-Taste: Wenn der Benutzer Enter drückt, wird die erste Stadt aus den Vorschlägen übernommen
    inputField.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Standardverhalten verhindern

            const firstSuggestion = suggestionsContainer.querySelector(".autocomplete-suggestion");
            if (firstSuggestion) {
                inputField.value = firstSuggestion.textContent.trim();
                icon.src = "images/city-icon.png"; // Icon aktualisieren
                icon.style.display = "inline-block";
                suggestionsContainer.innerHTML = "";
                suggestionsContainer.style.display = "none";
            }
        }
    });

    // Klicke außerhalb -> Vorschläge ausblenden
    document.addEventListener("click", function (event) {
        if (!inputField.contains(event.target) && !suggestionsContainer.contains(event.target)) {
            suggestionsContainer.style.display = "none";
        }
    });

    // Entferne die Stadt-Icon und setze die Lupe zurück, wenn das Feld leer ist
    inputField.addEventListener("input", function () {
        if (inputField.value.trim().length === 0) {
            icon.src = "images/lupe-icon.png"; // Zeige die Lupe an, wenn das Feld leer ist
            icon.style.display = "inline-block";
        }
    });
});
