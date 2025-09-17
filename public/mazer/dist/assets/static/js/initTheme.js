// Initialize theme
function initTheme() {
    const theme = localStorage.getItem("theme") || "light";
    const toggle = document.getElementById("toggle-dark");

    // Set initial state
    if (theme === "dark") {
        document.documentElement.setAttribute("data-bs-theme", "dark");
        document.body.classList.add("theme-dark");
        if (toggle) toggle.checked = true;
    }

    // Listen for toggle changes
    if (toggle) {
        toggle.addEventListener("change", function () {
            if (this.checked) {
                document.documentElement.setAttribute("data-bs-theme", "dark");
                document.body.classList.add("theme-dark");
                localStorage.setItem("theme", "dark");
            } else {
                document.documentElement.setAttribute("data-bs-theme", "light");
                document.body.classList.remove("theme-dark");
                localStorage.setItem("theme", "light");
            }
        });
    }
}

// Run initialization
initTheme();
