@php
    $links = $links ?? collect([
        'hero' => 'Home',
        'about' => 'About',
        'skills' => 'Skills',
        'projects' => 'Projects',
        'education' => 'Education',
        'contact' => 'Contact',
    ]);
    if (is_array($links)) {
        $links = collect($links);
    }
@endphp

<header
    id="site-header"
    class="fixed top-0 left-0 z-50 w-full"
>
    <div aria-hidden="true" class="absolute inset-0 pointer-events-none bg-[var(--surface)] header-bg-layer"></div>
    <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-px pointer-events-none bg-[var(--border)] header-border-layer"></div>
    <div aria-hidden="true" class="absolute inset-0 pointer-events-none header-dark-layer"></div>

    <div class="relative max-w-6xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
        <a
            href="#hero"
            data-nav-link="#hero"
            class="navbar-brand display-font shrink-0"
            aria-label="KIRBY PAREL home"
        >
            <span class="brand-gradient pb-px">KIRBY PAREL</span>
        </a>

        <div class="flex items-center gap-2">
            <nav aria-label="Primary" class="relative flex items-center gap-2">
                <div id="nav-menu" class="relative">
                    @foreach ($links as $href => $label)
                        <a
                            href="#{{ ltrim($href, '#') }}"
                            data-nav-link="#{{ ltrim($href, '#') }}"
                            class="relative px-1 py-0.5 text-sm text-[var(--text)] nav-link-item"
                        >
                            {{ $label }}
                            <span data-nav-underline="{{ ltrim($href, '#') }}" class="absolute left-0 right-0 -bottom-1 h-[2px] rounded-full bg-[var(--brand)] nav-underline"></span>
                        </a>
                    @endforeach
                </div>
            </nav>

            <button
                id="theme-toggle"
                type="button"
                aria-label="Toggle color theme"
                class="p-2 rounded-full border border-[var(--border)] bg-[var(--surface)] hover:bg-[var(--border)]/30 transition cursor-pointer"
            >
                <span id="theme-icon-dark" class="hidden">
                    <x-icon name="sun" class="w-[22px] h-[22px]" />
                </span>
                <span id="theme-icon-light" class="hidden">
                    <x-icon name="moon" class="w-[22px] h-[22px]" />
                </span>
            </button>

            <button
                id="nav-toggle"
                type="button"
                aria-label="Open menu"
                aria-expanded="false"
                aria-controls="nav-menu"
                class="md:hidden p-2 rounded-lg border border-[var(--border)] bg-[var(--surface)] hover:bg-[var(--border)]/30 transition cursor-pointer nav-toggle"
            >
                <span class="nav-toggle-icon block w-5" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</header>
