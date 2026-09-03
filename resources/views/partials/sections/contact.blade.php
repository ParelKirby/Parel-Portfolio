<section id="contact" class="py-8">
    <h2 class="display-font gradient-text-title text-3xl md:text-5xl font-black">Contact</h2>
    <p class="text-lg text-gray-500 dark:text-gray-400 mt-2">
        Tell me about your project, or just say hi.
    </p>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="p-6 rounded-2xl bg-[var(--surface)] border border-[var(--border)] flex flex-col gap-4 min-w-0 break-words">
            <div>
                <div class="text-xl md:text-2xl font-bold">Let's collaborate</div>
                <div class="text-base md:text-lg text-gray-500 dark:text-gray-400">
                    I'm available for freelance and contract work. My inbox is open.
                </div>
            </div>
            <div class="mt-2">
                <div class="text-xl md:text-2xl font-bold">Quick contact</div>
                <div class="mt-2 text-base md:text-lg text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <x-icon name="mail" class="w-5 h-5" />
                    <a href="mailto:{{ $portfolio['personal']['contact']['email'] ?? '' }}" class="hover:underline">
                        {{ $portfolio['personal']['contact']['email'] ?? '' }}
                    </a>
                </div>
                <div class="text-base md:text-lg text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-2">
                    <x-icon name="phone" class="w-5 h-5" />
                    {{ $portfolio['personal']['contact']['phone'] ?? '' }}
                </div>
                <div class="text-base md:text-lg text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-2">
                    <x-icon name="map-pin" class="w-5 h-5" />
                    {{ $portfolio['personal']['contact']['location'] ?? '' }}
                </div>
            </div>
            @if (count($portfolio['socials'] ?? []) > 0)
                <div class="mt-2">
                    <div class="text-xl md:text-2xl font-bold">Connect with me</div>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach (($portfolio['socials'] ?? []) as $s)
                            <a
                                href="{{ $s['url'] }}"
                                target="_blank"
                                rel="noreferrer"
                                aria-label="{{ $s['label'] }}"
                                class="inline-flex items-center gap-2 rounded-full border border-[var(--border)] bg-[var(--bg)] px-4 py-2 text-base text-[var(--text)] hover:border-[var(--brand)] hover:text-[var(--brand)] transition-colors"
                            >
                                <x-icon name="{{ strtolower($s['icon']) === 'sifacebook' ? 'facebook' : 'globe' }}" class="w-4 h-4" />
                                {{ $s['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="p-6 rounded-2xl bg-[var(--surface)] border border-[var(--border)] flex flex-col gap-4 min-w-0 break-words">
            <div class="text-xl md:text-2xl font-bold">Send a message</div>

            @if (session('contact_sent'))
                <div class="text-base text-green-600">Message sent — thank you!</div>
            @endif
            @if (session('contact_error'))
                <div class="text-base text-amber-600">{{ session('contact_error') }}</div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}" class="grid gap-3" aria-live="polite">
                @csrf

                <label for="contact-name" class="text-base md:text-lg text-[var(--text)]">Name</label>
                <input
                    id="contact-name"
                    name="name"
                    title="Name"
                    placeholder="Your name"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-3 rounded-md bg-[var(--bg)] border border-[var(--border)] text-[var(--text)]"
                />

                <label for="contact-email" class="text-base md:text-lg text-[var(--text)]">Email</label>
                <input
                    id="contact-email"
                    name="email"
                    type="email"
                    title="Email"
                    placeholder="Your email"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-3 rounded-md bg-[var(--bg)] border border-[var(--border)] text-[var(--text)]"
                />
                @error('email')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror

                <label for="contact-message" class="text-base md:text-lg text-[var(--text)]">Message</label>
                <textarea
                    id="contact-message"
                    name="message"
                    title="Message"
                    placeholder="Your message"
                    rows="6"
                    required
                    class="w-full px-4 py-3 rounded-md bg-[var(--bg)] border border-[var(--border)] text-[var(--text)]"
                >{{ old('message') }}</textarea>
                @error('message')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror

                <div class="pt-2">
                    <button
                        type="submit"
                        class="px-6 py-3 rounded-lg text-white bg-[var(--brand)] disabled:opacity-60 cursor-pointer"
                    >
                        Send message
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
