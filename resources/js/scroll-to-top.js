import { $, onReady, prefersReducedMotion } from "./utils";

const SHOW_AFTER = 300;
const FLY_MS = 900;

export function initScrollToTop() {
    const btn = $("#scroll-to-top");
    if (!btn) return;

    let flying = false;
    let hiddenUntilScroll = false;

    const apply = () => {
        const visible = !flying && !hiddenUntilScroll && window.scrollY > SHOW_AFTER;
        btn.classList.toggle("is-visible", visible);
    };

    window.addEventListener("scroll", apply, { passive: true });
    apply();

    btn.addEventListener("click", () => {
        if (prefersReducedMotion()) {
            window.scrollTo({ top: 0, behavior: "smooth" });
            return;
        }
        flying = true;
        hiddenUntilScroll = true;
        btn.classList.remove("is-visible");
        window.scrollTo({ top: 0, behavior: "smooth" });
        setTimeout(() => {
            flying = false;
            hiddenUntilScroll = false;
            apply();
        }, FLY_MS + 150);
    });
}

onReady(initScrollToTop);
