import { $, $$, onReady } from "./utils";

export function initTheme() {
    const toggle = $("#theme-toggle");
    if (!toggle) return;

    const applyIcons = () => {
        const dark = document.documentElement.classList.contains("dark");
        const sun = $("#theme-icon-dark");
        const moon = $("#theme-icon-light");
        if (sun) sun.classList.toggle("hidden", !dark);
        if (moon) moon.classList.toggle("hidden", dark);
    };

    const applyTheme = (dark) => {
        const el = document.documentElement;
        el.classList.toggle("dark", dark);
        el.setAttribute("data-theme", dark ? "dark" : "light");
        try {
            localStorage.setItem("theme", dark ? "dark" : "light");
        } catch {}
        applyIcons();
    };

    toggle.addEventListener("click", () => {
        applyTheme(!document.documentElement.classList.contains("dark"));
    });

    applyIcons();
}

onReady(initTheme);
