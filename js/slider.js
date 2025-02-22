console.log("Slider Script geladen!");

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