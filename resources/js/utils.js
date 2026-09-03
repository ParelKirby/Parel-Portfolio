export const APP = window.__APP__ || {};

export function portfolioJson() {
    const el = document.getElementById("portfolio-json");
    if (!el) return null;
    try {
        return JSON.parse(el.textContent);
    } catch {
        return null;
    }
}

export const $ = (sel, root = document) => root.querySelector(sel);
export const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

export function onReady(fn) {
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", fn, { once: true });
    } else {
        fn();
    }
}

export function prefersReducedMotion() {
    return (
        typeof window !== "undefined" &&
        "matchMedia" in window &&
        window.matchMedia("(prefers-reduced-motion: reduce)").matches
    );
}

export function esc(s) {
    const div = document.createElement("div");
    div.textContent = s == null ? "" : String(s);
    return div.innerHTML;
}

export function absoluteUrl(path) {
    if (!path) return path;
    if (/^https?:\/\//i.test(path)) return path;
    return (APP.baseUrl || "/").replace(/\/$/, "") + "/" + path.replace(/^\/+/, "");
}
