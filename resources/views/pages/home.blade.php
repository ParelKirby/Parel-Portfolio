@extends('layouts.app')

@section('title', 'Parel Kirby — Portfolio')

@section('before-content')
    @include('partials.hello-overlay')
@endsection

@section('content')

@php
    $personal = $portfolio['personal'];
    $features = $portfolio['highlights'] ?? [];
    $contact = $personal['contact'] ?? [];
@endphp

<!-- ══════════════ HERO ══════════════ -->
<section
    id="hero"
    class="hero-panel hero-enter relative min-h-screen w-full overflow-hidden flex items-center"
>
    <div class="relative z-10 w-full px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-6xl 2xl:max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 items-center">
                <div class="md:col-span-7">
                    <div class="relative z-10">
                        @php
                            $nameWords = preg_split('/\s+/', trim($personal['name']));
                        @endphp
                        <h1 class="hero-name font-black leading-tight" aria-label="{{ $personal['name'] }}">
                            @foreach ($nameWords as $wordIndex => $word)
                                <span class="hero-word">
                                    @foreach (str_split($word) as $charIndex => $char)
                                        <span class="hero-letter" style="--i: {{ $wordIndex * 8 + $charIndex }};">{{ $char }}</span>
                                    @endforeach
                                </span>
                            @endforeach
                        </h1>

                        @if (!empty($personal['title']))
                            <div class="mt-3 text-base text-[var(--muted)]">
                                {{ $personal['title'] }}
                            </div>
                        @endif

                        <p class="mt-6 text-xl text-[var(--muted)] max-w-2xl">
                            {{ $personal['hero']['summary'] ?? $personal['summary'] ?? '' }}
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a
                                href="#about"
                                data-smooth-link
                                class="inline-flex items-center gap-2 rounded-md bg-[var(--brand)] text-white px-6 py-3.5 text-base font-semibold shadow-lg hover:opacity-95"
                            >
                                Learn more
                            </a>
                            <a
                                href="#projects"
                                data-smooth-link
                                class="inline-flex items-center gap-2 rounded-md bg-[var(--text)] text-[var(--bg)] px-6 py-3.5 text-base font-semibold shadow-lg hover:opacity-95"
                            >
                                See my work
                            </a>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-5 flex items-center justify-center" data-carousel>
                    <div class="relative w-full h-100 flex items-center justify-center" style="perspective: 1000px">
                        <div class="relative h-full flex items-center justify-center" style="transform-style: preserve-3d">
                            @php
                                $avatar = $personal['avatar'] ?? null;
                                $avatarItems = is_array($avatar) && isset($avatar['url']) ? [$avatar] : (is_array($avatar) ? $avatar : []);
                                if (empty($avatarItems)) {
                                    $avatarItems = [['url' => 'images/parel.jpg', 'label' => $personal['name']]];
                                }
                                $slides = [];
                                foreach ($avatarItems as $idx => $item) {
                                    $url = is_array($item) ? ($item['url'] ?? '') : (string) $item;
                                    $label = is_array($item) ? ($item['label'] ?? '') : '';
                                    $slides[] = ['url' => $url, 'label' => $label ?: ($personal['name'] ?? 'Profile')];
                                }
                            @endphp

                            @foreach ($slides as $index => $slide)
                                <div
                                    class="absolute cursor-pointer carousel-slide"
                                    data-slide-index="{{ $index }}"
                                    style="transform-style: preserve-3d"
                                >
                                    <div class="w-72 h-96 rounded-xl overflow-hidden shadow-2xl bg-[var(--surface)] ring-2 ring-[var(--border)]/20">
                                        @if ($slide['url'] && !str_contains($slide['url'], 'placeholder'))
                                            <img
                                                src="{{ asset($slide['url']) }}"
                                                alt="{{ $slide['label'] }}"
                                                class="w-full h-full object-cover"
                                                loading="eager"
                                            />
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-sky-500 to-indigo-600 text-white">
                                                <div class="text-6xl font-bold mb-4">
                                                    {{ mb_substr($personal['name'] ?? 'S', 0, 1) }}
                                                </div>
                                                <div class="text-sm font-medium opacity-80">
                                                    {{ $slide['label'] }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if (count($slides) > 1)
                            <button
                                type="button"
                                class="carousel-prev absolute left-4 z-20 w-10 h-10 rounded-full bg-[var(--surface)]/80 backdrop-blur shadow-lg flex items-center justify-center hover:bg-[var(--surface)] transition-colors disabled:opacity-30"
                                aria-label="Previous slide"
                            >
                                <x-icon name="arrow-left" class="w-5 h-5" />
                            </button>

                            <button
                                type="button"
                                class="carousel-next absolute right-4 z-20 w-10 h-10 rounded-full bg-[var(--surface)]/80 backdrop-blur shadow-lg flex items-center justify-center hover:bg-[var(--surface)] transition-colors disabled:opacity-30"
                                aria-label="Next slide"
                            >
                                <x-icon name="arrow-right" class="w-5 h-5" />
                            </button>
                        @endif
                    </div>

                    @if (count($slides) > 1)
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 flex justify-center gap-2 carousel-dots">
                            @foreach ($slides as $index => $slide)
                                <button
                                    type="button"
                                    class="h-2 rounded-full transition-all carousel-dot {{ $index === 0 ? 'bg-[var(--text)] w-8' : 'bg-[var(--text)]/30 hover:bg-[var(--text)]/50 w-2' }}"
                                    data-dot-index="{{ $index }}"
                                    aria-label="Go to slide {{ $index + 1 }}"
                                ></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<main class="max-w-7xl 2xl:max-w-[96rem] mx-auto px-6 py-15 sm:py-20 lg:py-32 relative z-20">

    <!-- ══════════════ ABOUT ══════════════ -->
    <section id="about" class="py-8">
        <h2 class="display-font gradient-text-title text-3xl md:text-5xl font-black">About Me</h2>
        <p class="mt-2 text-lg text-gray-500 dark:text-gray-400 max-w-2xl">
            A quick look at who I am and what I care about.
        </p>

        <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-7">
                @if (!empty($personal['summary']))
                    <p class="text-lg md:text-xl text-[var(--text)] leading-relaxed break-words">{{ $personal['summary'] }}</p>
                @endif

                @if (count($features) > 0)
                    <ul class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($features as $feature)
                            <li class="flex items-start gap-3">
                                <svg class="mt-1 w-6 h-6 text-[var(--brand)]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M5 12l4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="text-base">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="lg:col-span-5">
                <div class="p-6 rounded-2xl bg-[var(--surface)] border border-[var(--border)] flex flex-col gap-3">
                    <div class="text-lg font-semibold">Personal Info</div>
                    @if (!empty($contact['phone']))
                        <div class="text-base text-gray-500 dark:text-gray-400 flex items-center gap-2">
                            <x-icon name="phone" class="w-5 h-5 text-[var(--brand)]" />
                            {{ $contact['phone'] }}
                        </div>
                    @endif
                    @if (!empty($contact['email']))
                        <div class="text-base text-gray-500 dark:text-gray-400 flex items-center gap-2">
                            <x-icon name="mail" class="w-5 h-5 text-[var(--brand)]" />
                            <a href="mailto:{{ $contact['email'] }}" class="hover:underline break-all">{{ $contact['email'] }}</a>
                        </div>
                    @endif
                    @if (!empty($contact['location']))
                        <div class="text-base text-gray-500 dark:text-gray-400 flex items-center gap-2">
                            <x-icon name="map-pin" class="w-5 h-5 text-[var(--brand)]" />
                            {{ $contact['location'] }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('partials.sections.skills')
    @include('partials.sections.projects')
    @include('partials.sections.education')
    @include('partials.sections.contact')

</main>

@endsection

@push('modals')
    @include('partials.project-modal')
@endpush
