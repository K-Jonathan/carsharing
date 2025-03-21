/**
 * This script handles two main features on the privacy policy page:
 * 
 * 1. Accordion Functionality:
 *    - Clicking a button with the class ".datenschutzpage-accordion-button"
 *      toggles the visibility of its associated content section.
 *    - Only one accordion can be open at a time.
 *    - A "+" or "−" icon visually indicates the accordion state.
 *    - Smooth animation is applied for both opening and closing transitions.
 * 
 * 2. Dynamic Date Display:
 *    - Retrieves the current date in German format (e.g., "21. März 2025").
 *    - Inserts this date into the element with ID "datenschutz-datum"
 *      to show when the privacy policy was last updated.
 */
document.addEventListener("DOMContentLoaded", function () {
    let buttons = document.querySelectorAll(".datenschutzpage-accordion-button");
    
    buttons.forEach(button => {
        button.addEventListener("click", function () {
            let content = this.nextElementSibling;
            let icon = this.querySelector(".datenschutzpage-accordion-icon");
            let isOpen = content.classList.contains("open");

            // Closes all other open accordions
            document.querySelectorAll(".datenschutzpage-accordion-content").forEach(c => {
                if (c !== content) {
                    c.style.maxHeight = "0px"; 
                    c.style.opacity = "0";
                    c.style.visibility = "hidden";
                    c.classList.remove("open");
                }
            });

            document.querySelectorAll(".datenschutzpage-accordion-button").forEach(b => b.classList.remove("active"));
            document.querySelectorAll(".datenschutzpage-accordion-icon").forEach(i => i.textContent = "+");

            if (!isOpen) {
                // Opens the current accordion
                content.classList.add("open");
                content.style.visibility = "visible";
                content.style.opacity = "1";
                content.style.maxHeight = content.scrollHeight + "px"; // Set dynamic height
                
                this.classList.add("active");
                icon.textContent = "−";
            } else {
                // **Fluid closing**
                content.style.maxHeight = content.scrollHeight + "px"; // Fixes the current height
                setTimeout(() => {
                    content.style.maxHeight = "0px"; // Only set the height to 0 after a short time
                    content.style.opacity = "0";
                    content.style.visibility = "hidden";
                    content.classList.remove("open");
                }, 10); // Minimal delay for better animation
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let datumElement = document.getElementById("datenschutz-datum");
    
    // Get current date
    let heute = new Date();
    
    // Format date: March 21, 2025
    let options = { day: "numeric", month: "long", year: "numeric" };
    let formatiertesDatum = heute.toLocaleDateString("de-DE", options);
    
    // Insert date in the HTML element
    datumElement.textContent = "Aktualisiert am " + formatiertesDatum;
});