document.addEventListener("DOMContentLoaded", function () {
    const reviewTexts = document.querySelectorAll(".review-text"); // Get all review texts
    const dots = document.querySelectorAll(".dot"); // Get all navigation dots
    let currentIndex = 0; // Keeps track of the currently displayed review
    let isAnimating = false; // Prevents multiple animations from running simultaneously

    // 🔹 Initially, display the first review
    reviewTexts[currentIndex].classList.add("active");
    updateDots(); // Update navigation dots

    // 🔹 Event listener for the "Next" button
    document.getElementById("nextBtn").addEventListener("click", function () {
        if (!isAnimating) {
            isAnimating = true; // Lock animation
            changeText("next");
        }
    });

    // 🔹 Event listener for the "Previous" button
    document.getElementById("prevBtn").addEventListener("click", function () {
        if (!isAnimating) {
            isAnimating = true; // Lock animation
            changeText("prev");
        }
    });

    /**
     * 🔹 Change the review text with an animation effect
     * @param {string} direction - "next" or "prev"
     */
    function changeText(direction) {
        const currentText = reviewTexts[currentIndex]; // Current review element

        // 🔹 Apply exit animation before switching to the next review
        if (direction === "next") {
            currentText.classList.add("exit-left");
        } else {
            currentText.classList.add("exit-right");
        }

        setTimeout(() => {
            currentText.classList.remove("active", "exit-left", "exit-right"); // Remove active class & animations

            // 🔹 Calculate the new index
            if (direction === "next") {
                currentIndex = (currentIndex + 1) % reviewTexts.length;
            } else {
                currentIndex = (currentIndex - 1 + reviewTexts.length) % reviewTexts.length;
            }

            const newText = reviewTexts[currentIndex]; // New review element

            // 🔹 Apply enter animation for the new review
            newText.classList.add("active");
            if (direction === "next") {
                newText.classList.add("enter-right");
            } else {
                newText.classList.add("enter-left");
            }

            setTimeout(() => {
                newText.classList.remove("enter-left", "enter-right");
                isAnimating = false; // Unlock animation after transition
            }, 500);

            updateDots(); // Update navigation dots
        }, 500); // Matches animation duration (500ms)
    }

    /**
     * 🔹 Updates the navigation dots to reflect the current review
     */
    function updateDots() {
        dots.forEach((dot, index) => {
            if (index === currentIndex) {
                dot.classList.add("active-dot"); // Highlight current dot
            } else {
                dot.classList.remove("active-dot");
            }
        });
    }
});