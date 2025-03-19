document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Select all accordion buttons
    let buttons = document.querySelectorAll(".datenschutzpage-accordion-button");

    // 🔹 Add click event listener to each button
    buttons.forEach(button => {
        button.addEventListener("click", function () {
            // Get the accordion content directly following the clicked button
            let content = this.nextElementSibling;

            // Get the icon inside the clicked button (for "+" or "−" symbol)
            let icon = this.querySelector(".datenschutzpage-accordion-icon");

            // Check if the clicked accordion is already open
            let isOpen = content.classList.contains("open");

            // 🔹 Close all other accordions before opening a new one
            document.querySelectorAll(".datenschutzpage-accordion-content").forEach(c => {
                if (c !== content) { // Ensure that we do not close the clicked one
                    c.style.maxHeight = "0px"; 
                    c.style.opacity = "0"; 
                    c.style.visibility = "hidden"; 
                    c.classList.remove("open");
                }
            });

            // 🔹 Reset all buttons and icons to their default state
            document.querySelectorAll(".datenschutzpage-accordion-button").forEach(b => b.classList.remove("active"));
            document.querySelectorAll(".datenschutzpage-accordion-icon").forEach(i => i.textContent = "+");

            if (!isOpen) {
                // 🔹 Open the clicked accordion
                content.classList.add("open"); // Add "open" class to track state
                content.style.visibility = "visible"; // Make it visible
                content.style.opacity = "1"; // Fade in effect
                content.style.maxHeight = content.scrollHeight + "px"; // Set max height to allow smooth expansion
                
                this.classList.add("active"); // Highlight the active button
                icon.textContent = "−"; // Change icon to minus
            } else {
                // 🔹 Smoothly close the accordion
                content.style.maxHeight = content.scrollHeight + "px"; // Temporarily set to full height
                setTimeout(() => {
                    content.style.maxHeight = "0px"; // After a short delay, collapse the accordion
                    content.style.opacity = "0";
                    content.style.visibility = "hidden";
                    content.classList.remove("open");
                }, 10); // Small delay ensures a smooth transition
            }
        });
    });
});

// 🔹 Automatically updates the privacy policy date in the footer
document.addEventListener("DOMContentLoaded", function () {
    let datumElement = document.getElementById("datenschutz-datum");

    // 🔹 Get the current date
    let today = new Date();

    // 🔹 Format the date as "21. März 2025"
    let options = { day: "numeric", month: "long", year: "numeric" };
    let formattedDate = today.toLocaleDateString("de-DE", options);

    // 🔹 Insert the formatted date into the HTML element
    datumElement.textContent = "Aktualisiert am " + formattedDate;
});