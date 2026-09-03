import { $, $$, onReady, portfolioJson, esc, APP } from "./utils";
import { marked } from "marked";
import "github-markdown-css/github-markdown-light.css";

let currentProject = null;

function projectById(id) {
    const data = portfolioJson();
    if (!data || !Array.isArray(data.projects)) return null;
    return data.projects.find((p) => String(p.id) === String(id)) || null;
}

function iframeAllowed(url) {
    if (!url) return false;
    return (
        url.includes("github.io") ||
        url.includes("vercel.app") ||
        url.includes("netlify.app")
    );
}

function renderTags(tags, wrap) {
    wrap.innerHTML = "";
    const colors = APP.tagColors || {};
    (tags || []).forEach((t) => {
        const span = document.createElement("span");
        span.className = `text-xs font-semibold px-2 py-1 rounded-full ${
            colors[t] || "bg-gray-100 text-gray-800"
        }`;
        span.textContent = t;
        wrap.appendChild(span);
    });
}

function renderLinks(project, wrap) {
    wrap.innerHTML = "";
    const make = (label, url) => {
        const a = document.createElement("a");
        a.href = url;
        a.target = "_blank";
        a.rel = "noopener noreferrer";
        a.className =
            "inline-flex items-center gap-1 px-3 py-1 text-sm font-medium rounded-md border border-[var(--border)] bg-[var(--surface)] text-[var(--text)] hover:underline";
        a.textContent = label;
        return a;
    };

    if (project.href) {
        const demo = make("Demo", project.href);
        demo.prepend(linkIcon());
        wrap.appendChild(demo);
    }
    (project.links || []).forEach((l) => {
        const a = make(l.label, l.url);
        a.prepend(linkIcon());
        wrap.appendChild(a);
    });
}

function linkIcon() {
    const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute("viewBox", "0 0 24 24");
    svg.setAttribute("fill", "none");
    svg.setAttribute("stroke", "currentColor");
    svg.setAttribute("stroke-width", "2");
    svg.setAttribute("stroke-linecap", "round");
    svg.setAttribute("stroke-linejoin", "round");
    svg.setAttribute("class", "w-4 h-4");
    svg.innerHTML =
        '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" /><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />';
    return svg;
}

async function fetchReadme(project, body) {
    if (!project || !Array.isArray(project.links)) {
        body.classList.add("hidden");
        return;
    }
    const github = project.links.find(
        (l) => (l.label || "").toLowerCase() === "github",
    );
    if (!github) {
        body.classList.add("hidden");
        return;
    }
    const match = /github\.com\/([^/]+)\/([^/]+)/.exec(github.url);
    if (!match) {
        body.classList.add("hidden");
        return;
    }
    try {
        const [, owner, repo] = match;
        const res = await fetch(
            `https://raw.githubusercontent.com/${owner}/${repo}/main/README.md`,
        );
        if (res.ok) {
            const text = await res.text();
            const readmeBody = $("#modal-readme-body");
            if (readmeBody) readmeBody.innerHTML = marked.parse(text);
            body.classList.remove("hidden");
            return;
        }
        body.classList.add("hidden");
    } catch {
        body.classList.add("hidden");
    }
}

function setTab(name) {
    const tabs = $$("[data-modal-tab]");
    tabs.forEach((btn) => {
        const active = btn.getAttribute("data-modal-tab") === name;
        btn.classList.toggle("text-[var(--brand)]", active);
        btn.classList.toggle("border-b-2", active);
        btn.classList.toggle("border-[var(--brand)]", active);
        btn.classList.toggle("text-[var(--muted)]", !active);
        btn.classList.toggle("hover:text-[var(--text)]", !active);
    });

    $$("[data-modal-panel]").forEach((panel) => {
        panel.classList.toggle("hidden", panel.getAttribute("data-modal-panel") !== name);
    });
}

export function initProjects() {
    const modal = $("#project-modal");
    if (!modal) return;

    const title = $("#modal-title");
    const image = $("#modal-image");
    const description = $("#modal-description");
    const linksWrap = $("#modal-links");
    const tagsWrap = $("#modal-tags");
    const readmeWrap = $("#modal-readme");
    const tabs = $("#modal-tabs");
    const iframe = $("#modal-iframe");
    const spinner = $("#modal-spinner");
    const fullscreen = $("#modal-fullscreen-link");
    const scroller = modal.querySelector(".custom-scroll");
    const progress = $("#modal-progress");

    const resetModal = () => {
        if (title) title.textContent = "";
        if (image) {
            image.removeAttribute("src");
            image.classList.add("hidden");
        }
        if (description) description.textContent = "";
        if (readmeWrap) readmeWrap.classList.add("hidden");
        setTab("details");
        if (iframe) {
            iframe.removeAttribute("src");
            iframe.removeAttribute("data-loaded");
        }
        if (spinner) spinner.classList.add("hidden");
    };

    const openModal = async (project) => {
        if (!project) return;
        currentProject = project;
        resetModal();

        if (title) title.textContent = project.title;

        if (project.image) {
            image.src = project.image;
            image.alt = project.title || "";
            image.classList.remove("hidden");
        }

        if (description) description.textContent = project.description || "";

        renderLinks(project, linksWrap);
        renderTags(project.tags, tagsWrap);

        const allowed = iframeAllowed(project.href);
        if (tabs) tabs.classList.toggle("hidden", !allowed);
        if (fullscreen) {
            fullscreen.href = project.href || "#";
            fullscreen.classList.toggle("hidden", !allowed);
        }
        if (spinner) spinner.classList.toggle("hidden", !allowed);

        await fetchReadme(project, readmeWrap);

        modal.classList.add("is-open");
        modal.style.display = "flex";
        document.body.style.overflow = "hidden";
    };

    const closeModal = () => {
        modal.classList.add("is-closing");
        setTimeout(() => {
            modal.classList.remove("is-open", "is-closing");
            modal.style.display = "none";
            document.body.style.overflow = "";
            if (iframe) iframe.removeAttribute("src");
        }, 280);
    };

    $$("[data-project-card]").forEach((card) => {
        card.addEventListener("click", (e) => {
            if (e.target.closest("[data-stop-prop]")) return;
            if (e.target.closest("[data-tags-toggle]")) return;
            openModal(projectById(card.getAttribute("data-project-id")));
        });
        card.addEventListener("keydown", (e) => {
            if (e.key === "Enter" || e.key === " ") {
                e.preventDefault();
                openModal(projectById(card.getAttribute("data-project-id")));
            }
        });
    });

    $$("[data-tags-toggle]").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.stopPropagation();
            const pid = btn.getAttribute("data-tags-toggle");
            const hidden = $$(`[data-tag-item][data-project="${pid}"]`);
            hidden.forEach((el) => el.classList.remove("hidden"));
            btn.remove();
        });
    });

    const closeBtn = $("#modal-close");
    if (closeBtn) closeBtn.addEventListener("click", closeModal);

    const backdrop = modal.querySelector(".modal-backdrop");
    if (backdrop) {
        backdrop.addEventListener("click", (e) => {
            if (e.target === backdrop) closeModal();
        });
    }

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modal.style.display !== "none") closeModal();
    });

    $$("[data-modal-tab]").forEach((btn) => {
        btn.addEventListener("click", () => {
            const name = btn.getAttribute("data-modal-tab");
            setTab(name);
            if (name === "playground" && currentProject && iframe && !iframe.getAttribute("src")) {
                iframe.src = currentProject.href;
                if (spinner) spinner.classList.remove("hidden");
            }
        });
    });

    if (iframe) {
        iframe.addEventListener("load", () => {
            iframe.setAttribute("data-loaded", "1");
            if (spinner) spinner.classList.add("hidden");
        });
    }

    if (scroller && progress) {
        const updateProgress = () => {
            const max = scroller.scrollHeight - scroller.clientHeight;
            const p = max > 0 ? scroller.scrollTop / max : 0;
            progress.style.transform = `scaleX(${Math.min(1, Math.max(0, p)).toFixed(4)})`;
        };
        scroller.addEventListener("scroll", updateProgress, { passive: true });
    }
}

onReady(initProjects);
