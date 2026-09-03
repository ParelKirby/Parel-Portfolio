@php
    $colors = config('portfolio.tag_colors');
    $visibleCount = 3;
    $tags = $project['tags'] ?? [];
    $visibleTags = array_slice($tags, 0, $visibleCount);
    $hiddenTags = array_slice($tags, $visibleCount);
@endphp

<div class="h-full group" data-project-card data-project-id="{{ $project['id'] }}" tabindex="0" role="button" aria-label="Open project: {{ $project['title'] }}">
    <article class="relative p-5 rounded-2xl bg-[var(--surface)] border border-[var(--border)] shadow-sm hover:shadow-md transition-shadow h-full hover:-translate-y-1.5 transition-transform duration-300 cursor-pointer min-w-0 break-words">
        <button
            type="button"
            title="Open project"
            class="absolute top-2 right-2 z-10 bg-[var(--surface)]/80 backdrop-blur-sm rounded-full shadow-md cursor-pointer hover:scale-110 transition duration-300 opacity-0 group-hover:opacity-100"
            data-project-open
        >
            <span class="leading-none text-[var(--brand)] block p-1">
                <x-icon name="arrow-up-right-circle" class="w-8 h-8" />
            </span>
        </button>

        @if (!empty($project['image']))
            <div class="w-full flex justify-center mb-4">
                <img
                    src="{{ asset($project['image']) }}"
                    alt="{{ $project['title'] }}"
                    class="rounded-lg border border-[var(--border)] w-full object-cover h-45"
                    loading="lazy"
                />
            </div>
        @endif

        <button
            type="button"
            title="Open project"
            class="display-font font-black text-xl md:text-2xl text-[var(--brand)] cursor-pointer text-left break-words"
            data-project-open
        >
            {{ $project['title'] }}
        </button>

        @if (!empty($project['isUnderDevelopment']))
            <span class="text-sm text-[var(--muted)] pl-2">Under Development</span>
        @endif

        <p class="text-base md:text-lg text-[var(--muted)] mt-2 line-clamp-2 leading-relaxed">
            {{ $project['description'] }}
        </p>

        @php $hasLinks = !empty($project['href']) || count($project['links'] ?? []) > 0; @endphp
        @if ($hasLinks)
            <div class="mt-4 flex gap-3 flex-wrap text-[var(--muted)]">
                @if (!empty($project['href']))
                    <a
                        href="{{ $project['href'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="hover:text-[var(--text)] inline-flex items-center gap-1 text-base font-medium text-[var(--link)] hover:underline"
                        data-stop-prop
                    >
                        <x-icon name="link" class="w-4 h-4" /> Demo
                    </a>
                @endif

                @foreach (($project['links'] ?? []) as $link)
                    <a
                        href="{{ $link['url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="hover:text-[var(--text)] inline-flex items-center gap-1 text-base font-medium text-[var(--link)] hover:underline"
                        data-stop-prop
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="mt-3 flex gap-2 flex-wrap" data-tag-wrap>
            @foreach ($visibleTags as $tag)
                <span class="text-sm font-semibold px-2.5 py-1 rounded-full {{ $colors[$tag] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $tag }}
                </span>
            @endforeach

            @if (count($hiddenTags) > 0)
                <span class="text-sm font-semibold px-2.5 py-1 rounded-full bg-gray-200 text-gray-800 hidden" data-tag-item data-project="{{ $project['id'] }}" data-tag-name="{{ $tags[3] }}" data-tags-hidden>
                    @foreach ($hiddenTags as $tag)
                        <span class="inline-block mr-1 last:mr-0">{{ $tag }}</span>
                    @endforeach
                </span>
                <button
                    type="button"
                    class="text-sm font-semibold px-2.5 py-1 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 cursor-pointer"
                    data-tags-toggle="{{ $project['id'] }}"
                >
                    +{{ count($hiddenTags) }}
                </button>
            @endif
        </div>
    </article>
</div>
