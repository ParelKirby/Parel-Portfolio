import { $, $$, onReady, prefersReducedMotion } from "./utils";

export function initHero() {
    initCarousel();
    initHelloOverlay();
}

function initCarousel() {
    const root = $("[data-carousel]");
    if (!root) return;

    const slides = $$("[data-slide-index]", root);
    if (!slides.length) return;

    const prev = $(".carousel-prev", root);
    const next = $(".carousel-next", root);
    const dots = $$(".carousel-dot", root);

    let activeIndex = 0;

    const apply = () => {
        slides.forEach((slide, index) => {
            const offset = index - activeIndex;
            const isActive = index === activeIndex;
            const absOffset = Math.abs(offset);

            const x = offset * 140;
            const z = isActive ? 0 : -100;
            const scale = isActive ? 1 : 0.75;
            const rot = offset * -35;

            slide.style.transform = `translateX(${x}px) translateZ(${z}px) scale(${scale}) rotateY(${rot}deg)`;
            slide.style.opacity = absOffset > 1 ? "0" : "1";
            slide.style.zIndex = String(10 - absOffset);
        });

        if (prev) prev.disabled = activeIndex === 0;
        if (next) next.disabled = activeIndex === slides.length - 1;

        dots.forEach((dot, index) => {
            const active = index === activeIndex;
            dot.classList.toggle("bg-[var(--text)]", active);
            dot.classList.toggle("w-8", active);
            dot.classList.toggle("bg-[var(--text)]/30", !active);
            dot.classList.toggle("w-2", !active);
        });
    };

    const goTo = (index) => {
        activeIndex = Math.max(0, Math.min(slides.length - 1, index));
        apply();
    };

    if (prev) prev.addEventListener("click", () => goTo(activeIndex - 1));
    if (next) next.addEventListener("click", () => goTo(activeIndex + 1));

    dots.forEach((dot) => {
        dot.addEventListener("click", () => {
            const d = Number(dot.getAttribute("data-dot-index"));
            if (!Number.isNaN(d)) goTo(d);
        });
    });

    slides.forEach((slide) => {
        slide.addEventListener("click", () => {
            const i = Number(slide.getAttribute("data-slide-index"));
            if (!Number.isNaN(i)) goTo(i);
        });
    });

    apply();
}

function initHelloOverlay() {
    const overlay = $("#hello-overlay");

    if (prefersReducedMotion()) {
        if (overlay) overlay.remove();
        document.body.classList.add("hero-ready");
        return;
    }

    const finish = () => {
        if (overlay) {
            overlay.classList.add("fade-out");
            setTimeout(() => {
                if (overlay.parentNode) overlay.remove();
                document.body.classList.add("hero-ready");
            }, 450);
        } else {
            document.body.classList.add("hero-ready");
        }
    };

    if (!overlay) {
        document.body.classList.add("hero-ready");
        return;
    }

    setTimeout(finish, 3700);
}

onReady(initHero);
