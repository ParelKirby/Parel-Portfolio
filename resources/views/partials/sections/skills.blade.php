<section id="skills" class="py-8" data-skills>
    <h2 class="display-font gradient-text-title text-3xl md:text-5xl font-black">Skills</h2>
    <p class="mb-6 text-lg text-gray-500 dark:text-gray-400 mt-2">
        Tools and technologies I use regularly.
    </p>

    <div class="space-y-6">
        <div class="flex flex-wrap gap-3" data-skills-filters>
            <button
                type="button"
                data-skill-filter="all"
                aria-pressed="true"
                class="px-4 py-2 rounded-full text-base border transition select-none bg-[var(--brand)] text-white border-[var(--brand)]"
            >
                All ({{ collect($portfolio['skills'])->flatMap(fn ($g) => $g['skills'])->count() }})
            </button>

            @foreach ($portfolio['skills'] as $group)
                <button
                    type="button"
                    data-skill-filter="{{ $group['title'] }}"
                    aria-pressed="false"
                    class="px-4 py-2 rounded-full text-base border transition select-none bg-[var(--surface)] text-[var(--text)] border-[var(--border)] hover:bg-[var(--border)]/30"
                >
                    {{ $group['title'] }} ({{ count($group['skills']) }})
                </button>
            @endforeach
        </div>

        <div class="overflow-hidden transition-[max-height] duration-500" data-skills-collapse>
            <div class="space-y-6" data-skills-content>
                @foreach ($portfolio['skills'] as $group)
                    <section aria-labelledby="skills-{{ Str::slug($group['title']) }}" data-skill-group="{{ $group['title'] }}">
                        <h3 id="skills-{{ Str::slug($group['title']) }}" class="text-lg font-semibold text-[var(--brand)] mb-4">
                            {{ $group['title'] }}
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-6 gap-4">
                            @foreach ($group['skills'] as $skill)
                                @php
                                    $slug = config('portfolio.icon_slugs')[$skill['icon'] ?? ''] ?? null;
                                    $isBar = $skill['level'] !== null && $skill['level'] !== '';
                                @endphp
                                <div class="p-5 rounded-xl bg-[var(--surface)] border border-[var(--border)] transition duration-300 cursor-default text-[var(--muted)] hover:text-[var(--text)] hover:-translate-y-1.5 min-w-0">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <div class="font-semibold text-base md:text-lg break-words">{{ $skill['name'] }}</div>
                                            <div class="text-sm text-slate-400 mt-1 break-words">
                                                @if (!empty($skill['years']))
                                                    {{ $skill['years'] }} yr{{ $skill['years'] > 1 ? 's' : '' }}
                                                @endif
                                                @if (!empty($skill['note']))
                                                    <span class="ml-2">• {{ $skill['note'] }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($slug)
                                            <img
                                                src="https://cdn.simpleicons.org/{{ $slug }}/6b7280"
                                                alt=""
                                                class="w-6 h-6 shrink-0"
                                                loading="lazy"
                                                onerror="this.style.display='none'"
                                            />
                                        @endif
                                    </div>

                                    @if ($isBar)
                                        <div class="mt-3 bg-[var(--border)]/40 h-2 rounded-full overflow-hidden">
                                            <div
                                                class="h-2 rounded-full w-full origin-left"
                                                data-skill-bar
                                                data-level="{{ $skill['level'] }}"
                                                style="transform: scaleX(0); background: linear-gradient(90deg, var(--brand), var(--accent))"
                                            ></div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>
        </div>

        <div class="flex justify-center hidden" data-skills-toggle-wrap>
            <button
                type="button"
                class="flex items-center gap-2 px-4 py-2 rounded-full cursor-pointer border border-[var(--border)] bg-[var(--surface)] hover:bg-[var(--border)]/30 text-[var(--text)] transition"
                aria-expanded="false"
                data-skills-toggle
            >
                <x-icon name="chevron-down" class="w-4 h-4" data-skills-toggle-icon />
                <span class="text-base" data-skills-toggle-label>Show more</span>
            </button>
        </div>
    </div>
</section>
