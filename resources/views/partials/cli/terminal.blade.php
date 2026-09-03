<div id="cli-root" class="hidden" aria-hidden="false">
    <div id="cli-overlay" class="fixed inset-0 transition-opacity pointer-events-none z-60" aria-hidden="true"></div>

    <div
        id="cli-panel"
        class="fixed z-60 bottom-4 left-1/2 -translate-x-1/2 px-4 w-full"
        role="dialog"
        aria-modal="true"
        aria-label="Terminal resume"
    >
        <div
            id="cli-window"
            class="w-full max-w-4xl transition-all duration-200 h-[420px] rounded-xl border shadow-2xl overflow-hidden"
            style="background: var(--surface); border-color: var(--border); backdrop-filter: blur(6px)"
        >
            <div class="h-full grid" style="grid-template-rows: auto 1fr auto">
                <div class="flex items-center gap-3 px-3 py-2 border-b border-slate-700">
                    <div class="flex items-center gap-2">
                        <button type="button" data-cli="close" title="Close" class="w-3 h-3 rounded-full shadow-sm hover:scale-110 transition-transform" aria-label="Close terminal">
                            <span class="block w-3 h-3 bg-red-500 rounded-full"></span>
                        </button>
                        <button type="button" data-cli="minimize" title="Minimize" class="w-3 h-3 rounded-full shadow-sm hover:scale-110 transition-transform" aria-label="Minimize terminal">
                            <span class="block w-3 h-3 bg-amber-500 rounded-full"></span>
                        </button>
                        <button type="button" data-cli="fullscreen" title="Toggle fullscreen" class="w-3 h-3 rounded-full shadow-sm hover:scale-110 transition-transform" aria-label="Toggle fullscreen">
                            <span class="block w-3 h-3 bg-green-500 rounded-full"></span>
                        </button>
                    </div>

                    <div class="ml-3 flex items-center gap-2">
                        <div class="text-xs font-medium text-[var(--text)] bg-[var(--bg)] px-2 py-0.5 rounded-sm">Terminal</div>
                        <div class="text-xs text-[var(--muted)] ml-2">bash — {{ $portfolio['personal']['name'] ? strtolower(preg_replace('/\s+/', '', $portfolio['personal']['name'])) : 'user' }}@portfolio</div>
                    </div>

                    <div class="ml-auto flex items-center gap-3 text-[var(--muted)] text-xs">
                        <div class="hidden sm:block">
                            Press <span class="font-mono text-[var(--text)] bg-[var(--bg)] px-1 rounded">Tab</span> to autocomplete
                        </div>
                        <button type="button" data-cli="clear" class="text-xs px-2 py-1 rounded hover:bg-[var(--bg)] cursor-pointer">Clear</button>
                    </div>
                </div>

                <div
                    id="cli-output"
                    class="min-h-0 overflow-y-auto font-mono text-sm p-4"
                    aria-live="polite"
                    style="overflow-anchor: none; color: var(--text)"
                ></div>

                <div id="cli-minimized-row" class="hidden flex items-center px-4 text-sm" style="color: var(--muted)">
                    <div class="font-mono mr-2" style="color: var(--brand)">$</div>
                    <div class="truncate">terminal — minimized. Click the yellow dot to restore or the red dot to close.</div>
                </div>

                <div
                    id="cli-input-row"
                    class="px-4 py-3 flex items-center gap-3"
                    style="border-top: 1px solid; border-top-color: var(--border)"
                >
                    <span class="font-mono" style="color: var(--brand)">$</span>
                    <input
                        id="cli-input"
                        type="text"
                        placeholder='type "help" and press Enter'
                        class="flex-1 bg-transparent outline-none text-sm font-mono"
                        autocomplete="off"
                        spellcheck="false"
                        aria-label="CLI command input"
                        style="color: var(--text); caret-color: var(--brand)"
                    />
                    <button
                        type="button"
                        data-cli="run"
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded text-sm"
                        aria-label="Run command"
                        style="background: var(--brand); color: white; box-shadow: 0 1px 0 rgba(0,0,0,0.05)"
                    >
                        Run
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
