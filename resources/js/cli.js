import { $, onReady, portfolioJson, absoluteUrl } from "./utils";

const state = {
    visible: false,
    initialized: false,
    minimized: false,
    fullscreen: false,
    processing: false,
    history: [],
    cmdHistory: [],
    cmdIndex: null,
    resumeData: null,
};

function formatDateRange(d) {
    if (!d) return "";
    if (typeof d === "string") return d;
    const { start, end, present } = d;
    if (present) return `${start ?? ""} - Present`;
    return `${start ?? ""}${end ? " - " + end : ""}`.trim();
}

function downloadJson(obj, filename = "resume.json") {
    const blob = new Blob([JSON.stringify(obj, null, 2)], {
        type: "application/json",
    });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    a.remove();
    URL.revokeObjectURL(url);
}

function jumpDots() {
    const wrap = document.createElement("span");
    wrap.className = "inline-flex items-center gap-1 ml-2 cli-jumping-dots";
    wrap.setAttribute("aria-hidden", "true");
    wrap.textContent = "🤖";
    const delays = ["0s", "0.12s", "0.24s"];
    delays.forEach((d, i) => {
        const dot = document.createElement("span");
        dot.style.cssText = `width:6px;height:6px;border-radius:9999px;background:var(--brand);display:inline-block;`;
        if (i > 0) dot.style.marginLeft = "2px";
        wrap.appendChild(dot);
    });
    wrap.querySelectorAll("span").forEach((s, i) => {
        s.style.animation = "cli-bounce 1s infinite";
        s.style.animationDelay = delays[i];
    });
    return wrap;
}

export function initCli() {
    const root = $("#cli-root");
    if (!root) return;

    const overlay = $("#cli-overlay");
    const windowEl = $("#cli-window");
    const output = $("#cli-output");
    const input = $("#cli-input");
    const minimizedRow = $("#cli-minimized-row");
    const inputRow = $("#cli-input-row");
    const tryCli = $("#try-cli");

    state.resumeData = portfolioJson();

    const scrollToBottom = () => {
        if (!output) return;
        output.scrollTop = output.scrollHeight;
    };

    const appendOut = (text = "") => {
        const pre = document.createElement("pre");
        pre.className = "whitespace-pre-wrap leading-relaxed cli-out";
        pre.style.cssText = "color:var(--text);margin:0;";
        pre.textContent = text;
        output.appendChild(pre);
        scrollToBottom();
        return pre;
    };

    const appendCmd = (text) => {
        const div = document.createElement("div");
        div.className = "whitespace-pre-wrap cli-cmd";
        div.style.color = "var(--text)";
        const prompt = document.createElement("span");
        prompt.className = "cli-cmd-prompt";
        prompt.style.color = "var(--brand)";
        prompt.textContent = "$";
        const cmd = document.createElement("span");
        cmd.style.marginLeft = "6px";
        cmd.textContent = text;
        div.appendChild(prompt);
        div.appendChild(cmd);
        output.appendChild(div);
        scrollToBottom();
        return div;
    };

    const typeOut = (text, speed = 18) =>
        new Promise((resolve) => {
            const pre = appendOut("");
            let i = 0;
            const step = () => {
                i++;
                pre.textContent = text.slice(0, i);
                if (i < text.length) {
                    setTimeout(step, speed + Math.random() * 8);
                } else {
                    pre.textContent = text;
                    scrollToBottom();
                    resolve();
                }
            };
            step();
        });

    const setProcessing = (p) => {
        state.processing = p;
        if (input) input.disabled = p;
        const run = document.querySelector('[data-cli="run"]');
        if (run) run.disabled = p;
        if (!output) return;
        const existing = output.querySelector(".cli-jumping-dots");
        if (existing) existing.remove();
        if (p) {
            const row = document.createElement("div");
            row.className = "cli-jumping-row";
            row.appendChild(jumpDots());
            output.appendChild(row);
            scrollToBottom();
        }
    };

    const welcome = async () => {
        appendOut(`Welcome — type "help" to see commands.`);
        const d = state.resumeData?.personal;
        appendOut(
            d
                ? `Loaded resume for ${d.name} (${d.title})\n`
                : "No portfolio data loaded.\n",
        );
    };

    const runCommand = async (raw) => {
        const cmd = raw.trim();
        if (!cmd || state.processing) return;

        appendCmd(cmd);
        state.cmdHistory.push(cmd);
        state.cmdIndex = null;

        const [base, ...args] = cmd.split(/\s+/);
        const data = state.resumeData || {};
        const personal = data.personal || {};

        try {
            switch (base.toLowerCase()) {
                case "help":
                    await typeOut(
                        [
                            "help — List available commands",
                            "about — Short intro & summary",
                            "whoami — Name & title",
                            "skills — Show grouped skills",
                            "projects — List featured projects",
                            "experience — List work roles (ids shown)",
                            "role <id> — Show role detail",
                            "open <id|resume> — Open project/role/resume in new tab",
                            "resume --pdf — Open pre-rendered PDF resume (if provided)",
                            "resume --json — Download resume JSON",
                            "contact — Show contact links",
                            "clear — Clear terminal",
                        ].join("\n") + "\n",
                        6,
                    );
                    break;

                case "about": {
                    const s = data.summary ?? personal.summary ?? personal.headline ?? "";
                    await typeOut(`${personal.name} — ${personal.title}\n\n${s}\n`);
                    if (data?.highlights?.length) {
                        await typeOut(
                            `\nHighlights:\n- ${data.highlights.join("\n- ")}\n`,
                        );
                    }
                    break;
                }

                case "whoami":
                    await typeOut(`${personal.name} — ${personal.title}\n`);
                    break;

                case "skills":
                    if (!data.skills || data.skills.length === 0) {
                        await typeOut("No skills defined in resume.\n");
                        break;
                    }
                    for (const group of data.skills) {
                        await typeOut(
                            `${group.title ?? "Skills"}: ${group.skills
                                .map((s) => s.name)
                                .join(", ")}\n`,
                            8,
                        );
                    }
                    break;

                case "projects":
                    if (!data.projects || data.projects.length === 0) {
                        await typeOut("No projects listed.\n");
                        break;
                    }
                    for (const p of data.projects) {
                        await typeOut(
                            `${p.id ?? "(no-id)"}: ${p.title} — ${
                                p.short ?? p.description ?? ""
                            }\n`,
                            10,
                        );
                    }
                    await typeOut(`\nOpen a project: open <project-id>\n`);
                    break;

                case "experience":
                    if (!data.experience || data.experience.length === 0) {
                        await typeOut("No experience entries.\n");
                        break;
                    }
                    for (const r of data.experience) {
                        await typeOut(
                            `${r.id ?? "(no-id)"}: ${r.title} @ ${
                                r.company ?? ""
                            } — ${formatDateRange(r.date)}\n`,
                            6,
                        );
                    }
                    await typeOut(`\nView role details: role <id>\n`);
                    break;

                case "role": {
                    const id = args[0];
                    if (!id) {
                        await typeOut(`Usage: role <id>\n`);
                        break;
                    }
                    const found = (data.experience || []).find((x) => x.id === id);
                    if (!found) {
                        await typeOut(
                            `No role found with id "${id}". Use 'experience' to list ids.\n`,
                        );
                        break;
                    }
                    await typeOut(
                        `${found.title} @ ${found.company ?? ""} — ${formatDateRange(
                            found.date,
                        )}\n\n`,
                        6,
                    );
                    if (found.summary) await typeOut(`${found.summary}\n\n`);
                    if (found.bullets) {
                        for (const b of found.bullets) await typeOut(`- ${b}\n`, 6);
                    }
                    if (found?.tech?.length)
                        await typeOut(`Tech: ${found.tech.join(", ")}\n`, 6);
                    if (found.link) await typeOut(`Company: ${found.link}\n`, 6);
                    break;
                }

                case "open": {
                    const target = args[0];
                    if (!target) {
                        await typeOut(`Usage: open <project-id|role-id|resume>\n`);
                        break;
                    }
                    if (target === "resume") {
                        const pdf = data.meta?.pdf;
                        const url = absoluteUrl(pdf) || personal.contact?.website;
                        if (url) {
                            await typeOut(`Opening resume at ${url}\n`);
                            window.open(url, "_blank", "noopener");
                        } else {
                            await typeOut(
                                "No resume URL found in resume.meta or personal.contact.website.\n",
                            );
                        }
                        break;
                    }
                    const proj = (data.projects || []).find((p) => p.id === target);
                    if (proj) {
                        const u = proj.href || proj.links?.[0]?.url;
                        if (u) {
                            await typeOut(`Opening ${proj.title} -> ${u}\n`);
                            window.open(u, "_blank", "noopener");
                        } else {
                            await typeOut(`${proj.title} has no href/links.\n`);
                        }
                        break;
                    }
                    const role = (data.experience || []).find((r) => r.id === target);
                    if (role) {
                        if (role.link) {
                            await typeOut(`Opening ${role.company} -> ${role.link}\n`);
                            window.open(role.link, "_blank", "noopener");
                        } else {
                            await typeOut(`${role.title} has no company link.\n`);
                        }
                        break;
                    }
                    await typeOut(`No project or role found with id "${target}".\n`);
                    break;
                }

                case "resume": {
                    const flag = args[0];
                    if (flag === "--pdf") {
                        const pdf = data.meta?.pdf;
                        if (pdf) {
                            const url = absoluteUrl(pdf);
                            await typeOut(`Opening PDF resume: ${url}\n`);
                            window.open(url, "_blank", "noopener");
                        } else {
                            await typeOut("No PDF available (resume.meta.pdf not set).\n");
                        }
                    } else if (flag === "--json") {
                        await typeOut("Downloading resume JSON.\n");
                        downloadJson(
                            data,
                            `${(personal.name || "resume").replace(/\s+/g, "_")}_resume.json`,
                        );
                    } else {
                        const url =
                            data.meta?.url ??
                            (data.meta?.pdf ? absoluteUrl(data.meta.pdf) : null) ??
                            personal.contact?.website;
                        if (url) {
                            await typeOut(`Opening ${url}\n`);
                            window.open(url, "_blank", "noopener");
                        } else {
                            await typeOut("No resume URL or PDF found in resume.meta.\n");
                        }
                    }
                    break;
                }

                case "contact": {
                    const c = personal.contact;
                    if (!c) {
                        await typeOut("No contact info.\n");
                    } else {
                        if (c.email) await typeOut(`Email: ${c.email}\n`);
                        if (c.phone) await typeOut(`Phone: ${c.phone}\n`);
                        if (c.website) await typeOut(`Website: ${c.website}\n`);
                        if (c.location) await typeOut(`Location: ${c.location}\n`);
                        if (c?.socials?.length) {
                            for (const s of c.socials) {
                                await typeOut(`${s.label}: ${s.url}\n`, 6);
                            }
                        }
                    }
                    break;
                }

                case "clear":
                    output.innerHTML = "";
                    state.history = [];
                    await typeOut(`(terminal cleared)\n`);
                    break;

                default: {
                    setProcessing(true);
                    try {
                        const answer = await queryRagApi(cmd);
                        if (answer) {
                            await typeOut("🤖\t" + answer + "\n", 6);
                        } else {
                            await typeOut(`Unknown command: ${cmd}\n`);
                        }
                    } catch (err) {
                        await typeOut(`Error querying API: ${err.message}\n`);
                    } finally {
                        setProcessing(false);
                    }
                    break;
                }
            }
        } catch (err) {
            await typeOut(`Error: ${err.message}\n`);
        }
    };

    async function queryRagApi(q) {
        const api = window.__APP__?.ragApiUrl || "";
        if (!api) return null;
        const resp = await fetch(`${api.replace(/\/$/, "")}/api/query`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ q }),
        });
        const json = await resp.json();
        return json?.answer || null;
    }

    const handleKeyDown = (e) => {
        const el = input;
        if (e.key === "Enter") {
            e.preventDefault();
            const val = el.value;
            el.value = "";
            runCommand(val);
        } else if (e.key === "ArrowUp") {
            e.preventDefault();
            if (state.cmdHistory.length === 0) return;
            const idx =
                state.cmdIndex === null
                    ? state.cmdHistory.length - 1
                    : Math.max(0, state.cmdIndex - 1);
            state.cmdIndex = idx;
            el.value = state.cmdHistory[idx];
        } else if (e.key === "ArrowDown") {
            e.preventDefault();
            if (state.cmdHistory.length === 0 || state.cmdIndex === null) return;
            const idx = Math.min(state.cmdHistory.length - 1, state.cmdIndex + 1);
            state.cmdIndex = idx;
            el.value = state.cmdHistory[idx] || "";
            if (idx === state.cmdHistory.length - 1) {
                state.cmdIndex = null;
                el.value = "";
            }
        } else if (e.key === "Tab") {
            e.preventDefault();
            const options = [
                "help",
                "about",
                "skills",
                "projects",
                "experience",
                "role",
                "open",
                "resume",
                "contact",
                "clear",
            ];
            const match = options.find((o) => o.startsWith(el.value));
            if (match)
                el.value =
                    match + (match === "open" || match === "role" ? " " : "");
        }
    };

    const applyWindowState = () => {
        if (windowEl) {
            windowEl.classList.toggle("fullscreen", state.fullscreen);
            windowEl.classList.toggle("minimized", state.minimized);
        }
        if (overlay) overlay.classList.toggle("dimmed", state.fullscreen);
        if (output) output.classList.toggle("hidden", state.minimized);
        if (inputRow) inputRow.classList.toggle("hidden", state.minimized);
        if (minimizedRow) minimizedRow.classList.toggle("hidden", !state.minimized);
    };

    const open = () => {
        state.visible = true;
        root.style.display = "block";
        if (!state.initialized) {
            state.initialized = true;
            welcome();
        }
        applyWindowState();
        if (input && !state.minimized) {
            input.focus();
            input.setSelectionRange(input.value.length, input.value.length);
        }
    };

    const close = () => {
        state.visible = false;
        state.minimized = false;
        state.fullscreen = false;
        root.style.display = "none";
        applyWindowState();
    };

    const toggleMinimize = () => {
        state.minimized = !state.minimized;
        applyWindowState();
        if (!state.minimized && input) input.focus();
    };

    const toggleFullscreen = () => {
        state.fullscreen = !state.fullscreen;
        applyWindowState();
    };

    document.addEventListener("keydown", (e) => {
        if (!state.visible) return;
        if (e.key === "Escape") close();
        if ((e.key === "m" || e.key === "M") && (e.ctrlKey || e.metaKey)) {
            e.preventDefault();
            toggleMinimize();
        }
    });

    const runBtn = document.querySelector('[data-cli="run"]');
    if (runBtn) {
        runBtn.addEventListener("click", () => {
            if (state.processing) return;
            runCommand(input.value);
            input.value = "";
            input.focus();
        });
    }

    if (input) {
        input.addEventListener("keydown", handleKeyDown);
    }

    const clearBtn = document.querySelector('[data-cli="clear"]');
    if (clearBtn) {
        clearBtn.addEventListener("click", () => {
            output.innerHTML = "";
            state.history = [];
            input.value = "";
            appendOut("(terminal cleared)\n");
        });
    }

    const closeBtn = document.querySelector('[data-cli="close"]');
    if (closeBtn) closeBtn.addEventListener("click", close);

    const minimizeBtn = document.querySelector('[data-cli="minimize"]');
    if (minimizeBtn) minimizeBtn.addEventListener("click", toggleMinimize);

    const fullscreenBtn = document.querySelector('[data-cli="fullscreen"]');
    if (fullscreenBtn) fullscreenBtn.addEventListener("click", toggleFullscreen);

    if (tryCli) tryCli.addEventListener("click", open);
}

onReady(initCli);
