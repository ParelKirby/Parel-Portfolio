import { $, $$, onReady } from "./utils";

function springScrollTo(y) {
    const start = window.scrollY;
    const delta = y - start;
    if (Math.abs(delta) < 2) {
        window.scrollTo({ top: y, behavior: "smooth" });
        return;
    }
    // Smooth decelerating ease (easeOutQuint) for a gentle, natural glide
    const duration = Math.min(1100, 420 + Math.abs(delta) * 0.2);
    const t0 = performance.now();
    const easeOutQuint = (p) => 1 - Math.pow(1 - p, 5);
    const ease = (p) =>
        p < 0.5
            ? easeOutQuint(p * 2) * 0.5
            : 0.5 + easeOutQuint((p - 0.5) * 2) * 0.5;
    const step = (t) => {
        const p = Math.min(1, (t - t0) / duration);
        window.scrollTo(0, start + delta * ease(p));
        if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
}

export function initHeader() {
    const header = $("#site-header");
    const navLinks = $$("#site-header a[data-nav-link]");

    const trackScroll = () => {
        if (!header) return;
        if (window.scrollY > 10) {
            header.classList.add("is-scrolled");
        } else {
            header.classList.remove("is-scrolled");
        }
    };

    let ticking = false;
    const onScroll = () => {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(() => {
            trackScroll();
            ticking = false;
        });
    };
    window.addEventListener("scroll", onScroll, { passive: true });
    trackScroll();

    // --- mobile nav toggle ---
    const navToggle = $("#nav-toggle");
    const navMenu = $("#nav-menu");
    const setNavOpen = (open) => {
        if (!navMenu || !navToggle) return;
        navMenu.classList.toggle("open", open);
        navToggle.setAttribute("aria-expanded", String(open));
        navToggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
    };
    if (navToggle && navMenu) {
        navToggle.addEventListener("click", (e) => {
            e.stopPropagation();
            setNavOpen(!navMenu.classList.contains("open"));
        });
        document.addEventListener("click", (e) => {
            if (navMenu.classList.contains("open") && !navMenu.contains(e.target) && !navToggle.contains(e.target)) {
                setNavOpen(false);
            }
        });
        window.addEventListener("keydown", (e) => {
            if (e.key === "Escape") setNavOpen(false);
        });
    }

    const onNavClick = (e, href) => {
        if (!href.startsWith("#")) return;
        const target = $(href);
        if (!target) return;
        e.preventDefault();
        setNavOpen(false);
        const headerH = header ? header.offsetHeight : 0;
        const y = target.getBoundingClientRect().top + window.scrollY - headerH;
        springScrollTo(y);
    };

    $$("a[data-smooth-link], #site-header a[href^='#']").forEach((a) => {
        a.addEventListener("click", (e) => onNavClick(e, a.getAttribute("href")));
        a.addEventListener("keydown", (e) => {
            if (e.key === "Enter" || e.key === " " || e.key === "Spacebar") {
                const href = a.getAttribute("href");
                if (href && href.startsWith("#")) {
                    e.preventDefault();
                    onNavClick(e, href);
                }
            }
        });
    });

    const setActive = (id) => {
        navLinks.forEach((l) => {
            const href = l.getAttribute("href");
            const isActive = href === `#${id}`;
            const underline = l.querySelector(`[data-nav-underline]`);
            if (underline) underline.classList.toggle("is-active", isActive);
            if (isActive) l.setAttribute("aria-current", "true");
            else l.removeAttribute("aria-current");
        });
    };

    const sections = navLinks
        .map((l) => $(l.getAttribute("href")))
        .filter(Boolean);

    // Robust active-link detection based on scroll position:
    // always pick the section whose top is closest to (but not past) the viewport center.
    let tickingActive = false;
    const updateActive = () => {
        const headerH = header ? header.offsetHeight : 0;
        const probeY = window.scrollY + headerH + window.innerHeight * 0.35;
        let currentId = null;
        let bestTop = -Infinity;
        sections.forEach((s) => {
            const top = s.getBoundingClientRect().top + window.scrollY;
            if (top <= probeY && top > bestTop) {
                bestTop = top;
                currentId = s.id;
            }
        });
        const last = sections[sections.length - 1];
        if (last) {
            const lastRect = last.getBoundingClientRect();
            if (window.innerHeight >= lastRect.bottom - 4) {
                currentId = last.id;
            }
        }
        if (currentId) setActive(currentId);
    };
    const scheduleActive = () => {
        if (tickingActive) return;
        tickingActive = true;
        requestAnimationFrame(() => {
            updateActive();
            tickingActive = false;
        });
    };
    window.addEventListener("scroll", scheduleActive, { passive: true });
    window.addEventListener("resize", scheduleActive);
    updateActive();
}

onReady(initHeader);
