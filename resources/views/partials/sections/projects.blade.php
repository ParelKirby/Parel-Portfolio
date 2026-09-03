<section id="projects" class="py-8">
    <h2 class="display-font gradient-text-title text-3xl md:text-5xl font-black">Projects</h2>
    <p class="mb-6 text-lg text-gray-500 dark:text-gray-400 mt-2">
        Selected work — click a card for details.
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-fr">
        @forelse ($portfolio['projects'] as $project)
            @include('partials.project-card', ['project' => $project])
        @empty
            <p class="text-base text-[var(--muted)]">No projects listed.</p>
        @endforelse
    </div>
</section>
