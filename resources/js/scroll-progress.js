import { $, onReady } from "./utils";

export function initScrollProgress() {
    const bar = $("#scroll-progress");
    if (!bar) return;

    let ticking = false;
    const update = () => {
        const max = document.documentElement.scrollHeight - window.innerHeight;
        const progress = max > 0 ? window.scrollY / max : 0;
        bar.style.transform = `scaleX(${Math.min(1, Math.max(0, progress)).toFixed(4)})`;
        ticking = false;
    };

    window.addEventListener("scroll", () => {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    }, { passive: true });
    update();
}

onReady(initScrollProgress);
