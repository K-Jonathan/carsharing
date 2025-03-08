document.addEventListener("DOMContentLoaded", function () {
    let buttons = document.querySelectorAll(".datenschutzpage-accordion-button");
    
    buttons.forEach(button => {
        button.addEventListener("click", function () {
            let content = this.nextElementSibling;
            let icon = this.querySelector(".datenschutzpage-accordion-icon");
            let isOpen = content.classList.contains("open");

            // Schließt alle anderen geöffneten Accordions
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
                // Öffnet das aktuelle Accordion
                content.classList.add("open");
                content.style.visibility = "visible";
                content.style.opacity = "1";
                content.style.maxHeight = content.scrollHeight + "px"; // Dynamische Höhe setzen
                
                this.classList.add("active");
                icon.textContent = "−";
            } else {
                // **Flüssiges Schließen**
                content.style.maxHeight = content.scrollHeight + "px"; // Fixiert die aktuelle Höhe
                setTimeout(() => {
                    content.style.maxHeight = "0px"; // Erst nach kurzer Zeit die Höhe auf 0 setzen
                    content.style.opacity = "0";
                    content.style.visibility = "hidden";
                    content.classList.remove("open");
                }, 10); // Minimale Verzögerung für bessere Animation
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let datumElement = document.getElementById("datenschutz-datum");
    
    // Aktuelles Datum holen
    let heute = new Date();
    
    // Datum formatieren: 21. März 2025
    let options = { day: "numeric", month: "long", year: "numeric" };
    let formatiertesDatum = heute.toLocaleDateString("de-DE", options);
    
    // Datum in das HTML-Element einfügen
    datumElement.textContent = "Aktualisiert am " + formatiertesDatum;
});