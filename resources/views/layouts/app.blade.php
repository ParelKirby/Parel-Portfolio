<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
    <link rel="icon" type="image/svg+xml" href="{{ asset('fav.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', ($portfolio['personal']['name'] ?? 'Parel Kirby') . ' — Portfolio')</title>
    <meta
        name="description"
        content="Parel Kirby — Student / Developer. Portfolio showcasing skills, projects, education, and contact info."
    />

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/github-markdown.css') }}" />

    <script>
        (function () {
            try {
                var saved = localStorage.getItem('theme');
                var dark = saved
                    ? saved === 'dark'
                    : window.matchMedia &&
                      window.matchMedia('(prefers-color-scheme: dark)').matches;
                var el = document.documentElement;
                el.classList.toggle('dark', dark);
                el.setAttribute('data-theme', dark ? 'dark' : 'light');
            } catch (e) {}
        })();
    </script>

    @stack('head')
</head>
<body class="min-h-screen scroll-smooth relative bg-[var(--bg)] text-[var(--text)]">
    <script>
        window.__APP__ = {
            ragApiUrl: @js(config('portfolio.rag_api_url')),
            contactEmail: @js(config('portfolio.contact_email')),
            baseUrl: @js(url('/')),
            tagColors: @js(config('portfolio.tag_colors')),
            iconSlugs: @js(config('portfolio.icon_slugs')),
        };
    </script>
    <script type="application/json" id="portfolio-json">{!! json_encode($portfolio, JSON_THROW_ON_ERROR) !!}</script>

    @yield('before-content')

    @include('partials.header')

    @yield('content')

    @include('partials.footer')
    @include('partials.scroll-progress')
    @include('partials.scroll-to-top')
    @include('partials.cli.terminal')

    @stack('modals')

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
