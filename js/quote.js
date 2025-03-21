/**
 * This script manages a testimonial slider with smooth animations and dot indicators.
 * 
 * Features:
 * 
 * 📝 Testimonial Text Cycling:
 * - Displays one `.review-text` at a time.
 * - Initially sets the first review as active.
 * - Allows navigation using "Next" and "Previous" buttons.
 * 
 * 🎭 Smooth Animations:
 * - Fades out the current review with a left/right exit animation.
 * - Updates `currentIndex` to cycle through reviews in both directions.
 * - Fades in the new review with a corresponding entry animation.
 * - Locks interactions during animations to prevent rapid clicks.
 * 
 * 🔵 Dot Indicator Updates:
 * - Updates the active dot (`.active-dot`) to match the current review.
 * - Ensures visual feedback for users on which review is currently displayed.
 * 
 * This script creates an interactive and visually appealing review slider with smooth transitions.
 */
document.addEventListener("DOMContentLoaded", function () {
    const reviewTexts = document.querySelectorAll(".review-text");
    const dots = document.querySelectorAll(".dot");
    let currentIndex = 0;
    let isAnimating = false; // Locks the function while an animation is running

    // Sets the first quote visible
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

        // Remove the active quote with the appropriate animation
        if (direction === "next") {
            currentText.classList.add("exit-left");
        } else {
            currentText.classList.add("exit-right");
        }

        setTimeout(() => {
            currentText.classList.remove("active", "exit-left", "exit-right");

            // Calculate new index
            if (direction === "next") {
                currentIndex = (currentIndex + 1) % reviewTexts.length;
            } else {
                currentIndex = (currentIndex - 1 + reviewTexts.length) % reviewTexts.length;
            }

            const newText = reviewTexts[currentIndex];

            // Set the new quote with the appropriate animation
            newText.classList.add("active");
            if (direction === "next") {
                newText.classList.add("enter-right");
            } else {
                newText.classList.add("enter-left");
            }

            setTimeout(() => {
                newText.classList.remove("enter-left", "enter-right");
                isAnimating = false; // Unlocks the function after the animation
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