import { $, $$, onReady } from "./utils";

const ROW_HEIGHT = 140;
const MAX_ROWS_COLLAPSED = 3;
const COLLAPSED_PX = ROW_HEIGHT * MAX_ROWS_COLLAPSED;

let selectedTitles = ["all"];
let expanded = false;
let hasOverflow = false;

export function initSkills() {
    const root = $("[data-skills]");
    if (!root) return;

    const filters = $$("[data-skill-filter]", root);
    const groups = $$("[data-skill-group]", root);
    const collapseEl = $("[data-skills-collapse]", root);
    const contentEl = $("[data-skills-content]", root);
    const toggleWrap = $("[data-skills-toggle-wrap]", root);
    const toggleBtn = $("[data-skills-toggle]", root);
    const toggleIcon = $("[data-skills-toggle-icon]", root);
    const toggleLabel = $("[data-skills-toggle-label]", root);
    const bars = $$("[data-skill-bar]", root);

    const checkOverflow = () => {
        if (!contentEl || !collapseEl) return;
        hasOverflow = contentEl.scrollHeight > COLLAPSED_PX;
        if (toggleWrap) toggleWrap.classList.toggle("hidden", !hasOverflow && !expanded);
        if (toggleBtn) toggleBtn.setAttribute("aria-expanded", String(expanded));
    };

    const applyCollapse = () => {
        if (!collapseEl) return;
        const target = expanded
            ? `${contentEl ? contentEl.scrollHeight + 48 : 0}px`
            : hasOverflow
              ? `${COLLAPSED_PX}px`
              : "auto";
        collapseEl.style.maxHeight = target;
        if (toggleLabel) toggleLabel.textContent = expanded ? "Show less" : "Show more";
        if (toggleIcon) toggleIcon.classList.toggle("rotate-180", expanded);
        checkOverflow();
    };

    const applyFilters = () => {
        const all = selectedTitles.includes("all");
        groups.forEach((g) => {
            const title = g.getAttribute("data-skill-group");
            g.classList.toggle("hidden", !all && !selectedTitles.includes(title));
        });
        filters.forEach((btn) => {
            const title = btn.getAttribute("data-skill-filter");
            const active = selectedTitles.includes(title);
            btn.classList.toggle("bg-[var(--brand)]", active);
            btn.classList.toggle("text-white", active);
            btn.classList.toggle("border-[var(--brand)]", active);
            btn.classList.toggle("bg-[var(--surface)]", !active);
            btn.classList.toggle("text-[var(--text)]", !active);
            btn.classList.toggle("border-[var(--border)]", !active);
            btn.classList.toggle("hover:bg-[var(--border)]/30", !active);
            btn.setAttribute("aria-pressed", String(active));
        });
        expanded = false;
        requestAnimationFrame(() => {
            checkOverflow();
            applyCollapse();
        });
    };

    const toggleTitle = (title) => {
        if (title === "all") {
            selectedTitles = ["all"];
        } else {
            const withoutAll = selectedTitles.filter((t) => t !== "all");
            if (withoutAll.includes(title)) {
                const next = withoutAll.filter((t) => t !== title);
                selectedTitles = next.length === 0 ? ["all"] : next;
            } else {
                selectedTitles = [...withoutAll, title];
            }
        }
        applyFilters();
    };

    filters.forEach((btn) => {
        const fire = () => toggleTitle(btn.getAttribute("data-skill-filter"));
        btn.addEventListener("click", fire);
        btn.addEventListener("keydown", (e) => {
            if (e.key === "Enter" || e.key === " ") {
                e.preventDefault();
                fire();
            }
        });
    });

    if (toggleBtn) {
        toggleBtn.addEventListener("click", () => {
            expanded = !expanded;
            applyCollapse();
        });
    }

    if (bars.length) {
        const observeBars = () => {
            bars.forEach((bar) => {
                const level = Number(bar.getAttribute("data-level")) || 0;
                bar.style.transform = `scaleX(${Math.max(0, Math.min(100, level)) / 100})`;
            });
        };
        if ("IntersectionObserver" in window) {
            const obs = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            const bar = entry.target;
                            const level = Number(bar.getAttribute("data-level")) || 0;
                            bar.style.transform = `scaleX(${Math.max(0, Math.min(100, level)) / 100})`;
                            obs.unobserve(bar);
                        }
                    });
                },
                { threshold: 0.2 },
            );
            bars.forEach((bar) => obs.observe(bar));
        } else {
            observeBars();
        }
    }

    if ("ResizeObserver" in window && contentEl) {
        const ro = new ResizeObserver(() => {
            checkOverflow();
            applyCollapse();
        });
        ro.observe(contentEl);
    }
    window.addEventListener("resize", () => {
        checkOverflow();
        applyCollapse();
    });

    applyFilters();
}

onReady(initSkills);
