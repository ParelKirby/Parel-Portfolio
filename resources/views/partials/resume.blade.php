@php
    $personal = $portfolio['personal'];
    $contact = $personal['contact'] ?? [];

    $formatDate = function ($date) {
        if (is_string($date)) return $date;
        $start = $date['start'] ?? '';
        if (!empty($date['present'])) return trim($start.' — Present');
        if (!empty($date['end'])) return trim($start.' — '.$date['end']);
        return $start;
    };
@endphp

<article id="resume-print-area" class="max-w-none" aria-label="Printable resume">
    <header class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">{{ $personal['name'] }}</h1>
            @if (!empty($personal['title']))
                <p class="text-sm text-[var(--muted)] mt-1">{{ $personal['title'] }}</p>
            @endif
            @if (!empty($personal['headline']))
                <div class="text-sm text-[var(--muted)] mt-1">{{ $personal['headline'] }}</div>
            @endif
        </div>

        <div class="text-sm text-right space-y-1">
            @if (!empty($contact['email']))
                <div class="flex items-center justify-end gap-2">
                    <x-icon name="mail" class="w-4 h-4" />
                    <a href="mailto:{{ $contact['email'] }}" class="underline">{{ $contact['email'] }}</a>
                </div>
            @endif
            @if (!empty($contact['phone']))
                <div class="flex items-center justify-end gap-2">
                    <x-icon name="phone" class="w-4 h-4" />
                    <span>{{ $contact['phone'] }}</span>
                </div>
            @endif
            @if (!empty($contact['website']))
                <div class="flex items-center justify-end gap-2">
                    <x-icon name="globe" class="w-4 h-4" />
                    <a href="{{ $contact['website'] }}" target="_blank" rel="noopener noreferrer" class="underline">
                        {{ parse_url($contact['website'], PHP_URL_HOST) ?: $contact['website'] }}
                    </a>
                </div>
            @endif
            @if (!empty($contact['location']))
                <div class="flex items-center justify-end gap-2">
                    <x-icon name="map-pin" class="w-4 h-4" />
                    <span>{{ $contact['location'] }}</span>
                </div>
            @endif
            @if (count($portfolio['socials'] ?? []) > 0)
                <div class="flex items-center justify-end gap-3 flex-wrap">
                    @foreach (($portfolio['socials'] ?? []) as $s)
                        <a href="{{ $s['url'] }}" target="_blank" rel="noreferrer" class="underline">{{ $s['label'] }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </header>

    @if (!empty($personal['summary']))
        <section>
            <h2 class="text-base font-semibold mt-4">Summary</h2>
            <p class="text-sm text-[var(--text)]">{{ $personal['summary'] }}</p>
        </section>
    @endif

    @if (count($portfolio['highlights'] ?? []) > 0)
        <section>
            <h2 class="text-base font-semibold mt-4">Highlights</h2>
            <ul class="list-disc list-inside text-sm">
                @foreach (($portfolio['highlights'] ?? []) as $h)
                    <li>{{ $h }}</li>
                @endforeach
            </ul>
        </section>
    @endif

    @if (count($portfolio['skills'] ?? []) > 0)
        <section>
            <h2 class="text-base font-semibold mt-4">Skills</h2>
            <div class="space-y-3">
                @foreach (($portfolio['skills'] ?? []) as $group)
                    <div>
                        @if (!empty($group['title']))
                            <div class="text-sm font-medium mb-1">{{ $group['title'] }}</div>
                        @endif
                        <ul class="flex flex-wrap gap-2 text-sm">
                            @foreach (($group['skills'] ?? []) as $skill)
                                <li class="px-2 py-1 rounded-md bg-[var(--surface)] border border-[var(--border)] text-[var(--text)]">
                                    {{ $skill['name'] }}
                                    @if (!empty($skill['years']))
                                        <span class="ml-2 text-xs text-[var(--muted)]">· {{ $skill['years'] }}y</span>
                                    @endif
                                    @if (!empty($skill['level']))
                                        <span class="ml-1 text-xs text-[var(--muted)]">· {{ $skill['level'] }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if (count($portfolio['experience'] ?? []) > 0)
        <section>
            <h2 class="text-base font-semibold mt-4">Experience</h2>
            <div class="space-y-6">
                @foreach (($portfolio['experience'] ?? []) as $exp)
                    <div class="text-sm">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                            <div>
                                <div class="font-medium">
                                    {{ $exp['title'] }}
                                    @if (!empty($exp['company']))
                                        <span class="text-[var(--muted)]"> — {{ $exp['company'] }}</span>
                                    @endif
                                </div>
                                @if (!empty($exp['location']))
                                    <div class="text-xs text-[var(--muted)]">{{ $exp['location'] }}</div>
                                @endif
                            </div>
                            <div class="text-[var(--muted)] mt-2 sm:mt-0">{{ $formatDate($exp['date'] ?? null) }}</div>
                        </div>

                        @if (!empty($exp['summary']))
                            <p class="mt-2 text-[var(--text)]">{{ $exp['summary'] }}</p>
                        @endif

                        @if (count($exp['bullets'] ?? []) > 0)
                            <ul class="list-disc list-inside mt-2">
                                @foreach (($exp['bullets'] ?? []) as $bullet)
                                    <li class="text-[var(--text)]">{{ $bullet }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (count($exp['tech'] ?? []) > 0)
                            <div class="mt-2 text-xs text-[var(--muted)]">Tech: {{ implode(', ', $exp['tech']) }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if (count($portfolio['projects'] ?? []) > 0)
        <section>
            <h2 class="text-base font-semibold mt-4">Projects</h2>
            <div class="space-y-4">
                @foreach (($portfolio['projects'] ?? []) as $p)
                    <div class="text-sm">
                        <div class="flex justify-between">
                            <div class="font-medium">
                                {{ $p['title'] }}
                                @if (!empty($p['short']))
                                    <span class="text-[var(--muted)]"> — {{ $p['short'] }}</span>
                                @endif
                            </div>
                        </div>
                        @if (!empty($p['description']))
                            <div class="mt-1 text-[var(--text)]">{{ $p['description'] }}</div>
                        @endif
                        @if (count($p['tags'] ?? []) > 0)
                            <div class="mt-2 flex gap-2 flex-wrap">
                                @foreach (($p['tags'] ?? []) as $t)
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-[var(--surface)] border border-[var(--border)]">
                                        {{ $t }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if (count($portfolio['education'] ?? []) > 0)
        <section>
            <h2 class="text-base font-semibold mt-4">Education</h2>
            <div class="space-y-2 text-sm">
                @foreach (($portfolio['education'] ?? []) as $ed)
                    <div class="flex justify-between">
                        <div>
                            @if (!empty($ed['degree']))<strong>{{ $ed['degree'] }}</strong>@endif
                            @if (!empty($ed['school']))<span class="ml-2">{{ $ed['school'] }}</span>@endif
                        </div>
                        <div class="text-[var(--muted)]">
                            {{ $formatDate($ed['date'] ?? null) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if (count($portfolio['certifications'] ?? []) > 0)
        <section>
            <h2 class="text-base font-semibold mt-4">Certifications</h2>
            <ul class="text-sm list-disc list-inside">
                @foreach (($portfolio['certifications'] ?? []) as $cert)
                    <li>
                        <span class="font-medium">{{ $cert['name'] }}</span>
                        @if (!empty($cert['issuer']) || !empty($cert['url']))
                            <span class="text-[var(--muted)]">
                                @if (!empty($cert['issuer']))
                                    — @if (!empty($cert['url']))<a href="{{ $cert['url'] }}" target="_blank" rel="noopener noreferrer" class="underline text-sm">{{ $cert['issuer'] }}</a>@else{{ $cert['issuer'] }}@endif
                                @elseif (!empty($cert['url']))
                                    <a href="{{ $cert['url'] }}" target="_blank" rel="noopener noreferrer" class="underline text-sm">Link</a>
                                @endif
                            </span>
                        @endif
                        @if (!empty($cert['date']))
                            <span class="text-xs text-[var(--muted)] ml-3">{{ $formatDate($cert['date']) }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    <footer class="mt-6 text-xs text-[var(--muted)]">
        <div class="flex items-center justify-between">
            <div>© {{ date('Y') }} {{ $personal['name'] }}</div>
        </div>
    </footer>
</article>

<button
    type="button"
    id="print-resume"
    aria-label="Print resume"
    class="fixed bottom-6 right-6 z-50 p-3 rounded-full bg-[var(--surface)] border border-[var(--border)] shadow-lg hover:scale-110 transition cursor-pointer"
>
    <x-icon name="printer" class="w-5 h-5 text-[var(--text)]" />
</button>
