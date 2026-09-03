<div
    id="project-modal"
    class="fixed inset-0 z-50 items-center justify-center p-6 flex"
    style="display: none"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title"
>
    <div class="modal-backdrop absolute inset-0 bg-[color:var(--bg)/0.6] backdrop-blur-sm"></div>

    <div
        class="modal-dialog relative z-10 w-full max-w-4xl max-h-[90vh] p-6 rounded-2xl bg-[var(--surface)] border border-[var(--border)] shadow-lg flex flex-col"
    >
        <button
            type="button"
            id="modal-close"
            class="absolute top-4 right-4 cursor-pointer text-[var(--muted)] hover:text-[var(--text)] z-10"
        >
            ✕
        </button>

        <h3 id="modal-title" class="display-font font-black text-xl md:text-2xl text-[var(--brand)] mb-2 pr-8 break-words"></h3>

        <div id="modal-tabs" class="hidden border-b border-[var(--border)] mb-2">
            <button
                type="button"
                data-modal-tab="details"
                class="px-4 py-2 text-sm font-medium cursor-pointer text-[var(--brand)] border-b-2 border-[var(--brand)]"
            >
                Details
            </button>
            <button
                type="button"
                data-modal-tab="playground"
                class="px-4 py-2 text-sm font-medium cursor-pointer text-[var(--muted)] hover:text-[var(--text)]"
            >
                Playground
            </button>
        </div>

        <div class="flex-1 overflow-y-auto pr-1 max-h-[500px] custom-scroll relative">
            <div id="modal-progress" class="sticky top-0 left-0 right-0 h-1 bg-[var(--border)]/50 z-10 origin-left" style="transform: scaleX(0)"></div>

            <div id="modal-details" class="modal-panel block" data-modal-panel="details">
                <img id="modal-image" class="hidden rounded-lg border border-[var(--border)] mb-4 w-full h-auto object-cover max-h-60" alt="" />
                <p id="modal-description" class="text-base md:text-lg text-[var(--text)] mb-4 leading-relaxed break-words"></p>

                <div id="modal-links" class="flex gap-3 flex-wrap mb-4"></div>

                <div id="modal-tags" class="mt-3 flex gap-2 flex-wrap"></div>

                <div id="modal-readme" class="hidden h-full overflow-auto rounded-md border border-[var(--border)] bg-[var(--surface)] mt-6">
                    <div id="modal-readme-body" class="p-4 markdown-body"></div>
                </div>
            </div>

            <div id="modal-playground" class="hidden modal-panel relative" data-modal-panel="playground">
                <div
                    id="modal-spinner"
                    class="absolute inset-0 flex items-center justify-center bg-[var(--surface)]/60 rounded-lg"
                >
                    <div class="modal-spinner-ring"></div>
                </div>

                <div class="text-right">
                    <a
                        id="modal-fullscreen-link"
                        href="#"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-sm text-[var(--brand)] hover:underline"
                    >
                        Open Fullscreen ↗
                    </a>
                </div>

                <iframe
                    id="modal-iframe"
                    title="Project playground"
                    class="w-full h-100 rounded-lg border border-[var(--border)] bg-[var(--bg)]"
                    loading="lazy"
                ></iframe>
            </div>
        </div>
    </div>
</div>
