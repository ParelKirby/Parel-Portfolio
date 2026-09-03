import { $$, onReady } from "./utils";

export function initReveal() {
    const els = $$("[data-reveal]");
    if (!els.length) return;

    els.forEach((el) => {
        const delay = el.getAttribute("data-reveal-delay");
        if (delay && !el.style.transitionDelay) {
            el.style.transitionDelay = `${Number(delay) || 0}ms`;
        }
    });

    if (!("IntersectionObserver" in window)) {
        els.forEach((el) => el.classList.add("is-visible"));
        return;
    }

    const obs = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("is-visible");
                    obs.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15, rootMargin: "-40px 0px" },
    );

    els.forEach((el) => obs.observe(el));
}

onReady(initReveal);
