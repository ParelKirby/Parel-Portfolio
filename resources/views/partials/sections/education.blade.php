<section id="education" class="py-8">
    <h2 class="display-font gradient-text-title text-3xl md:text-5xl font-black">
        Educational Background
    </h2>
    <p class="mb-6 mt-2 text-lg text-gray-500 dark:text-gray-400">
        My academic journey.
    </p>

    @if (count($portfolio['education']) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($portfolio['education'] as $ed)
                @php
                    $d = $ed['date'] ?? [];
                    $dateText = '';
                    if (($d['present'] ?? false) === true) {
                        $dateText = trim(($d['start'] ?? '').' — Present');
                    } else {
                        $dateText = trim(implode(' — ', array_filter([$d['start'] ?? '', $d['end'] ?? ''])));
                    }
                @endphp
                <div class="p-6 rounded-2xl bg-[var(--surface)] border border-[var(--border)] flex gap-4 items-start reveal min-w-0 break-words" data-reveal data-reveal-delay="{{ $loop->index * 80 }}">
                    <div class="shrink-0 w-14 h-14 rounded-xl bg-[var(--brand)]/10 flex items-center justify-center text-[var(--brand)]">
                        <x-icon name="school" class="w-[30px] h-[30px]" />
                    </div>
                    <div class="min-w-0">
                        @if (!empty($ed['degree']))
                            <div class="text-sm font-semibold uppercase tracking-wide text-[var(--brand)]">
                                {{ $ed['degree'] }}
                            </div>
                        @endif
                        <div class="mt-1 text-xl md:text-2xl font-bold text-[var(--text)] break-words">
                            {{ $ed['school'] }}
                        </div>
                        <div class="mt-1 text-base md:text-lg text-gray-500 dark:text-gray-400">
                            {{ $dateText }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
